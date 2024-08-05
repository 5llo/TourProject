<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Models\Designer;
use App\Models\Tour;
use App\Http\Resources\DesignerResource;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Http\Requests\TourRequest;
use App\Http\Requests\UpdatedRequest;
use App\Http\Resources\TourResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TourService;

class TourController extends Controller

{
    use GeneralTrait, ImageTrait;

    protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    public function store(TourRequest $request)
    {

        try {

            $tour = $this->tourService->createTour($request->validated());
            $this->storeImage($request, $tour, '/Tours');
        //    return $tour->services;
            $mytour = Designer::with('tours')->find(Auth::id());
            $data = new DesignerResource($mytour);
            return $this->successResponse($data, 'your tour has been created successfully.');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }




    public function index(Request $request)
    {
        try {
            $tours = Designer::with('tours')->find(Auth::id());
            $data = new DesignerResource($tours);
            return $this->successResponse($data, 'This is all tours.');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(DeleteRequest $request)
    {
        try {
            $tour = Tour::with('services.contents')->find($request['id']);

            $data = new TourResource($tour);
            return $data;
            return $this->successResponse($data, 'This is data about this tour.');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedRequest $request)
    {
        try {
            // return 5;
            $tour = $this->tourService->updateTour($request->validated());
            $this->storeImage($request, $tour, '/Tours'); // Update image if necessary
            $myTour = Designer::with('tours.services.contents')->find(Auth::id());
            $data = new DesignerResource($myTour);
            return $this->successResponse($data, 'Tour has been updated successfully.');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteRequest $request)
    {
        return Auth::user();
        try {
            // return $request['id'];
            $tour = Auth::user()->tours;

            if (in_array($request['id'], $tour->pluck('id')->toArray()))
                $tour->find($request['id'])->delete();
            $my_tours = Designer::with('tours.services.contents')->find(Auth::id());
            $data = new DesignerResource($my_tours);
            return $this->successResponse($data, 'your tour has been created successfully.');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }
}
