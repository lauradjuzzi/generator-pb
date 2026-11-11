<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Style\Font;
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

        $sheetName = match ($section->section_type) {
            'pb01' => 'PB_ATMB',
            'pb02' => 'PB_ATMB (2)',
            default => throw new \RuntimeException('Jenis PB tidak valid.'),
        };

        $sheet = $spreadsheet->getSheetByName($sheetName);

        if (! $sheet) {
            throw new \RuntimeException(
                'Sheet Excel "' . $sheetName . '" tidak ditemukan.'
            );
        }

        $entries = $section->entries->keyBy('entry_type');

        $debit = $entries->get('debet');
        $credit = $entries->get('kredit');

        if (! $debit || ! $credit) {
            throw new \RuntimeException('Data Debet atau Kredit tidak lengkap.');
        }

        // Tanda tangan hanya untuk sheet PB yang sedang diproses.
        $this->fillSignature($spreadsheet, $document, $sheetName);

        // Nomor PB hanya untuk sheet PB yang sedang diproses.
        $year = $document->signature_date->year;

        $sheet->setCellValue(
            'B5',
            'No : ' . $document->document_number . ' /OPS.PBK/' . $year
        );

        // Terbilang hanya berdasarkan nominal dokumen ini.
        $sheet->setCellValue(
            'C30',
            $this->terbilang((float) $debit->amount)
        );

        // Data Debet
        $sheet->setCellValue('B10', $debit->account_number);
        $sheet->setCellValue('B11', $debit->account_name);
        $sheet->setCellValue('C11', (float) $debit->amount);

        // Data Kredit
        $sheet->setCellValue('D10', $credit->account_number);
        $sheet->setCellValue('D11', $credit->account_name);
        $sheet->setCellValue('E11', (float) $credit->amount);

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

        if ($entry->date_from->isSameDay($entry->date_until)) {
            return $start;
        }

        $end = $entry->date_until->translatedFormat('d F Y');

        return $start . ' s.d. ' . $end;
    }


    private function fillSignature(
        Spreadsheet $spreadsheet,
        PbDocument $document,
        string $sheetName
    ): void {
        $sheet = $spreadsheet->getSheetByName($sheetName);

        if (! $sheet) {
            throw new \RuntimeException(
                'Sheet Excel "' . $sheetName . '" tidak ditemukan.'
            );
        }

        // Buka baris yang digunakan untuk area tanda tangan.
        foreach ([36, 38, 39, 40, 41] as $row) {
            $sheet->getRowDimension($row)->setVisible(true);
        }

        // Bersihkan sel bantu nomor PB.
        $sheet->setCellValue('H10', null);
        $sheet->setCellValue('H11', null);

        // Perluas area cetak sampai baris tanda tangan.
        $sheet->getPageSetup()->setPrintArea('B2:E43');

        // Lepaskan merge lama.
        $mergeRanges = [
            'B40:C40',
            'B41:C41',
            'D33:E33',
            'D34:E34',
            'D36:E36',
            'D38:E38',
            'D39:E39',
            'D40:E40',
            'D41:E41',
            'D42:E42',
            'D43:E43',
        ];

        foreach ($mergeRanges as $range) {
            if (isset($sheet->getMergeCells()[$range])) {
                $sheet->unmergeCells($range);
            }
        }

        // Bersihkan area tanda tangan.
        foreach (
            [
                'D36',
                'E36',
                'D38',
                'E38',
                'D39',
                'E39',
                'D40',
                'E40',
                'D41',
                'E41',
                'D42',
                'E42',
                'D43',
                'E43',
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

        $sheet->setCellValue(
            'D33',
            'Pekanbaru, ' . $date
        );

        $sheet->setCellValue(
            'D34',
            'DIVISI OPERASIONAL & AKUNTANSI'
        );

        if ($document->signatory_type === 'pimpinan') {
            // Satu pimpinan.
            $sheet->mergeCells('D40:E40');
            $sheet->mergeCells('D41:E41');

            $sheet->setCellValue(
                'D40',
                $document->first_signatory_name
            );

            $sheet->setCellValue(
                'D41',
                $document->first_signatory_position
            );
        } elseif ($document->signatory_type === 'pimpinan_bagian') {
            $sheet->setCellValue(
                'D40',
                $document->first_signatory_name
            );

            $sheet->setCellValue(
                'E40',
                $document->second_signatory_name
            );

            $sheet->setCellValue(
                'D41',
                $document->first_signatory_position
            );

            $sheet->setCellValue(
                'E41',
                $document->second_signatory_position
            );
        } else {
            throw new \RuntimeException(
                'Tipe penanda tangan tidak valid.'
            );
        }

        // Samakan font dasar area tanda tangan dengan template.
        $signatureFont = clone $sheet->getStyle('D33')->getFont();

        $sheet->getStyle('D33:E34')
            ->setFont(clone $signatureFont);

        $sheet->getStyle('D40:E41')
            ->setFont(clone $signatureFont);

        // Font area tanda tangan.
        $sheet->getStyle('D40:E41')
            ->getFont()
            ->setName($signatureFont->getName())
            ->setSize(12);

        // Nama pimpinan: bold dan underline.
        $sheet->getStyle('D40:E40')
            ->getFont()
            ->setBold(true)
            ->setUnderline(Font::UNDERLINE_SINGLE);

        // Jabatan: normal.
        $sheet->getStyle('D41:E41')
            ->getFont()
            ->setBold(false)
            ->setUnderline(Font::UNDERLINE_NONE);

        // Ratakan area tanda tangan.
        $sheet->getStyle('D33:E43')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle('D33:E34')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getRowDimension(40)->setRowHeight(-1);
        $sheet->getRowDimension(41)->setRowHeight(-1);

        $sheet->getStyle('D40:E41')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function terbilang(float $angka): string
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
