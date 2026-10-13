<?php

namespace App\Http\Controllers;

use App\Models\TopupType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TopupTypeController extends Controller
{
    public function index()
    {
        $topupTypes = TopupType::orderBy('name')->get();

        return view('topup-types.index', compact('topupTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:topup_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Pastikan slug tetap unik.
        $baseSlug = $validated['slug'];
        $counter = 1;

        while (TopupType::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        $validated['is_active'] = true;

        TopupType::create($validated);

        return redirect()
            ->route('topup-types.index')
            ->with('success', 'Jenis top up berhasil ditambahkan.');
    }

    public function update(Request $request, TopupType $topupType)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('topup_types', 'name')->ignore($topupType->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $baseSlug = $validated['slug'];
        $counter = 1;

        while (
            TopupType::where('slug', $validated['slug'])
                ->where('id', '!=', $topupType->id)
                ->exists()
        ) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        $topupType->update($validated);

        return redirect()
            ->route('topup-types.index')
            ->with('success', 'Jenis top up berhasil diperbarui.');
    }

    public function toggleStatus(TopupType $topupType)
    {
        $topupType->update([
            'is_active' => ! $topupType->is_active,
        ]);

        return redirect()
            ->route('topup-types.index')
            ->with(
                'success',
                $topupType->is_active
                    ? 'Jenis top up berhasil diaktifkan.'
                    : 'Jenis top up berhasil dinonaktifkan.'
            );
    }
}
