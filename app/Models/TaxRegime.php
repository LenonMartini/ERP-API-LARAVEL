<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRegime extends Model
{
    use HasFactory;

    protected $table = 'tax_regimes';

    protected $fillable = [
        'tenant_id',
        'code',
        'description',
    ];
}
