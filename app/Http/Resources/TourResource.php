<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     */
    public function toArray(Request $request)

    {

        return [
           'image'=>asset($this->image->url),
            'id' => $this->id,
            'path'=>$this->path,
            'date_start' => $this->date_start,
           // 'image'=>$this->iamge,
            'date_end'=>$this->date_end,
            'quantity'=>$this->quantity,
            'tour_counter'=>$this->tour_counter,
            'description'=>$this->description,
            'status'=>$this->status,
            'price'=>$this->price,
            'phone_number'=>$this->designer->phone_number,

            // Load services if available
            'services' => ServiceResource::collection($this->services),
        ];  }

}
