<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchFiscalSetting extends Model
{
    use HasFactory;

    protected $table = 'branch_fiscal_settings';

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'environment',
        'nfe_series',
        'nfe_last_number',
        'nfce_series',
        'nfce_last_number',
        'nfce_csc_id',
        'nfce_csc_code',
    ];
}
