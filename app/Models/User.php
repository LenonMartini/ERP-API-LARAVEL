<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, HasRoles, HasUuids, Notifiable;

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

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);
    }

    public function isSystem(): bool
    {
        return $this->type === 'SYSTEM';
    }

    public function isTenant(): bool
    {
        return $this->type === 'TENANT';
    }

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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function preferences()
    {
        return $this->hasMany(UserPreference::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    /**
     * Permissões que o usuário PODE VER/USAR
     */
    public function availablePermissions()
    {
        $permissions = $this->getAllPermissions();

        if ($this->isSystem()) {
            return $permissions->filter(
                fn ($p) => str_starts_with($p->name, 'system.')
            )->values();
        }

        return $permissions->filter(
            fn ($p) => str_starts_with($p->name, 'tenant.')
        )->values();
    }
}
