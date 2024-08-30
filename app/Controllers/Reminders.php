<?php
namespace App\Controllers;
use App\Models\Main_item_party_table;
use SendinBlue;

class Reminders extends BaseController { 
        public function index()
        {    
 
                $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', BREVO_KEY);
             
                $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', BREVO_PARTNER_KEY);
       
                $apiInstance = new SendinBlue\Client\Api\AccountApi( 
                    new \GuzzleHttp\Client(),
                    $config
                );

                ////transactional emails
                $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi( 
                    new \GuzzleHttp\Client(),
                    $config
                );
             

                $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
                     'subject' => 'from the PHP SDK!',
                     'sender' => ['name' => 'Aitsun ERP', 'email' => 'no-reply@aitsun.com'], 
                     'to' => [[ 'name' => 'Max Mustermann', 'email' => 'rajesh@conceptgrps.com']],
                     'htmlContent' => '<html><body><h1>This is a transactional email {{params.bodyMessage}}</h1></body></html>',
                     'params' => ['bodyMessage' => 'made just for you!']
                ]); 

                try {
                    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
                    print_r($result);
                } catch (Exception $e) {
                    echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
                }
                ////transactional emails


                ////transactional sms

                // $apiInstance = new SendinBlue\Client\Api\TransactionalSMSApi(
                //     new \GuzzleHttp\Client(),
                //     $config
                // );
                // $sendTransacSms = new \SendinBlue\Client\Model\SendTransacSms();
                // $sendTransacSms['sender'] = 'senderName';
                // $sendTransacSms['recipient'] = '+918943868855';
                // $sendTransacSms['content'] = 'This is a transactional SMS';
                // $sendTransacSms['type'] = 'transactional';
                // $sendTransacSms['webUrl'] = 'https://example.com/notifyUrl';

                // try {
                //     $result = $apiInstance->sendTransacSms($sendTransacSms);
                //     print_r($result);
                // } catch (Exception $e) {
                //     echo 'Exception when calling TransactionalSMSApi->sendTransacSms: ', $e->getMessage(), PHP_EOL;
                // }
                ////transactional sms

                

               // $apiInstance = new SendinBlue\Client\Api\TransactionalWhatsAppApi(
               //      // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
               //      // This is optional, `GuzzleHttp\Client` will be used as default.
               //      new \GuzzleHttp\Client(),
               //      $config
               //  );
               //  $sendWhatsappMessage = new \SendinBlue\Client\Model\SendWhatsappMessage(); // \SendinBlue\Client\Model\SendWhatsappMessage | Values to send WhatsApp message

               //  $sendTransacSms['senderNumber'] = '+918943868855';
               //  $sendTransacSms['contactNumbers'] = '+918075680885'; 
               //  $sendTransacSms['text'] = 'Hi';  

               //  try {
               //      $result = $apiInstance->sendWhatsappMessage($sendWhatsappMessage);
               //      print_r($result);
               //  } catch (Exception $e) {
               //      echo 'Exception when calling TransactionalWhatsAppApi->sendWhatsappMessage: ', $e->getMessage(), PHP_EOL;
               //  }
 
        }

        public function send_email(){
            if ($this->request->getMethod()=='get') {
                $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', BREVO_KEY);

                $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi( 
                    new \GuzzleHttp\Client(),
                    $config
                );

                $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
                     'subject' => trim(strip_tags(htmlentities($this->request->getVar('subject')))),
                     'sender' => ['name' => 'Aitsun ERP', 'email' => 'no-reply@aitsun.com'], 
                     'to' => [[ 'name' => trim(strip_tags(htmlentities($this->request->getVar('name')))), 'email' => trim(strip_tags(htmlentities($this->request->getVar('to'))))]],
                     'htmlContent' => trim(strip_tags(htmlentities($this->request->getVar('message')))),
                     'params' => ['bodyMessage' => 'made just for you!']
                ]); 

                try {
                    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
                    echo 1;
                } catch (Exception $e) {
                    echo 0;
                }
                
            }else{
                echo 0;
            } 
        }
}