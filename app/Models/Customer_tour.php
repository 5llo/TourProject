<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_tour extends Model
{
    use HasFactory;
    protected $table = 'customer_tour';
    protected $guarded=[];
    public function book(){
        return $this->belongsToMany(Tour::class);
    }
    public function customer(){
        return $this->belongsToMany(customer::class)->withPivot('status');
    }

}
