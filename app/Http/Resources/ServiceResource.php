<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {$serviceContentIds = json_decode($this->pivot->service_contents_ids);
      //  return $request->toArray();
      return [
        'id' => $this->id,
        'name' => $this->name,
        'date_appointment'=>$this->pivot->date_appointment,
        'status'=>$this->pivot->status,
        'contents' => ContentResource::collection($this->contents->whereIn('id', $serviceContentIds)),
    ];
}

}
