<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCertificate extends Model
{
    use HasFactory;

    protected $table = 'branch_certificates';

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'name',
        'type',
        'file_path',
        'password',
        'expires_at',
    ];
}
