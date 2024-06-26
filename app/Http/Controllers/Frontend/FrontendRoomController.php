<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomBookedDate;
use App\Models\Facility;
use App\Models\MultiImage;

class FrontendRoomController extends Controller
{
    public function AllFrontendRooms(){
        $rooms = Room::latest()->get();
        return view('frontend.room.all_rooms',compact('rooms'));
    }//End Method


    public function RoomDetailsPage($id){
        $roomdetails = Room::find($id);
        $multiImage = MultiImage::where('room_id',$id)->get();
        $facility = Facility::where('room_id',$id)->get();
        $otherRooms = Room::where('id','!=',$id)->orderBy('id','DESC')->limit(2)->get();
        return view('frontend.room.room_details_page',compact('roomdetails','multiImage','facility','otherRooms'));
    }//End Method

    public function BookingSearch(Request $request){

        $request->flash();

        if ($request->check_in == $request->check_out) {
            $notificaton = array(
                'message' => 'Something Want To Wrong',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notificaton);
        }


        $sdate = date('Y-m-d',strtotime($request->check_in));
        $edate = date('Y-m-d',strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate,$alldate);

        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d',strtotime($period)));
        }


        $check_date_booking_id = RoomBookedDate::whereIn('book_date',$dt_array)->distinct()->pluck('booking_id')->toArray();

        $rooms = Room::withCount('room_number')->where('status',1)->get();


        return view('frontend.room.search_room',compact('rooms','check_date_booking_id'));



    }//End Method


    public function SearchRoomDetails(Request $request,$id){

        $request->flash();
        $roomdetails = Room::find($id);
        $multiImage = MultiImage::where('room_id',$id)->get();
        $facility = Facility::where('room_id',$id)->get();
        $otherRooms = Room::where('id','!=',$id)->orderBy('id','DESC')->limit(2)->get();
        $room_id = $id;
        return view('frontend.room.search_room_details_page',compact('roomdetails','multiImage','facility','otherRooms','room_id'));

    }//End Method


    public function CheckRoomAvailability(Request $request){

        $sdate = date('Y-m-d',strtotime($request->check_in));
        $edate = date('Y-m-d',strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate,$alldate);

        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d',strtotime($period)));
        }


        $check_date_booking_ids = RoomBookedDate::whereIn('book_date',$dt_array)->distinct()->pluck('booking_id')->toArray();

        $room = Room::withCount('room_number')->find($request->room_id);

        $bookings = Booking::withCount('assign_rooms')->whereIn('id',$check_date_booking_ids)->where('room_id',$room->id)->get()->toArray();

        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));

        $av_room = @$room->room_number_count - $total_book_room;

        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);

        return response()->json(['available_room'=>$av_room,'total_nights'=>$nights]);

    }//End Method


















}
