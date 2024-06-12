<?php 
    if ($form_type=='edit') {
        $booking_id=$ap_data['id'];
        $appointment_id=$ap_data['appointment_id'];
        $booking_name=$ap_data['booking_name'];
        $customer=$ap_data['customer'];
        $from_date=get_date_format($ap_data['book_from'],'Y-m-d');
        $from_time=get_date_format($ap_data['book_from'],'H:i:s');
        $to_date=get_date_format($ap_data['book_to'],'Y-m-d'); 
        $duration=$ap_data['duration'];
        $newTime =get_date_format($ap_data['book_to'],'H:i:s'); 
        $note=$ap_data['note'];
        $booking_type=$ap_data['booking_type'];
        $save_type='edit';
    }else{
        $booking_name=appointments_data(strip_tags($appointment_id),'title');
        $customer=''; 
        $from_date=$date;
        $from_time=$time;
        $to_date=$date;
        $booking_id='';
        $timeObject = DateTime::createFromFormat('H:i', $time);
        $duration='01:00'; 
        list($hours, $minutes) = explode(':', $duration); 
        $intervalSpec = sprintf('PT%dH%dM', $hours, $minutes);
        $durationObject = new DateInterval($intervalSpec); 
        $timeObject->add($durationObject); 
        $newTime = $timeObject->format('H:i'); 
        $note='';
        $booking_type='';
        $save_type='insert';
    } 
 ?>
<div class="row">
    <input type="hidden" name="booking_id" id="booking_id" value="<?= $booking_id ?>">
    <input type="hidden" name="appointment_id" id="appointment_id" value="<?= $appointment_id ?>">
      <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Booking name</label>
        <input type="text" class="form-control modal_inpu" name="booking_name" id="booking_name" value="<?= $booking_name ?>">
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Party</label> 
         <div class="d-flex">
             <div class="w-100">
                 <div class="aitsun_select position-relative d-inline-flex" id="aitsun_select" style="width: 100%;">                            
                    <input type="text" class="aitsun-datebox d-none " style="min-width:100%; height: 35px;" data-select_url="<?= base_url('selectors/all_parties'); ?>">
                    <a class="select_close d-none" style="top:0px; color: black;"><i class="bx bx-x"></i></a>
                    <select class="px-3 form-select" name="customer_id" id="booking_party" style="margin: auto; min-width:250px; height: 35px; padding: 0;">
                        <?php if ($customer!=''): ?>
                            <option value="<?= $customer ?>"><?= user_name($customer) ?></option> 
                        <?php else: ?>
                            <option value="">Search party</option>
                        <?php endif ?> 
                    </select>
                    <div class="aitsun_select_suggest">
                    </div>
                </div> 
             </div>
             <div style="position: relative;">
                 <a style="min-width: 110px; height:35px;" class="btn btn-success" onclick="$('#new_party_popup').toggle();">New party</a>
                 <div class="new_party_popup" id="new_party_popup">
                     <div>
                         <input type="text" class="mb-2 form-control" id="pop_name" placeholder="Name">
                         <input type="number" class="mb-2 form-control" id="pop_phone" placeholder="Phone">
                         <input type="email" class="mb-2 form-control" id="pop_email" placeholder="Email">
                         <div class="text-center">
                             <a class="btn btn-back-dark btn-sm add_party_popup" data-element_id="">Add</a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
       </div>


       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">From</label>
        <div class="d-flex">
            <input type="date" class="form-control modal_inpu" name="book_from_date" id="book_from_date" value="<?= $from_date ?>">
            <input type="time" class="form-control modal_inpu" name="book_from_time" id="book_from_time" value="<?= $from_time ?>">
        </div>
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">To</label>
        <div class="d-flex">
            <input type="date" class="form-control modal_inpu" name="book_to_date" id="book_to_date" value="<?= $to_date ?>">
          
            <input type="time" class="form-control modal_inpu" name="book_to_time" id="book_to_time" value="<?= $newTime ?>">
        </div>
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Duration</label>
        <input type="text" class="form-control modal_inpu duration_input booking_duration" name="duration" id="duration" value="<?= $duration ?>">
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Extra note</label>
        <textarea class="form-control modal_inpu" name="note" id="note"><?= $note ?></textarea>
       </div>
  </div>
   
  <div class="text-center mt-3">
    <?php if ($save_type=='edit'): ?>
            <?php if ($booking_type=='person'): ?>
                <?php if (is_allowed($user['id'], 'delete_booked_person')): ?>
                    <a class="btn btn-danger ajax_delete rounded-pill" data-url="<?= base_url('appointments/delete_booking') ?>/<?= $booking_id ?>"><i class="bx bx-trash"></i> Delete</a>
                <?php endif ?>
            <?php else: ?>
                <?php if (is_allowed($user['id'], 'delete_booked_resources')): ?>
                    <a class="btn btn-danger ajax_delete rounded-pill" data-url="<?= base_url('appointments/delete_booking') ?>/<?= $booking_id ?>"><i class="bx bx-trash"></i> Delete</a>
                <?php endif ?>
            <?php endif ?>
    <?php endif ?> 


    <button type="button" class="btn <?= ($save_type!='edit')? 'btn-erp-medium':'btn-primary'; ?> rounded-pill text-center save_booking" data-save_type="<?= $save_type ?>">
       <?php if ($save_type=='edit'): ?>
            Update
       <?php else: ?>
            Book now
       <?php endif ?>  
    </button>
  </div> 