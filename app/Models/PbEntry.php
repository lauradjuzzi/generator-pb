<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PbEntry extends Model
{
    protected $fillable = [
        'pb_section_id',
        'entry_type',
        'date_from',
        'date_until',
        'account_number',
        'account_name',
        'description',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'date_from' => 'date',
            'date_until' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PbSection::class, 'pb_section_id');
    }
}
