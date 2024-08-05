<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Offer;
use App\Models\Service;
use App\Models\Service_content;
use App\Models\Service_tour;
use App\Models\Tour;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    use GeneralTrait;
    public function allRequest(Request $request)
    {

        $req = Offer::find(Auth::id())->service_tour->where('status','pending')->select('tour_id', 'date_appointment', 'service_contents_ids', 'service_id')->all();

        $result = [];
        foreach ($req as $item) {
            $lista = [];
            $data = Tour::find($item['tour_id'])->designer;
            foreach ($item['service_contents_ids'] as $it) {


                $lista[] =  Service_content::findorfail($it)->name;
            }

            $result[] = [
                'service_id' => $item['service_id'],
                'tour_id' => $item['tour_id'],
                'username' => $data['username'],
                'phone number' => $data['phone_number'],
                'date_appointment' => $item['date_appointment'],
                'service_contents' => $lista
            ];
        }

        return $result;
    }




    public function answer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|integer|exists:tours,id|max:10',
            'service_id' => 'required|integer|exists:services,id',
            'answer' => 'required|boolean|max:1',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        try {
            if ($request['answer'] == 0) {
                $data =  Tour::find($request['tour_id'])->firstorfail();
                $data->status = 'rejected';
                $data->save();
                $data1 = Service_tour::where('tour_id', $request['tour_id'])->where('service_id', $request['service_id'])->firstorfail();
                $data1->status = 'rejected';
                $data1->save();
                $name = Service::find($request['service_id'])->name;
                $notification = new Notification([
                    'message' => $name.' تم رفض طلب حجز خدمة'
                ]);

                $var = Tour::find($request['tour_id'])->designer;
             $var->notifications()->save($notification);
                return $this->successResponse([], 'your answer send successfully');
            } else {
                $data1 = Service_tour::where('tour_id', $request['tour_id'])->where('service_id', $request['service_id'])->firstorfail();
                $data1->status = 'active';
                $data1->save();
                $name = Service::find($request['service_id'])->name;
                $notification = new Notification([
                    'message' => $name.' تم قبول طلب حجز خدمة'
                ]);

                $var = Tour::find($request['tour_id'])->designer;
             $var->notifications()->save($notification);
                $data3 = Service_tour::where('tour_id', $request['tour_id'])->get();
                foreach($data3 as $data){
                    if( $data['status']=='pending'){

                        return $this->successResponse([], 'your answer has been send successfully');

                    }

                }
           $tour =   Tour::find($request['tour_id'])->first();
           $tour->status='active';
           $tour->save();
           $id = $tour->id;
           sleep(1);
        //   $name = Service::find($request['service_id'])->name;
           $notification = new Notification([
               'message' => ' تم تفعيل الرحلة ذو المعرف ' . $id . ' لان جميع الخدمات متاحة '
           ]);

           $var = Tour::find($request['tour_id'])->designer;
        $var->notifications()->save($notification);
           return $this->successResponse([], 'your answer has been send successfully');


            }
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }
}
