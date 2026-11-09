<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopupType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',

        'default_debit_account_number',
        'default_debit_account_name',
        'default_debit_description',

        'default_credit_account_number',
        'default_credit_account_name',
        'default_credit_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
