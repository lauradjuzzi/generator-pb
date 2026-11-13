<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PbDocument extends Model
{
    protected $fillable = [
        'excel_group_id',
        'document_number',
        'topup_type_id',
        'leader_id',
        'leader_name_snapshot',
        'leader_position_snapshot',
        'signature_date',
        'created_by',
        'signatory_type',
        'first_signatory_position',
        'first_signatory_name',
        'second_signatory_position',
        'second_signatory_name',
        'generated_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'signature_date' => 'date',
            'generated_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function topupType(): BelongsTo
    {
        return $this->belongsTo(TopupType::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Leader::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PbSection::class);
    }
}
