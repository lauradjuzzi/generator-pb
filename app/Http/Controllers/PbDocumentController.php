<?php

namespace App\Http\Controllers;

use App\Models\PbDocument;
use App\Models\PbSection;
use App\Models\PbEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TopupType;
use App\Models\Leader;
use App\Services\PbExcelGenerator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PbDocumentController extends Controller
{
    public function showGenerator(TopupType $topupType)
    {
        abort_unless($topupType->is_active, 404);

        return view('topup.show', compact('topupType'));
    }

    public function create(TopupType $topupType, string $documentType)
    {
        abort_unless($topupType->is_active, 404);
        abort_unless(in_array($documentType, ['pb01', 'pb02']), 404);
        $pimpinanAktif = Leader::where('signatory_type', 'pimpinan')
            ->where('is_active', true)
            ->first();

        $pimpinanBagianAktif = Leader::where('signatory_type', 'pimpinan_bagian')
            ->where('is_active', true)
            ->first();

        return view('topup.generator', compact(
            'topupType',
            'documentType',
            'pimpinanAktif',
            'pimpinanBagianAktif'
        ));
    }

    public function store(
        Request $request,
        TopupType $topupType,
        string $documentType
    ) {
        abort_unless($topupType->is_active, 404);
        abort_unless(in_array($documentType, ['pb01', 'pb02']), 404);

        $validated = $request->validate([
            'pb_number' => ['required', 'string', 'max:100'],

            'date_from' => ['required', 'date'],
            'date_until' => ['nullable', 'date', 'after_or_equal:date_from'],

            'debit_account_number' => ['required', 'string', 'max:16'],
            'debit_account_name' => ['required', 'string', 'max:150'],
            'debit_description' => ['nullable', 'string'],
            'debit_amount' => ['required', 'numeric', 'min:0.01'],

            'credit_account_number' => ['required', 'string', 'max:16'],
            'credit_account_name' => ['required', 'string', 'max:150'],
            'credit_description' => ['nullable', 'string'],
            'credit_amount' => [
                'required',
                'numeric',
                'min:0.01',
                'same:debit_amount',
            ],
        ], [
            'credit_amount.same' => 'Nominal Kredit harus sama dengan Nominal Debet.',
        ]);

        $pimpinan = Leader::where('signatory_type', 'pimpinan')
            ->where('is_active', true)
            ->first();

        $pimpinanBagian = Leader::where('signatory_type', 'pimpinan_bagian')
            ->where('is_active', true)
            ->first();

        if (!$pimpinan && !$pimpinanBagian) {
            return back()
                ->withInput()
                ->withErrors([
                    'leader' => 'Belum ada pimpinan atau pimpinan bagian yang aktif.',
                ]);
        }

        $user = $request->user();

        $document = DB::transaction(function () use (
            $validated,
            $topupType,
            $documentType,
            $pimpinan,
            $pimpinanBagian,
            $user
        ) {
            if ($pimpinanBagian) {
                $signatoryType = 'pimpinan_bagian';
                $firstPosition = $pimpinanBagian->first_position;
                $firstName = $pimpinanBagian->first_name;
                $secondPosition = $pimpinanBagian->second_position;
                $secondName = $pimpinanBagian->second_name;
                $leaderId = $pimpinanBagian->id;
            } else {
                $signatoryType = 'pimpinan';
                $firstPosition = $pimpinan->first_position;
                $firstName = $pimpinan->first_name;
                $secondPosition = null;
                $secondName = null;
                $leaderId = $pimpinan->id;
            }

            $document = PbDocument::create([
                'document_number' => $validated['pb_number'],
                'topup_type_id' => $topupType->id,
                'leader_id' => $leaderId,
                'leader_name_snapshot' => $firstName,
                'leader_position_snapshot' => $firstPosition,
                'signature_date' => now()->toDateString(),
                'created_by' => $user->id,
                'signatory_type' => $signatoryType,
                'first_signatory_position' => $firstPosition,
                'first_signatory_name' => $firstName,
                'second_signatory_position' => $secondPosition,
                'second_signatory_name' => $secondName,
            ]);

            $section = PbSection::create([
                'pb_document_id' => $document->id,
                'section_type' => $documentType,
            ]);

            // Simpan data Debet
            PbEntry::create([
                'pb_section_id' => $section->id,
                'entry_type' => 'debet',
                'date_from' => $validated['date_from'],
                'date_until' => $validated['date_until'] ?? null,
                'account_number' => $validated['debit_account_number'],
                'account_name' => $validated['debit_account_name'],
                'description' => $validated['debit_description'] ?? null,
                'amount' => $validated['debit_amount'],
            ]);

            // Simpan data Kredit
            PbEntry::create([
                'pb_section_id' => $section->id,
                'entry_type' => 'kredit',
                'date_from' => $validated['date_from'],
                'date_until' => $validated['date_until'] ?? null,
                'account_number' => $validated['credit_account_number'],
                'account_name' => $validated['credit_account_name'],
                'description' => $validated['credit_description'] ?? null,
                'amount' => $validated['credit_amount'],
            ]);

            return $document;
        });

        // Ambil kembali dokumen beserta seluruh relasinya.
        $document->load('sections.entries');

        // Muat template dan isi data PB.
        $generator = app(PbExcelGenerator::class);

        $spreadsheet = $generator->loadTemplate();

        $generator->fillDocument($spreadsheet, $document);

        // Buat file Excel.
        $writer = new Xlsx($spreadsheet);

        // Nama file berdasarkan nomor PB.
        $safeNumber = preg_replace(
            '/[^A-Za-z0-9._-]/',
            '_',
            $document->document_number
        );

        $fileName = 'PB-' . strtoupper($documentType) . '-' . $safeNumber . '.xlsx';

        // Unduh file Excel.
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
