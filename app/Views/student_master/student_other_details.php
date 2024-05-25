<table class="hide_erp_table">

    <tr style="border: 1px solid white!important;">
    <td class="text-center p-2 " style="width: 155px;"><img src="<?= base_url(); ?>public/uploads/students/<?php if(trim(get_student_data(company($user['id']),$std_id,'profile_pic'))!=''){echo get_student_data(company($user['id']),$std_id,'profile_pic');}else{if(user_gender($std_id)=='male'){echo 'profile_av_male.png';}elseif(user_gender($std_id)=='female'){echo 'profile_av_female.png';}else{echo 'profile_av_other.png';}} ?>" style='    width: 95px;height: 95px;object-fit: cover;border-radius: 50%;'></td>
    <td style="width: 500px;" class="p-2">
        <table >
            <tr style="border: 1px solid white!important;">
                <td  style="width: 120px;">Father Name</td>
                <td  style="width:5px;">:</td>
                <td style="font-weight: 600;"><?= get_student_data(company($user['id']),$std_id,'father_name'); ?></td>
            </tr>
            <tr style="border: 1px solid white!important;">
                <td style="width: 120px;">Mother Name</td>
                <td style="width:5px;">:</td>
                <td style="font-weight: 600;"><?= get_student_data(company($user['id']),$std_id,'mother_name'); ?></td>
            </tr>
            <tr style="border: 1px solid white!important;">
                <td style="width: 120px; vertical-align: baseline;">Address</td>
                <td style="width:5px; vertical-align: baseline;">:</td>
                <td style="white-space: unset !important;font-weight: 600;"><?= get_student_data(company($user['id']),$std_id,'billing_address'); ?></td>
            </tr>
        </table>
    </td>
    <td class="p-2" style="border-right: 1px solid #dee2e6; "><table >
            <tr style="border: 1px solid white!important;">
                <td style="width:110px">Gender</td>
                <td style="width:5px">:</td>
                <td style="font-weight: 600;"><?= user_gender($std_id); ?></td>
            </tr>
            <tr style="border: 1px solid white!important;">
                <td style="width:110px">Category</td>
                <td style="width:5px">:</td>
                <td style="font-weight: 600;"><?= student_category_name(get_student_data(company($user['id']),$std_id,'category')) ?></td>
            </tr>
            <tr style="border: 1px solid white!important;">
                <td style="width:110px">Joined Date</td>
                <td style="width:5px">:</td>
                <td style="font-weight: 600;">
                    <?php if (get_student_data(company($user['id']),$std_id,'date_of_join')!='0000-00-00 00:00:00'): ?>
                        <?= get_date_format(get_student_data(company($user['id']),$std_id,'date_of_join'),'d M Y') ?>
                    <?php endif ?>
                    
                </td>
            </tr>
        </table></td>
    <td class="text-center px-0" style="width: 311px;">
        
        <div class="pt-2 ">
        <a class="btn-trans transfer_student me-1 px-4 py-1 rounded cursor-pointer" data-student_id="<?= $std_id; ?>"  data-deleteurl="<?= base_url('student-master/transfer_student'); ?>/<?= $std_id; ?>">Transfer</a>
        </div>
        
       
    </td>
    </tr>
</table>