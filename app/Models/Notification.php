<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden =['id',
    'notifiable_type',
    'notifiable_id',
    'updated_at'];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
