<style type="text/css">
    @page {
            margin: 20px;
        } 
    @font-face {
        font-family: "source_sans_proregular";           
        src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;

    }
    .progress_font{
        font-size: 20px;
    }
    .company_logo{
      height: 50px;
    } 
    
    table{width: 100%;}      
    body{
        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
    }
</style>


<div class="body p-0 ex_result_sc"  style="overflow:scroll">
    <div id="exam_result<?= $main_exam_data['id']; ?>">
        <table class="table ex_result_c" style="border-bottom: snow;" border="0">
            <tr>
                <td class="p-2">
                  <div class="body table-responsive p-0">          
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th colspan="5" class="pb-0">
                                        <div class="text-center my-auto">
                                            <h4 class="mb-0 progress_font"><?= $main_exam_data['exam_name']; ?> Report Card</h4>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <table style="" cellspacing="0" cellpadding="0">
            <tr>
                <td width="120">
                    School Name <br>
                    Phone <br>
                    Email <br>
                    Address
                </td>
                <td colspan="3" class="pl-0"><b>: &nbsp;&nbsp;&nbsp;<?= organisation_name($company); ?></b><br>
                    <b>: &nbsp;&nbsp;&nbsp;<?= organisation_phone($company); ?></b> <br>
                    <b>: &nbsp;&nbsp;&nbsp;<?= organisation_email($company); ?></b> <br>
                    <b>: &nbsp;&nbsp;&nbsp;<?= organisation_address($company); ?></b>

                </td>
                <td style="text-align:right;">
                    <div> 
                        <img src="<?= organisation_logo($company); ?>" alt="profile-image" style="width: auto;height: 100px;"  > 
                    </div>
                </td>
            </tr>
        </table>


         <br>

        
        <table style="line-height:1.5;" cellspacing="0" cellpadding="2" class="invoice_font">
            <tr style="color: black;"> 
                <td colspan="6" style=" border:1px solid #cccccc;padding: 0px 5px;"  >
                    Student Name :  <b><?= user_name($student['id']); ?></b>
                    
                </td>
                <td colspan="6" style=" border:1px solid #cccccc;padding: 0px 5px;"  >
                    Class :  <b><?= class_name(current_class_of_student_for_progress_card(year_of_academic_year($main_exam_data['academic_year']),$student['id'])) ?></b>
                    
                </td>
            </tr>
  
            <tr style="color: black;" id="thisheight"> 
                <td colspan="6" style=" border:1px solid #cccccc;padding: 0px 5px;"  >
                    Mother Name :  <b><?= $student['mother_name']; ?></b>
                    
                </td>
                 <td colspan="6" style=" border:1px solid #cccccc;padding: 0px 5px;"  >
                    Academic Year :  <b><?= year_of_academic_year($main_exam_data['academic_year']) ?></b>
                    
                </td>
            </tr>

            <tr style="color: black;" id="thisheight"> 
                <td colspan="6" style=" border:1px solid #cccccc;padding: 0px 5px;"  >
                    Father Name :  <b><?= $student['father_name']; ?></b>
                    
                </td>
                 <td colspan="6" style=" border:1px solid #cccccc;padding: 0px 5px;"  >
                    Admission No :  <b><?= school_code($company) ?><?= location_code($company) ?><?= $student['serial_no']; ?></b>        
                </td>
            </tr>
        </table>


        <br>

        <table style="padding-top: 10px; width: 100%;" cellpadding="5" cellspacing="0" class="invoice_font mt-4">

            <tr  style="border:1px solid #cccccc; background: #5a0923c9;color: white;" class="text-center">
                <td style=" text-align:center;border:1px solid #cccccc;"><b>Subject</b></td>
                <td style=" text-align:center;border:1px solid #cccccc;"><b>Subject code</b></td>
                <td style=" text-align:center;border:1px solid #cccccc;"><b>Max. Marks</b></td>
                <td style=" text-align:center;border:1px solid #cccccc;"><b> Min. Marks</b></td>
                <td style=" text-align:center;border:1px solid #cccccc;"><b>Aggregate</b></td>
                <td style=" text-align:center;border:1px solid #cccccc;"><b>Grade</b></td>
                <td style=" text-align:center;border:1px solid #cccccc;" class=""><b>Result</b></td>  
            </tr>

            <?php 
                $sumofmax=0;
                $sumofmin=0;
                $sumofaggre=0;
                $averggrade='';
                $grade='';
                foreach (exams_of_main_exam_of_progreecard($company,$main_exam_data['id'],current_class_of_student_for_progress_card(year_of_academic_year($main_exam_data['academic_year']),$student['id'])) as $emex):
                



                if ($emex['exammarks']=='grade') {
                    $sumofaggre='';
                }else{   
                    if (aggregate_marks(year_of_academic_year($main_exam_data['academic_year']),$student['id'],$emex['id'],$emex['exam_for_subject'])!='N/A') {
                        $sumofaggre+= aggregate_marks(year_of_academic_year($main_exam_data['academic_year']),$student['id'],$emex['id'],$emex['exam_for_subject']);
                    }
                }

                if ($emex['exammarks']=='grade') {
                    $averggrade='';
                }else{  
                    
                    $averggrade=percentage_to_grade($company,percent_of_numbers($sumofaggre,$sumofmax));
                }

            ?>



            <tr style="color: black;" id="thisheight"> 
                <td style="border:1px solid #cccccc;" valign="baseline">
                    <?php if (empty($emex['exam_name'])): ?>
                        <?= subjects_name($emex['exam_for_subject']); ?>
                    <?php else: ?>
                        <?= $emex['exam_name']; ?>
                    <?php endif ?>
                </td>
                <td style="border:1px solid #cccccc;" valign="baseline" class=""><?= subjects_code($emex['exam_for_subject']); ?></td>
                <td style="border:1px solid #cccccc;" valign="baseline" >
                    <?php if($emex['exammarks']=='grade'):?>
                        <?= $emex['max_grade']; ?>
                    <?php else: ?>   
                        <?= $emex['max_marks']; ?>
                    <?php endif ?>
                </td>
                <td style="border:1px solid #cccccc;" valign="baseline">
                    <?php if($emex['exammarks']=='grade'):?>
                        <?= $emex['min_grade']; ?>
                    <?php else: ?>   
                        <?= $emex['min_marks']; ?>
                    <?php endif ?>
 
                    <?php 
                        if ($emex['exammarks']=='grade') {
                             $sumofmax+=0;
                            $sumofmin+=0;
                        }else{
                           
                            $sumofmax+=$emex['max_marks'];
                            $sumofmin+=$emex['min_marks'];
                            
                        }
                     ?> 
                </td>
                <td style="border:1px solid #cccccc;" valign="baseline">
                    <?= aggregate_marks($company,$student['id'],$emex['id'],$emex['exam_for_subject']); ?>        
                </td>
                 <td style="border:1px solid #cccccc;" valign="baseline">
                    <?php if($emex['exammarks']=='grade'):?> 
                        <?= aggregate_marks($company,$student['id'],$emex['id'],$emex['exam_for_subject']); ?>        
                    <?php else: ?>
                        <?= percentage_to_grade($company,percent_of_numbers(aggregate_marks($company,$student['id'],$emex['id'],$emex['exam_for_subject']),$emex['max_marks'  ])); ?>
                    <?php endif ?>
                </td>

                <td style="border:1px solid #cccccc;" valign="baseline" class="">
                    <?php if($emex['exammarks']=='grade'):?>
                        <?php if (value_of_grade(aggregate_marks($company,$student['id'],$emex['id'],$emex['exam_for_subject']),company($user['id']))>=value_of_grade($emex['min_grade'],company($user['id']))){echo "Pass"; }else{ echo "Fail";} ?>
                    <?php else: ?>
                        <?php if (aggregate_marks($company,$student['id'],$emex['id'],$emex['exam_for_subject'])>=$emex['min_marks']){echo "Pass"; }else{ echo "Fail";} ?>
                    <?php endif ?>
                </td>

            </tr>



            <?php endforeach ?>
            <tr>
                <td style="border:1px solid #cccccc;" valign="baseline" colspan="2">
                    <b>Total</b>
                </td>


                <td style="border:1px solid #cccccc;" valign="baseline">
                    <b><?= $sumofmax; ?></b>
                </td>
                <td style="border:1px solid #cccccc;" valign="baseline">
                    <b><?= $sumofmin; ?></b>
                </td>
                <td style="border:1px solid #cccccc;" valign="baseline">
                    <b><?= $sumofaggre; ?></b>
                </td>
                <td style="border:1px solid #cccccc;" valign="baseline">
                    <b><?= $averggrade; ?></b>
                </td>


                 <td style="border:1px solid #cccccc;" valign="baseline">
                   
                </td>
            </tr>
            

        </table>

        <br>


    <!--     <div>
            <h4>Grading Scale :</h4>
            <table  style="width:50%; line-height: 1.5;" cellspacing="0" cellpadding="5" class="invoice_font">
                <tr style="color: black;"> 
                    <td colspan="2" style=" border:1px solid #cccccc;padding: 5px 5px;"  >
                        A+ = 80 - 100 <br>
                        
                        B+ = 55 - 60  <br>
                        
                        C+ = 55 - 60  <br>
                        D+ = 55 - 60  <br>
                        E+ = 55 - 60  <br>
                    </td>
                    <td colspan="2" style=" border:1px solid #cccccc;padding: 0px 5px;"  >
                        
                        A  = 70 - 80  <br>
                        B  = 55 - 60  <br>
                        C  = 55 - 60  <br>
                        D  = 55 - 60  <br>
                        
                        E  = 55 - 60  <br>
                        F  = Fail
                        
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
      
                
            </table>
        </div> -->
       
    </div>
</div>



