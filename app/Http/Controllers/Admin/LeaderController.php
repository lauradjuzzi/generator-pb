<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.leaders.index', compact('leaders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'signatory_type' => [
                'required',
                Rule::in(['pimpinan', 'pimpinan_bagian']),
            ],
            'first_position' => ['required', 'string', 'max:100'],
            'first_name' => ['required', 'string', 'max:150'],
            'second_position' => [
                'nullable',
                'required_if:signatory_type,pimpinan_bagian',
                'string',
                'max:100',
            ],
            'second_name' => [
                'nullable',
                'required_if:signatory_type,pimpinan_bagian',
                'string',
                'max:150',
            ],
        ]);

        if ($validated['signatory_type'] === 'pimpinan') {
            $validated['second_position'] = null;
            $validated['second_name'] = null;
        }

        $validated['is_active'] = false;
        $validated['sort_order'] = (Leader::max('sort_order') ?? 0) + 1;

        Leader::create($validated);

        return redirect()
            ->route('leaders.index')
            ->with('success', 'Data pimpinan berhasil ditambahkan.');
    }

    public function toggleStatus(Leader $leader)
    {
        if (!$leader->is_active) {
            Leader::where('signatory_type', $leader->signatory_type)
                ->where('is_active', true)
                ->update(['is_active' => false]);

            $leader->update(['is_active' => true]);

            return redirect()
                ->route('leaders.index')
                ->with(
                    'success',
                    'Pimpinan berhasil diaktifkan. Data aktif sebelumnya pada jenis yang sama telah dinonaktifkan.'
                );
        }

        $leader->update(['is_active' => false]);

        return redirect()
            ->route('leaders.index')
            ->with('success', 'Pimpinan berhasil dinonaktifkan.');
    }

    public function destroy(Leader $leader)
    {
        if ($leader->is_active) {
            return redirect()
                ->route('leaders.index')
                ->withErrors([
                    'leader' => 'Pimpinan yang masih aktif tidak dapat dihapus. Nonaktifkan terlebih dahulu.',
                ]);
        }

        $leader->delete();

        return redirect()
            ->route('leaders.index')
            ->with('success', 'Data pimpinan berhasil dihapus.');
    }
}