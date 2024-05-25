<?php
        use App\Models\UserModel as UserModel;
        use App\Models\Companies as Companies;
        use App\Models\MainCompanies as MainCompanies;
        use App\Models\Main_item_party_table as Main_item_party_table;
        use App\Models\Item_party_meta_1 as Item_party_meta_1;

        
        function app_status($company){
                $Companies = new Companies;
                $Main_item_party_table = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$Main_item_party_table->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['app_status']==1) {
                                                $app_status=1;
                                        }
                                }
                        }
                }

                return $app_status;
        } 

        function app_super_user($company){
                $Companies = new Companies;
                $Main_item_party_table = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$Main_item_party_table->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        $app_status=$auth['id'];
                                }
                        }
                }

                return $app_status;
        } 

        


        function company_year_end($company){
                $Companies = new Companies;
                $Main_item_party_table = new Main_item_party_table;
                $MainCompanies = new MainCompanies;
                $app_status=0;
                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$Main_item_party_table->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                       
                                        $app_status=$auth['year_end'];
                                        
                                }
                        }
                }

                return $app_status;
        }


        function is_aitsun($company){
                $Companies = new Companies;
                $Main_item_party_table = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$Main_item_party_table->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['aitsun_user']==1) {
                                                $app_status=1;
                                        }
                                }
                        }
                }

                return $app_status;
        } 


        function is_school($company){
                $Companies = new Companies;
                $Main_item_party_table = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$Main_item_party_table->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['school']!=0) {
                                                $app_status=$auth['school'];
                                        }
                                }
                        }
                }

                return $app_status;
        }

        function is_website($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['is_website']!=0) {
                                                $app_status=$auth['is_website'];
                                        }
                                }
                        }
                }

                return $app_status;
        }

        function is_appoinments($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['is_appoinments']!=0) {
                                                $app_status=$auth['is_appoinments'];
                                        }
                                }
                        }
                }

                return $app_status;
        }

        
        
        function is_online_shop($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['online_shop']==1) {
                                                $app_status=1;
                                        }
                                }
                        }
                }

                return $app_status;
        } 

        function is_crm($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['crm']!=0) {
                                                $app_status=$auth['crm'];
                                        }
                                }
                        }
                }

                return $app_status;
        } 


        function branch_limit($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $branch_limit=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['max_branch']>0) {
                                                $branch_limit=$auth['max_branch'];
                                        }
                                }
                        }
                }

                return $branch_limit;
            }


        function total_branch($user){
            $Companies = new Companies;
            $UserModel = new Main_item_party_table;
            $MainCompanies = new MainCompanies;

            $get_branches=$Companies->where('parent_company', main_company_id($user));
            return $get_branches->countAllResults();
        }


        function app_type($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $apppp='';
                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        $apppp=$auth['app']; 
                                }
                        }
                }

                return $apppp;
        }


        function app_languages($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $apppp='';

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        
                                        $apppp=$auth['languages'];
                                        
                                }
                        }
                }

                return $apppp;
        }


        function app_languages_array($company){
                $Companies = new Companies;
                $Main_item_party_table = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $apppp='';

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$Main_item_party_table->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        $apppp=trim($auth['languages']);  
                                }
                        }
                }

                return explode(',', $apppp);
        }

        

        

        function user_limit($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $user_limit=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('main_type','user')->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['max_user']>0) {
                                                $user_limit=$auth['max_user'];
                                        }
                                }
                        }
                }

                return $user_limit;
        }


        function total_user($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $total_user=0;
                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$Companies->where('parent_company',$mc['id']);
                                foreach ($get_author->findAll() as $user) {
                                        $gettotal=$UserModel->where('main_type','user')->where('company_id', $user['id'])->where('deleted',0);
                                        $total_user+=$gettotal->countAllResults();
                                }
                        }
                }
                return $total_user-1;
        }



        function is_medical($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['medical']!=0) {
                                                $app_status=$auth['medical'];
                                        }
                                }
                        }
                }

                return $app_status;
        } 


        function is_hrmanage($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['hr_manage']!=0) {
                                                $app_status=$auth['hr_manage'];
                                        }
                                }
                        }
                }

                return $app_status;
        }


        function is_payment_method($company){
                $Companies = new Companies;
                $UserModel = new Main_item_party_table;
                $MainCompanies = new MainCompanies;

                $app_status=0;

                $get_company=$Companies->where('id',$company);
                foreach ($get_company->findAll() as $gc) {
                        $get_main_company=$MainCompanies->where('id',$gc['parent_company']);
                        foreach ($get_main_company->findAll() as $mc) {
                                $get_author=$UserModel->where('id',$mc['uid']);
                                foreach ($get_author->findAll() as $auth) {
                                        if ($auth['payment_method']==1) {
                                                $app_status=$auth['payment_method'];
                                        }
                                }
                        }
                }

                return $app_status;
        } 



function message_credits($company){
        $UserModel = new Main_item_party_table;
        $Companies = new Companies;
        $MainCompanies = new MainCompanies;
        $message_credit=0;

        $get_company=$Companies->where('id',$company);
        foreach ($get_company->findAll() as $gc) {
                $get_main_company=$MainCompanies->where('id', $gc['parent_company']);
                foreach ($get_main_company->findAll() as $mc) {
                        $get_author=$UserModel->where('id',$mc['uid']);
                        foreach ($get_author->findAll() as $auth) {
                                $message_credit=$auth['message_credits'];
                        }
                }
        }

        return $message_credit;
        }



function author_id($company){
        $UserModel = new Main_item_party_table;
        $Companies = new Companies;
        $MainCompanies = new MainCompanies;
        $message_credit=0;

        $get_company=$Companies->where('id',$company);
        foreach ($get_company->findAll() as $gc) {
                $get_main_company=$MainCompanies->where('id', $gc['parent_company']);
                foreach ($get_main_company->findAll() as $mc) {
                        $get_author=$UserModel->where('id',$mc['uid']);
                        foreach ($get_author->findAll() as $auth) {
                                $message_credit=$auth['id'];
                        }
                }
        }

        return $message_credit;
}
?>