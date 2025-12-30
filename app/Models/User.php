<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasUuids;


    protected $guard_name = 'web';
    public $incrementing = false;   // 🔥 importante
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function permissionsTree(): array
    {
        return $this->getAllPermissions()
            ->pluck('name')
            ->map(function ($permission) {
                [$categoria, $modulo, $acao] = explode('.', $permission);

                return compact('categoria', 'modulo', 'acao');
            })
            ->groupBy('categoria')
            ->map(function ($items) {
                return $items->groupBy('modulo')
                    ->map(fn ($acoes) => $acoes->pluck('acao')->values());
            })
            ->toArray();
    }

}
