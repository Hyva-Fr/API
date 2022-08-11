<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JsonException;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'agency_id',
        'employed',
        'password',
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
    ];

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $this->attributes['firstname'] . ' ' . strtoupper($this->attributes['lastname']);
    }

    public function setLastnameAttribute($value): void
    {
        $this->attributes['lastname'] = strtoupper($value);
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getRoles()
    {
        return User::find($this->id)->roles()->orderBy('name')->get();
    }

    /**
     * @throws JsonException
     */
    private function setPermissions(): array
    {
        $roles = $this->getRoles();
        $perms = [];
        foreach ($roles as $role) {
            $constants = json_decode($role->constants, true, 512, JSON_THROW_ON_ERROR);
            foreach ($constants as $constant) {
                $const = constant("App\Constants\PermissionsConstants::$constant");
                foreach ($const as $item) {
                    if (str_ends_with($item, '.*')) {
                        $split = str_replace('.*', '', $item);
                        $perms[] = $split . '.read';
                        $perms[] = $split . '.edit';
                        $perms[] = $split . '.update';
                        $perms[] = $split . '.delete';
                    } else {
                        $perms[] = $item;
                    }
                }
            }
        }

        return array_unique($perms);
    }

    public function hasPermissions($data): bool
    {
        $perms = $this->setPermissions();
        if (is_array($data)) {
            $check = false;
            foreach ($data as $datum) {
                if (str_ends_with($datum, '.*')) {
                    $split = str_replace('.*', '', $datum);
                    $check = in_array($split . '.read', $perms, true)
                        && in_array($split . '.edit', $perms, true)
                        && in_array($split . '.update', $perms, true)
                        && in_array($split . '.delete', $perms, true);
                } else {
                    $check = in_array($datum, $perms, true);
                }
            }
            return $check;
        }

        if (str_ends_with($data, '.*')) {
            $split = str_replace('.*', '', $data);
            return in_array($split . '.read', $perms, true)
                && in_array($split . '.edit', $perms, true)
                && in_array($split . '.update', $perms, true)
                && in_array($split . '.delete', $perms, true);
        }
        return in_array($data, $perms, true);
    }

    /**
     * Get the agency that owns the user.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
