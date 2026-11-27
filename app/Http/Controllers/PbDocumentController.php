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
use Illuminate\Support\Str;

class PbDocumentController extends Controller
{
    public function showGenerator(TopupType $topupType)
    {
        abort_unless($topupType->is_active, 404);

        return view('topup.show', compact('topupType'));
    }

    public function create(
        TopupType $topupType,
        string $documentType
    ) {
        abort_unless($topupType->is_active, 404);

        abort_unless(
            in_array($documentType, ['pb01', 'pb02']),
            404
        );

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

    public function storePb01(
        Request $request,
        TopupType $topupType
    ) {
        return $this->storePb($request, $topupType, 'pb01');
    }

    public function storePb02(
        Request $request,
        TopupType $topupType
    ) {
        return $this->storePb($request, $topupType, 'pb02');
    }

    private function normalizeAmountInput($value)
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $value = trim((string) $value);

        if (str_contains($value, ',') && str_contains($value, '.')) {
            if (strrpos($value, ',') > strrpos($value, '.')) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
            } else {
                $value = str_replace(',', '', $value);
            }
        } elseif (str_contains($value, ',')) {
            $value = str_replace(',', '.', $value);
        }

        return $value;
    }

    private function storePb(
        Request $request,
        TopupType $topupType,
        string $documentType
    ) {
        abort_unless($topupType->is_active, 404);

        $request->merge([
            'debit_amount' => $this->normalizeAmountInput(
                $request->input('debit_amount')
            ),
            'credit_amount' => $this->normalizeAmountInput(
                $request->input('credit_amount')
            ),
        ]);

        $validated = $request->validate([
            'pb_number' => ['required', 'string', 'max:100'],

            'date_from' => ['required', 'date'],
            'date_until' => ['nullable', 'date', 'after_or_equal:date_from'],

            'debit_account_number' => [
                'required',
                'string',
                'max:16',
                'regex:/^[0-9]+$/',
            ],

            'debit_account_name' => [
                'required',
                'string',
                'max:150',
            ],

            'debit_description' => [
                'nullable',
                'string',
            ],

            'debit_amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'credit_account_number' => [
                'required',
                'string',
                'max:16',
                'regex:/^[0-9]+$/',
            ],

            'credit_account_name' => [
                'required',
                'string',
                'max:150',
            ],

            'credit_description' => [
                'nullable',
                'string',
            ],

            'credit_amount' => [
                'required',
                'numeric',
                'min:0.01',
                'same:debit_amount',
            ],
        ], [
            'debit_account_number.regex' =>
            'Nomor rekening hanya boleh berisi angka.',

            'credit_account_number.regex' =>
            'Nomor rekening hanya boleh berisi angka.',

            'credit_amount.same' =>
            'Nominal Kredit harus sama dengan Nominal Debet.',
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

        DB::transaction(function () use (
            $validated,
            $topupType,
            $documentType,
            $pimpinan,
            $pimpinanBagian,
            $user
        ) {

            $excelGroupId = session('pb_active_group_id');

            if (
                session('pb_active_topup_id') !== $topupType->id ||
                !$excelGroupId
            ) {
                $excelGroupId = (string) Str::uuid();

                session([
                    'pb_active_topup_id' => $topupType->id,
                    'pb_active_group_id' => $excelGroupId,
                ]);
            }

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

            PbDocument::where('topup_type_id', $topupType->id)
                ->where('created_by', $user->id)
                ->where('is_active', true)
                ->whereHas('sections', function ($query) use ($documentType) {
                    $query->where('section_type', $documentType);
                })
                ->update([
                    'is_active' => false,
                ]);

            $document = PbDocument::create([
                'excel_group_id' => $excelGroupId,
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
                'is_active' => true,
            ]);

            $section = PbSection::create([
                'pb_document_id' => $document->id,
                'section_type' => $documentType,
            ]);

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
        });

        return redirect()
            ->route('topup.show', [
                'topupType' => $topupType->slug,
            ])
            ->with(
                'success',
                strtoupper($documentType) . ' berhasil disimpan.'
            );
    }

    public function update(
        Request $request,
        PbDocument $document
    ) {

        $request->merge([
            'pb01_debit_amount' => $this->normalizeAmountInput(
                $request->input('pb01_debit_amount')
            ),
            'pb01_credit_amount' => $this->normalizeAmountInput(
                $request->input('pb01_credit_amount')
            ),
            'pb02_debit_amount' => $this->normalizeAmountInput(
                $request->input('pb02_debit_amount')
            ),
            'pb02_credit_amount' => $this->normalizeAmountInput(
                $request->input('pb02_credit_amount')
            ),
        ]);

        $validated = $request->validate([
            'pb01_number' => ['nullable', 'string', 'max:100'],
            'pb02_number' => ['nullable', 'string', 'max:100'],

            'date_from' => ['required', 'date'],
            'date_until' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            'pb01_debit_account_number' => [
                'nullable',
                'string',
                'max:16',
                'regex:/^[0-9]+$/',
            ],
            'pb01_debit_account_name' => [
                'nullable',
                'string',
                'max:150',
            ],
            'pb01_debit_description' => [
                'nullable',
                'string',
            ],
            'pb01_debit_amount' => [
                'nullable',
                'numeric',
                'min:0.01',
            ],

            'pb01_credit_account_number' => [
                'nullable',
                'string',
                'max:16',
                'regex:/^[0-9]+$/',
            ],
            'pb01_credit_account_name' => [
                'nullable',
                'string',
                'max:150',
            ],
            'pb01_credit_description' => [
                'nullable',
                'string',
            ],
            'pb01_credit_amount' => [
                'nullable',
                'numeric',
                'min:0.01',
                'same:pb01_debit_amount',
            ],

            'pb02_debit_account_number' => [
                'nullable',
                'string',
                'max:16',
                'regex:/^[0-9]+$/',
            ],
            'pb02_debit_account_name' => [
                'nullable',
                'string',
                'max:150',
            ],
            'pb02_debit_description' => [
                'nullable',
                'string',
            ],
            'pb02_debit_amount' => [
                'nullable',
                'numeric',
                'min:0.01',
            ],

            'pb02_credit_account_number' => [
                'nullable',
                'string',
                'max:16',
                'regex:/^[0-9]+$/',
            ],
            'pb02_credit_account_name' => [
                'nullable',
                'string',
                'max:150',
            ],
            'pb02_credit_description' => [
                'nullable',
                'string',
            ],
            'pb02_credit_amount' => [
                'nullable',
                'numeric',
                'min:0.01',
                'same:pb02_debit_amount',
            ],
        ], [
            'pb01_debit_account_number.regex' =>
            'Nomor rekening Debet Mendebet Rekening hanya boleh berisi angka.',

            'pb01_credit_account_number.regex' =>
            'Nomor rekening Kredit Mendebet Rekening hanya boleh berisi angka.',

            'pb02_debit_account_number.regex' =>
            'Nomor rekening Debet Penerusan BI hanya boleh berisi angka.',

            'pb02_credit_account_number.regex' =>
            'Nomor rekening Kredit Penerusan BI hanya boleh berisi angka.',

            'pb01_credit_amount.same' =>
            'Nominal Kredit Mendebet Rekening harus sama dengan Nominal Debet.',

            'pb02_credit_amount.same' =>
            'Nominal Kredit Penerusan BI harus sama dengan Nominal Debet.',
        ]);

        $document->load([
            'sections.entries',
        ]);

        $groupDocuments = PbDocument::where(
            'excel_group_id',
            $document->excel_group_id
        )
            ->with([
                'sections.entries',
            ])
            ->get();

        $pb01 = $groupDocuments->first(function ($item) {
            return $item->sections
                ->contains('section_type', 'pb01');
        });

        $pb02 = $groupDocuments->first(function ($item) {
            return $item->sections
                ->contains('section_type', 'pb02');
        });

        if (!$pb01 && !$pb02) {
            return back()->withErrors([
                'document' => 'Data dokumen PB tidak ditemukan.',
            ]);
        }

        $pimpinan = Leader::where('signatory_type', 'pimpinan')
            ->where('is_active', true)
            ->first();

        $pimpinanBagian = Leader::where(
            'signatory_type',
            'pimpinan_bagian'
        )
            ->where('is_active', true)
            ->first();

        if (!$pimpinan && !$pimpinanBagian) {
            return back()->withErrors([
                'leader' =>
                'Belum ada pimpinan atau pimpinan bagian yang aktif.',
            ]);
        }

        DB::transaction(function () use (
            $validated,
            $pb01,
            $pb02,
            $pimpinan,
            $pimpinanBagian
        ) {

            if ($pimpinanBagian) {
                $signatoryType = 'pimpinan_bagian';

                $firstPosition =
                    $pimpinanBagian->first_position;

                $firstName =
                    $pimpinanBagian->first_name;

                $secondPosition =
                    $pimpinanBagian->second_position;

                $secondName =
                    $pimpinanBagian->second_name;

                $leaderId =
                    $pimpinanBagian->id;
            } else {
                $signatoryType = 'pimpinan';

                $firstPosition =
                    $pimpinan->first_position;

                $firstName =
                    $pimpinan->first_name;

                $secondPosition = null;
                $secondName = null;

                $leaderId =
                    $pimpinan->id;
            }

            $documents = collect([
                $pb01,
                $pb02,
            ])->filter();

            foreach ($documents as $currentDocument) {

                $section = $currentDocument
                    ->sections
                    ->first();

                if (!$section) {
                    continue;
                }

                $sectionType =
                    $section->section_type;

                if ($sectionType === 'pb01') {
                    $prefix = 'pb01';
                } else {
                    $prefix = 'pb02';
                }

                $currentDocument->update([
                    'document_number' =>
                    $validated[$prefix . '_number'],

                    'leader_id' =>
                    $leaderId,

                    'leader_name_snapshot' =>
                    $firstName,

                    'leader_position_snapshot' =>
                    $firstPosition,

                    'signature_date' =>
                    now()->toDateString(),

                    'signatory_type' =>
                    $signatoryType,

                    'first_signatory_position' =>
                    $firstPosition,

                    'first_signatory_name' =>
                    $firstName,

                    'second_signatory_position' =>
                    $secondPosition,

                    'second_signatory_name' =>
                    $secondName,

                    'generated_at' =>
                    null,

                    'is_active' =>
                    true,
                ]);

                $debit = $section->entries
                    ->firstWhere('entry_type', 'debet');

                $credit = $section->entries
                    ->firstWhere('entry_type', 'kredit');

                if ($debit) {
                    $debit->update([
                        'date_from' =>
                        $validated['date_from'],

                        'date_until' =>
                        $validated['date_until'] ?? null,

                        'account_number' =>
                        $validated[$prefix . '_debit_account_number'],

                        'account_name' =>
                        $validated[$prefix . '_debit_account_name'],

                        'description' =>
                        $validated[$prefix . '_debit_description'] ?? null,

                        'amount' =>
                        $validated[$prefix . '_debit_amount'],
                    ]);
                }

                if ($credit) {
                    $credit->update([
                        'date_from' =>
                        $validated['date_from'],

                        'date_until' =>
                        $validated['date_until'] ?? null,

                        'account_number' =>
                        $validated[$prefix . '_credit_account_number'],

                        'account_name' =>
                        $validated[$prefix . '_credit_account_name'],

                        'description' =>
                        $validated[$prefix . '_credit_description'] ?? null,

                        'amount' =>
                        $validated[$prefix . '_credit_amount'],
                    ]);
                }
            }
        });

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Dokumen berhasil diperbarui.'
            );
    }

    public function preview(
        Request $request,
        TopupType $topupType
    ) {
        abort_unless($topupType->is_active, 404);

        $user = $request->user();

        $activeTopupId = $request->session()->get('pb_active_topup_id');
        $activeGroupId = $request->session()->get('pb_active_group_id');

        if (
            $activeTopupId !== $topupType->id ||
            !$activeGroupId
        ) {
            return redirect()
                ->route('topup.show', [
                    'topupType' => $topupType->slug,
                ])
                ->withErrors([
                    'preview' => 'Belum ada dokumen PB yang siap untuk di-preview.',
                ]);
        }

        $pb01 = PbDocument::where('excel_group_id', $activeGroupId)
            ->where('topup_type_id', $topupType->id)
            ->where('created_by', $user->id)
            ->where('is_active', true)
            ->whereNull('generated_at')
            ->whereHas('sections', function ($query) {
                $query->where('section_type', 'pb01');
            })
            ->with('sections.entries')
            ->latest()
            ->first();

        $pb02 = PbDocument::where('excel_group_id', $activeGroupId)
            ->where('topup_type_id', $topupType->id)
            ->where('created_by', $user->id)
            ->where('is_active', true)
            ->whereNull('generated_at')
            ->whereHas('sections', function ($query) {
                $query->where('section_type', 'pb02');
            })
            ->with('sections.entries')
            ->latest()
            ->first();

        if (!$pb01 && !$pb02) {
            return redirect()
                ->route('topup.show', [
                    'topupType' => $topupType->slug,
                ])
                ->withErrors([
                    'preview' => 'Belum ada dokumen PB yang siap untuk di-preview.',
                ]);
        }

        return view('topup.preview', compact(
            'topupType',
            'pb01',
            'pb02'
        ));
    }

    public function generateExcel(
        Request $request,
        TopupType $topupType
    ) {
        abort_unless($topupType->is_active, 404);

        $user = $request->user();

        $activeTopupId = $request->session()->get('pb_active_topup_id');
        $activeGroupId = $request->session()->get('pb_active_group_id');

        if (
            $activeTopupId !== $topupType->id ||
            !$activeGroupId
        ) {
            abort(404);
        }

        $documents = PbDocument::where(
            'excel_group_id',
            $activeGroupId
        )
            ->where('topup_type_id', $topupType->id)
            ->where('created_by', $user->id)
            ->where('is_active', true)
            ->whereNull('generated_at')
            ->with([
                'sections.entries',
            ])
            ->orderBy('id')
            ->get();

        if ($documents->isEmpty()) {
            abort(404);
        }

        $generator = new PbExcelGenerator();

        $spreadsheet = $generator->loadTemplate();

        foreach ($documents as $document) {
            $generator->fillDocument(
                $spreadsheet,
                $document
            );
        }

        $filename =
            'PB-' .
            $topupType->slug .
            '-' .
            now()->format('YmdHis') .
            '.xlsx';

        $writer = new Xlsx($spreadsheet);

        $generatedAt = now();

        foreach ($documents as $document) {
            $document->update([
                'generated_at' => $generatedAt,
                'is_active' => false,
            ]);
        }

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $filename,
            [
                'Content-Type' =>
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }

    public function download(PbDocument $document)
    {
        $document->load([
            'topupType',
            'sections.entries',
        ]);

        $documents = PbDocument::where(
            'excel_group_id',
            $document->excel_group_id
        )
            ->with([
                'topupType',
                'sections.entries',
            ])
            ->orderBy('id')
            ->get();

        if ($documents->isEmpty()) {
            abort(404);
        }

        $generator = new PbExcelGenerator();
        $spreadsheet = $generator->loadTemplate();

        foreach ($documents as $item) {
            $generator->fillDocument(
                $spreadsheet,
                $item
            );
        }

        $filename = 'PB-' . $document->topupType->slug .
            '-' .
            now()->format('d-m-Y') .
            '.xlsx';

        $writer = new Xlsx($spreadsheet);

        $generatedAt = now();

        foreach ($documents as $item) {
            $item->update([
                'generated_at' => $generatedAt,
                'is_active' => false,
            ]);
        }

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $filename,
            [
                'Content-Type' =>
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }

    public function dashboard(Request $request)
    {
        $search = trim($request->input('search', ''));

        $perPage = (int) $request->input('per_page', 25);

        if (!in_array($perPage, [25, 50, 100])) {
            $perPage = 25;
        }

        $documents = PbDocument::with([
            'creator',
            'topupType',
            'sections.entries',
        ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where(
                        'document_number',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhereHas('topupType', function ($query) use ($search) {
                            $query->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        })
                        ->orWhereHas('creator', function ($query) use ($search) {
                            $query->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        })
                        ->orWhereHas('sections.entries', function ($query) use ($search) {
                            $query->where(
                                'account_number',
                                'like',
                                "%{$search}%"
                            )
                                ->orWhere(
                                    'account_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'description',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'date_from',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'date_until',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'amount',
                                    'like',
                                    "%{$search}%"
                                );
                        });
                });
            })
            ->latest()
            ->get()
            ->groupBy(function ($document) {
                return $document->excel_group_id
                    ?? 'document-' . $document->id;
            })
            ->map(function ($group) {
                $document = $group->sortByDesc('id')->first();

                $document->group_documents = $group->values();

                return $document;
            })
            ->values();

        $totalDocuments = $documents->count();

        $totalPb01 = $documents->filter(function ($document) {
            return $document->group_documents
                ->flatMap(function ($groupDocument) {
                    return $groupDocument->sections;
                })
                ->contains('section_type', 'pb01');
        })->count();

        $totalPb02 = $documents->filter(function ($document) {
            return $document->group_documents
                ->flatMap(function ($groupDocument) {
                    return $groupDocument->sections;
                })
                ->contains('section_type', 'pb02');
        })->count();

        $currentPage = $request->input('page', 1);

        $paginatedDocuments = new \Illuminate\Pagination\LengthAwarePaginator(
            $documents->forPage($currentPage, $perPage)->values(),
            $documents->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('dashboard', [
            'documents' => $paginatedDocuments,
            'search' => $search,
            'perPage' => $perPage,
            'totalDocuments' => $totalDocuments,
            'totalPb01' => $totalPb01,
            'totalPb02' => $totalPb02,
        ]);
    }

    public function destroy(PbDocument $document)
    {
        DB::transaction(function () use ($document) {
            if ($document->excel_group_id) {
                PbDocument::where('excel_group_id', $document->excel_group_id)
                    ->delete();
            } else {
                $document->delete();
            }
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Riwayat PB berhasil dihapus.');
    }

    public function edit(PbDocument $document)
    {
        $document->load([
            'topupType',
            'sections.entries',
        ]);

        $groupDocuments = PbDocument::where(
            'excel_group_id',
            $document->excel_group_id
        )
            ->with([
                'sections.entries',
            ])
            ->orderBy('id')
            ->get();

        return response()->json([
            'id' => $document->id,

            'excel_group_id' => $document->excel_group_id,

            'document_number' => $document->document_number,

            'documents' => $groupDocuments->map(function ($groupDocument) {
                return [
                    'id' => $groupDocument->id,

                    'section_type' =>
                    $groupDocument->sections->first()?->section_type,

                    'document_number' =>
                    $groupDocument->document_number,

                    'entries' => $groupDocument->sections
                        ->first()
                        ?->entries
                        ->map(function ($entry) {
                            return [
                                'entry_type' => $entry->entry_type,
                                'date_from' => $entry->date_from?->format('Y-m-d'),
                                'date_until' => $entry->date_until?->format('Y-m-d'),
                                'account_number' => $entry->account_number,
                                'account_name' => $entry->account_name,
                                'description' => $entry->description,
                                'amount' => $entry->amount,
                            ];
                        })
                        ->values(),
                ];
            })->values(),
        ]);
    }
}
