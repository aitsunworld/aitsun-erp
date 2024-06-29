<div class="modal-header">
    <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
  
  <div class="form-group mb-2">
        <label for="to-input">Name</label>
        <input type="text" class="form-control" id="name"  placeholder="Name" value="<?= $name; ?>" required> 
    </div>
    <div class="form-group mb-2">
        <label for="to-input">To</label>
        <input type="email" class="form-control" id="emailto"  placeholder="To" value="<?= $to; ?>" required> 
    </div>

    <div class="form-group mb-2">
        <label for="subject-input">Subject</label>
        <input type="text" class="form-control" id="subject" placeholder="Subject" value="<?= $subject ?>">
    </div>

    <div class="form-group mb-2 ">
        <label for="message-input">Message</label>
        <textarea style="white-space: pre-wrap;" class="form-control" value="" id="message" rows="10"><?= $message ?></textarea>
    </div> 

    <div class="btn-toolbar form-group mt-2">
            <button class="aitsun-primary-btn send_email" data-id=""> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
    </div>  
</div>