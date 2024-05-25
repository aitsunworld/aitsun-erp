<div class="topbar d-flex">
        <div class="right_bar d-flex justify-content-between w-100">
            <div class="d-flex">
                <img src="<?= base_url('public/images/logo_full-white.png') ?>" class="app_logo my-auto me-4">

                
                 <div class="dropdown my-auto">
                 
                  <a class="my-auto ms-2 text-light position-relative cursor-pointer font-size-topbar" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <i class='bx bx-search mb-0' style="font-size: 20px; margin-top: 2px;"></i>
                    </a>

                  <ul class="dropdown-menu aitsun-dropdown-quick-search">
                    <li>
                        <div class="position-relative search-bar-box my-auto">
                            <form method="get" action="javascript:void(0);">
                                <input type="hidden" name="csrf_aitsun_token" value="026cc814ea22e7fa8b3d2345e42a6243">                             <input type="text" class="aitsun_focus form-control search-control" name="product_name" placeholder="Type to search..." autocomplete="off" id="wholesearch"> <span class="position-absolute top-50 search-show translate-middle-y"><i class="bx bx-search"></i></span>
                                <span class="position-absolute top-50 search-close translate-middle-y"><i class="bx bx-x"></i></span>
                            </form>
                            <div class="search_result d-none">
                                <div class="search_result_inner p-2">
                                    <ul id="suggest">
                                        
                                    </ul>
                                </div>
                            </div>

                            <div class="searchbox_close_layer"></div>

                        </div>
                    </li> 
                  </ul>
                </div>
                    
            </div>
            
            <div class="my-auto dropdown">
                <div class="d-flex">

                    <!-- cash -->
                    <a href="cursor-pointer" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><h6 class="mb-0 text-light font-size-topbar me-4" style="font-weight: 300;">Cash <b><?= currency_symbol(company($user['id'])) ?> <?= cash_in_hand(company($user['id'])) ?></b></h6></a>
                       

                    <div class="dropdown-menu aitsun-dropdown-menu" style="width: 300px;">
                        <?php foreach (only_cash_accounts_of_account(company($user['id'])) as $ca): ?>
                        <div class="dropdown_css d-flex justify-content-center align-items-center" style="height: 100%;">
                            <div class="my-auto"> 
                                <h5 for="input-5" class="form-label mb-0" style="font-size: 13px;">
                                    <?= $ca['group_head']; ?>
                                </h5>
                            </div>
                            <div class="my-auto ms-4">
                                <input type="number" step="any" name="closing_balance" value="<?= aitsun_round($ca['closing_balance'],get_setting(company($user['id']),'round_of_value')) ?>" class="form-control allow_minus form_input" style="background: transparent!important;" placeholder="Amount">
                            </div>
                            <div style="font-size: 20px;" class="ms-4 my-auto check-mark" data-group-head-id="<?= $ca['id'] ?>">
                                <i class="bx bx-check-circle" style="color: green;"></i>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>

                    <!-- cash -->

                    <!-- bank -->
                    
                    <a href="cursor-pointer" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><h6 class="mb-0 text-light font-size-topbar cursor-pointer" style="font-weight: 300;">Bank <b><?= currency_symbol(company($user['id'])) ?> <?= cash_in_bank(company($user['id'])) ?></b></h6></a>

                    <div class="dropdown-menu aitsun-dropdown-menu" style="width: 300px;">
                        <?php foreach (only_bank_accounts_of_account(company($user['id'])) as $ba): ?>
                        <div class="dropdown_css d-flex align-items-center" style="height: 100%;">
                            <div class="my-auto"> 
                                <h5 for="input-5" class="form-label mb-0" style="font-size: 13px;">
                                    <?= $ba['group_head']; ?>
                                </h5>
                            </div>
                            <div class="my-auto ms-4">
                                <input type="number" step="any" name="closing_balance" value="<?= aitsun_round($ba['closing_balance'],get_setting(company($user['id']),'round_of_value')) ?>" class="form-control allow_minus form_input" style="background: transparent!important;">
                            </div>
                            <div style="font-size: 20px;" class="ms-4 my-auto check-mark" data-group-head-id="<?= $ba['id'] ?>">
                                <i class="bx bx-check-circle" style="color: green;"></i>
                            </div>
                        </div>
                         <?php endforeach ?>
                    </div>

                    <!-- bank -->

                </div>
            </div>
 
         
            <div class="d-flex">
                <?php if (is_school(company($user['id']))): ?>
                    <a class="my-auto ms-2 text-light cursor-pointer href_loader font-size-topbar" href="<?= base_url('settings/academic_year') ?>"> 
                        <?= year_of_academic_year(academic_year($user['id'])) ?>
                    </a>
                 <?php endif ?>
                <a class="my-auto ms-2 text-light href_loader cursor-pointer font-size-topbar go_back_or_close" title="Back">
                    <i class="bx bx-arrow-back"></i>
                </a>
                <a class="my-auto ms-2 text-light cursor-pointer font-size-topbar href_loader" title="Refresh" onclick="location.reload();">    
                    <i class="bx bx-refresh"></i>
                </a>

                 <a class="my-auto ms-2 text-light position-relative cursor-pointer font-size-topbar href_loader" href="<?= base_url('notifications') ?>"><div id="bell"></div>
                        <i class='bx bx-bell'></i>
                </a>

                
                 <div class="dropdown my-auto">
                 
                  <a class="my-auto ms-2 text-light position-relative cursor-pointer font-size-topbar" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <i class='bx bx-cog mb-1'></i>
                    </a>

                  <ul class="dropdown-menu aitsun-dropdown-menu">
                    <li><a class="dropdown-item href_loader" href="<?= base_url('settings'); ?>">Profile</a></li>
                    <li><a class="dropdown-item href_loader" href="<?= base_url('settings/organisation-setting'); ?>">Organisation settings</a></li>
                    <li><a class="dropdown-item href_loader" href="<?= base_url('branch_manager'); ?>">Branch Manager</a></li> 
                    <li><a class="dropdown-item href_loader" href="<?= base_url('users/logout') ?>">Logout</a></li> 
                  </ul>
                </div>



                <div class="dropdown my-auto">
                 
                  <a class="d-flex align-items-center nav-link pe-0 py-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= base_url(); ?>/public/images/avatars/<?php if($user['profile_pic'] != ''){echo $user['profile_pic']; }else{ echo 'avatar-icon.png';} ?>" class="user-img" alt="user avatar">
                        <div class="user-info ps-3">
                            <p class="user-name mb-0 text-light"><?= get_company_data(company($user['id']),'company_name') ?></p>
                            <p class="designattion mb-0 text-white-50"><?= user_data($user['id'],'display_name'); ?></p>
                        </div>
                    </a>

                  <ul class="dropdown-menu aitsun-dropdown-menu">
                    
                    <?php foreach ($branches as $br): ?>

                          <?php if (is_allowed_branch($br['id'],$user['allowed_branches'])==true || $user['author']==1 || $user['u_type']=='admin'): ?>
                              
                           

                            <?php if (company($user['id'])==$br['id']): ?>

                            <?php else: ?>

                                <li> 
                                    <a class="dropdown-item branch_click_quick_change" data-href="<?= base_url('branch_manager/change_branch_ajax'); ?>/<?= $br['id']; ?>">
                                        <i class="bx bx-building-house"></i>
                                        <?= $br['company_name']; ?>
                                    </a>
                                </li> 
                          <?php endif; ?>
                            
 
                          <?php endif ?>

                        <?php endforeach ?>
                     

                        <li>
                        <?php if ($user['author'] == 1): ?>
                            <a class="dropdown-item" href="<?= base_url('branch_manager') . '?trigger-modal=add_branch'; ?>">
                                <i class="bx bx-plus"></i>
                                New branch
                            </a>
                        <?php else: ?>
                            <a class="dropdown-item" onclick="popup_message('error','Failed','You don\'t have permission. Contact your administrator!');">
                                <i class="bx bx-plus"></i>
                                New branch
                            </a>
                        <?php endif; ?>
                        </li>
                  </ul>
                </div>

            </div>
                 

            
                

               

        </div>
    </div>


    <style type="text/css">
        .dropdown_css{
            font-size: 13px;
            padding: .25rem 1rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }
    </style>