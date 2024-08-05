<?php

namespace App\Services;

use App\Http\Requests\UpdatedRequest;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;

class TourService
{
    public function createTour($request)
    {
        $tour = Tour::create([
            'designer_id' => Auth::id(),
            'path' => $request['path'],
            'quantity' => $request['quantity'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],
            'description' => $request['description'],
            'status' => $request['status'],
            'price' => $request['price'],
        ]);

        foreach ($request['services'] as $req) {
            $contents = json_encode($req['service_contents_ids']);
            $tour->services()->attach($req['id'], [
                'service_type' => $req['service_type'],
                'date_appointment' => $req['date_appointment'],
                'service_contents_ids' => $contents,
            ]);
        }

        return $tour;
    }



    public function updateTour($request)
{
    $tour = Tour::findOrFail($request['id']);

    $tour->update([
        'path' => $request['path'],
        'quantity' => $request['quantity'],
        'date_start' => $request['date_start'],
        'date_end' => $request['date_end'],
        'description' => $request['description'],
        'status' => $request['status'],
        'price' => $request['price'],
    ]);

    foreach ($request['services'] as $req) {
        $service = $tour->services()->wherePivot('service_id', $req['id'])->first();

        if ($service && $service->pivot->status !== 'active') {
            $contents = json_encode($req['service_contents_ids']);
            $service->pivot->update([
                'service_type' => $req['service_type'],
                'date_appointment' => $req['date_appointment'],
                'service_contents_ids' => $contents,
            ]);
        }
    }

    return $tour;
}
}
