<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    use ImageTrait;
    protected $casts = [
        'path' => 'array',
    ];

    protected $fillable =
     [
        'designer_id','path','quantity',
        'tour_counter','date_start','date_end',
        'description','status','price'
    ];



    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('service_contents_ids')->withPivot('service_type')->withPivot('date_appointment')->withPivot('status');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withPivot('status','paid_url');
    }
}
//service_type
// date_appointment
