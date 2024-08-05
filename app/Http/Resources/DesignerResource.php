<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

   //  $a=$request['services'][0]['service_contents_ids'] ;
  // $a = $this->resource['tours'][0]['services'][0]['pivot']['service_contents_ids'];

   // Extract service contents ids
//    $a = json_decode($services['pivot']['service_contents_ids']);

return [
  //  'id' => $this->id,
   // 'username' => $this->username,
    // Add other attributes

    // Load tours if available
    'tours' => TourResource::collection($this->tours),
];
    }
}
