<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use ImageTrait;
    protected $casts = [
        'location' => 'array',
    ];
    protected $fillable = [
        'name',
        'offer_id',
        'type',
        'location'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function tours()
    {
        return $this->belongsToMany(Tour::class);
    }

    public function contents()
    {
        return $this->hasMany(Service_content::class);
    }


}
