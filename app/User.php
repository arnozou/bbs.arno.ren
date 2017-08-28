<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\Database\HasRolesAndAbilities;

use App\User;

class User extends Model
{
    use HasRolesAndAbilities;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function info()
    {
       return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }
}
