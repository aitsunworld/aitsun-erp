<div class="row">
    <input type="text" name="appointment_id" id="appointment_id" value="<?= $appointment_id ?>">
      <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Booking name</label>
        <input type="text" class="form-control modal_inpu" name="booking_name" id="booking_name">
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Party</label> 
         <div>
             <div class="aitsun_select position-relative d-inline-flex" style="width: 100%;">                            
                <input type="text" class="aitsun-datebox d-none " style="min-width:100%; height: 35px;" data-select_url="<?= base_url('selectors/all_parties'); ?>">
                <a class="select_close d-none" style="top:0px; color: black;"><i class="bx bx-x"></i></a>
                <select class="px-3 form-select" name="customer_id" id="booking_party" style="margin: auto; min-width:250px; height: 35px; padding: 0;">
                    <option value="">Search party</option> 
                   
                </select>
                <div class="aitsun_select_suggest">
                </div>
            </div> 
         </div>
       </div>


       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">From</label>
        <div class="d-flex">
            <input type="date" class="form-control modal_inpu" name="book_from_date" id="book_from_date" value="<?= $date ?>">
            <input type="time" class="form-control modal_inpu" name="book_from_time" id="book_from_time" value="<?= $time ?>">
        </div>
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">To</label>
        <div class="d-flex">
            <input type="date" class="form-control modal_inpu" name="book_to_date" id="book_to_date" value="<?= $date ?>">
            <?php 
                $timeObject = DateTime::createFromFormat('H:i', $time);
                $duration='01:00'; 
                list($hours, $minutes) = explode(':', $duration); 
                $intervalSpec = sprintf('PT%dH%dM', $hours, $minutes);
                $durationObject = new DateInterval($intervalSpec); 
                $timeObject->add($durationObject); 
                $newTime = $timeObject->format('H:i'); 
            ?>
            <input type="time" class="form-control modal_inpu" name="book_to_time" id="book_to_time" value="<?= $newTime ?>">
        </div>
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Duration</label>
        <input type="text" class="form-control modal_inpu duration_input booking_duration" name="duration" id="duration" value="01:00">
       </div>

       <div class=" col-md-12 mb-2"> 
        <label for="input-1" class="modal_lab">Extra note</label>
        <textarea class="form-control modal_inpu" name="note" id="note"></textarea>
       </div>
  </div>
   
  <div class="text-center mt-3">
    <button type="button" class="btn btn-erp-medium rounded-pill text-center save_booking">Book now</button>
  </div> 