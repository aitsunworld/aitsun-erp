<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;


class E_mailer extends BaseController
{
    public function index()
    {

        $session=session();
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $UserModel=new Main_item_party_table;
            $usaerdata=$UserModel->where('id',$myid)->first();

            $data=[
                'title'=>'E-mailer | Erudite ERP',
                'user'=>$usaerdata,

            ];

                echo view('header',$data);
                echo view('emailer/emailer');
                echo view('footer');


            
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    }


     public function send_email(){
         $myid=session()->get('id');
         $session=session();
            if ($session->has('isLoggedIn')){
          if ($this->request->getMethod() =='post')
            {
               $email_to=$this->request->getPost('email_to');
               $email_template=$this->request->getPost('email_template');
               $email_subject=$this->request->getPost('email_subject');


                $email = \Config\Services::email();



                

                $get_single_email = explode(',', $email_to);

                foreach ($get_single_email as $recipient) {
                if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {

                    $email = "rajbharath533@gmail.com"; // Replace this with the email you want to check

                    if (isGmailAccount($recipient)) {
                        // code...
                    }
                    
                    $config['SMTPHost'] =  get_setting(company($myid),'smtp_host');
                    $config['SMTPUser'] =  get_setting(company($myid),'smtp_user');     
                    $config['SMTPPass']  =  get_setting(company($myid),'smtp_password');
                    $config['SMTPPort'] = get_setting(company($myid),'smtp_port');      
                    $config['mailType'] = 'html';      
                    $email->initialize($config);


                    $email->clear();
                    $email->setFrom(get_setting(company($myid),'from_email'), get_setting(company($myid),'from_name'));
                    $email->setTo($recipient);

                    $email->setSubject($email_subject);
                    $email->setMessage(str_replace('<[email]>', $recipient, $email_template));
              
                    if ($email->send()) {
                        echo "<div class='alert alert-success py-1 col-md-12'>Email sent to: <b>$recipient</b></div>";
                    } else {
                        echo "<div class='alert alert-danger py-1 col-md-12'>Email sending failed for: <b>$recipient</b>. Error: {$email->printDebugger()}</div>";
                    }

                } else {
                    echo "<div class='alert alert-danger py-1 col-md-12'>Invalid email address: <b>$recipient</b></div>";
                }
            }

            }else{
                return redirect()->to(base_url());
            }

            }else{
            return redirect()->to(base_url('users/login'));
        }
        
        
    }

