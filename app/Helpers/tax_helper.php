<?php 
    use App\Models\InvoiceTaxes;

function all_taxes_of_invoice($company_id,$invoice_id){
     $InvoiceTaxes=new InvoiceTaxes;

     $invoice_tax=$InvoiceTaxes->where('invoice_id',$invoice_id)->findAll();
   return $invoice_tax;
}




function insert_invoice_tax($invoice_id,$main_tax,$main_tax_percent_amt,$price,$invoice_date,$company_state,$state_of_supply){
    $InvoiceTaxes=new InvoiceTaxes;
    $myid=session()->get('id');
    
    foreach (budpaina_tax($main_tax,$main_tax_percent_amt,$price,$company_state,$state_of_supply) as $bt) {

        $check_tax_exist=$InvoiceTaxes->where('invoice_id',$invoice_id)->where('tax_name',$bt['tax_name'])->first();
        if ($check_tax_exist) {
            $tx_data=[
                'invoice_id'=>$invoice_id,
                'tax_name'=>$bt['tax_name'],
                'tax_percent'=>$bt['tax_percent'],
                'tax_amount'=>aitsun_round($check_tax_exist['tax_amount']+$bt['tax_amount'],get_setting(company($myid),'round_of_value')),
                'taxable_amount'=>aitsun_round($check_tax_exist['taxable_amount']+$bt['taxable_amount'],get_setting(company($myid),'round_of_value')),
                'created_at'=>$invoice_date
            ];

            $InvoiceTaxes->update($check_tax_exist['id'],$tx_data); 
        }else{
            $tx_data=[
                'invoice_id'=>$invoice_id,
                'tax_name'=>$bt['tax_name'],
                'tax_percent'=>$bt['tax_percent'],
                'tax_amount'=>aitsun_round($bt['tax_amount'],get_setting(company($myid),'round_of_value')),
                'taxable_amount'=>aitsun_round($bt['taxable_amount'],get_setting(company($myid),'round_of_value')),
                'created_at'=>$invoice_date
            ];

            $InvoiceTaxes->save($tx_data);
            $sid=$InvoiceTaxes->insertID();
        } 

    }

}

function is_tax_available($tax,$from,$to){
    // $InvoiceTaxes=new InvoiceTaxes; 
    // if (!empty($from) && empty($to)) {
    //     $InvoiceTaxes->where('date(created_at)',$from);
    // }
    // if (!empty($to) && empty($from)) {
    //     $InvoiceTaxes->where('date(created_at)',$to);
    // }

    // if (empty($to) && empty($from)) {
    //      $InvoiceTaxes->where('date(created_at)',get_date_format(now_time(session()->get('id')),'Y-m-d'));
    // }
    // if (!empty($to) && !empty($from)) {
    //     $InvoiceTaxes->where("date(created_at) BETWEEN '$from' AND '$to'");
    // }
    // $invoice_tax=$InvoiceTaxes->where('tax_name',$tax)->first();

    // if ($invoice_tax) {
    //     return true;
    // }else{
    //     return true;
    // }
    return true;
    
}

