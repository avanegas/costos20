<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Proyecto\ProyectoRubro;
use App\Models\Proyecto\Proyecto;
use App\Models\Precio\Precio;
use App\Models\Post\Post;
use App\Models\Post\Comment;
use App\Models\Oferta\Oferta;
use App\Image;
use App\Zona;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];

    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function location()
    {
        return $this->hasOneThrough(Location::class, Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function precios()
    {
        return $this->hasMany(Precio::class);
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }

    public function zonas()
    {
        return $this->hasMany(Zona::class);
    }

    public static function form()
    {
        return [
            'name' => '',
            'email' => '',
            'password' => '',
            'roles' => []
        ];
    }
}
