<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'cms_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function getMobilePermissions()
    {
        return [];
    }

    public function getListAksesRuang()
    {
        if (!$this->userGroup) {
            return [];
        }

        return $this->userGroup->getListAksesRuang();
    }

    public function hasAksesRuang(Ruang $ruang)
    {
        return in_array($ruang->getKey(), $this->getListAksesRuang());
    }

    public function userGroup()
    {
        return $this->hasOne(UserGroup::class, 'id', 'id_user_group');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'id_karyawan');
    }
}
