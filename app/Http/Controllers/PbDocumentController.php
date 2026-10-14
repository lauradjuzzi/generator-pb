<?php

namespace App\Http\Controllers;

use App\Models\TopupType;
use App\Models\Leader;

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
}
