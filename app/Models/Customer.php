<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ImageTrait;
class Customer extends User

{
    use HasFactory, HasApiTokens, Notifiable,ImageTrait;
    protected $fillable =
    [
        'username', 'phone_number',
        'gender', 'date', 'country', 'password'
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'date'
    ];

    /*   to hash the pass :)
protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    */



    public function tours()
    {
        return $this->belongsToMany(Tour::class)->withPivot('status')->withPivot('paid_url');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }


}
