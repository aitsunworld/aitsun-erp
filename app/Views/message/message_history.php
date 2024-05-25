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

                <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url('messaging'); ?>" class="href_loader" >Message</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Message History</b>
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


<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">
    <div>
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#message_history_table" data-filename="Message History"> 
            <span class="my-auto">Excel</span>
        </a>
        
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
        
   

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">

    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="message_history_table" class="erp_table ">
             <thead>
                <tr>
                    <th>#</th>
                    <th>Number</th> 
                    <th>Message</th> 
                    <th>Date</th> 
                    <th>Sender</th> 
                </tr>
            </thead>
            <tbody>

                <?php $i=0; foreach ($message_data as $msl): $i++; ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $msl['number']; ?></td>
                        <td class="w-50"><?= $msl['message']; ?></td>
                        <td><?= get_date_format($msl['datetime'],'d-m-Y H:i A'); ?></td>
                        <td><?= user_name($msl['sender_id']); ?></td>
                        
                    </tr>

                    <?php endforeach ?>
                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="5"><center>No messages</center></td>
                        </tr>
                    <?php endif ?>
 
            </tbody>
            </table>
        </div>

        

    </div>

    
    
</div>


