<?php

namespace App\Models;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Global_info extends Model
{
    use HasFactory;
    use ImageTrait;
    protected $guarded=[];
}
