<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ImageTrait;

class Designer extends User
{
    use HasFactory, HasApiTokens, Notifiable,ImageTrait;
    protected $fillable =
    [
        'username','phone_number',
        'country','password'
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }


}