    public function etest(){

        $myid=session()->get('id');

        $email = \Config\Services::email();

        $config['SMTPHost'] =  get_setting(company($myid),'smtp_host');
        $config['SMTPUser'] =  get_setting(company($myid),'smtp_user');     
        $config['SMTPPass']  =  get_setting(company($myid),'smtp_password');
        $config['SMTPPort'] = get_setting(company($myid),'smtp_port');      
        $email->initialize($config);

        $email->setFrom('no-reply@aitsun.in', 'ctech');
        $email->setTo('rajesh@aitsun.com');
        $email->setCC('rajeshmave6@gmail.com');

        $email->setSubject('Email Test');

        $message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>      
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,"/>
        <!--[if !mso]><!-->         
        <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
        <!--<![endif]-->  
        <title>Website request email template</title>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <style type="text/css"> 

            /* Base CSS */
            html { width: 100%; }
            body {margin:0; padding:0; width:100%; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;font-family: Montserrat, sans-serif;}
            img {display:block !important; border:0; -ms-interpolation-mode:bicubic;} 

            @media (prefers-color-scheme: dark) {
                body{
                    background-color: #ffffff;
                }
            }
        </style>

    </head>
        
    <body marginwidth="0" marginheight="0" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #ffffff;" offset="0" topmargin="0" leftmargin="0">
        
        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" data-thumb="banner.png" style="max-width: 650px; padding-bottom:10px;">
            <tr>
                <td style="text-align: left;">
                    <a href="https://www.csloman.com">
                        <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/csloman_logo.jpg" height="56" style="pointer-events: none; height:56px">
                    </a>
                </td>


                <td style="text-align: right;">
                    <table width="100%">
                        <tr>
                            <td style="text-align: right;">
                            <a style="font-size:12px; display: block; font-weight:400; color:black; text-decoration:none !important; text-decoration:none;" href="tel:+968 7994 7742">+968 7994 7742</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">
                            <a style="font-size:12px; display: block; font-weight:400; color:black; text-decoration:none !important; text-decoration:none;" href="mailto:info@csloman.com">info@csloman.com</a></td>
                            </td>
                        </tr>
                    </table>

            </tr> 
        </table>

        <table align="center" bgcolor="#022c7b" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 650px;">
            <tr>
                <td style="text-align: left; padding: 12px 15px;"> 
                    <p style="color:white; font-size: 12px; margin:0;" >
                        Dear Customer, <br>
                        We are excited to introduce you to our new branch <b>Concept Solution LLC</b> which is part of <b>Concept Technologies LLC</b>. <br><br>It is completely based on web services, designed to empower and elevate your businesss online presence. 
                    </p>
                </td> 
            </tr> 
        </table>
        <br>
        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-bottom:10px; max-width: 650px;">
            <tr>
                <td>
                    <a href="https://www.csloman.com">
                        <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/banner.png" width="650"  style="pointer-events: none!important; width: 100%;">
                    </a>
                </td>
            </tr>
         
        </table>

        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-bottom:10px; max-width: 650px;">
             
            <tr>
                <td style="text-align: center; padding: 0 15px;"> 
                    <div style="font-size:18px;color:#071d2e;"><b>Find a Website For Your Business <br>To Start Today</b></div>
                </td> 
            </tr> 
        </table>

<br>
        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-bottom:10px;max-width: 650px;"> 
            <tr>
                <td style="text-align: center; padding: 0 15px;"> 
                    <a href="https://www.csloman.com/website-development">
                        <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/web.png" style="pointer-events: none; width:100%; max-width: 60px;margin: auto;" width="100">
                    </a>
                    <a href="https://www.csloman.com/website-development" style="text-decoration:none !important; text-decoration:none;"><h4 style="color:#071d2e;font-size: 14px;">Website <br> Development</h4></a>
                </td>
                <td style="text-align: center; padding: 0 15px;"> 
                    <a href="https://www.csloman.com/mobile-application">
                        <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/mobile.png" style="pointer-events: none; width:100%; max-width: 60px;margin: auto;" width="100">
                    </a>
                    <a href="https://www.csloman.com/mobile-application" style="text-decoration:none !important; text-decoration:none;"><h4 style="color:#071d2e;font-size: 14px;">Mobile App <br> Development</h4></a>
                </td>
                <td style="text-align: center; padding: 0 15px;"> 
                    <a href="https://www.csloman.com/business-email">
                        <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/email.png" style="pointer-events: none; width:100%; max-width: 60px;margin: auto;" width="100">
                    </a>
                    <a href="https://www.csloman.com/business-email" style="text-decoration:none !important; text-decoration:none;"><h4 style="color:#071d2e;font-size: 14px;">Business <br> Emails</h4></a>
                </td> 
            </tr> 
        </table>


        <table align="center" bgcolor="#022c7b" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 650px;"> 
            <tr>
                <td style="text-align: center; padding: 0 15px;"> 
                    <div style="font-size:20px;color:#ffffff; margin-top: 12px;"><b>Ready to take your business to the next level?</div>
                </td> 
            </tr> 
            <tr>
                <td style="text-align: center; padding: 10px 15px;">
                    <center>
                        <a href="https://www.csloman.com/call-back/" style="color: #071d2e; text-decoration:none;">
                            <table>
                                <tr>
                                    <td style="background: white; color: #071d2e; padding: 10px 40px; border-radius: 25px;">

                                    <p style="margin:0;"><a href="https://www.csloman.com/call-back/" style="background: white; color: #071d2e; text-decoration:none;">Request Call Back</a></p>

                                    </td>
                                </tr>
                            </table>
                        </a>
                    </center>
                </td>
            </tr> 
        </table>
        <br>
        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-bottom:10px; max-width: 650px;"> 
            <tr>
                <td style="text-align: center; padding: 0 15px;">
                    <p style="font-size: 12px; margin:0">
                        Or, 
                Contact us today to discuss your project and learn more about how we can collaborate to achieve your goals. 
Feel free to visit our website <a href="https://www.csloman.com" style="color: #022c7b;font-weight: 600; text-decoration:none !important; text-decoration:none;">www.csloman.com</a> / <a href="https://www.conceptgrps.com" style="color: #022c7b;font-weight: 600; text-decoration:none !important; text-decoration:none;">www.conceptgrps.com</a> for more information about our services and portfolio.
                    </p>
                </td>
            </tr>


        </table>
        <br>

        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 650px;"> 
            <tr>
                <td style="text-align: center; padding: 0 15px;">
                    <a href="tel:+968 7994 7742" style="text-decoration:none !important; text-decoration:none;">
                        <table style="border:1px solid #071d2e; border-radius: 10px; padding: 5px 5px; text-align:center;" width="100%">
                         
                            <tr>
                                <td>
                                    <h4 style="color:#071d2e; margin: 0;"><a href="tel:+968 7994 7742" style="text-decoration:none;color:#071d2e;">Call</a></h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <h5 style="margin-top:5px; margin-bottom:0px; color: black;"><a href="tel:+968 7994 7742" style="text-decoration:none;color:#071d2e;">+968 7994 7742</a></h5>
                                </td>
                            </tr>
                            
                        </table>  
                    </a>
                </td>
                <td style="text-align: center; padding: 0 15px;"> 

                      <a href="mailto:info@csloman.com" style="text-decoration:none !important; text-decoration:none;">
                        <table style="border:1px solid #071d2e; border-radius: 10px; padding: 5px 5px; text-align:center;" width="100%">  
                            <tr>
                                <td>
                                 <h4 style="color:#071d2e; margin: 0;"><a href="mailto:info@csloman.com" style="text-decoration:none;color:#071d2e;">Email</a></h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <h5 style="margin-top:5px; margin-bottom:0px; color: black;"><a href="mailto:info@csloman.com" style="text-decoration:none;color:#071d2e;">info@csloman.com</a></h5>
                                </td>
                            </tr>
                        </table>  
                    </a>

                </td>
                 
            </tr>


        </table>
        <br>

        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 650px;"> 
            <tr>
                <td style="text-align:center;"> 
                    <center>
                    <table>
                        <tr>
                            <td style="padding: 0 5px;">
                                <a href="">
                                    <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/facebook.png" style="pointer-events: none; width: 20px;" width="20">
                                </a>
                            </td>
                            <td style="padding: 0 5px;">
                                <a href="">
                                    <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/instagram.png" style="pointer-events: none; width: 20px;" width="20">
                                </a>
                            </td>
                            <td style="padding: 0 5px;">
                                <a href="">
                                    <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/linkedin.png" style="pointer-events: none; width: 20px;" width="20">
                                </a>
                            </td>
                            <td style="padding: 0 5px;">
                                <a href="">
                                    <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/twitter.png" style="pointer-events: none; width: 20px;" width="20">
                                </a>
                            </td>
                            <td style="padding: 0 5px;">
                                <a href="">
                                    <img src="https://aitsun.net/aitsuncloudservice/public/images/drivefiles/youtube.png" style="pointer-events: none; width: 20px;" width="20">
                                </a>
                            </td>
                        </tr>
                    </table>
                    </center>
                </td>
            </tr>

        </table>

        
    </body>
</html>

';
        $email->setMessage($message);

        if ($email->send()) 
        {
            echo 'Email successfully sent';
        } 
        else 
        {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
}