function budpaina_tax($main_tax,$tax_amt,$price,$company_state,$state_of_supply){

    $bt_array=array(); 
    $is_gst=true;

    if ($company_state!='' && $state_of_supply!='') {
        if ($company_state!=$state_of_supply) {
           $is_gst=false;
        }
     } 


        if ($main_tax=='GST @ 18%') { 

            if ($is_gst) {
                $txer=[
                    'tax_name'=>'SGST @ 9%',
                    'tax_percent'=>9,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 9%',
                    'tax_percent'=>9,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 18%',
                    'tax_percent'=>18,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer); 
            }
            
        }else if ($main_tax=='GST @ 0.1%') { 

            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 0.05%',
                    'tax_percent'=>0.05,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 0.05%',
                    'tax_percent'=>0.05,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{

                $txer=[
                    'tax_name'=>'IGST @ 0.1%',
                    'tax_percent'=>0.1,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 0.25%') { 

            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 0.125%',
                    'tax_percent'=>0.125,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 0.125%',
                    'tax_percent'=>0.125,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 0.25%',
                    'tax_percent'=>0.25,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 1.5%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 0.75%',
                    'tax_percent'=>0.75,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 0.75%',
                    'tax_percent'=>0.75,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 1.5%',
                    'tax_percent'=>1.5,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 3%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 1.5%',
                    'tax_percent'=>1.5,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 1.5%',
                    'tax_percent'=>1.5,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 3%',
                    'tax_percent'=>3,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 5%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 2.5%',
                    'tax_percent'=>2.5,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 2.5%',
                    'tax_percent'=>2.5,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 5%',
                    'tax_percent'=>5,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 6%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 3%',
                    'tax_percent'=>3,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 3%',
                    'tax_percent'=>3,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 6%',
                    'tax_percent'=>6,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 12%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 6%',
                    'tax_percent'=>6,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 6%',
                    'tax_percent'=>6,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 12%',
                    'tax_percent'=>12,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 13.8%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 6.9%',
                    'tax_percent'=>6.9,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 6.9%',
                    'tax_percent'=>6.9,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 13.8%',
                    'tax_percent'=>13.8,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 14% + Cess @ 12%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 7%',
                    'tax_percent'=>7,
                    'tax_amount'=>$tax_amt*7/26,
                    'taxable_amount'=>$price*7/26
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 7%',
                    'tax_percent'=>7,
                    'tax_amount'=>$tax_amt*7/26,
                    'taxable_amount'=>$price*7/26
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 14%',
                    'tax_percent'=>14,
                    'tax_amount'=>$tax_amt*14/26,
                    'taxable_amount'=>$price*14/26
                ];
                array_push($bt_array, $txer);
            }

            $txer=[
                'tax_name'=>'Cess @ 12%',
                'tax_percent'=>12,
                'tax_amount'=>$tax_amt*12/26,
                'taxable_amount'=>$price*12/26
            ];
            array_push($bt_array, $txer);

        }else if ($main_tax=='GST @ 28%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 14%',
                    'tax_percent'=>14,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 14%',
                    'tax_percent'=>14,
                    'tax_amount'=>$tax_amt/2,
                    'taxable_amount'=>$price/2
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 28%',
                    'tax_percent'=>28,
                    'tax_amount'=>$tax_amt,
                    'taxable_amount'=>$price
                ];
                array_push($bt_array, $txer);
            }

        }else if ($main_tax=='GST @ 28% + Cess @ 12%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 14%',
                    'tax_percent'=>14,
                    'tax_amount'=>$tax_amt*14/40,
                    'taxable_amount'=>$price*14/40
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 14%',
                    'tax_percent'=>14,
                    'tax_amount'=>$tax_amt*14/40,
                    'taxable_amount'=>$price*14/40
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 28%',
                    'tax_percent'=>28,
                    'tax_amount'=>$tax_amt*28/40,
                    'taxable_amount'=>$price*28/40
                ];
                array_push($bt_array, $txer);
            }

            $txer=[
                'tax_name'=>'Cess @ 12%',
                'tax_percent'=>12,
                'tax_amount'=>$tax_amt*12/40,
                'taxable_amount'=>$price*12/40
            ];
            array_push($bt_array, $txer);

        }else if ($main_tax=='GST @ 28% + Cess @ 60%') { 
            if ($is_gst) {
                 $txer=[
                    'tax_name'=>'SGST @ 14%',
                    'tax_percent'=>14,
                    'tax_amount'=>$tax_amt*14/88,
                    'taxable_amount'=>$price*14/88
                ];
                array_push($bt_array, $txer);

                $txer=[
                    'tax_name'=>'CGST @ 14%',
                    'tax_percent'=>14,
                    'tax_amount'=>$tax_amt*14/88,
                    'taxable_amount'=>$price*14/88
                ];
                array_push($bt_array, $txer);
            }else{
                $txer=[
                    'tax_name'=>'IGST @ 28%',
                    'tax_percent'=>28,
                    'tax_amount'=>$tax_amt*28/88,
                    'taxable_amount'=>$price*28/88
                ];
                array_push($bt_array, $txer);
            }

            $txer=[
                'tax_name'=>'Cess @ 60%',
                'tax_percent'=>60,
                'tax_amount'=>$tax_amt*60/88,
                'taxable_amount'=>$price*60/88
            ];
            array_push($bt_array, $txer);

        }else if ($main_tax=='VAT @ 5%') { 

             $txer=[
                'tax_name'=>'VAT @ 5%',
                'tax_percent'=>5,
                'tax_amount'=>$tax_amt,
                'taxable_amount'=>$price
            ];
            array_push($bt_array, $txer);


        }else{
            $txer=[
                'tax_name'=>$main_tax,
                'tax_percent'=>percent_of_tax($main_tax),
                'tax_amount'=>$tax_amt,
                'taxable_amount'=>$price/2
            ];
            array_push($bt_array, $txer);
        }

        return $bt_array;
}

function all_budpayina_taxes($company_id){

     if (get_company_data($company_id,'country')=='India') {
        
         $abt=[
            'SGST @ 9%',
            'CGST @ 9%',
            'SGST @ 0.05%',
            'CGST @ 0.05%',
            'SGST @ 0.125%',
            'CGST @ 0.125%',
            'SGST @ 0.75%',
            'CGST @ 0.75%',
            'SGST @ 1.5%',
            'CGST @ 1.5%',
            'SGST @ 2.5%',
            'CGST @ 2.5%',
            'SGST @ 3%',
            'CGST @ 3%',
            'SGST @ 6%',
            'CGST @ 6%',
            'SGST @ 6.9%',
            'CGST @ 6.9%',
            'SGST @ 7%',
            'CGST @ 7%',
            'SGST @ 14%',
            'CGST @ 14%',
            'IGST @ 18%',
            'IGST @ 0.1%',
            'IGST @ 0.25%',
            'IGST @ 1.5%',
            'IGST @ 3%',
            'IGST @ 5%',
            'IGST @ 6%',
            'IGST @ 12%',
            'IGST @ 13.8%',
            'IGST @ 14%',
            'IGST @ 28%',
            'Cess @ 12%',
            'Cess @ 60%',

        ];

    }elseif (get_company_data($company_id,'country')=='United Arab Emirates') {
        $abt=[
            'VAT @ 5%',
        ];
    }else{

        $abt=[
            'VAT @ 5%',
        ];
    }
   

    return $abt;
} 

?>