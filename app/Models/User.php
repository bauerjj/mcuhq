<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer'];

    // user has many posts
    public function posts()
    {
        return $this->hasMany('App\Models\Posts','author_id');
    }
    // user has many comments
    public function comments()
    {
        return $this->hasMany('App\Models\Comments','user_id')->where('status','=','approved');
    }
    public function can_post()
    {
        $role = $this->role;
       // if($role == 'author' || $role == 'admin')
        if($role == 'admin') {
            return true;
        }
        return false;
    }

    public function is_admin()
    {
        $role = $this->role;
        if($role == 'admin')
        {
            return true;
        }
        return false;
    }

    public function getAuthor()
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'url'    => $this->url,
            'avatar' => 'gravatar',
            'admin'  => $this->role === 'admin',
        ];
    }
}
