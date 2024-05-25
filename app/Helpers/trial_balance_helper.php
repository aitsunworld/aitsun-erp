<?php
    use App\Models\AccountingModel as AccountingModel;
    use App\Models\CustomerBalances as CustomerBalances;
    use App\Models\PaymentsModel as PaymentsModel;


    
    function transactions_under($company_id,$gid,$side){
        $PaymentsModel = new PaymentsModel;
        $debit=0;
        $credit=0;
        $amount=0; 

        if (get_group_data($gid,'group_head')=='Bank Accounts') { 

            $PaymentsModel->where('company_id',$company_id)->where('deleted',0);

            if (count(only_bank_accounts_of_account($company_id))>0) {
                $isFirst = true;
                $PaymentsModel->groupStart();
                foreach (only_bank_accounts_of_account($company_id) as $groups) {

                    if($isFirst){
                        $PaymentsModel->where('type',$groups['id']);
                    }else{
                        $PaymentsModel->orWhere('type',$groups['id']);
                    }
                    $isFirst = false;
                    
                }
                $PaymentsModel->groupEnd();
            }
           

            // $PaymentsModel->where('account_name',$gid);
            // $PaymentsModel->where('bill_type!=','sales');
            // $PaymentsModel->where('bill_type!=','purchase');

            $transactions=$PaymentsModel->findAll();

            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////
           
        }elseif(is_bank_account($company_id,$gid)==true){

            $transactions=$PaymentsModel->where('company_id',$company_id)->where('deleted',0)->where('type',$gid)->findAll();



            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////

        }elseif (get_group_data($gid,'group_head')=='Cash-in-Hand') { 

            $PaymentsModel->where('company_id',$company_id)->where('deleted',0);

            if (count(only_cash_accounts_of_account($company_id))>0) {
                $isFirst = true;
                $PaymentsModel->groupStart();
                foreach (only_cash_accounts_of_account($company_id) as $groups) {

                    if($isFirst){
                        $PaymentsModel->where('type',$groups['id']);
                    }else{
                        $PaymentsModel->orWhere('type',$groups['id']);
                    }
                    $isFirst = false;
                    
                }
                $PaymentsModel->groupEnd();
            }
           

            // $PaymentsModel->where('account_name',$gid);
            // $PaymentsModel->where('bill_type!=','sales');
            // $PaymentsModel->where('bill_type!=','purchase');

            $transactions=$PaymentsModel->findAll();

            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////


           
        }elseif (get_group_data($gid,'group_head')=='Purchase Accounts') { 

            $PaymentsModel->where('company_id',$company_id)->where('deleted',0);

           

            // $PaymentsModel->where('account_name',$gid);
            // $PaymentsModel->where('bill_type!=','sales');
            $PaymentsModel->where('bill_type','purchase');

            $transactions=$PaymentsModel->findAll();

            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////

            
           
        }elseif (get_group_data($gid,'group_head')=='Sales Accounts') { 

            $PaymentsModel->where('company_id',$company_id)->where('deleted',0);

           

            // $PaymentsModel->where('account_name',$gid);
            $PaymentsModel->where('bill_type','sales');
            // $PaymentsModel->where('bill_type','purchase');

            $transactions=$PaymentsModel->findAll();

            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////

            
           
        }elseif (get_group_data($gid,'group_head')=='Sundry Debtors') { 

            $PaymentsModel->where('company_id',$company_id)->where('deleted',0);

            if (count(only_sundry_debtors_accounts_of_account($company_id))>0) {
                $isFirst = true;
                $PaymentsModel->groupStart();
                foreach (only_sundry_debtors_accounts_of_account($company_id) as $groups) {

                    if($isFirst){
                        $PaymentsModel->where('account_name',$groups['id']);
                    }else{
                        $PaymentsModel->orWhere('account_name',$groups['id']);
                    }
                    $isFirst = false;
                    
                }
                $PaymentsModel->groupEnd();
            }
           

            // $PaymentsModel->where('account_name',$gid);
            // $PaymentsModel->where('bill_type!=','sales');
            // $PaymentsModel->where('bill_type!=','purchase');

            $transactions=$PaymentsModel->findAll();

            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////
           
        }elseif (get_group_data($gid,'group_head')=='Sundry Creditors') { 

            $PaymentsModel->where('company_id',$company_id)->where('deleted',0);

            if (count(only_sundry_creditors_accounts_of_account($company_id))>0) {
                $isFirst = true;
                $PaymentsModel->groupStart();
                foreach (only_sundry_creditors_accounts_of_account($company_id) as $groups) {

                    if($isFirst){
                        $PaymentsModel->where('account_name',$groups['id']);
                    }else{
                        $PaymentsModel->orWhere('account_name',$groups['id']);
                    }
                    $isFirst = false;
                    
                }
                $PaymentsModel->groupEnd();
            }
           

            // $PaymentsModel->where('account_name',$gid);
            // $PaymentsModel->where('bill_type!=','sales');
            // $PaymentsModel->where('bill_type!=','purchase');

            $transactions=$PaymentsModel->findAll();

            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////
           
        }elseif(is_sundry_account($company_id,$gid)==true){


            $transactions=$PaymentsModel->where('company_id',$company_id)->where('deleted',0)->where('customer',get_group_data($gid,'customer_id'))->findAll();



            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////

        }elseif (get_group_data($gid,'group_head')=='Stock-in-Hand') { 
                
                $credit=stock_amount_of_company($company_id);

                //////////////////  INITIALIZING FINAL VALUE //////////////////
                if ($side=='debit') {
                    $amount=$debit;
                }else{
                    $amount=$credit;
                }

                if ($amount!=0) {
                    return number_format($amount,2,'.','');
                }else{
                    return '---';
                }
                //////////////////  INITIALIZING FINAL VALUE //////////////////

        }else{
            $transactions=$PaymentsModel->where('company_id',$company_id)->where('deleted',0)->where('account_name',$gid)->where('bill_type!=','sales')->where('bill_type!=','purchase')->findAll();



            ////////////////// CALCULATING THE VALUE //////////////////////
            foreach ($transactions as $tamt) {
                if ($tamt['bill_type']=='sales' || $tamt['bill_type']=='discount_received' || $tamt['bill_type']=='receipt') {
                    $credit+=$tamt['amount'];
                }else{
                    $debit+=$tamt['amount'];
                }
            }
            ////////////////// CALCULATING THE VALUE //////////////////////

            //////////////////  INITIALIZING FINAL VALUE //////////////////
            if ($side=='debit') {
                $amount=$debit;
            }else{
                $amount=$credit;
            }

            if ($amount!=0) {
                return number_format($amount,2,'.','');
            }else{
                return '---';
            }
            //////////////////  INITIALIZING FINAL VALUE //////////////////
        }


        
    }