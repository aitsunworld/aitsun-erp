<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>" class="href_loader"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>

                <li class="breadcrumb-item active href_loader" aria-current="page">
                    <a href="<?= base_url('student-master'); ?>">Student Master</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= $student_data['first_name']; ?></b>
                </li>
            </ol>
        </nav>

        
     
        <div class="d-flex">
           
            <a class="my-auto ms-2 text-dark cursor-pointer font-size-topbar href_loader" title="Refresh" onclick="location.reload();">    
                <i class="bx bx-refresh"></i>
            </a>
             <a class="my-auto ms-2 text-aitsun-red href_loader cursor-pointer font-size-topbar" href="<?= base_url() ?>" title="Back">
                <i class="bx bxs-category"></i>
            </a>
        </div>

    </div>
</div>
<!-- ////////////////////////// TOP BAR END ///////////////////////// -->


<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="no_toolbar_sub_main_page_content overflow-scroll pt-4 pb-5 bg-invoice">
    <div class="card ">
        <div class="card-body w-100 pt-0 mb-5">  
            <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="avatar avatar-image avatar-lg orglogo mt-2">
                            <img src="<?= organisation_logo($user['company_id']); ?>">
                        </div>
                        <h4 class="mb-0"><?= organisation_name($user['company_id']); ?></h4>
                        <span class="text-gray font-size-14"><?= organisation_address($user['company_id']); ?></span>
                        <span class="d-block font-size-14">
                            Academic Year:&nbsp;<b>  <?= year_of_academic_year(academic_year($user['id'])) ?></b>
                        </span>
                        <hr>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="avatar avatar-image rounded">
                                    <img src="<?= student_pro_pic($student_data['id']); ?>" style="object-fit: contain; height: 110px;width: 110px;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media ">
                                    <div class="m-l-15">
                                        <p class=" mb-0 text-gray">Name</p>
                                        <p class=" mb-0">Class</p> 
                                        <p class=" mb-0">Registration No.</p>
                                        <p class=" mb-0">Roll No.</p>
                                        <p class=" mb-0">Joined on</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <p class="mb-0 text-dark">: <b><?= $student_data['first_name']; ?></b></p>
                                <p class=" mb-0 text-dark">: <b><?= class_name(current_class_of_student(company($user['id']),$student_data['id'])) ?> </b></p>
                                
                                <p class=" mb-0 text-dark">: <b><?= school_code(company($user['id']))?><?= location_code(company($user['id']))?><?= $student_data['serial_no']; ?></b></p> 
                                 <p class=" mb-0 text-dark">: <b><?=get_roll_no_of_student(company($user['id']),$student_data['id']); ?></b></p>
                                <p class=" mb-0 text-dark">: <b><?= get_date_format($student_data['date_of_join'],'d M Y'); ?></b></p>
                            </div>
                        </div>
                        
                    </div>
                
                    <div class="col-md-12 mt-0 mb-2">
                        <hr class="mt-0 mb-3">
                        <h5><b>Personal Information :</b></h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row ml-3">
                            <div class="col-md-4">
                                <p class=" mb-0">Father Name</p>
                                <p class=" mb-0">Mother Name</p>
                                <p class=" mb-0">Date Of Birth</p>
                                <p class=" mb-0">Age</p>
                                <p class=" mb-0">Contact</p>
                                <?php if ($student_data['religion']!=''): ?>
                                <p class=" mb-0">Religion</p>
                                <?php endif ?>
                                <?php if ($student_data['adhar']!=''): ?>
                                <p class=" mb-0">Adhar Number</p>
                                <?php endif ?>
                                
                            </div>
                            <div class="col-md-8">
                                <p class=" mb-0 text-dark">: <b><?= $student_data['father_name']; ?></b></p>
                                <p class=" mb-0 text-dark">: <b><?= $student_data['mother_name']; ?></b></p>
                                <p class=" mb-0 text-dark">: <b><?= get_date_format($student_data['date_of_birth'],'d M Y'); ?></b></p>
                                <p class=" mb-0 text-dark">: <b><?= $student_data['stdage']; ?></b></p>
                                <p class=" mb-0 text-dark">: <b><?= $student_data['phone']; ?></b>
                                    <?php if ($student_data['phone_2']!=''): ?>
                                    , <b><?= $student_data['phone_2']; ?></b>
                                    <?php endif ?>
                                </p>
                               <?php if ($student_data['religion']!=''): ?>
                                   <p class=" mb-0 text-dark">: <b><?= $student_data['religion']; ?></b></p>
                               <?php endif ?>
                                <?php if ($student_data['adhar']!=''): ?>
                                <p class=" mb-0 text-dark">: <b><?= $student_data['adhar']; ?></b></p>
                                <?php endif ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 ml-3">
                                <?php if ($student_data['blood_group']!=''): ?>
                                <p class=" mb-0">Blood Group</p>
                                <?php endif ?>
                                <p class=" mb-0">Address </p>
                                <p class=" mb-0">Category </p>
                                 <?php if ($student_data['ration_card_no']!=''): ?>
                                <p class=" mb-0">Ration Card No.  </p>
                                <?php endif ?>
                                <?php if ($student_data['bank_name']!=''): ?>
                                <p class=" mb-0">Bank Name </p>
                                <?php endif ?>
                                <?php if ($student_data['account_number']!=''): ?>
                                <p class=" mb-0">Bank A/C No. </p>
                                <?php endif ?>
                                <?php if ($student_data['ifsc']!=''): ?>
                                <p class=" mb-0">Bank IFSC Code </p>
                                <?php endif ?>
                            </div>
                            <div class="col-md-8">
                                <?php if ($student_data['blood_group']!=''): ?>
                                <p class=" mb-0 text-dark">: <b><?= $student_data['blood_group']; ?></b></p>
                                <?php endif ?>
                                <p class=" mb-0">:  <b class="text-dark"><?= nl2br($student_data['billing_address']); ?></b></p>
                                <p class=" mb-0">:  <b class="text-dark"><?= student_category_name($student_data['category']); ?></b>
                                <?php if ($student_data['subcategory']!=0): ?>
                                 - <b class="text-dark"><?= student_category_name($student_data['subcategory']); ?></b>
                                <?php endif ?>
                                 </p>
                                 <?php if ($student_data['ration_card_no']!=''): ?>
                                <p class=" mb-0">:  <b class="text-dark"><?= $student_data['ration_card_no']; ?></b></p>
                                <?php endif ?>
                                <?php if ($student_data['bank_name']!=''): ?>
                                <p class=" mb-0">: <b class="text-dark"><?= $student_data['bank_name']; ?></b></p>
                                <?php endif ?>
                                <?php if ($student_data['account_number']!=''): ?>
                                <p class=" mb-0">:  <b class="text-dark"><?= $student_data['account_number']; ?></b></p>
                                <?php endif ?>
                                <?php if ($student_data['ifsc']!=''): ?>
                                <p class=" mb-0">:  <b class="text-dark"><?= $student_data['ifsc']; ?></b></p>
                                <?php endif ?>
                                
                            </div>

                        </div>

                    </div>

                    <div class="col-md-12 mb-0">
                        <hr class="mt-3 mb-3">
                        <h5><b>Analyitics :</b></h5>
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div>
                                    <input type="text" class="knob dial1" value="<?= percentage_of_attended(current_class_of_student(company($user['id']),$student_data['id']),$student_data['id'],company($user['id'])); ?>" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#666" readonly>                        
                                    <h6 class="m-t-20">Attendance</h6>
                                    <p class="displayblock mb-0"><?= percentage_of_attended(current_class_of_student(company($user['id']),$student_data['id']),$student_data['id'],company($user['id'])); ?>% Average </p>  
                                </div>
                                            
                            </div>
                            <div class="col-md-4">
                                <div>
                                <input type="text" class="knob dial2" value="<?= get_analytics_data(company($user['id']),$student_data['id'],'involve_sports') ?>" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#7b69ec" readonly>
                                <h6 class="m-t-20">Involvement in sports</h6>
                                <p class="displayblock mb-0"><?= get_analytics_data(company($user['id']),$student_data['id'],'involve_sports') ?>% Average </p>
                                </div>    
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <input type="text" class="knob dial3" value="<?= get_analytics_data(company($user['id']),$student_data['id'],'involve_eccc') ?>" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#f9bd53" readonly>
                                    <h6 class="m-t-20">Extra activities</h6>
                                    <p class="displayblock mb-0"><?= get_analytics_data(company($user['id']),$student_data['id'],'involve_eccc') ?>% Average </p>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <hr class="mt-3 mb-3">
                    </div>
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-7">
                                    <h5 class="m-t-0">Performance in Exams</h5>
                                    <p class="text-small text-black-50"><?= aitsun_round(performance_in_exams(company($user['id']),$student_data['id']),2); ?>% average (exclude online exams)</p>
                                </div>
                                <div class="col-5 text-end">
                                    <h2 class=""><?= aitsun_round(performance_in_exams(company($user['id']),$student_data['id']),2); ?></h2>
                                    <small class="info">of 100</small>
                                </div>
                                <div class="col-12">
                                    <div class="progress m-t-20">
                                    <div class="progress-bar l-amber" role="progressbar" aria-valuenow="<?= performance_in_exams(company($user['id']),$student_data['id']); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= performance_in_exams(company($user['id']),$student_data['id']); ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                            <div class="col-7">
                                <h5 class="m-t-0">Health</h5>
                                <p class="text-small text-black-50">Fat percentage <i class="zmdi zmdi-trending-up"></i> <?= calculate_BMI(get_health_data(company($user['id']),$student_data['id'],'weight'),get_health_data(company($user['id']),$student_data['id'],'height'),age_of_student(get_student_data(company($user['id']),$student_data['id'],'date_of_birth'),get_date_format(now_time($user['id']),'d-m-Y')),get_student_data(company($user['id']),$student_data['id'],'gender'),'fat_percentage'); ?>%</p>
                            </div>
                            <div class="col-5 text-end">
                                <h2 class=""><?= 100-calculate_BMI(get_health_data(company($user['id']),$student_data['id'],'weight'),get_health_data(company($user['id']),$student_data['id'],'height'),age_of_student(get_student_data(company($user['id']),$student_data['id'],'date_of_birth'),get_date_format(now_time($user['id']),'d-m-Y')),get_student_data(company($user['id']),$student_data['id'],'gender'),'fat_percentage'); ?>%</h2>
                                <small class="info">of 100</small>
                            </div>
                            <div class="col-12">
                                <div class="progress m-t-20">
                                <div class="progress-bar l-blue" role="progressbar" aria-valuenow="<?= 100-calculate_BMI(get_health_data(company($user['id']),$student_data['id'],'weight'),get_health_data(company($user['id']),$student_data['id'],'height'),age_of_student(get_student_data(company($user['id']),$student_data['id'],'date_of_birth'),get_date_format(now_time($user['id']),'d-m-Y')),get_student_data(company($user['id']),$student_data['id'],'gender'),'fat_percentage'); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= 100-calculate_BMI(get_health_data(company($user['id']),$student_data['id'],'weight'),get_health_data(company($user['id']),$student_data['id'],'height'),age_of_student(get_student_data(company($user['id']),$student_data['id'],'date_of_birth'),get_date_format(now_time($user['id']),'d-m-Y')),get_student_data(company($user['id']),$student_data['id'],'gender'),'fat_percentage'); ?>%;"></div>
                                </div>
                            </div>
                        </div>

                        </div>
                    

                    <div class="col-md-12 mt-0 mb-0">
                        <hr class="mt-2 mb-3">
                        
                    </div>

                    <div class="col-md-6">
                        <h5><b>Articles :</b></h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class=" mb-0">Total Articles</p>
                                <p class=" mb-0">Accepted</p>
                                <p class=" mb-0">Rejected</p>

                            </div>
                            <div class="col-md-6">
                                <p class=" mb-0 text-dark">: <b><?= total_articles_of_student(company($user['id']),$student_data['id'],'all') ?></b></p>
                                <p class=" mb-0 text-dark">: <b class="text-success"><?= total_articles_of_student(company($user['id']),$student_data['id'],'accepted') ?></b></p>
                                <p class=" mb-0 text-dark">: <b class="text-danger"><?= total_articles_of_student(company($user['id']),$student_data['id'],'rejected') ?></b></p>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5><b>Books :</b></h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class=" mb-0">Total Issued Books</p>
                                <p class=" mb-0">Returned</p>
                                <p class=" mb-0">In Hand</p>

                            </div>
                            <div class="col-md-6">
                                <p class=" mb-0 text-dark">: <b><?= total_issued_books_of_student(company($user['id']),$student_data['id'],'all') ?></b></p>
                                <p class=" mb-0 text-dark">: <b class="text-success"><?= total_issued_books_of_student(company($user['id']),$student_data['id'],'received') ?></b></p>
                                <p class=" mb-0 text-dark">: <b class="text-danger"><?= total_issued_books_of_student(company($user['id']),$student_data['id'],'Not Returned Yet') ?></b></p>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3 mb-3">
                        <hr class="mt-2 mb-3">
                    </div>

                    <div class="col-md-6">
                        <h5><b>Sports </b> <?php 
                                 
                                    $toEnd = count(sports_student_participate_array(company($user['id']),$student_data['id']));

                                    foreach (sports_student_participate_array(company($user['id']),$student_data['id']) as $stp): ?>

                                    (<?= subjects_name($stp['sports_id']); ?>) <?php if (0 === --$toEnd) {}else{echo ',';}
                                ?>  <?php endforeach ?> :</h5>
                      

                                <ol>
                                    <?php foreach (sports_student_event_array(company($user['id']),$student_data['id']) as $spevnt): ?>

                                    <li class="mb-2 font-size-12">
                                    <?php if ($spevnt['reward']!='participated'): ?>
                                        Secured
                                    <?php endif ?>
                                     <b><?= ucfirst($spevnt['reward']); ?>
                                    <?php if ($spevnt['reward']!='participated'): ?>
                                        price
                                    <?php endif ?></b> in <b><?= get_sports_event_data(company($user['id']),$spevnt['event_id'],'events_name'); ?></b> held from <b><?= get_date_format(get_sports_event_data(company($user['id']),$spevnt['event_id'],'from'),'d M Y'); ?></b> to <b><?= get_date_format(get_sports_event_data(company($user['id']),$spevnt['event_id'],'to'),'d M Y'); ?></b> at <b><?= get_sports_event_data(company($user['id']),$spevnt['event_id'],'place'); ?></b></li>

                                    <?php endforeach ?>
                                </ol>

                    </div>

                    <div class="col-md-6">
                        
                        <h5><b>EC/CC</b> <?php 
                                 
                                    $toecEnd = count(eccc_student_participate_array(company($user['id']),$student_data['id']));

                                    foreach (eccc_student_participate_array(company($user['id']),$student_data['id']) as $ectp): ?>

                                    (<?= subjects_name($ectp['sports_id']); ?>) <?php if (0 === --$toecEnd) {}else{echo ',';}
                                ?>  <?php endforeach ?> :</h5>
                      

                                <ol>
                                    <?php foreach (eccc_student_event_array(company($user['id']),$student_data['id']) as $eccevnt): ?>

                                    <li class="mb-2 font-size-12">
                                    <?php if ($eccevnt['reward']!='participated'): ?>
                                        Secured
                                    <?php endif ?>
                                     <b><?= ucfirst($eccevnt['reward']); ?>
                                    <?php if ($eccevnt['reward']!='participated'): ?>
                                        price
                                    <?php endif ?></b> in <b><?= get_sports_event_data(company($user['id']),$eccevnt['event_id'],'events_name'); ?></b> held from <b><?= get_date_format(get_sports_event_data(company($user['id']),$eccevnt['event_id'],'from'),'d M Y'); ?></b> to <b><?= get_date_format(get_sports_event_data(company($user['id']),$eccevnt['event_id'],'to'),'d M Y'); ?></b> at <b><?= get_sports_event_data(company($user['id']),$eccevnt['event_id'],'place'); ?></b></li>

                                    <?php endforeach ?>
                                </ol>
                    </div>




                    <div class="col-md-12 mt-2 mb-0">
                        <hr class="mt-3 mb-3">
                        <h5><b>Exam Details :</b></h5>
                    </div>



                    <div class="col-md-12">
                        


                        <?php foreach ($exam_data as $stexm): ?>

                            <div>
                                <a href="<?= base_url('exams/result'); ?>/<?= $stexm['id']; ?>/<?=$student_data['id'] ?>"><?= $stexm['exam_name'] ?></a>
                            </div>

                            
                        <?php endforeach ?>
                            


                       
                       
                    </div>

                    <div class="col-md-12 mt-2 mb-0">
                        <hr class="mt-3 mb-3">
                        <h5><b>Receipts :</b></h5>
                    </div>

                    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="parties_table" class="erp_table sortable">
                
             <thead>   
                <tr>
                    <th class="sorticon">Receipt Number</th>
                    <th class="sorticon">Fees Name</th>
                    <th class="sorticon">Total</th> 
                    <th class="sorticon">Payable Amount</th> 
                    <th class="sorticon">Concession</th>   
                    <th class="sorticon">Paid Amount</th> 
                    <th class="sorticon">Due Amount</th> 
                    <th class="sorticon">Date</th> 
                    <th class="sorticon">Status</th>
                    <th class="sorticon">Action</th>

                </tr>
             
             </thead>
              <?php  $data_count=0; ?>
                 <?php foreach ($invoice_of_student as $di){ $data_count++; ?>
              <tbody>
               
                    <td><a class="aitsun_link href_loader"  href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $di['id']; ?>">No. <?= inventory_prefix(company($user['id']),$di['invoice_type']) ?><?= $di['serial_no'] ?></a> </td>
                    <td><b><?= get_fees_data(company($user['id']),$di['fees_id'],'fees_name'); ?></b></td>
                    <td><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($di['main_total'],2); ?></td>
                    <td><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($di['total'],2); ?></td>

                    <td><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($di['discount'],2); ?></td>
                   
                   
                    <td><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($di['paid_amount'],2); ?></td>

                   
                    <td><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($di['due_amount'],2); ?></td>

                    <td>
                        
                        <?= get_date_format($di['invoice_date'],'d M Y'); ?>   
                        
                    </td>
                   

                    <td>
                        <?php if ($di['paid_status']=='paid'): ?>
                            <span class="badge badge-pill badge-success" style="color:green;">Fully Paid</span>
                        <?php endif ?>

                        <?php if ($di['paid_status']=='unpaid'): ?>
                            <?php if ($di['due_amount']>0 && $di['due_amount']<$di['total']): ?>
                                <span class="badge badge-pill badge-warning" style="color:red;">Half paid</span>
                            <?php else: ?>
                                <span class="badge badge-pill badge-danger" style="color:#ffb000;">Unpaid</span>
                            <?php endif ?>
                        <?php endif ?>
                    </td>
                    <td class="text-center">
                         <?php if ($di['due_amount']>0): ?>
                           <a class="my-auto  btn-sm btn-back rounded-pill" href="<?= base_url('fees_and_payments/payments'); ?>/<?= $di['id']; ?>">Pay due</a> 
                        <?php endif ?>
                    </td>


              </tbody>
              <?php } ?>
                
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="12">
                            <span class="text-danger">No Receipts</span>
                        </td>
                    </tr>
                <?php endif ?>
              
            </table>
        </div>

        

    </div>




                 </div>
        </div>
    </div>
</div>
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
