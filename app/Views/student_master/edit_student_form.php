<div class="row">

    <div class="form-group col-md-3 mb-2">
        <label for="profile">Student Profile</label>
       
        <input type="hidden" name="old_profile_pic" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'profile_pic') ?>">

        <input type="file" accept="image/*" class="form-control" id="select_student_img" name="student_img" style="padding:6px;"> 
    </div>

    <div class="form-group col-md-3 mb-2">
        <label for="stdname">Student Full Name</label>
        <input type="text" class="form-control" name="stdname" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'first_name') ?>" >
    </div>

   


    <div class="form-group col-md-3 mb-2">
        <label for="date_of_birth">Date of Birth</label>
        <input type="date" class="form-control date_of_birth" data-bxid="<?=  $stded_data_id['id'] ?>" name="date_of_birth" id="date_of_birth<?=  $stded_data_id['id'] ?>"  value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'date_of_birth') ?>" >
    </div>

    <div class="form-group col-md-3 mb-2">
        <label for="age">Age</label>
        <input type="number" class="form-control" name="age" id="age<?=  $stded_data_id['id'] ?>"  value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'stdage') ?>"  readonly>
    </div>

    <div class="form-group col-md-3 mb-2">
        <label for="fathername">Father Name</label>
        <input type="text" class="form-control" name="fathername" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'father_name') ?>" >
    </div>

    <div class="form-group col-md-3 mb-2">
        <label for="mothername">Mother Name</label>
        <input type="text" class="form-control" name="mothername" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'mother_name') ?>" >
    </div>

    <fieldset class="form-group col-md-3 mb-2">
    <div class="row">
        <div class="col-sm-12">
            <label> Gender </label>
        </div>
        <div class="col-sm-12 d-flex mt-2 ml-3">
            <div class="me-2">
                <input type="radio" name="gender" id="male" value="male" <?php if(get_student_data(company($user['id']),$stded_data_id['student_id'],'gender')=="male"){ echo "checked";}elseif(get_student_data(company($user['id']),$stded_data_id['student_id'],'gender')==''){ echo "checked";}?>>
                <label for="male">
                   Male
                </label>
            </div>
            <div class="me-2">
                <input type="radio" name="gender" id="female" value="female" <?php if(get_student_data(company($user['id']),$stded_data_id['student_id'],'gender')=="female"){ echo "checked";}?>>
                <label for="female">
                   Female
                </label>
            </div>

            <div class="me-2">
                <input type="radio" name="gender" id="others" value="others" <?php if(get_student_data(company($user['id']),$stded_data_id['student_id'],'gender')=="others"){ echo "checked";}?>>
                <label for="others">
                   Others
                </label>
            </div>
            
        </div>
    </div>
    </fieldset>

    <div class="form-group col-md-3 mb-2">
        <label for="mobileno">Contact</label>
        <input type="number" class="form-control" name="mobileno" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'phone') ?>" >
    </div>
    <div class="form-group col-md-3 mb-2">
        <label for="mobileno">Additional Contact </label>
        <input type="number" class="form-control" name="phone2" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'phone_2') ?>">
    </div>
    

    <div class="form-group col-md-3 mb-2">
    <label for="classes">Select Class</label>
    <div class="aitsun_select position-relative">
       
            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/classes'); ?>">
            <a class="select_close d-none"><i class="bx bx-x"></i></a>
 
        <select class="form-select" required name="classes">
            <option value="">Select Class</option>  
            <option value="<?= current_class_of_student(company($user['id']),get_student_data(company($user['id']),$stded_data_id['student_id'],'id')); ?>
            " selected><?= class_name(current_class_of_student(company($user['id']),get_student_data(company($user['id']),$stded_data_id['student_id'],'id'))); ?></option>
        </select>

        <div class="aitsun_select_suggest">
            
        </div>
    </div>
    
</div>

<div class="form-group col-md-3 mb-2">
    <label for="admission_no">Admission Number</label>
    <input type="text" class="form-control" name="admission_no" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'admission_no') ?>">
</div>

