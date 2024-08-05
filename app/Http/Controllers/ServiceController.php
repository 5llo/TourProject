<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteSerivceRequest;
use App\Http\Requests\StoreSerivceRequest;
use App\Http\Requests\UpdateSerivceRequest;
use App\Http\Resources\ServiceResource1;
use App\Models\Offer;
use App\Models\Service;
use App\Models\Service_content;
use App\Models\Student;
use App\Services\ServiceServices;
use App\Services\TourService;
use App\Traits\GeneralTrait;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ImageTrait;

class ServiceController extends Controller
{   use ImageTrait,GeneralTrait;
    protected $ServiceServices;

    public function __construct(ServiceServices $ServiceServices)
    {
        $this->ServiceServices = $ServiceServices;
    }
    public function index(Request $request){
        try{
            $service=Service::get()->where('offer_id',Auth::id());
            $data=ServiceResource1::collection($service);
            return $this->successResponse($data,'all service');}
        catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }
    public function show(DeleteSerivceRequest $request){
        try{
            $service=Service::get()->where('id',$request['id']);
            $data=ServiceResource1::collection($service);
            return $this->successResponse($data,'return successfully');}
        catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }
    public function store(StoreSerivceRequest $request)
    {  try{
        $service = $this->ServiceServices->createSerivce($request->validated());
        $this->storeImage($request,$service,'/Service');
        $service=Service::get()->where('offer_id',Auth::id());
        $data=ServiceResource1::collection($service);
        return $this->successResponse($data,'the service has been added successfully');}
    catch (\Exception $ex) {
        return $this->errorResponse($ex->getMessage(), 500);
    }

    }
    public function update(UpdateSerivceRequest $request){
        try{
            $service=$this->ServiceServices->updateSerivce($request->validated());
            $service=Service::get()->where('offer_id',Auth::id());
            $data=ServiceResource1::collection($service);
            return $this->successResponse($data,'the service has been updated successfully');}
        catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }
    public function delete(DeleteSerivceRequest $request){
        try{
            $service=Service::find($request['id']);
            $service->delete();
            $service=Service::get()->where('offer_id',Auth::id());
            $data=ServiceResource1::collection($service);
            return $this->successResponse($data,'the serivce has been delete successfully');}
        catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }
}
