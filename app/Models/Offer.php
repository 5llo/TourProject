<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ImageTrait;


class Offer extends User
{
    use HasFactory, HasApiTokens, Notifiable,ImageTrait;
    protected $table = 'offers';
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
        'updated_at',

    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function service_tour()
    {
        return $this->hasManyThrough(Service_tour::class,Service::class);
    }


}
