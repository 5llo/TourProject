<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource1 extends JsonResource
{//use imageTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'name' => $this->name,
            'type'=>$this->type,
            'location'=>$this->location,
            'image'=>asset($this->image->url),
            'contents' => ContentResource::collection($this->contents),
        ];
    }
}
