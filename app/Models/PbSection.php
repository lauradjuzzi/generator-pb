<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PbSection extends Model
{
    protected $fillable = [
        'pb_document_id',
        'section_type',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(PbDocument::class, 'pb_document_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(PbEntry::class, 'pb_section_id');
    }
}
