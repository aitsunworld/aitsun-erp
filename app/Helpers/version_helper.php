<?php
    use App\Models\UserModel as UserModel;
    use App\Models\ProjectTableModel as ProjectTableModel;
    use App\Models\VersionTableModel as VersionTableModel;
    use App\Models\ErrorSolutionsModel as ErrorSolutionsModel;
    use App\Models\ErrorSolutionsScreenshotModel as ErrorSolutionsScreenshotModel;

      
    function developers_project_array($company){
        $ProjectTableModel = new ProjectTableModel;
        $use=$ProjectTableModel->where('company_id',$company)->where('deleted',0)->findAll();
        return $use;
    }

    function error_screen_shots_array($id){
        $ErrorSolutionsScreenshotModel = new ErrorSolutionsScreenshotModel;
        $use=$ErrorSolutionsScreenshotModel->where('error_id',$id)->findAll();
        return $use;
    }

    function total_solutions_of_error($error_id){
        $ErrorSolutionsModel = new ErrorSolutionsModel;
        $res=$ErrorSolutionsModel->where('parent_id',$error_id)->where('deleted',0)->where('type','solution')->orderBy('id','desc')->countAllResults(); 
        return $res;
    }

    function solutions_of_error_array($error_id){
        $ErrorSolutionsModel = new ErrorSolutionsModel;
        $res=$ErrorSolutionsModel->where('parent_id',$error_id)->where('deleted',0)->where('type','solution')->orderBy('id','desc')->findAll(); 
        return $res;
    }
    
    function get_project_data($id,$option){
        $ProjectTableModel = new ProjectTableModel;
        $get_res=$ProjectTableModel->where('id',$id)->first();
        if ($get_res) {
           return $get_res[$option];
        }else{
            return '';
        }

    }

?>
