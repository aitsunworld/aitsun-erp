<div class="row">    
    <div class="form-group col-md-12 mb-2">
        <label for="classes">Select Class</label>
        <div class="aitsun_select position-relative">
           
            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/classes'); ?>">
            <a class="select_close d-none"><i class="bx bx-x"></i></a>
     
            <select class="form-select" name="classes" id="classes">
                <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                <option value="<?= $tcr['id']; ?>" <?php if ($tcr['id']==current_class_of_student(company($user['id']),get_student_data(company($user['id']),$std_data_id['student_id'],'id'))) { echo 'selected'; } ?>><?= $tcr['class']; ?></option>
            <?php endforeach ?>
            </select>

            <div class="aitsun_select_suggest">
                
            </div>
        </div>
        
    </div>

    <div class="form-group col-md-12">
        <label class="font-weight-semibold" for="years">Select Academic Year</label>
        <select class="form-select" name="years" id="years" >

            <?php foreach (academic_year_array(company($user['id'])) as $acr): ?>
                <option value="<?= $acr['id']; ?>" <?php if (academic_year($user['id'])==$acr['id']){echo 'selected';} ?>><?= $acr['year']; ?></option>
            <?php endforeach ?>
        </select>
    </div>
    </div>