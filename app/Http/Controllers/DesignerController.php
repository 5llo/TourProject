<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Customer_tour;
use App\Models\Designer;
use App\Models\Notification;
use App\Models\Tour;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Illuminate\Support\Facades\Validator;

class DesignerController extends Controller
{
    use GeneralTrait;
    public function requests(Request $request)
    {
        $result = [];
        $data =  Auth::user()->tours;
        foreach ($data as $item) {
            $data1 = $item->customers;
            $lista = [];

            foreach ($data1 as $item1) {

                if ($item1['pivot']['status'] == 'pending') {
                 $test =   $item1['pivot']['paid_url'];
                 if(!is_numeric($test)){$test = asset($item1['pivot']['paid_url']);}
                    $lista = [
                        "tour_id" => $item1['pivot']['tour_id'],
                        "customer_id" => $item1['pivot']['customer_id'],
                        "name" => $item1['username'],
                        "status" =>   $item1['pivot']['status'],
                        "paid_url" => $test,
                    ];
                }
                $result[] = $lista;
            }
            return $result;
        }
    }

    // if (is_numeric($variable)) {
    //     return 'process_number';
    // }
    public function answer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|integer|exists:tours,id|max:10',
            'customer_id' => 'required|integer|exists:customers,id',
            'answer' => 'required|boolean|max:1',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        try {
            if ($request['answer'] == 0) {
                $data = Customer_tour::where('tour_id', $request['tour_id'])->where('customer_id', $request['customer_id'])->firstorfail();
                if ($data->status != 'pending') {
                    return;
                }
                $data->status = 'rejected';
                $data->save();



                $customer = Customer::find($request['customer_id']);
                if ($customer) {
                    $notification = new Notification([
                        'message' => 'تم رفض طلب انظمامك للرحلة رقم ' . $request['tour_id']
                    ]);
                    $customer->notifications()->save($notification);
                }
                return $this->successResponse([], 'successfully rejected');
            } else {
                $data = Customer_tour::where('tour_id', $request['tour_id'])->where('customer_id', $request['customer_id'])->firstorfail();
                if ($data->status != 'pending') {
                    return;
                }
                $data->status = 'accepted';
                $data->save();
                $tour = Tour::find($request['tour_id'])->first();
                    $tour->tour_counter++;
                    $tour->save();

                $customer = Customer::find($request['customer_id']);
                if ($customer) {
                    $notification = new Notification([
                        'message' => 'تم قبول طلب انظمامك للرحلة رقم ' . $request['tour_id'] . 'بنجاح'
                    ]);
                    $customer->notifications()->save($notification);
                }
                return $this->successResponse([], 'successfully accepted');
            }
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }




    public function getallnotefication(Request $request){

        $info =  Designer::find(Auth::id())->notifications()->orderBy('created_at', 'desc')->get();
         return $info;
         }





}
