<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\EventModel;
use App\Models\OrganisationModel;
use App\Models\ClassModel;


class Calendar extends BaseController {

 
  public function index()
     {
        $session=session();
        $user=new Main_item_party_table();
        $event=new EventModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
          $usaerdata=$user->where('id', session()->get('id'))->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

               $active_date=get_date_format(now_time($myid),'Y-m-d');

                if ($_GET) {
                    if (isset($_GET['date'])) {
                        if (!empty($_GET['date'])) {
                            if (strtotime($_GET['date'])) {
                                $active_date=$_GET['date'];
                            } 
                        }
                    }
                }

                $today_event_data = $event->where('company_id',company($myid))->groupStart()->where('date(start_event)',$active_date)->orWhere('date(end_event)>=',$active_date)->groupEnd()->where('academic_year',academic_year($myid))->findAll();

                $this_month_event_data = $event->where('company_id',company($myid))->groupStart()->where('month(start_event)',get_date_format($active_date,'m'))->orWhere('month(end_event)',get_date_format($active_date,'m'))->groupEnd()->where('academic_year',academic_year($myid))->findAll();

              $data=[
                  'title'=>'Calendar | Erudite ERP',
                  'user'=>$usaerdata,
                  'today_event_data'=>$today_event_data,
                  'this_month_event_data'=>$this_month_event_data,
                ];
                $etype='';

                
                      echo view('header',$data);
                      echo view('calendar/calender');
                      echo view('footer');
                
    
                
        
      }else{
        return redirect()->to(base_url('users'));
      }   
  }


 function load()
 {
  $event=new EventModel();
  $myid=session()->get('id');
  $event_data = $event->where('company_id',company($myid))->where('academic_year',academic_year($myid))->findAll();
  foreach($event_data as $row)
  {
   $data[] = array(
    'id' => $row['id'],
    'title' => $row['title'],
    'start' => $row['start_event'],
    'end' => $row['end_event']
   );
  }
  echo json_encode($data);
 }

 public function add_cal_event()
 {

  $event = new EventModel();
  $myid=session()->get('id');
  $session = session();

  if ($this->request->getMethod() == 'post') {
  
   $calevent = [
    'company_id' => company($myid),
    'academic_year' => academic_year($myid),
    'title'=> $this->request->getVar('title'),
    'start_event'=> $this->request->getVar('start'),
    'end_event' => $this->request->getVar('end'),
    'deletable' => 1,
    ];
    
     if ($event->save($calevent)) {


       // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
        $title='New event <b>'.strip_tags($this->request->getVar('title')).'</b> added.';
        $message='';
        $url=main_base_url().'calendar'; 
        $icon=notification_icons('event');
        $userid='all';
        $nread=0;
        $for_who='student';
        $notid='event';
        notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
    // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

      // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
        $title='New event <b>'.strip_tags($this->request->getVar('title')).'</b> added.';
        $message='';
        $url=base_url().'/calendar'; 
        $icon=notification_icons('event');
        $userid='all';
        $nread=0;
        $for_who='admin';
        $notid='event';
        notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
    // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

        $session->setFlashdata('pu_msg', 'Event added successfully');
        return redirect()->to(base_url('calender'));

     }else{
         
        $session->setFlashdata('pu_er_msg', 'Failed');
        return redirect()->to(base_url('calender'));

     }   
  
 }
}

 function edit_cal_event($evid='')
 {
  $event = new EventModel();
  $session = session();

  if ($this->request->getMethod() == 'post') {
  
  $calevent = [
    'title'  => $this->request->getVar('title'),
    'start_event'=> $this->request->getVar('start'),
    'end_event' => $this->request->getVar('end')
  ];

  $check_deletable=$event->where('id',$evid)->first();

      if ($check_deletable['deletable']==1) {
        $event->update($evid,$calevent);

        $session->setFlashdata('pu_msg', 'Event updated');
        return redirect()->to(base_url('calender'));

      }else{
        alert('Cant update from here');
      }

    
  }
 }

public function delete_event($evid='')
{
  $event = new EventModel();

    if ($this->request->getMethod() == 'get') {

      $check_deletable=$event->where('id',$evid)->first();

      if ($check_deletable['deletable']==1) {

        $event->find($evid);
        $event->delete($evid);

      }else{

        alert('Cant delete from here');
      }
      
  }
}


public function sleep_mode(){
  echo view('sleep_mode');
}


}


