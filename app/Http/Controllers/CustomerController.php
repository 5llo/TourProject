<?php

namespace App\Http\Controllers;
use App\Http\Resources\DesignerResource;
use App\Http\Resources\TourResource;
use App\Models\Customer;
use App\Models\Customer_tour;
use App\Models\Designer;
use App\Models\Tour;
use App\Traits\ImageTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\TourService;
use LDAP\Result;

class CustomerController extends Controller
{
    protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }
    use GeneralTrait,ImageTrait;
    public function AllTour(Request $request)  {
try{
      $allTour=Tour::where('status','active')->get();
    $data =  TourResource::collection($allTour);
      return $this->successResponse($data, 'All active tours.');
  } catch (\Exception $ex) {
      return $this->errorResponse($ex->getMessage(), 500);
  }
    }


    public function joinTour(Request $request){

        $validator = Validator::make($request->all(), [
            'tour_id'=>'integer|exists:tours,id|unique:customer_tour,tour_id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'proccess_number' => 'string|max:25|unique:customer_tour,paid_url',
        ]);


        try{$user=Auth::id();
            $test = Tour::find($request['tour_id'])->status;
               if($test != 'active'){
                   return $this->errorResponse('still pending',403);
               }

            $exists = Customer_tour::where('tour_id', $request->tour_id)
                                    ->where('customer_id', $user)
                                    ->exists();
           if(!$exists){
            if(!empty($request['proccess_number'])){
             Auth::user()->tours()->attach($request['tour_id'],[
                'paid_url'=>$request['proccess_number']
             ]);


            }
            else{
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
             $customer=  Auth::user()->tours()->attach($request['tour_id'],[
                    'paid_url'=>'/images/Invoices' . '/' . $image_name
                 ]);

                 $image->move(public_path('images/Invoices'), $image_name);





            }
          //  $data=Auth::user()->tours;
            return $this->successResponse([],'Tour has been successfully.');}
            else
            return $this->errorResponse('already exists',403);





      //      return $this->successResponse($data, 'Your request is being processed.');
        }

        catch (\Exception $ex) {

            return $this->errorResponse($ex->getMessage(), 500);

        }




    }
    public function booking(Request $request){
   $data = Auth::user()->tours;
$result = [];
        foreach ($data as $item) {

            $lista = [];
            $res = $item->designer_id;
           $res1=Designer::find($res)->select('username','phone_number')->get();
           $data1=$item->services;
           foreach($data1 as $it){
            $lista[]=[
                    "name"=> $it['name'],
                    "type"=>   $it['pivot']['service_type']
            ];


           }
      $test = $item['pivot']['paid_url'];
           if(!is_numeric($test)){$test = asset($test);}
            $result[] = [
                'tour_id' => $res,
                'designer name' => $res1[0]->username,
                'designer phone' => $res1[0]->phone_number,
                'user status'=>$item['pivot']['status'],
                'paid url'=>$test,
                'quantity'=>$item['quantity'],
                'tour_counter'=>$item['tour_counter'],
                'date_start'=>$item['date_start'],
                'date_end'=>$item['date_end'],
                'description'=>$item['description'],
                'price'=>$item['price'],
                'path'=>$item['path'],
                'services'=>$lista,
            ];
        }


        return $result;
}

      public function getallnote(Request $request){

     $info =  Customer::find(Auth::id())->notifications()->orderBy('created_at', 'desc')->get();
      return $info;
      }



}
