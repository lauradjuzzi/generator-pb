<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\PbDocument;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PbExcelGenerator
{
    public function loadTemplate(): Spreadsheet
    {
        $templatePath = storage_path('app/templates/template-pb.xlsx');

        if (! file_exists($templatePath)) {
            throw new \RuntimeException('Template Excel tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($templatePath);

        $requiredSheets = [
            'PB_ATMB',
            'PB_ATMB (2)',
        ];

        foreach ($requiredSheets as $sheetName) {
            if (! $spreadsheet->sheetNameExists($sheetName)) {
                throw new \RuntimeException(
                    "Sheet {$sheetName} tidak ditemukan dalam template."
                );
            }
        }

        return $spreadsheet;
    }

    public function fillDocument(
        Spreadsheet $spreadsheet,
        PbDocument $document
    ): void {
        $document->loadMissing('sections.entries');

        $section = $document->sections->first();

        if (! $section) {
            throw new \RuntimeException('Data section PB tidak ditemukan.');
        }

        $this->fillSignature($spreadsheet, $document);

        $sheetName = match ($section->section_type) {
            'pb01' => 'PB_ATMB',
            'pb02' => 'PB_ATMB (2)',
            default => throw new \RuntimeException('Jenis PB tidak valid.'),
        };

        $sheet = $spreadsheet->getSheetByName($sheetName);

        $entries = $section->entries->keyBy('entry_type');

        $debit = $entries->get('debet');
        $credit = $entries->get('kredit');

        if (! $debit || ! $credit) {
            throw new \RuntimeException('Data Debet atau Kredit tidak lengkap.');
        }
        // Terbilang berdasarkan nominal transaksi.
        $sheetNames = ['PB_ATMB', 'PB_ATMB (2)'];

        foreach ($sheetNames as $name) {
            $currentSheet = $spreadsheet->getSheetByName($name);

            $currentSheet->setCellValue(
                'C30',
                $this->terbilang((float) $debit->amount)
            );
        }

        // Nomor PB
        $sheet->setCellValue('H10', $document->document_number);

        // Data Debet
        $sheet->setCellValue('B10', $debit->account_number);
        $sheet->setCellValue('B11', $debit->account_name);
        $sheet->setCellValue('C11', (float) $debit->amount);

        // Data Kredit
        $sheet->setCellValue('D10', $credit->account_number);
        $sheet->setCellValue('D11', $credit->account_name);
        $sheet->setCellValue('E11', (float) $credit->amount);

        // PB 02 menggunakan nominal langsung dari database
        if ($section->section_type === 'pb02') {
            $sheet->setCellValue('C11', (float) $debit->amount);
        }

        // Periode transaksi
        $period = $this->formatPeriod($debit);

        $sheet->setCellValue(
            'B15',
            trim($debit->description ?? '') . ' periode ' . $period
        );

        $sheet->setCellValue(
            'D15',
            trim($credit->description ?? '') . ' periode ' . $period
        );
    }

    private function formatPeriod($entry): string
    {
        $start = $entry->date_from->translatedFormat('d F Y');

        if (! $entry->date_until) {
            return $start;
        }

        $end = $entry->date_until->translatedFormat('d F Y');

        return $start . ' s.d. ' . $end;
    }


    private function fillSignature(
        Spreadsheet $spreadsheet,
        PbDocument $document
    ): void {
        $sheetNames = [
            'PB_ATMB',
            'PB_ATMB (2)',
        ];

        foreach ($sheetNames as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);

            // Samakan area cetak kedua sheet.
            $sheet->getPageSetup()->setPrintArea('B2:E39');

            // Lepaskan merge lama agar susunan tanda tangan konsisten.
            $mergeRanges = [
                'D33:E33',
                'D34:E34',
                'D36:E36',
                'D38:E38',
                'D39:E39',
                'D41:E41',
                'D42:E42',
            ];

            foreach ($mergeRanges as $range) {
                if (isset($sheet->getMergeCells()[$range])) {
                    $sheet->unmergeCells($range);
                }
            }

            // Hapus teks lama dan placeholder dari template.
            foreach (
                [
                    'D36',
                    'E36',
                    'D38',
                    'E38',
                    'D39',
                    'E39',
                    'D41',
                    'E41',
                    'D42',
                    'E42',
                ] as $cell
            ) {
                $sheet->setCellValue($cell, null);
            }

            // Tanggal dan nama divisi.
            $date = $document->signature_date
                ->locale('id')
                ->translatedFormat('d F Y');

            $sheet->mergeCells('D33:E33');
            $sheet->mergeCells('D34:E34');

            $sheet->setCellValue('D33', 'Pekanbaru, ' . $date);
            $sheet->setCellValue(
                'D34',
                'DIVISI OPERASIONAL & AKUNTANSI'
            );

            if ($document->signatory_type === 'pimpinan') {
                // Satu pimpinan, posisinya tepat di tengah.
                $sheet->mergeCells('D38:E38');
                $sheet->mergeCells('D39:E39');

                $sheet->setCellValue(
                    'D38',
                    $document->first_signatory_name
                );

                $sheet->setCellValue(
                    'D39',
                    $document->first_signatory_position
                );
            } elseif ($document->signatory_type === 'pimpinan_bagian') {
                // Dua pimpinan bagian.
                $sheet->mergeCells('D36:E36');

                $sheet->setCellValue('D36', 'MENGETAHUI');

                $sheet->setCellValue(
                    'D38',
                    $document->first_signatory_name
                );

                $sheet->setCellValue(
                    'E38',
                    $document->second_signatory_name
                );

                $sheet->setCellValue(
                    'D39',
                    $document->first_signatory_position
                );

                $sheet->setCellValue(
                    'E39',
                    $document->second_signatory_position
                );
            } else {
                throw new \RuntimeException(
                    'Tipe penanda tangan tidak valid.'
                );
            }

            // Ratakan seluruh area tanda tangan.
            $sheet->getStyle('D33:E39')
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(true);
        }
    }

    private function terbilang(float $angka): string
    {
        $angka = (int) round($angka);

        if ($angka === 0) {
            return 'Nol rupiah';
        }

        if ($angka < 0) {
            return 'Minus ' . $this->konversiAngka(abs($angka)) . ' rupiah';
        }

        return ucfirst($this->konversiAngka($angka)) . ' rupiah';
    }

    private function konversiAngka(int $angka): string
    {
        $kata = [
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
        ];

        if ($angka < 12) {
            return $kata[$angka];
        }

        if ($angka < 20) {
            return $this->konversiAngka($angka - 10) . ' belas';
        }

        if ($angka < 100) {
            return $this->konversiAngka((int) ($angka / 10))
                . ' puluh '
                . $this->konversiAngka($angka % 10);
        }

        if ($angka < 200) {
            return 'seratus ' . $this->konversiAngka($angka - 100);
        }

        if ($angka < 1000) {
            return $this->konversiAngka((int) ($angka / 100))
                . ' ratus '
                . $this->konversiAngka($angka % 100);
        }

        if ($angka < 2000) {
            return 'seribu ' . $this->konversiAngka($angka - 1000);
        }

        if ($angka < 1000000) {
            return $this->konversiAngka((int) ($angka / 1000))
                . ' ribu '
                . $this->konversiAngka($angka % 1000);
        }

        if ($angka < 1000000000) {
            return $this->konversiAngka((int) ($angka / 1000000))
                . ' juta '
                . $this->konversiAngka($angka % 1000000);
        }

        if ($angka < 1000000000000) {
            return $this->konversiAngka((int) ($angka / 1000000000))
                . ' miliar '
                . $this->konversiAngka($angka % 1000000000);
        }

        throw new \RuntimeException('Nominal terlalu besar untuk dikonversi.');
    }
}
