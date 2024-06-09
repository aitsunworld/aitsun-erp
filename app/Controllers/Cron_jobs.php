<?php
namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\AppointmentsBookings;
 

class Cron_jobs extends BaseController {
        public function index()
        {  
                $session=session();
                if($session->has('isLoggedIn')){
                        $UserModel= new Main_item_party_table; 
                        $myid=session()->get('id');
                        $AppointmentsBookings=new AppointmentsBookings;
                        $get_all_past_bookings=$AppointmentsBookings->where('company_id',company($myid))->where('deleted',0)->where('status',0)->where('book_to <', now_time($myid))->findAll();

                        foreach ($get_all_past_bookings as $past_bookings) {
                                echo $past_bookings['booking_name'].'<br>';
                                $status_data=[
                                        'id'=>$past_bookings['id'],
                                        'status'=>3
                                ];
                                $AppointmentsBookings->save($status_data);
                        }
                }
        }
}