<div class="form-group col-md-3 mb-2">
    <label for="date_of_join">Joined on:</label>
    <input type="date" class="form-control" name="date_of_join" value="<?= get_date_format(get_student_data(company($user['id']),$stded_data_id['student_id'],'date_of_join'),'Y-m-d') ?>" >
</div>

<div class="form-group col-md-3 mb-2">
    <label for="category">Select Category</label>
    <select class="form-select stdcat" name="category" data-stid="<?= $stded_data_id['id'] ?>" id="category" >
        
        <?php foreach (student_category_array(company($user['id'])) as $stc): ?>
            <option value="<?= $stc['id']; ?>" <?php if (get_student_data(company($user['id']),$stded_data_id['student_id'],'category')==$stc['id']) {echo 'selected';} ?>><?= $stc['category_name']; ?></option>
        <?php endforeach ?>
    </select>
    
</div>

<div class="form-group col-md-3 mb-2">
    <label for="subcategory">Select Sub Category</label>
    <select class="form-select" name="subcategory"  id="subcategory<?= $stded_data_id['id'] ?>" >
        <option value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'subcategory') ?>"><?= student_category_name(get_student_data(company($user['id']),$stded_data_id['student_id'],'subcategory')) ?></option>
        
    </select>
</div>
<div class="form-group col-md-3 mb-2">
    <label for="religion">Religion</label>
    <input type="text" class="form-control" name="religion"  value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'religion') ?>">
</div>

<div class="form-group col-md-3 mb-2">
    <label for="aadhar_no">Aadhar Number</label>
    <input type="text" class="form-control" name="aadhar_no"  value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'adhar') ?>">
</div>

<div class="form-group col-md-3 mb-2">
    <label for="ration_card_no">Ration Card Number</label>
    <input type="text" class="form-control" name="ration_card_no"  value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'ration_card_no') ?>">
</div>

<div class="form-group col-md-3 mb-2">
    <label for="bank_name">Bank Name</label>
    <input type="text" class="form-control" name="bank_name" value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'bank_name') ?>">
</div>

<div class="form-group col-md-3 mb-2">
    <label for="account_number">Bank Account Number</label>
    <input type="text" class="form-control" name="account_number"  value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'account_number') ?>">
</div>
<div class="form-group col-md-3 mb-2">
    <label for="ifsc">Bank IFSC Code</label>
    <input type="text" class="form-control" name="ifsc"   value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'ifsc') ?>">
</div>

<div class="form-group col-md-3 mb-2">
    <label for="blood_gp">Blood Group</label>
    <input type="text" class="form-control" name="blood_gp"  value="<?= get_student_data(company($user['id']),$stded_data_id['student_id'],'blood_group') ?>">
</div>

<div class="form-group col-md-3 mb-2 mb-2">
   <label for="input-5" class="modal_lab">Opening Balance</label>

  <input type="number" min="0" step="any" value="<?= str_replace('-','',aitsun_round(get_student_data(company($user['id']),$stded_data_id['student_id'],'opening_balance'),get_setting(company($user['id']),'round_of_value'))); ?>" class="form-control " name="opening_balance" id="input-5">

      <input type="hidden" name="current_balance" value="<?= aitsun_round(get_student_data(company($user['id']),$stded_data_id['student_id'],'opening_balance'),get_setting(company($user['id']),'round_of_value')); ?>">

</div>


<div class="form-group col-md-3 mb-2 ">
    <label>Type</label>
      <select class="form-select" name="opening_type">

            <option value="" <?php if (get_student_data(company($user['id']),$stded_data_id['student_id'],'opening_balance')>=0) {echo 'selected';} ?>>To Collect</option>
              <option value="-" <?php if (get_student_data(company($user['id']),$stded_data_id['student_id'],'opening_balance')<0) {echo 'selected';} ?>>To Pay</option>
      </select>
</div>  

     <div class="form-group col-md-12">
        
            <label for="address">Address</label>
            <textarea class="form-control" aria-label="address" required="required" name="address"><?= get_student_data(company($user['id']),$stded_data_id['student_id'],'billing_address') ?></textarea>
        
    </div>



</div>