<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Services\TourService;
use App\Http\Requests\TourRequest;
use App\Models\Designer;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DesignerResource;
class AllToursController extends Controller
{
    use GeneralTrait, ImageTrait;

   protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    public function Alltours(TourRequest $request)
    {

        try {
            $tour = $this->tourService->createTour($request->validated());
            $this->storeImage($request, $tour, '/Tours');
            $mytour = Designer::with('tours.services.contents')->find(Auth::id());
            $data = new DesignerResource($mytour);
            return $this->successResponse($data, 'your tour has been created successfully.');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }


    public function show() {
      return 9;
    }

}
