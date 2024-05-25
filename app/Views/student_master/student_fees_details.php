<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title><\= $title ?></title> -->
</head>
<body>
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
    .company_logo{
      height: 50px;
    } 
    .invoice_font{
      font-size: 13px;
    }
    table{width: 100%;}      
    body{
        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
    }
 </style>

 <!-- header -->
 <table>
    <tr>
        <td style="text-align:center;">
            <h4 style="margin-bottom: 5px;"><?= organisation_name($user['company_id']); ?></h4>
            <span style="font-size: 13px;"><?= organisation_address($user['company_id']); ?></span>
            <br>
            <span style="font-size: 13px;">
                Academic Year:&nbsp;<b><?= year_of_academic_year(academic_year($user['id'])) ?></b>
            </span>
            <hr style="margin-bottom:0;margin-top:10px;"> 
        </td>
    </tr>
 </table>

<!-- date & time section -->
 <table>
    <tr>
        <td><div style="font-size:13px;text-align: left;"><?= get_date_format(now_time($user['id']),'d M Y') ?></div></td>
        <td><div style="font-size:13px;text-align: right;"><?= get_date_format(now_time($user['id']),'h:i A') ?></div></td>
    </tr>
    <tr>
        <td colspan="2"><hr style="margin:0;"></td>
    </tr>
 </table>

 <!-- Student details & Fees details -->
 <table>
    <tr>
        <td style="width:50%;">
            <!-- student details table -->
            <table style="font-size:13px;"> 
                <tr>
                    <td style="color:black;width:100px;">Name</td>
                    <td><b><?= $student_data['display_name']; ?></b></td>
                </tr>
                <tr>
                    <td style="color:black;width:100px;">Class</td>
                    <td><b><?= class_name(current_class_of_student(company($user['id']),$student_data['id'])) ?> </b></td>
                </tr>
                <tr>
                    <td style="color:black;width:100px;">Reg. No.</td>
                    <td><b><?= school_code(company($user['id']))?><?= location_code(company($user['id']))?><?= $student_data['serial_no']; ?></b></td>
                </tr>
                <tr>
                    <td style="color:black;width:100px;">Adms. No.</td>
                    <td><b><?= $student_data['admission_no']; ?></td>
                </tr>
                <tr>
                    <td style="color:black;width:100px;">Contact:</td>
                    <td><b><b><?= $student_data['phone']; ?></b></td>
                </tr>
                <tr>
                    <td style="color:black;width:100px;">Address:</td>
                    <td><b><b><?= nl2br($student_data['billing_address']); ?></b></td>
                </tr>
            </table>
        </td>
        <td valign="baseline">
            <!-- fees details table --> 
            <table style="font-size:13px;">  
                <?php $total_fees=0; $total_due=0; foreach ($invoice_of_student as $di){ $total_fees+=aitsun_round($di['total'],2); $total_due+=aitsun_round($di['due_amount'],2); ?>
                    <tr>
                        <td style="color:black;"><?= get_fees_data(company($user['id']),$di['fees_id'],'fees_name'); ?></td>
                        <td style="text-align:right;"><b><?= aitsun_round($di['total'],2); ?></b></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><hr style="margin-bottom:0;margin-top:0;"></td>
                </tr> 
                <tr>
                    <td style="color:black;">Total Fees</td> 
                    <td style="text-align:right;"><b><?= aitsun_round($total_fees,2); ?></b></td>
                </tr>
                <tr>
                    <td colspan="2"><hr style="margin-bottom:0;margin-top:0;"></td>
                </tr> 
            </table>
        </td>
    </tr> 
 </table>
<br>
 <!-- Student fees payment details -->
<table border="1" cellspacing="0" cellpadding="2">
    <tr style="font-size:13px; border-top: 1px solid; border-bottom: 1px solid;">
        <td><b>Receipt No.</b></td>
        <td style="text-align: center"><b>Date</b></td>
         <?php foreach ($invoice_of_student as $fs){
                $var_name=$fs['fees_id'];
                ${'total_f_'.$var_name} = 0;
          ?> 
            <td style="color:black; text-align: center;"><b><?= get_fees_data(company($user['id']),$fs['fees_id'],'fees_name'); ?></b></td> 
         <?php } ?>
        <td style="text-align: right"><b>Total</b></td>
    </tr>
    <?php $total_paid=0; foreach ($payments_of_students as $db){  ?>
        <tr style="font-size:13px;">  
            <td style="color:black;"><?= get_setting($user['company_id'],'payment_prefix'); ?> <?= $db['serial_no']; ?></td>
            <td style="text-align: center"><?= get_date_format($db['datetime'],'d-m-Y'); ?></td>
            
            <?php 
                $tamount=0; foreach ($invoice_of_student as $ps){   
                $m_name=$ps['fees_id'];
            ?> 
                <td style="text-align: center">
                    <?php if ($ps['fees_id']==$db['fees_id']): ${'total_f_'.$m_name}+=aitsun_round($db['amount'],2); $tamount+=aitsun_round($db['amount'],2); ?>
                        <?= aitsun_round($db['amount'],2); ?>
                    <?php else: ?>
                    - 
                    <?php endif ?> 
                </td> 
            <?php } ?>

            <td style="text-align:right;"><b><?= aitsun_round($tamount,2); ?> <?php $total_paid+=aitsun_round($tamount,2); ?></b></td> 
        </tr>
    <?php } ?>
    
     <tr style="font-size:13px;">  
        <td style="color:black; text-align: center;" colspan="2">
            <b>Total paid</b>
        </td>
        <?php  foreach ($invoice_of_student as $nps){ $fvar_name=$nps['fees_id'];?> 
            <td style="text-align: center">
                <b><?= aitsun_round(${'total_f_'.$fvar_name},2); ?></b>
            </td> 
        <?php } ?>

        <td style="text-align:right;"><b><?= aitsun_round($total_paid,2); ?></b></td> 

        
    </tr>

</table>

<br>

<table>
     <tr>
        <td colspan="2"><hr style="margin-bottom:0;margin-top:0;"></td>
    </tr> 
    <tr style="font-size:13px;">
        <td>Total pending fees</td>
        <td style="text-align:right;"><b><?= aitsun_round($total_due,2); ?></b></td>
    </tr>
    <tr>
        <td colspan="2"><hr style="margin-bottom:0;margin-top:0;"></td>
    </tr> 
</table>

</body>
</html>