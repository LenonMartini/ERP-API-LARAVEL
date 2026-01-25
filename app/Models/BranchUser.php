<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchUser extends Model
{
    use HasFactory;

    protected $table = 'branch_user';

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'user_id',
    ];
}
