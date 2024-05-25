<?php

namespace App\Libraries;
require_once 'odoo/ripcord.php';

class ConceptOdoo {
     
    
    //Page header

    
    public function add_data($url,$db,$username,$password,$uid,$odoo_data) {
        ///// BASIC AUTHENTICATION START
            $common = \ripcord::client("$url/xmlrpc/2/common");
            if ($uid<0 || $uid=='') {
                 $uid = $common->authenticate($db, $username, $password, array());
            }
            $models = \ripcord::client("$url/xmlrpc/2/object");
        ///// BASIC AUTHENTICATION END

        // Initialization
        $final_result='';
        $company_id=0;
        $task_id=0;
        $lead_id=0;
        $partner_id=0;

        // add company
        if (!empty($odoo_data['company'])) {
            $company_data = array(
                'name' => $odoo_data['company'],
                'street' => '',
                'city' => '',
                'zip' => '',
                // 'country_id' => 1,
                'email' => $odoo_data['email'],
                'phone' => $odoo_data['phone'],
                'is_company' => true, 
            );

            $company_id = $models->execute_kw($db, $uid, $password, 'res.partner', 'create', array($company_data));

            if (!is_numeric($company_id)) {
                $company_id=0;
                $final_result.='Company not created<br>'; 
            }else{
                $final_result.='Company created with id - '.$company_id.'<br>';
            }
        }

        // add customer
        if (!empty($odoo_data['name'])) {
            $cus_data = array(
                'name' => $odoo_data['name'],
                'street' => '',
                'city' => '',
                'zip' => '',
                // 'country_id' => 1,
                'email' => $odoo_data['email'],
                'phone' => $odoo_data['phone'],
                'parent_id' => $company_id
            );

            $partner_id = $models->execute_kw($db, $uid, $password, 'res.partner', 'create', array($cus_data));

            if (!is_numeric($partner_id)) {
                $partner_id=0;
                $final_result.='Customer not created<br>';
            }else{
                $final_result.='Customer created with id - '.$partner_id.'<br>'; 
            }
        }

        //add lead to CRM
        if ($odoo_data['enquiry_type']=='quotation') {
            $final_partner_id=$partner_id;
            if ($partner_id==0) {
               $final_partner_id=$company_id;
            }
            $lead_data = array(
                'name' => $odoo_data['subject'],
                'contact_name' => $odoo_data['name'],
                'email_from' => $odoo_data['email'],
                'phone' => $odoo_data['phone'],
                'description' => $odoo_data['message'],
                'partner_name' => $odoo_data['company'],
                'type' => 'opportunity', 
                'partner_id' => $final_partner_id,
                'user_id' => $uid,
             
            );

            $lead_id = $models->execute_kw($db, $uid, $password,'crm.lead', 'create', array($lead_data)); 

            if (!is_numeric($lead_id)) {
                $lead_id=0;
                $final_result.='Lead not created<br>';
            }else{
                $final_result.='Lead created with id - '.$lead_id.'<br>'; 
            }
        }

        //add task to projects
        if ($odoo_data['enquiry_type']=='service') {
            $final_task_partner_id=$partner_id;
            if ($partner_id==0) {
               $final_task_partner_id=$company_id;
            }
            $task_data = array(
                'name' => $odoo_data['subject'],
                'project_id' => $odoo_data['project_id'], 
                'description' => $odoo_data['message'], 
                'user_ids'=>array(),
                'partner_id'=>$final_task_partner_id
            );

            $task_id = $models->execute_kw($db, $uid, $password,'project.task', 'create',array($task_data)); 

             if (!is_numeric($task_id)) {
                $task_id=0;
                $final_result.='Task not created<br>';
            }else{
                $final_result.='Task created with id - '.$task_id.'<br>'; 

                    // attatchments
                    if (!empty($odoo_data['document_path'])) {
                        $document_data = array( 
                            'name' => $odoo_data['document_name'],
                            'type' => 'binary',
                            'datas' => base64_encode(file_get_contents($odoo_data['document_path'])), 
                            'res_model' => 'project.task',
                            'res_id' => $task_id,
                        );

                        $attachment_id = $models->execute_kw($db, $uid, $password,'ir.attachment', 'create',array($document_data));

                        if (!is_numeric($attachment_id)) {
                            $attachment_id=0;
                            $final_result.='File not uploaded<br>';
                        }else{
                            $final_result.='File uploaded with id - '.$attachment_id.'<br>'; 
                        }
                            
                    }
            }

            
        }

        return $final_result;
        
    }

  

  
}