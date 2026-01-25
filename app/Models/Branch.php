<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'status_id',

        // Identificação
        'name', // Razão social
        'trade_name', // Nome fantasia
        'code', // código interno
        'cnpj', // CNPJ
        'state_registration', // IE
        'municipal_registration', // IM

        // Regime tributário (CRT)
        'crt_id',

        // Endereço (SEFAZ)
        'zip_code',
        'address',
        'address_number',
        'address_complement',
        'neighborhood',
        'city',
        'ibge_city_code',
        'state',

        // Contato
        'phone',

    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function fiscalSettings()
    {
        return $this->hasOne(BranchFiscalSetting::class);
    }

    public function certificate()
    {
        return $this->hasOne(BranchCertificate::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
