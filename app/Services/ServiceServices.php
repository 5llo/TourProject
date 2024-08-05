<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceServices
{
    public function createSerivce($request){
        $req=$request['location'];
        $location['latitude']= $req[0]['latitude'];
        $location['longitude']= $req[0]['longitude'];
        $json_location=$location;
        $service = Service::create([
            'name' => $request['name'],
            'offer_id' => Auth::id(),
            'type' => $request['type'],
            'location' =>$json_location,
        ]);
        foreach ($request['service_content'] as $item) {
            $service->contents()->create([
                'name'=>$item['name'],
                'price'=>$item['price'],
            ]);
        }
        return $service;
    }
    public function updateSerivce($request){
        $service=Service::find($request['id']);
        $service->update([
            'name'=>$request['name'],
        ]);
        $service->contents()->delete();
        $newContent=[];
        foreach ($request['service_content'] as $item) {
            $newContent[]=[
                'name'=>$item['name'],
                'price'=>$item['price']
            ];
        }
        $service->contents()->createMany($newContent);
        return $service;
    }
}
