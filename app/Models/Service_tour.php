<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_tour extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'service_tour';
    protected $casts = [
        'service_contents_ids' => 'array',
    ];


}
