<?php
use App\Models\UserModel as UserModel;
use App\Models\ProductCategories as ProductCategories;
use App\Models\ProductSubCategories as ProductSubCategories;
use App\Models\SecondaryCategories as SecondaryCategories;
use App\Models\ProductUnits as ProductUnits;
use App\Models\ProductBrand as ProductBrand;
use App\Models\ProductsImages as ProductsImages;
use App\Models\ProductsModel as ProductsModel;
use App\Models\HomesliderModel as HomesliderModel;
use App\Models\RequestModel as RequestModel;
use App\Models\RequestitemsModel as RequestitemsModel;
use App\Models\AdditionalfieldsModel as AdditionalfieldsModel;
use App\Models\ProductratingsModel as ProductratingsModel;
use App\Models\MessageModel as MessageModel;
use App\Models\CompanySettings as CompanySettings;
use App\Models\Logs as Logs;
use App\Models\TaxModel as TaxModel;
use App\Models\Companies as Companies;
use App\Models\MainCompanies as MainCompanies;
use App\Models\FinancialYears as FinancialYears;
use App\Models\InvoiceModel as InvoiceModel;
use App\Models\CustomerBalances as CustomerBalances;
use App\Models\PaymentsModel as PaymentsModel;
use App\Models\AccountCategory as AccountCategory;
use App\Models\TaxtypeModel as TaxtypeModel;
use App\Models\PermissionModel as PermissionModel;
use App\Models\RawmwterialsModel as RawmwterialsModel;
use App\Models\InvoiceitemsModel as InvoiceitemsModel;
use App\Models\ScrapModel as ScrapModel;
use App\Models\ExpensestypeModel as ExpensestypeModel;
use App\Models\ScrapCurrencyTable as ScrapCurrencyTable;
use App\Models\StockModel as StockModel;
use App\Models\OrdertrackingModel as OrdertrackingModel;
use App\Models\ExgroupheadsModel as ExgroupheadsModel;
use App\Models\DeliverylocationModel as DeliverylocationModel;
use App\Models\CrmActionInventories as CrmActionInventories;
use App\Models\WorkUpdatesModel as WorkUpdatesModel;
use App\Models\QuoteItemsModel as QuoteItemsModel;
use App\Models\DocumentRenewModel as DocumentRenewModel;
use App\Models\DoccategoryModel as DoccategoryModel;
use App\Models\WorkcategoryModel as WorkcategoryModel;
use App\Models\ContactType as ContactType;
use App\Models\Designation as Designation;
use App\Models\TaskreportModel as TaskreportModel;
use App\Models\WorkDepartmentModel as WorkDepartmentModel;
use App\Models\LeadModel as LeadModel;
use App\Models\AttendanceModel as AttendanceModel;
use App\Models\OffersModel as OffersModel;
use App\Models\CarryForwardedLeaves as CarryForwardedLeaves;
use App\Models\LeaveManagement as LeaveManagement;
use App\Models\AccountingModel as AccountingModel;
use App\Models\FieldsNameModel as FieldsNameModel;
use App\Models\HidedTaxes as HidedTaxes;
use App\Models\InvoiceTaxes as InvoiceTaxes; 
use App\Models\VoucherListModel as VoucherListModel; 
use App\Models\ClientpaymentModel as ClientpaymentModel; 
use App\Models\AlertSessionModel as AlertSessionModel;
use App\Models\ProductSubUnit as ProductSubUnit;
use App\Models\PaymentsNoteModel as PaymentsNoteModel;
use App\Models\WorkshiftModel as WorkshiftModel;
use App\Models\PartiesCategories as PartiesCategories;
use App\Models\AttendanceAllowedList as AttendanceAllowedList;
use App\Models\StockValuesTable as StockValuesTable;
use App\Models\WeighingMachines as WeighingMachines;
use App\Models\InvoiceSubmitModel as InvoiceSubmitModel;
use App\Models\CompanySettings2 as CompanySettings2; 
use App\Models\InvoiceSettings as InvoiceSettings;
use App\Models\ManufacturesModel as ManufacturesModel;
use App\Models\ManufacturedItems as ManufacturedItems;
use App\Models\ManufacturedCosts as ManufacturedCosts;
use App\Models\ManualPayrollFieldValues as ManualPayrollFieldValues;
use App\Models\PostCategoryModel as PostCategoryModel;
use App\Models\PostThumbnail as PostThumbnail;
use App\Models\EmployeeCategoriesModel as EmployeeCategoriesModel;
use App\Models\Stockadjustmodel as Stockadjustmodel;
use App\Models\Main_item_party_table as Main_item_party_table;
use App\Models\PrintersModel as PrintersModel;
use App\Models\AppointmentsBookings as AppointmentsBookings;
use App\Models\PosSessions as PosSessions;
use App\Models\PosRegisters as PosRegisters;
use App\Models\PosTables as PosTables;
use App\Models\PermissionsModel as PermissionsModel;
use App\Models\Permissionlist as Permissionlist;
use App\Models\RentalLogsModel as RentalLogsModel;
use App\Models\RentalHoursModel as RentalHoursModel;
use App\Models\ProductPriceListModel as ProductPriceListModel;
use App\Models\ChequeDepartmentsModel as ChequeDepartmentsModel;
use App\Models\ChequesModel as ChequesModel;

function style_version(){
    return '1.2.7';
}

function script_version(){
    return '1.2.7';
}

function round_after(){
    return 2;
}

function total_leave_of_year(){
    return 12;
}

 
//online
function sn2(){
    if (APP_STATE=='offline') {
        return 2;
    }else{
        return 1;
    } 
}

function sn3(){
    if (APP_STATE=='offline') {
        return 3;
    }else{
        return 1;
    }  
}

function sn4(){
    if (APP_STATE=='offline') {
        return 4;
    }else{
        return 3;
    }  
} 





    // online
function secret_key(){
    if (APP_STATE=='offline') {
        return '6LcCRJsfAAAAADeslwAkl7uOXCkjPHp56ivzc_Nv';
    }elseif(APP_STATE=='remote_localhost'){
        return '6Ld4NjIpAAAAAIlo6tPMXA6XstqO17xuvoQGC1WD';
    }else{
        return '6LeLFIQlAAAAAJMGRjl7SZJNGh5QEMn98Iy8X7pm';
    }  
}

function site_key(){
    if (APP_STATE=='offline') {
        return '6LcCRJsfAAAAABfFFL-5UWuQjqZKbVequrqUwEb4';
    }elseif(APP_STATE=='remote_localhost'){
        return '6Ld4NjIpAAAAALDCafzSm_j2Fa8JNOBlPydoxFoX';
    }else{
        return '6LeLFIQlAAAAAF2nc9eyEn0iYWhZUJm4qKXLeYGm';
    }  
}

function timeToExpire($currentDate,$expiryDate) {
    // Current date
    $currentDate = new DateTime($currentDate);
    // Expiry date
    $expiry = new DateTime($expiryDate);
    
    // Calculate the difference
    $interval = $currentDate->diff($expiry);
    
    // Extract months and days remaining
    $monthsRemaining = ($interval->y * 12) + $interval->m;
    $daysRemaining = $interval->d;
    
    // Initialize result string
    $result = [];
    
    // Add months to result if greater than 0
    if ($monthsRemaining > 0) {
        $result[] = $monthsRemaining . " month" . ($monthsRemaining > 1 ? "s" : "");
    }
    
    // Add days to result if greater than 0
    if ($daysRemaining > 0) {
        $result[] = $daysRemaining . " day" . ($daysRemaining > 1 ? "s" : "");
    }
    
    // Join the result array with ' & '
    return implode(' & ', $result);
}

function get_rental_period_data($id,$column){
    $RentalHoursModel = new RentalHoursModel;
    $numrows=$RentalHoursModel->where('id', $id)->first();
    if ($numrows) {
        return $numrows[$column];
    }else{
        return '';
    }  
}

function get_total_cheque_of_department($company_id,$cheque_department){
    $ChequesModel=new ChequesModel;
    if ($cheque_department>0) {
        $ChequesModel->where('cheque_department',$cheque_department);
    }
    $ChequesModel->where('company_id',$company_id)->where('deleted',0);
    $result=$ChequesModel->countAllResults();
    return $result;
}

function get_total_cheque_of_category($company_id,$cheque_category){
    $ChequesModel=new ChequesModel;
    if ($cheque_category!='') {
        $ChequesModel->where('cheque_category',$cheque_category);
    }
    $ChequesModel->where('company_id',$company_id)->where('deleted',0);
    $result=$ChequesModel->countAllResults();
    return $result;
}



function get_total_cheque_of_status($company_id,$cheque_status){
    $ChequesModel=new ChequesModel;
    if ($cheque_status>0) {
        $ChequesModel->where('status',$cheque_status);
    }
    $ChequesModel->where('company_id',$company_id)->where('deleted',0);
    $result=$ChequesModel->countAllResults();
    return $result;
}


function duration_to_rental_days($duration){
   // Split the duration into hours and minutes
    list($hours, $minutes) = explode(':', $duration);

    // Convert to total minutes
    $totalMinutes = ($hours * 60) + $minutes;

    // Convert total minutes to total hours
    $totalHours = $totalMinutes / 60;

    // Calculate years, months, weeks, days, and remaining hours
    $years = floor($totalHours / (365 * 24));
    $remainingHours = $totalHours - ($years * 365 * 24);

    $months = floor($remainingHours / (30 * 24));
    $remainingHours -= $months * 30 * 24;

    $weeks = floor($remainingHours / (7 * 24));
    $remainingHours -= $weeks * 7 * 24;

    $days = floor($remainingHours / 24);
    $remainingHours -= $days * 24;

    // Round remaining hours
    $remainingHours = round($remainingHours);

    // Construct the result string
    $result = '';

    if ($years > 0) {
        $result .= $years . ' year' . ($years > 1 ? 's' : '') . ' ';
    }
    if ($months > 0) {
        $result .= $months . ' month' . ($months > 1 ? 's' : '') . ' ';
    }
    if ($weeks > 0) {
        $result .= $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ';
    }
    if ($days > 0) {
        $result .= $days . ' day' . ($days > 1 ? 's' : '') . ' ';
    }
    if ($remainingHours > 0 || ($years == 0 && $months == 0 && $weeks == 0 && $days == 0)) {
        $result .= $remainingHours . ' hour' . ($remainingHours > 1 ? 's' : '');
    }

    return trim($result);
}
  



function price_list_of_product($product_id){
    $ProductPriceListModel= new ProductPriceListModel();
    $RentalHoursModel= new RentalHoursModel();
    $ProductPriceListModel->select('product_price_list.*,rental_hours.*');
    $ProductPriceListModel->join('rental_hours', 'rental_hours.id = product_price_list.period_id', 'left');
    $pricelist = $ProductPriceListModel->where('product_price_list.product_id',$product_id)->where('product_price_list.deleted',0)->findAll();
    return $pricelist;
}

function rental_periods_array($company_id){
    $RentalHoursModel= new RentalHoursModel();
    $rental_hours_data = $RentalHoursModel->where('company_id',$company_id)->where('deleted',0)->orderBy("id", "desc")->findAll();
    return $rental_hours_data;
}

function total_picked_quantity_of_invoice($invoice_id,$log_type){
    $RentalLogsModel=new RentalLogsModel;
    $res=0;
    $gettotal=$RentalLogsModel->select('SUM(quantity) as totalqty')->where('invoice_id',$invoice_id)->where('log_type',$log_type)->where('deleted',0)->first();
    if ($gettotal) {
        if ($gettotal['totalqty']>0) {
            $res=$gettotal['totalqty'];
        } 
    }
    return $res;
}

function cheque_department(){
    $ChequeDepartmentsModel= new ChequeDepartmentsModel();
    $myid=session()->get('id');
    $pricelist = $ChequeDepartmentsModel->where('company_id',company($myid))->where('deleted',0)->findAll();
    return $pricelist;
}

function get_cheque_department($chdid,$column){
    $ChequeDepartmentsModel=new ChequeDepartmentsModel;
    $defaults=$ChequeDepartmentsModel->where('id',$chdid)->where('deleted',0)->first();
    if ($defaults) {
        return $defaults[$column];
    }else{
        return 0;
    }
}

function total_actual_quantity_of_invoice($invoice_id){
    $InvoiceitemsModel=new InvoiceitemsModel;
    $res=0;
    $gettotal=$InvoiceitemsModel->select('SUM(quantity) as totalqty')->where('invoice_id',$invoice_id)->where('deleted',0)->first();
    if ($gettotal) {
        if ($gettotal['totalqty']>0) {
            $res=$gettotal['totalqty'];
        } 
    }
    return $res;
}


function total_picked_quantity($invoice_id,$product_id,$log_type){
    $RentalLogsModel=new RentalLogsModel;
    $res=0;
    $gettotal=$RentalLogsModel->select('SUM(quantity) as totalqty')->where('invoice_id',$invoice_id)->where('item_id',$product_id)->where('log_type',$log_type)->where('deleted',0)->first();
    if ($gettotal) {
        if ($gettotal['totalqty']>0) {
            $res=$gettotal['totalqty'];
        } 
    }
    return $res;
}

function all_rental_logs($invoice_id){
    $RentalLogsModel=new RentalLogsModel;
    $alllogs=$RentalLogsModel->where('invoice_id',$invoice_id)->where('deleted',0)->orderBy('id','desc')->findAll();
    return $alllogs;
}

function transpose($array) {
    $transposedArray = [];
    foreach ($array as $row => $columns) {
        foreach ($columns as $col => $value) {
            $transposedArray[$col][$row] = $value;
        }
    }
    return $transposedArray;
}

function isValidColumn($column) {
    foreach ($column as $cell) {
        if (trim($cell) !== '') {
            return true;
        }
    }
    return false;
}

function is_allowed($userid,$permission_name){
    $PermissionsModel= new PermissionsModel;
    if (usertype($userid)=='admin') {

        return true;
    }else{
        $permi=$PermissionsModel->where('user_id',$userid)->where('permission_name',$permission_name)->where('is_allowed',1)->first();
        if ($permi) {
            return true;
        }else{
            return false;
        }
    }
}


function get_permission_heading_of_name($permission_name){
    $Permissionlist = new Permissionlist;
    $get_name=$Permissionlist->where('permission_name',$permission_name)->first();
    if ($get_name) {
        return $get_name['permission_heading'];
    }else{
        return ''; 
    }
}

function get_total_rental($company_id,$status){ 
    $InvoiceModel=new InvoiceModel; 
   
    if ($status!='') {
        $InvoiceModel->where('rental_status',$status);
    } 
       
    $InvoiceModel->where('invoice_type!=','sales'); 
    $total_rentals=$InvoiceModel->where('company_id',$company_id)->where('deleted',0)->where('bill_from','rental')->countAllResults();
    return $total_rentals;
}

function get_total_rental_invoices($company_id,$status){ 
    $InvoiceModel=new InvoiceModel; 
    $InvoiceModel->where('invoice_type','sales');
    $total_rentals=$InvoiceModel->where('company_id',$company_id)->where('deleted',0)->where('bill_from','rental')->countAllResults();
    return $total_rentals;
}
 

function register_data($register_id,$column){
    $PosRegisters=new PosRegisters;
    $defaults=$PosRegisters->where('id',$register_id)->first();
    if ($defaults) {
        return $defaults[$column];
    }else{
        return '';
    }
}

function floor_tables_array($floor_id){
    $PosTables=new PosTables;
    return $PosTables->where('floor_id',$floor_id)->where('deleted',0)->findAll();
}

function last_session_data($register_id,$column){
    $PosSessions=new PosSessions;
    $last_session_data=''; 
    $lssdata=$PosSessions->where('register_id',$register_id)->where('deleted',0)->orderBy('id','desc')->first();
    if ($lssdata) {
        $last_session_data=$lssdata['closing_balance'];
        $last_session_data=$lssdata['date'];
        $last_session_data=$lssdata[$column];
    }
    return $last_session_data;
}
 

function duration_in_days($timeString) {
    // Parse the input string
    list($hours, $minutes) = explode(':', $timeString);

    // Constants
    $hoursInDay = 24;
    $daysInMonth = 30; // Assuming an average month length of 30 days

    // Convert total minutes to hours
    $totalHours = $hours + ($minutes / 60);

    // Calculate days and remaining hours
    $days = floor($totalHours / $hoursInDay);
    $remainingHours = $totalHours % $hoursInDay;

    // Calculate months and remaining days
    $months = floor($days / $daysInMonth);
    $remainingDays = $days % $daysInMonth;

    // Calculate remaining minutes
    $remainingMinutes = $minutes % 60;

    // Construct the output
    $output = '';

    if ($months > 0) {
        $output .= $months . " month" . ($months > 1 ? "s" : "") . ", ";
    }
    if ($remainingDays > 0) {
        $output .= $remainingDays . " day" . ($remainingDays > 1 ? "s" : "") . ", ";
    }
    if ($remainingHours > 0) {
        $output .= floor($remainingHours) . " hour" . (floor($remainingHours) > 1 ? "s" : "") . ", ";
    }
    if ($remainingMinutes > 0) {
        $output .= $remainingMinutes . " minute" . ($remainingMinutes > 1 ? "s" : "");
    }

    // Remove trailing comma and space if any
    $output = rtrim($output, ', ');

    return $output;
}

function printer_data($userid,$column){
    $PrintersModel=new PrintersModel;
    $defaults=$PrintersModel->where('company_id',company($userid))->where('default',1)->where('user_id',$userid)->first();
    if ($defaults) {
        return $defaults[$column];
    }else{
        return 0;
    }
}

function user_token(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $length=50;
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString.''.time();
}

function pdf_api_url(){
    return 'https://services.aitsun.net/generate-pdf';
}

function isGmailAccount($recipient) {
    $gmailDomain = "@gmail.com";
    return substr($email, -strlen($gmailDomain)) === $gmailDomain;
}

function get_payments_of_invoice($invoice_id){
    $PaymentsModel=new PaymentsModel;
    $allpays=$PaymentsModel->where('invoice_id',$invoice_id)->findAll();
    return $allpays;
}

function email_support($company_id){

    $country=get_company_data($company_id,'country');

    $email='';

    if ($country=='India') {
        $email='info@aitsun.com';
    }elseif ($country=='Oman') {
        $email='info@aitsun.com';
        
    }else{

    }
    return $email;
}

function waiter_of(){
    return '';
}
function call_support($company_id){

    $country=get_company_data($company_id,'country');

    $phone='';

    if ($country=='India') {
        $phone='+918606662299';
    }elseif ($country=='Oman') {
        $phone='+96879947742';
    }else{
        
    }
    return $phone;
}

function send_sms_oman($Sender,$MSISDNs,$Message,$Priority,$Schdate,$AppID,$SourceRef){
    $ch = curl_init("https://ndssms.com/user/smspush.aspx?username=concept&password=concept123&phoneno=".$MSISDNs."&message=".$Message."&sender=".$Sender."&source=".$SourceRef."");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    // close the connection, release resources used
    curl_close($ch);

    $final_status=$response[0].$response[1];

    if (trim($final_status)=='OK') {
        return 'sent';
    }else{
        return 'failed';
    }
}

function no_of_invoice_payemts($invoice_id){ 
    $myid=session()->get('id');
    $PaymentsModel=new PaymentsModel;

    $all_invoices=0;

    $all_invoices=$PaymentsModel->where('deleted',0)->where('invoice_id',$invoice_id)->countAllResults();

    return $all_invoices;
}


function dpt_serial($company){
    $ProductCategories = new ProductCategories;
    $ProductCategories->where('deleted', 0)->selectMax('cat_department');
    $ProductCategories->where('company_id',$company);
    $get_serial=$ProductCategories->first();
    return $get_serial['cat_department']+1;
}

function concession_data($inid){
    $InvoiceModel = new InvoiceModel;
    $concession_data=$InvoiceModel->where('id',$inid)->where('concession_for!=','')->findAll();
    return $concession_data;
}

function category_dpt($categoryid){
    $ProductCategories = new ProductCategories;
    $user=$ProductCategories->where('id', $categoryid)->first();
    if ($user) {
        $fn=$user['cat_department'];
        return $fn;
    }else{
        return '';
    } 
}

function get_product_category($categoryid,$column){
    $ProductCategories = new ProductCategories;
    $user=$ProductCategories->where('id', $categoryid)->first();
    if ($user) {
         return $user[$column];
    }else{
            return 0;
    }
}

function aitsun_round($valueee,$decemals=0){
    $roundresult=round(0,$decemals);
    if (!empty($valueee)) {
        if (is_numeric($valueee)) { 
            $roundresult=number_format(round($valueee,$decemals),$decemals,'.',''); 
        }
    }
    return $roundresult; 
}


function weeks_array(){

    $weeks_array=[
        [
            'week'=>0,
            'week_name'=>'Sunday',
            'post_name'=>'sunday'
        ],
        [
            'week'=>1,
            'week_name'=>'Monday',
            'post_name'=>'monday'
        ],
        [
            'week'=>2,
            'week_name'=>'Tuesday',
            'post_name'=>'tuesday'
        ],
        [
            'week'=>3,
            'week_name'=>'Wednesday',
            'post_name'=>'wednesday'
        ],
        [
            'week'=>4,
            'week_name'=>'Thursday',
            'post_name'=>'thursday'
        ],
        [
            'week'=>5,
            'week_name'=>'Friday',
            'post_name'=>'friday'
        ],
        [
            'week'=>6,
            'week_name'=>'Saturday',
            'post_name'=>'saturday'
        ]
    ];

    return $weeks_array;
}


function custom_weeks(){

    $custom_weeks=[ 
        '1'=>'1st', 
        '2'=>'2nd', 
        '3'=>'3rd', 
        '4'=>'4rth', 
        '1,2'=>'1st & 2nd', 
        '1,3'=>'1st & 3rd', 
        '1,4'=>'1st & 4th', 
        '2,1'=>'2nd & 1st', 
        '2,3'=>'2nd & 3rd', 
        '2,4'=>'2nd & 4th', 
        '3,1'=>'3rd & 1st', 
        '3,2'=>'3rd & 2nd', 
        '3,4'=>'3rd & 4th', 
        '4,1'=>'4th & 1st', 
        '4,2'=>'4th & 2nd', 
        '4,3'=>'4th & 3rd', 
    ];

    return $custom_weeks;
}

function dateDifference($date1, $date2) {
    $dateTime1 = new DateTime($date1);
    $dateTime2 = new DateTime($date2);
    
    $interval = $dateTime1->diff($dateTime2);
    
    if ($interval->y > 0) {
        return $interval->y . ' year(s)';
    } elseif ($interval->m > 0) {
        return $interval->m . ' month(s)';
    } else {
        return $interval->d . ' day(s)';
    }
}


function convertToValidURL($domain) {
    $protocol = '//';
    if (substr($domain, 0, 2) === '//' || substr($domain, 0, 4) === 'http') {
        // Domain already has a protocol, no need to add it again
        return $domain;
    } else {
        return $protocol . $domain;
    }
}

function post_categories_array(){
    $myid=session()->get('id');
    $catmodel = new PostCategoryModel;
    $id=$catmodel->where('company_id',company($myid))->findAll();
    return $id;
}

function thumbnails_array($postid){
    $thumbmodel = new PostThumbnail;
    return $thumbmodel->where('post_id',$postid)->findAll();
}


function cat_name($cat){
    $catmodel = new PostCategoryModel;
    $numrows=$catmodel->where('id', $cat)->first();
    if ($numrows) {
        return $numrows['category_name'];
    }else{
        return '';
    }  
} 

function cat_data($cat,$column){
    $catmodel = new PostCategoryModel;
    $numrows=$catmodel->where('id', $cat)->first();
    if ($numrows) {
        return $numrows[$column];
    }else{
        return '';
    }  
} 

function numberTowords($num,$company_id)
{ 

    $country=get_company_data($company_id,'country');

    $before_dot='';
    $after_dot=''; 

    if ($country=='India') {
        $before_dot='rupees';
        $after_dot='paisa';
    }elseif ($country=='Oman') {
        $before_dot='rial';
        $after_dot='baisa';
    }else{

    }

    $ones = array( 
        1 => "one", 
        2 => "two", 
        3 => "three", 
        4 => "four", 
        5 => "five", 
        6 => "six", 
        7 => "seven", 
        8 => "eight", 
        9 => "nine", 
        10 => "ten", 
        11 => "eleven", 
        12 => "twelve", 
        13 => "thirteen", 
        14 => "fourteen", 
        15 => "fifteen", 
        16 => "sixteen", 
        17 => "seventeen", 
        18 => "eighteen", 
        19 => "nineteen" 
    ); 
    
    $tens = array( 
        1 => "ten",
        2 => "twenty", 
        3 => "thirty", 
        4 => "fourty", 
        5 => "fifty", 
        6 => "sixty", 
        7 => "seventy", 
        8 => "eighty", 
        9 => "ninety" 
    ); 
    
    $hundreds = array( 
        "hundred", 
        "thousand", 
        "million", 
        "billion", 
        "trillion", 
        "quadrillion" 
    ); // limit to quadrillion 
    
    $num = number_format($num, get_setting($company_id,'round_of_value'), ".", ",");
    $num_arr = explode(".", $num);
    $wholenum = $num_arr[0];

    if (isset($num_arr[1])) {
        $decnum = $num_arr[1];
    }else{
        $decnum=0;
    }
    
    
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr);
    
    $rettxt = ""; 
    
    foreach ($whole_arr as $key => $i) { 
        if ($i < 20) { 
            if (isset($ones[$i])) {
                $rettxt .= $ones[$i]; 
            }
            
        } elseif ($i < 100) { 
            if (isset($tens[substr($i, 0, 1)])) {
                $rettxt .= $tens[substr($i, 0, 1)]; 
            }
            if (isset($ones[substr($i, 1, 1)])) {
                $rettxt .= " " . $ones[substr($i, 1, 1)];
            }
            
        } else { 
            $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0]; 
            if (isset($tens[substr($i, 1, 1)])) {
                $rettxt .= " " . $tens[substr($i, 1, 1)]; 
            }
            if (isset($ones[substr($i, 2, 1)])) {
                $rettxt .= " " . $ones[substr($i, 2, 1)]; 
            } 
        } 
        
        if ($key > 0) { 
            $rettxt .= " " . $hundreds[$key] . " "; 
        } 
    } 
    
    if ($decnum > 0) { 
        $rettxt .= " ".$before_dot." and "; 
        if ($decnum < 20) { 

            if (isset($ones[$decnum])) {
             $rettxt .= $ones[$decnum]; 
         }
         

     } elseif ($decnum < 100) {  
        if (isset($tens[substr($decnum, 0, 1)])) {
            $rettxt .= $tens[substr($decnum, 0, 1)];
        }
        if (isset($ones[substr($decnum, 1, 1)])) {
           $rettxt .= " " . $ones[substr($decnum, 1, 1)]; 
       }
       
   } elseif ($decnum < 1000) { 
    $rettxt .= $ones[substr($decnum, 0, 1)] . ' ' . $hundreds[0]; 
    if (isset($tens[substr($decnum, 1, 1)])) {
        $rettxt .= " " . $tens[substr($decnum, 1, 1)]; 
    } 
    if (isset($ones[substr($decnum, 2, 1)])) {
        $rettxt .= " " . $ones[substr($decnum, 2, 1)]; 
    } 
} 

$rettxt .= " ".$after_dot."";
} else {
    $rettxt .= " ".$before_dot;
}

$rettxt .= " only";

return $rettxt; 
}



function get_manual_field_data($month_det,$var_employee_id,$var_field_id,$column){
    $ManualPayrollFieldValues = new ManualPayrollFieldValues();
    $checkexistman=$ManualPayrollFieldValues->where('MONTH(month_details)',get_date_format($month_det,'m'))->where('YEAR(month_details)',get_date_format($month_det,'Y'))->where('employee_id',$var_employee_id)->where('field_id',$var_field_id)->first();
    if ($checkexistman) {
        return $checkexistman[$column];
    }else{
        return 0;
    }
}

function additional_costs_array($manufacture_id){
    $ManufacturedCosts = new ManufacturedCosts();
    $docarray=$ManufacturedCosts->where('manufacture_id', $manufacture_id)->where('deleted',0)->findAll();
    return $docarray;
}

function manufactured_items_array($manufacture_id){
    $InvoiceitemsModel = new InvoiceitemsModel();
    $docarray=$InvoiceitemsModel->where('invoice_id', $manufacture_id)->where('product_priority!=', 1)->where('deleted',0)->findAll();
    return $docarray;
}

function get_invoicesetting($company,$invoice_type,$option){
    $InvoiceSettings = new InvoiceSettings;
    $get_res=$InvoiceSettings->where('company_id',$company)->where('invoice_type',$invoice_type)->first();
    if ($get_res) {
     
     return $get_res[$option];
 }else{
    return '';
}
}


function get_setting2($company,$option){
    $CompanySettings2 = new CompanySettings2;
    $get_res=$CompanySettings2->where('company_id',$company)->first();
    if ($get_res) {
     return $get_res[$option];
 }else{
    return '';
}
}

function get_organisation_settings2($company_id,$column){
    $CompanySettings2 = new CompanySettings2;
    $orname=$CompanySettings2->where('company_id',$company_id)->first();
    return $orname[$column];
}


function time_flow_sales_report($from,$to)
{
 $InvoiceModel = new InvoiceModel;
 $timeflow=$InvoiceModel->where("created_at BETWEEN '$from' AND '$to'")->where('invoice_type','sales')->where('deleted',0)->countAllResults();
 return $timeflow;
}

function count_submit($company_id){
    $InvoiceSubmitModel = new InvoiceSubmitModel();
    $subarray=$InvoiceSubmitModel->where('company_id', $company_id)->where('deleted',0)->findAll();
    return count($subarray);
} 







///////////////////////////////////////////////////////////////////////

function init_update_final_closing_product($product_id){
    $ProductsModel= new Main_item_party_table;
    $ProductsModel->update($product_id,['ready_to_update'=>1]);
}

function update_final_closing_value($product_id){
    $AccountingModel=new AccountingModel;
    $InvoiceitemsModel=new InvoiceitemsModel;
     $ProductsModel= new Main_item_party_table;
     $Stockadjustmodel= new Stockadjustmodel;

     $myid=session()->get('id');
     $acti=activated_year(company($myid));

    //declaring variables
    $final_closing_value=0;
    $purchase_value_of_item=0;
    $purchase_return_value_of_item=0;
    $sales_value_of_item=0;
    $sales_return_value_of_item=0;
    $avg_price_of_item=0;
    $adding_value=0;
    $removing_value=0;
    $sum_of_opening_and_adding_value=0;
    $get_account= $AccountingModel->where('customer_id',$product_id)->where('type','stock')->first();
    if ($get_account) {

        //opening stock and value
        $at_price=get_products_data($product_id,'at_price');
        $opening_stock=$get_account['opening_balance'];
        $opening_value=$opening_stock*$at_price;

        $current_year=get_date_format(now_time($myid),'Y');

        // counting purchase value item and purchase return value
        $get_purchase_value=$InvoiceitemsModel->select('sum(purchased_amount/conversion_unit_rate) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) as total_quantity')->where('product_id',$product_id)->where('invoice_type','purchase')->where('YEAR(invoice_date)',$current_year)->where('deleted',0)->first();

        $get_purchase_return_value=$InvoiceitemsModel->select('sum(purchased_amount/conversion_unit_rate) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) as total_quantity')->where('product_id',$product_id)->where('invoice_type','purchase_return')->where('YEAR(invoice_date)',$current_year)->where('deleted',0)->first();

        $purchase_value_of_item=$get_purchase_value['total'];
        $purchase_quantity_of_item=$get_purchase_value['total_quantity'];




        // /////////////
        // $adjusted_value=0; 

        // $adjusted_product=$Stockadjustmodel->select('sum(amount) as total_adjust_value,sum(qty) as total_adjust_qty')->where('adjust_type','add')->where('product_id',$product_id)->where('deleted',0)->first();
        // if ($adjusted_product) {
        //     $adjusted_value=$adjusted_product['total_adjust_value']; 
        //     $adjusted_qty=$adjusted_product['total_adjust_qty']; 
        // }

        // $purchase_value_of_item+=$adjusted_value;
        // $purchase_quantity_of_item+=$adjusted_qty;
        // /////////////
        

        $p_avg_price=$purchase_value_of_item;

        if (is_numeric($get_purchase_value['total_quantity'])) {
            if ($get_purchase_value['total_quantity']>0) {
                $p_avg_price=$purchase_value_of_item/$purchase_quantity_of_item;
            }
        }
        

        
        if ($p_avg_price<=0) {
            if ($at_price>0) {
                $p_avg_price=$at_price;
            }
            
        }

        $purchase_return_quantity_of_item=$get_purchase_return_value['total_quantity'];
        $purchase_return_value_of_item=$get_purchase_return_value['total_quantity']*$p_avg_price;
        



        // counting sales value item and sales return value
        $get_sales_value=$InvoiceitemsModel->select('sum(amount) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) AS total_qty')->where('product_id',$product_id)->where('invoice_type','sales')->where('deleted',0)->where('YEAR(invoice_date)',$current_year)->first();

        $get_sales_return_value=$InvoiceitemsModel->select('sum(amount) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) AS total_qty')->where('product_id',$product_id)->where('invoice_type','sales_return')->where('deleted',0)->where('YEAR(invoice_date)',$current_year)->first();

        

        $sales_value_of_item=$get_sales_value['total'];
        $sales_return_value_of_item=$get_sales_return_value['total'];



        $sales_value_of_item=$get_sales_value['total_qty']*$p_avg_price;
        $sales_return_value_of_item=$get_sales_return_value['total_qty']*$p_avg_price;

        // /////////////
        // $adjusted_sale_value=0; 
        // $sale_adjusted_product=$Stockadjustmodel->select('sum(amount) as total_sale_amt')->where('adjust_type','reduce')->where('product_id',$product_id)->where('deleted',0)->first();
        // if ($sale_adjusted_product) {
        //     $adjusted_sale_value=$sale_adjusted_product['total_sale_amt']; 
        // }
        // $sales_value_of_item+=$adjusted_sale_value;
        // ////////////
        

        // counting adding value and removeing value
        $adding_value=$purchase_value_of_item+$sales_return_value_of_item;
        $removing_value=$sales_value_of_item+$purchase_return_value_of_item;
        $final_adding_value=$adding_value-$removing_value;


        $avg_price_of_item=$sum_of_opening_and_adding_value;
        // sum of opening value and adding value
        $sum_of_opening_and_adding_value=$opening_value+$final_adding_value;

        if (is_numeric($get_account['closing_balance'])) {
            if ($get_account['closing_balance']>0) {
                $avg_price_of_item=$sum_of_opening_and_adding_value/$get_account['closing_balance'];
            }
        }
        

        $final_closing_value=$avg_price_of_item*$get_account['closing_balance'];
        $up_ga=[
            'final_closing_value'=>$final_closing_value
        ];

        $AccountingModel->update($get_account['id'],$up_ga);


        $ProductsModel->update($product_id,['ready_to_update'=>0]);
    }
}




function stock_value_product($product_id)
{
   $InvoiceitemsModel = new InvoiceitemsModel;
   $AccountingModel = new AccountingModel;
   $Stockadjustmodel = new Stockadjustmodel;

   // start purchase side
   $opening_value=0;
   $purchase_value=0;
   $purchase_return_value=0;
   $opening_value_product= $AccountingModel->where('customer_id',$product_id)->where('type','stock')->first();

   $purchase_value_product=$InvoiceitemsModel->select('sum(purchased_amount/conversion_unit_rate) as total')->where('product_id',$product_id)->where('invoice_type','purchase')->where('deleted',0)->first();

   $purchase_return_value_product=$InvoiceitemsModel->select('sum(purchased_amount/conversion_unit_rate) as total')->where('product_id',$product_id)->where('invoice_type','purchase_return')->where('deleted',0)->first();

   if ($opening_value_product) {
       $opening_value=$opening_value_product['opening_value'];
   }

   if ($purchase_value_product) {
    $purchase_value=$purchase_value_product['total'];
}

if ($purchase_return_value_product) {
    $purchase_return_value=$purchase_return_value_product['total'];
}


/////////////
$adjusted_value=0; 

$adjusted_product=$Stockadjustmodel->select('sum(amount) as total_adjust_value')->where('adjust_type','add')->where('product_id',$product_id)->where('deleted',0)->first();
if ($adjusted_product) {
    $adjusted_value=$adjusted_product['total_adjust_value']; 
}
$purchase_value+=$adjusted_value;
/////////////


$purchase_side=($opening_value+$purchase_value)-$purchase_return_value;

    // end purchase side


return $purchase_side;


}




function sales_stock_value($product_id,$qty){

    $InvoiceitemsModel = new InvoiceitemsModel;
    $AccountingModel = new AccountingModel;
    $Stockadjustmodel = new Stockadjustmodel;





// start sales side
    $sopening_value=0;
    $sale_value=0;
    $sale_return_value=0;
    $total_stock_value=stock_value_product($product_id);
    $purchase_quantity=0;
    $purchase_return_quantity=0;

    $purchase_value=$InvoiceitemsModel->select('sum(quantity/conversion_unit_rate) as total')->where('product_id',$product_id)->where('invoice_type','purchase')->where('deleted',0)->first();

    $purchase_return_value=$InvoiceitemsModel->select('sum(quantity/conversion_unit_rate) as total')->where('product_id',$product_id)->where('invoice_type','purchase_return')->where('deleted',0)->first();

    if ($purchase_value) {
        $purchase_quantity=$purchase_value['total'];
    }

    if ($purchase_return_value) {
       $purchase_return_quantity=$purchase_return_value['total'];
    }


    /////////////
    $adjusted_qty=0; 

    $adjusted_product=$Stockadjustmodel->select('sum(qty/conversion_unit_rate) as total_adjust_qty')->where('adjust_type','add')->where('product_id',$product_id)->where('deleted',0)->first();
    if ($adjusted_product) {
        $adjusted_qty=$adjusted_product['total_adjust_qty']; 
    }
    $purchase_quantity+=$adjusted_qty;
    ////////////

   $total_stock_quantity=($qty+$purchase_quantity)-$purchase_return_quantity;
   $avg_amt=0;

    if ($total_stock_quantity>0) {
        $avg_amt=$total_stock_value/$total_stock_quantity;
    }




$sopening_value_product= $AccountingModel->where('customer_id',$product_id)->first();

$sale_qty=$InvoiceitemsModel->select('sum(quantity/conversion_unit_rate) as total')->where('product_id',$product_id)->where('invoice_type','sales')->where('deleted',0)->first();

$sale_return_value_product=$InvoiceitemsModel->select('sum(quantity/conversion_unit_rate) as total')->where('product_id',$product_id)->where('invoice_type','sales_return')->where('deleted',0)->first();



/////////////
$adjusted_sale_qty=0; 

$sale_adjusted_product=$Stockadjustmodel->select('sum(qty/conversion_unit_rate) as total_adjust_qty')->where('adjust_type','reduce')->where('product_id',$product_id)->where('deleted',0)->first();
if ($sale_adjusted_product) {
    $adjusted_sale_qty=$sale_adjusted_product['total_adjust_qty']; 
}
////////////


if ($sopening_value_product) {
   $sopening_value=$sopening_value_product['opening_value'];
}
if ($sale_qty) {
    $sale_value=($sale_qty['total']+$adjusted_sale_qty)*$avg_amt;
}
if ($sale_return_value_product) {
    $sale_return_value=$sale_return_value_product['total']*$avg_amt;
}

$sales_side=$sale_value-$sale_return_value;

return $sales_side;

// end sales side

}







///////////////////////////////////////////////












function document_count($company_id){
    $DocumentRenewModel = new DocumentRenewModel();
    $docarray=$DocumentRenewModel->where('company_id', $company_id)->where('deleted',0)->findAll();
    return count($docarray);
}

function sum_of_amount($product_id){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $stock_val=$InvoiceitemsModel->select('sum(amount) as total')->where('deleted',0)->where('product_id',$product_id)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}

function get_stock_value($product_id,$inv_type)
{
    $InvoiceitemsModel = new InvoiceitemsModel;
    $stock_val=$InvoiceitemsModel->select('sum(amount) as total')->where('product_id',$product_id)->where('invoice_type',$inv_type)->where('deleted',0)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}



function avg_product_price($product_id,$pqty)
{
    $avg_price=0;
    
    $total_amount=(get_stock_value($product_id,'purchase')+get_stock_value($product_id,'sales_return'))-(get_stock_value($product_id,'sales')+get_stock_value($product_id,'purchase_return'));
    if ($total_amount>0 && $pqty>0) {
     $avg_price=$total_amount/$pqty;
 }
 
 return $avg_price;
}


function day_of_date($current,$datee){
   
    $curr_date=strtotime($current);
    $the_date=strtotime($datee);
    $diff=floor(($curr_date-$the_date)/(60*60*24));
    switch($diff)
    {
        case 0:
        return "Today";
        break;
        case 1:
        return "Yesterday";
        break;
        default:
        return get_date_format($datee,'d M Y');
    }
}


function get_cost_of_product($product_id){
    $avg_price=0;
    
    $total_amount=(get_stock_value($product_id,'purchase')+get_stock_value($product_id,'sales_return'));
    
    
    return $total_amount;
}

function get_profit_of_product($product_id){
    $avg_price=0;
    
    $total_amount=(get_stock_value($product_id,'sales')+get_stock_value($product_id,'purchase_return'));
    
    return $total_amount;
}


function sum_of_quantity($product_id,$from='',$dto=''){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $myid=session()->get('id');

    if (!empty($from) && empty($dto)) {
        $InvoiceitemsModel->where('invoice_date',$from);
    }
    if (!empty($dto) && empty($from)) {
        $InvoiceitemsModel->where('invoice_date',$dto);
    }

    if (!empty($dto) && !empty($from)) {
        $InvoiceitemsModel->where("invoice_date BETWEEN '$from' AND '$dto'");
    } 

     if (empty($dto) && empty($from)) {
        $InvoiceitemsModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
    }

    $stock_val=$InvoiceitemsModel->select('sum(quantity) as total')->where('deleted',0)->where('product_id',$product_id)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}

function sum_of_quantity_of_sales($product_id,$from='',$dto='',$invoice_type="sales"){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $myid=session()->get('id');

    if (!empty($from) && empty($dto)) {
        $InvoiceitemsModel->where('invoice_date',$from);
    }
    if (!empty($dto) && empty($from)) {
        $InvoiceitemsModel->where('invoice_date',$dto);
    }

    if (!empty($dto) && !empty($from)) {
        $InvoiceitemsModel->where("invoice_date BETWEEN '$from' AND '$dto'");
    } 

     if (empty($dto) && empty($from)) {
        $InvoiceitemsModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
    }

    $stock_val=$InvoiceitemsModel->select('sum(quantity) as total')->where('deleted',0)->where('invoice_type',$invoice_type)->where('product_id',$product_id)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}


function get_sales_value_of_product($product_id,$from='',$dto='',$invoice_type="sales"){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $myid=session()->get('id');
    
    if (!empty($from) && empty($dto)) {
        $InvoiceitemsModel->where('invoice_date',$from);
    }
    if (!empty($dto) && empty($from)) {
        $InvoiceitemsModel->where('invoice_date',$dto);
    }

    if (!empty($dto) && !empty($from)) {
        $InvoiceitemsModel->where("invoice_date BETWEEN '$from' AND '$dto'");
    } 

     if (empty($dto) && empty($from)) {
        $InvoiceitemsModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
    }

    $stock_val=$InvoiceitemsModel->select('sum(amount) as total')->where('deleted',0)->where('invoice_type',$invoice_type)->where('product_id',$product_id)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}

function weighing_machines_array(){
    $WeighingMachines = new WeighingMachines;
    return $WeighingMachines->findAll();

}

function get_splice_unit($device_id){ 
    $WeighingMachines = new WeighingMachines;
    $getsp=$WeighingMachines->where('id',$device_id)->first();
    if ($getsp) {
        return $getsp['slice_unit'];
    }else{
        return 1;
    }

}




function stock_value_of_product($product_id)
{
    $StockValuesTable = new StockValuesTable;
    $stock_val=$StockValuesTable->select('sum(amount) as total')->where('product_id',$product_id)->where('invoice_type!=','sales')->where('deleted',0)->first();
    if ($stock_val) {
        return $stock_val['total']-purchase_return_value($product_id)-sales_value($product_id)+sales_return_value($product_id);
    }else{
        return 0;
    }
}

function sales_value($product_id)
{
    $StockValuesTable = new StockValuesTable;
    $stock_val=$StockValuesTable->select('sum(amount) as total')->where('invoice_type','sales')->where('deleted',0)->where('product_id',$product_id)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}

function purchase_return_value($product_id)
{
    $StockValuesTable = new StockValuesTable;
    $stock_val=$StockValuesTable->select('sum(amount) as total')->where('invoice_type','purchase_return')->where('deleted',0)->where('product_id',$product_id)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}


function sales_return_value($product_id)
{
    $StockValuesTable = new StockValuesTable;
    $stock_val=$StockValuesTable->select('sum(amount) as total')->where('invoice_type','sales_return')->where('deleted',0)->where('product_id',$product_id)->first();
    if ($stock_val) {
        return $stock_val['total'];
    }else{
        return 0;
    }
}


function attendance_allowed_list($company_id){
    $AttendanceAllowedList=new AttendanceAllowedList();


    $AttendanceAllowedList->select('attendance_allowed.*, 
                customers.employee_category');
    $AttendanceAllowedList->join('customers', 'customers.id = attendance_allowed.user_id', 'left');
            
             

    $udata=$AttendanceAllowedList->where('attendance_allowed.company_id',$company_id)->where('attendance_allowed.attendance_allowed',1)->orderBy('attendance_allowed.user_name','asc')->findAll();
    return $udata;
}


function is_attendance_allowed($company_id,$employee_id){
    $AttendanceAllowedList=new AttendanceAllowedList();
    $ressss=0;
    $udata=$AttendanceAllowedList->where('company_id',$company_id)->where('user_id',$employee_id)->where('attendance_allowed',1)->first();
    if ($udata) {
        $ressss=$udata['attendance_allowed'];
    }
    return $ressss;
}




function parties_categories_array($company_id){
    $PartiesCategories = new PartiesCategories;
    $user=$PartiesCategories->where('company_id',$company_id)->where('deleted',0)->findAll();
    return $user;
}

function is_allowed_branch($branch_id,$allow_branch){
    $result=false;
    $al_branches=explode(',',$allow_branch);
    foreach ($al_branches as $br) {
        if (!empty($br)) {
            if ($br==$branch_id) {
             $result=true;
         }
     }
 }
 return $result;
}



function due_invoice_of_customer($invid,$invoice_type){
    $InvoiceModel = new InvoiceModel;
    $get_name=$InvoiceModel->where('customer',$invid)->where('due_amount>',0)->where('invoice_type',$invoice_type)->where('deleted',0)->orderBy('id','desc')->findAll();
    return $get_name;
} 


function lead_id_of_invoice($invid){
    $CrmActionInventories = new CrmActionInventories;
    $get_name=$CrmActionInventories->where('invoice_id',$invid)->first();
    if ($get_name) {
        return $get_name['lead_id'];
    }else{
        return 0;
    }
}


function payment_id($client_id){
    $UserModel = new Main_item_party_table;
    $user=$UserModel->where('id',$client_id)->findAll();
    return $user;
}

function alert_sessions_array($billid){
    $AlertSessionModel = new AlertSessionModel;
    $get_name=$AlertSessionModel->where('bill_id',$billid)->findAll();
    return $get_name;
}



function user_price($userid){
    $UserModel = new Main_item_party_table;
    $get_name=$UserModel->where('id',$userid)->first();
    if ($get_name) {
        return $get_name['price'];
    }else{
        return '';
    }
}


function difference_bw_dates($date1,$date2){

    $diff=date_diff(date_create($date1),date_create($date2));
    return str_replace('+', '', $diff->format("%R%a"));
}

function get_bill_data($userid,$column){
    $ClientpaymentModel = new ClientpaymentModel;
    $get_name=$ClientpaymentModel->where('client_id',$userid)->first();
    if ($get_name) {
        return $get_name[$column];
    }else{
        return '';
    }
}



function create_billing($insert_id){
    $ClientpaymentModel = new ClientpaymentModel;
    $AlertSessionModel = new AlertSessionModel;
    $UserModel = new Main_item_party_table;
    $myid=session()->get('id');

    $client_data=$UserModel->where('id',$insert_id)->first();

    $client_monthly_billing=$client_data['monthly_billing_date'];

    $curr_date=get_date_format(now_time($myid),'d');
    $temp_billing_date=get_date_format(now_time($myid),'Y-m').'-'.$client_monthly_billing;
    

    $pos_payment_type=$client_data['pos_payment_type'];

    if ($pos_payment_type=='monthly') {
        if ($curr_date<$client_monthly_billing) {
            $billing_date = date('Y-m-d', strtotime($temp_billing_date));
        }else{
            $billing_date = date('Y-m-d', strtotime('+1 month', strtotime($temp_billing_date)));
        }
    }else{
        if ($curr_date<$client_monthly_billing) {
            $billing_date = date('Y-m-d', strtotime($temp_billing_date));
        }else{
            $billing_date = date('Y-m-d', strtotime('+1 year', strtotime($temp_billing_date)));
        }
    }
    
    $date1=date('Y-m-d', strtotime('-2 days', strtotime($billing_date)));
    $date2=date('Y-m-d', strtotime('-1 days', strtotime($billing_date)));
    $date3=date('Y-m-d', strtotime('0 days', strtotime($billing_date)));
    $date4=date('Y-m-d', strtotime('+1 days', strtotime($billing_date)));                
    

    $csdata = [

        'client_id'=>$insert_id,
        'company_id'=>company($myid),
        'status'=>'pending',
        'datetime'=> now_time($myid),
        'billing_date'=> $billing_date,
        'date1'=>$date1,
        'date2'=>$date2,
        'date3'=>$date3,
        'date4'=>$date4,
        'datetime'=>now_time($myid),
    ];

    $ClientpaymentModel->save($csdata);


    $insert_id1=$ClientpaymentModel->insertID();


    $dates_array=[

        $date1.' 06:00:00',
        $date1.' 16:00:00',
        $date2.' 06:00:00',
        $date2.' 16:00:00',
        $date3.' 06:00:00',
        $date3.' 16:00:00',
        $date4.' 06:00:00',
        $date4.' 16:00:00',
    ];


    foreach ($dates_array as $fd) {
        $ntdata = [
            'bill_id'=>$insert_id1,
            'status'=>'running',
            'datetime'=>$fd,
        ];

        $AlertSessionModel->save($ntdata);
    }
}



function is_hided($company_id,$tax_name){
    $HidedTaxes=new HidedTaxes;
    $chek=$HidedTaxes->where('company_id',$company_id)->where('tax_name',$tax_name)->first();
    if($chek){
        return 1;
    }else{
        return 0;
    }
}

function child_site(){
    return 'https://utechoman.com/';
}

function three_days_before($datee){
    return date('Y-m-d', strtotime($datee.'-3 days '));
}

function calculate_date($datee,$days){
    return date('Y-m-d', strtotime($datee.''.$days.' days '));
}

function before_one_week($datee){
    return date('Y-m-d', strtotime($datee.'-1 weeks'));
}

function gst_value_of_invoice($company_id,$invoice_id,$tax){
    $InvoiceTaxes=new InvoiceTaxes; 
    $invoice_tax=$InvoiceTaxes->where('invoice_id',$invoice_id)->where('tax_name',$tax)->first();
    if ($invoice_tax) {
        return $invoice_tax['tax_amount'];
    }else{
        return 0;
    }
    

}

function gst_taxable_value_of_invoice($company_id,$invoice_id,$tax){
    $InvoiceTaxes=new InvoiceTaxes; 
    $invoice_tax=$InvoiceTaxes->where('invoice_id',$invoice_id)->where('tax_name',$tax)->first();
    if ($invoice_tax) {
        return $invoice_tax['taxable_amount'];
    }else{
        return 0;
    }
    
}


function get_payment_data($payment_id,$column){
    $PaymentsModel = new PaymentsModel;
    $user=$PaymentsModel->where('id',$payment_id)->first();
    
    if ($user) {
        return $user[$column];
    }else{
        return 0;
    }
}





function search_array($array, $key, $value) {
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subarray) {
            $results = array_merge($results, search_array($subarray, $key, $value));
        }
    }
    return $results;
} 

function pro_identy($pro){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$pro)->first();
    if ($namu) {
        return $namu['pro_in'];
    }else{
        return '';
    }
    
}

function name_of_work_category($categoryid){
    $WorkcategoryModel = new WorkcategoryModel;
    $user=$WorkcategoryModel->where('id', $categoryid)->first();

    if ($user) {
        $fn=$user['category_name'];
        return $fn;
    }else{
        return '';
    }
    
}

function rand_string($n) {  
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    
    return $randomString; 
}  



function reCaptcha($recaptcha){
  $secret = "6LcCRJsfAAAAADeslwAkl7uOXCkjPHp56ivzc_Nv";
  $ip = $_SERVER['REMOTE_ADDR'];

  $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
  $url = "https://www.google.com/recaptcha/api/siteverify";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  $data = curl_exec($ch);
  curl_close($ch);

  return json_decode($data, true);
}


function user_rg($userid){
    $WorkDepartmentModel = new WorkDepartmentModel;
    $get_name=$WorkDepartmentModel->where('id',$userid)->first();
    if ($get_name) {
        return $get_name['department_name'];
    }else{
        return '';
    }
}

function users_array($company){
    $UserModel = new Main_item_party_table;
    $use=$UserModel->where('company_id',$company)->where('deleted',0)->findAll();
    return $use;
}

function fields_name_array($company){
    $FieldsNameModel = new FieldsNameModel;
    $use=$FieldsNameModel->where('company_id',$company)->where('deleted',0)->findAll();
    return $use;
}

function child_of_group_categories($parent_id){
    $AccountCategory = new AccountCategory;
    $catgry=$AccountCategory->where('parent_id',$parent_id)->where('deleted',0)->orderBy('id','desc')->findAll();
    return $catgry;
}

function group_head_array($company_id){
    $ExgroupheadsModel = new ExgroupheadsModel;
    $user=$ExgroupheadsModel->where('company_id',$company_id)->where('deleted',0)->orderBy('id','desc')->findAll();
    return $user;
}

function invoice_id_of_payment($payment_id){
    $PaymentsModel = new PaymentsModel;
    $user=$PaymentsModel->where('id',$payment_id)->first();
    
    if ($user) {
        return $user['invoice_id'];
    }else{
        return 0;
    }
}


function get_leave_manage_date($staff_id,$date,$status){
    $LeaveManagement = new LeaveManagement;
    $cur_year=get_date_format($date,'Y');
    $crda=$LeaveManagement->where('YEAR(date)',$cur_year)->where('staff_id',$staff_id)->where('leave_status',$status)->findAll();
    return $crda;
}


function carry_forwarded_leave($staff_id,$year){
    $CarryForwardedLeaves = new CarryForwardedLeaves;
    $cur_year=get_date_format($year,'Y');
    $prev_year=$cur_year-1;
    $crda=$CarryForwardedLeaves->where('year',$prev_year)->where('staff_id',$staff_id)->first();
    if ($crda) {
        return $crda['leave'];
    }else{
        return 0;
    }
}

function default_unit($company){
    $ProductUnits = new ProductUnits;
    $unit=$ProductUnits->where('company_id',$company)->where('deleted',0)->where('check_default',1)->first();
    if ($unit) {
        return $unit['id'];
    }else{
        return 0;
    }
}

function invoice_convert($inid){
    $InvoiceModel = new InvoiceModel;
    $cs=$InvoiceModel->where('id',$inid);
    $inqr=$cs->findAll();
    foreach ($inqr as $get_r) {
        $converted=$get_r['converted'];
        return $converted;
    } 
}

function calculate_percentage($num1,$num2){
    if ($num1>0 && $num2>0) {
        return ($num1/$num2)*100;
    }else{
        return 0;
    }
    
}


function completed_days($userid,$date){
    $dayss=0;
    $AttendanceModel=new AttendanceModel();
    $AttendanceModel->where('YEAR(date)',get_date_format($date,'Y'));
    $AttendanceModel->where('MONTH(date)',get_date_format($date,'m'));
    $AttendanceModel->where('employee_id',$userid);
    $AttendanceModel->where('company_id',company($userid));
    $AttendanceModel->where('attendance!=','WO');
    $dayss=$AttendanceModel->countAllResults();
    return $dayss;
}


function present_days_for_diagram($userid,$date){
    $present_days=present_days($userid,$date);
    $half_days=half_days($userid,$date)/2;
    return $present_days+$half_days;
}

function absent_days_for_diagram($userid,$date){
    $absent_days=absent_days($userid,$date);
    $half_days=half_days($userid,$date)/2;
    return $absent_days+$half_days;
}

function present_days($userid,$date){
    $dayss=0;
    $AttendanceModel=new AttendanceModel();
    $AttendanceModel->where('YEAR(date)',get_date_format($date,'Y'));
    $AttendanceModel->where('MONTH(date)',get_date_format($date,'m'));
    $AttendanceModel->where('employee_id',$userid);
    $AttendanceModel->where('company_id',company($userid));
    $AttendanceModel->where('attendance!=','WO');
    $AttendanceModel->where('attendance!=','Absent');
    $AttendanceModel->where('attendance!=','H.D'); 
    $dayss=$AttendanceModel->countAllResults();
    return $dayss;
}

function half_days($userid,$date){
    $dayss=0;
    $AttendanceModel=new AttendanceModel();
    $AttendanceModel->where('YEAR(date)',get_date_format($date,'Y'));
    $AttendanceModel->where('MONTH(date)',get_date_format($date,'m'));
    $AttendanceModel->where('employee_id',$userid);
    $AttendanceModel->where('company_id',company($userid));
    $AttendanceModel->where('attendance','H.D');
    $dayss=$AttendanceModel->countAllResults();
    return $dayss;
}

function absent_days($userid,$date){
    $dayss=0;
    $AttendanceModel=new AttendanceModel();
    $AttendanceModel->where('YEAR(date)',get_date_format($date,'Y'));
    $AttendanceModel->where('MONTH(date)',get_date_format($date,'m'));
    $AttendanceModel->where('employee_id',$userid);
    $AttendanceModel->where('company_id',company($userid));
    $AttendanceModel->where('attendance','Absent');
    $dayss=$AttendanceModel->countAllResults();
    return $dayss;
}

function overtime_days($userid,$date){
    $dayss=0;
    $AttendanceModel=new AttendanceModel();
    $AttendanceModel->where('YEAR(date)',get_date_format($date,'Y'));
    $AttendanceModel->where('MONTH(date)',get_date_format($date,'m'));
    $AttendanceModel->where('employee_id',$userid);
    $AttendanceModel->where('company_id',company($userid));
    $AttendanceModel->where('attendance','OT');
    $dayss=$AttendanceModel->countAllResults();
    return $dayss;
}

function work_from_home_days($userid,$date){
    $dayss=0;
    $AttendanceModel=new AttendanceModel();
    $AttendanceModel->where('YEAR(date)',get_date_format($date,'Y'));
    $AttendanceModel->where('MONTH(date)',get_date_format($date,'m'));
    $AttendanceModel->where('employee_id',$userid);
    $AttendanceModel->where('company_id',company($userid));
    $AttendanceModel->where('attendance','W H');
    $dayss=$AttendanceModel->countAllResults();
    return $dayss;
}

function week_off_days($userid,$date){
    $dayss=0;
    $AttendanceModel=new AttendanceModel();
    $AttendanceModel->where('YEAR(date)',get_date_format($date,'Y'));
    $AttendanceModel->where('MONTH(date)',get_date_format($date,'m'));
    $AttendanceModel->where('employee_id',$userid);
    $AttendanceModel->where('company_id',company($userid));
    $AttendanceModel->where('attendance','WO');
    $dayss=$AttendanceModel->countAllResults();
    return $dayss;
}

function products_array($company){
    $ProductsModel=new Main_item_party_table();
    $getuse=$ProductsModel->where('company_id',$company)->where('main_type','product')->where('deleted',0)->findAll();
    return $getuse;
}

function get_users_by_permission($company_id,$solumn){
    $PermissionModel=new PermissionModel();
    $getuse=$PermissionModel->where('company_id',$company_id)->where($solumn,1)->findAll();
    return $getuse;
}

function get_admins_of_company($company_id){
    $UserModel=new Main_item_party_table();
    $getuse=$UserModel->where('company_id',$company_id)->where('u_type','admin')->where('deleted',0)->findAll();
    return array();
}

function aitsun_get_admins_of_company($company_id){
    $UserModel=new Main_item_party_table();
    $getuse=$UserModel->where('company_id',$company_id)->where('u_type','admin')->where('deleted',0)->findAll();
    return $getuse;
}

function staffs_array($company_id){
    $myid=session()->get('id');
    $UserModel=new Main_item_party_table();
    $getuse=$UserModel->where('company_id',$company_id)->where('u_type','staff')->where('deleted',0)->findAll();
    return $getuse;
}



function timetest($date){
        $date = get_date_format($date,'F Y');//Current Month Year
        $de_date = get_date_format($date,'Y-m');//Current Month Year
        return $de_date . '-' . date('t', strtotime($date));
    }


function get_company_data($user,$option){
    $Companies = new Companies;
    $get_res=$Companies->where('id',$user)->first();
    if ($get_res) {
        return $get_res[$option];
    }else{
        return '';
    } 
}

function child_of_categories($parent_id){
    $ProductSubCategories = new ProductSubCategories;
    $user=$ProductSubCategories->where('parent_id',$parent_id)->where('deleted',0)->findAll();
    return $user;
}


function child_of_subcategories($parent_id){
    $SecondaryCategories = new SecondaryCategories;
    $user=$SecondaryCategories->where('parent_id',$parent_id)->where('deleted',0)->findAll();
    return $user;
}

function work_department_array($dptname){
    $WorkDepartmentModel =new WorkDepartmentModel;
    $wd = $WorkDepartmentModel->where('company_id',$dptname)->where('deleted',0);
    return $wd->findAll();
}

function add_task_report($task_report_data){
    $TaskreportModel = new TaskreportModel;
    $TaskreportModel->save($task_report_data);
    $id = $TaskreportModel->insertID();
    return $id;
}

function company_settings_id($company_id){
    $CompanySettings=new CompanySettings;
    $getid=$CompanySettings->where('company_id',$company_id)->first();
    if ($getid) {
        return $getid['id'];
    }else{
        return 0;
    }
}

function c_color($letter){
    $char=strtolower($letter);
    if ($char=='a') {
        return '#FF0000';
    }elseif ($char=='b') {
        return '#681194';
    }elseif ($char=='c') {
        return '#800000';
    }elseif ($char=='d') {
        return '#808000';
    }elseif ($char=='e') {
        return '#00FF00';
    }elseif ($char=='f') {
        return '#008000';
    }elseif ($char=='g') {
        return '#00FFFF';
    }elseif ($char=='h') {
        return '#008080';
    }elseif ($char=='i') {
        return '#0000FF';
    }elseif ($char=='j') {
        return '#000080';
    }elseif ($char=='k') {
        return '#FF00FF';
    }elseif ($char=='l') {
        return '#800080';
    }elseif ($char=='m') {
        return '#FF0000';
    }elseif ($char=='n') {
        return '#800000';
    }elseif ($char=='o') {
        return '#808000';
    }elseif ($char=='p') {
        return '#00FF00';
    }elseif ($char=='q') {
        return '#008000';
    }elseif ($char=='r') {
        return '#00FFFF';
    }elseif ($char=='s') {
        return '#008080';
    }elseif ($char=='t') {
        return '#0000FF';
    }elseif ($char=='u') {
        return '#000080';
    }elseif ($char=='v') {
        return '#FF00FF';
    }elseif ($char=='w') {
        return '#800080';
    }elseif ($char=='x') {
        return '#FF0000';
    }elseif ($char=='y') {
        return '#800000';
    }elseif ($char=='z') {
        return '#808000';
    }else{
        return '#000000';
    }
}

function first_letter($word,$char){
    return substr($word, 0,$char);
}

function contact_type($id){
    $ContactType = new ContactType;
    $ct=$ContactType->where('id',$id)->first();
    if($ct){
        return $ct['contact_type'];
    }else{
        return '';
    }
    
}

function all_users_array($main_company_id){ 
    $UserModel=new Main_item_party_table();
    $getuse=$UserModel->where('main_compani_id',$main_company_id)->where('deleted',0)->where('u_type!=','customer')->where('u_type!=','vendor')->where('u_type!=','seller')->where('u_type!=','delivery')->orderBy('display_name','ASC')->findAll();
    return $getuse;
}


function designation($id){
    $Designation = new Designation;
    $cc=$Designation->where('id',$id)->first();
    if($cc){
        return $cc['designation'];
    }else{
        return '';
    }
    
}

function contact_typearray($company){
    $ContactType = new ContactType;
    $ContactType->where('company_id',$company)->where('deleted',0);
    return $ContactType->findAll();
}
function designationarray($company){
    $Designation = new Designation;
    $Designation->where('company_id',$company)->where('deleted',0);
    return $Designation->findAll();
}

function work_category_name($categoryid){
    $WorkcategoryModel = new WorkcategoryModel;
    $user=$WorkcategoryModel->where('id', $categoryid)->first();
    if ($user) {
        $fn=$user['category_name'];
        return $fn;
    }else{
        return '';
    }
    
    
}

function work_category_array($company){
    $WorkcategoryModel= new WorkcategoryModel;
    $wc=$WorkcategoryModel->where('company_id',$company)->where('deleted',0);
    return $wc->findAll();
}

function one_week_before($datee){
    return date('Y-m-d', strtotime($datee.'-1 weeks '));
}
function one_month_before($datee){
    return date('Y-m-d', strtotime($datee.'-1 months'));
}

function count_renew($company,$stat){
    $DocumentRenewModel = new DocumentRenewModel;
    $stcnt=$DocumentRenewModel->where('company_id',$company)->where('r_status',$stat)->where('deleted',0);
    return count($stcnt->findAll());
}


function rn_status_class($status){
    if ($status=='due') {
     return 'bg-primary';
 }elseif ($status=='over due') {
    return 'bg-danger';
}elseif ($status=='critical') {
    return 'bg-warning';
}else {
    return 'bg-dark';
}

}

function document_renew_category_array($company){
    $DoccategoryModel= new DoccategoryModel;
    $dcatqry=$DoccategoryModel->where('company_id',$company)->where('deleted',0)->findAll();
    return $dcatqry;
}

function doc_cat_name($cat_id){
    $DoccategoryModel = new DoccategoryModel;
    $farray=$DoccategoryModel->where('id', $cat_id)->first();
    if ($farray) {
        return $farray['name'];
    }else{
        return '';
    }
    
}

function pro_request_items_array($pro_rq_id,$limit){
    $QuoteItemsModel= new QuoteItemsModel;

    $QuoteItemsModel->where('request_id',$pro_rq_id);
    if ($limit!='unlimited') {
        $pro_rq=$QuoteItemsModel->findAll($limit);
    }else{
        $pro_rq=$QuoteItemsModel->findAll();
    }
    
    return $pro_rq;

}

function delete_work_update($workid){
    $WorkUpdatesModel=new WorkUpdatesModel();
    if ($WorkUpdatesModel->delete($workid)) {
        return true;
    }else{
        return false;
    }
}

function lead_of_invoice($invoice_id){
    $CrmActionInventories= new CrmActionInventories;
    $ex=$CrmActionInventories->where('invoice_id',$invoice_id)->first();
    if ($ex) {
        return $ex['lead_id'];
    }else{
        return 'no_leads';
    }
    
}

function lead_data($lead,$column){
    $LeadModel= new LeadModel;
    $ex=$LeadModel->where('id',$lead)->first();
    if ($ex) {
        return $ex[$column];
    }else{
        return '';
    }
    
}

function get_delivery_days($company){
    $CompanySettings= new CompanySettings;
    $ex=$CompanySettings->where('company_id',$company)->first();
    return $ex['delivery_days'];
}

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

function iso_to_name($iso){
    $country_name='';
    if (!empty($iso)) {
        $isoo=strtolower($iso);
        if ($isoo=='om') {
            $country_name='Oman';
        }
        if ($isoo=='in') {
            $country_name='India';
        }
    }
    return $country_name;
}



function stocks($company,$activated_year,$product_id,$column){
    $StockModel= new StockModel;
    $hs=$StockModel->where('company_id',$company)->where('product_id',$product_id)->first();
    if ($hs) {
        return $hs[$column];
    }else{
        return 0;
    }
    
}



function check_unit_during_import($company,$unit){
    $ProductUnits= new ProductUnits;
    $rettt='';
    $checkunit=$ProductUnits->where('name',$unit)->where('company_id',$company)->first();
    if ($checkunit) {
        $rettt=$checkunit['id'];
    }else{
        $datau=[
            'company_id'=>$company,
            'name'=>$unit
        ];
        $ProductUnits->save($datau);
        $rettt=$ProductUnits->insertID();
    }
    return $rettt;
}



function check_tax_during_import($company,$taxname){

    $TaxtypeModel= new TaxtypeModel;
    $rettt='';
    $checkunit=$TaxtypeModel->where('name',$taxname)->where('company_id',$company)->first();
    if ($checkunit) {
        $rettt=$checkunit['id'];
    }else{
            // $datau=[
            //     'company_id'=>$company,
            //     'name'=>$taxname,
            //     'percent'=>$taxvalue,
            // ];
            // $TaxtypeModel->save($datau);
        $rettt=0;
    }
    return $rettt;
}



function check_category_during_import($company,$unit){
    $ProductCategories= new ProductCategories;
    $rettt='';
    if (empty($unit)) {
        $unit='Default';
    }
    $checkunit=$ProductCategories->where('cat_name',$unit)->where('company_id',$company)->first();
    if ($checkunit) {
        $rettt=$checkunit['id'];
    }else{
        $datau=[
            'company_id'=>$company,
            'cat_name'=>$unit,
            'cat_department' =>  dpt_serial($company)
        ];
        $ProductCategories->save($datau);
        $rettt=$ProductCategories->insertID();
    }
    return $rettt;
}


function check_sub_category_during_import($company,$unit,$parent){
    $ProductSubCategories= new ProductSubCategories;
    $rettt='';
    $checkunit=$ProductSubCategories->where('sub_cat_name',$unit)->where('parent_id',$parent)->where('company_id',$company)->first();
    if ($checkunit) {
        $rettt=$checkunit['id'];
    }else{
        $datau=[
            'company_id'=>$company,
            'sub_cat_name'=>$unit,
            'parent_id'=>$parent
        ];
        if (trim($unit)!='') {
            if ($parent!=0) {
                $ProductSubCategories->save($datau);
                $rettt=$ProductSubCategories->insertID();
            }else{
                $rettt=0;
            }
            
        }else{
            $rettt=0;
        }
        
    }
    return $rettt;
}

function check_brand_category_during_import($company,$unit){
    $ProductBrand= new ProductBrand;
    $rettt='';

    if (empty($unit)) {
        $unit='General';
    }
    
    $checkunit=$ProductBrand->where('brand_name',$unit)->where('company_id',$company)->first();
    if ($checkunit) {
        $rettt=$checkunit['id'];
    }else{
        $datau=[
            'company_id'=>$company,
            'brand_name'=>$unit
        ];
        $ProductBrand->save($datau);
        $rettt=$ProductBrand->insertID();
    }
    return $rettt;
}



function unique_send_email($company,$to,$subject,$message,$attached){
    $email = \Config\Services::email();
    $from =get_setting($company,'smtp_user');
    $fromName=get_setting($company,'from_name');
    $email->setFrom($from, $fromName);
    $email->setTo($to);
    $email->setSubject($subject);
    $email->setMessage($message);
    $email->setMailtype('html');

    if ($email->send()) {
        return true;
    }
    else
    {
        return false;
            // echo "Failed to send email";
            // show_error($ci->email->print_debugger());             
    }
}

function send_sms($company,$message,$mobileNumber){
    $fields = array(
        "message" => $message,
        "language" => "english",
        "route" => "v3",
        "sender_id" => 'FTWSMS',
        "numbers" => $mobileNumber,
    );



    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($fields),
      CURLOPT_HTTPHEADER => array(
        "authorization: Y9gztp6vla0Z1HbXrmA2ei7LKhnMqCfQojs8RuwFcEySVO3kxGQAhf3c7ubGxL60P9EZOJlv8BtUjYRF",
        "accept: /",
        "cache-control: no-cache",
        "content-type: application/json"
    ),
  ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    $manage = json_decode($response, true);

    $sms_status=$manage['return'];
    $sms_message=$manage['message'];

    if ($sms_status=='true') {
       $lstcred=message_credits($company)-1;
       $org_data = [
          'message_credits'=>$lstcred
      ];

      $UserModel = new Main_item_party_table;

      $aurthorid=author_id($company);
      $UserModel->update($aurthorid,$org_data);

      return true;

      
  } else {
    
    return false;
    
}

}

function lead_by_array($company){
    $myid=session()->get('id');
    $UserModel = new Main_item_party_table;
    $UserModel->where('main_compani_id',main_company_id($myid))->where('deleted',0);
    $UserModel->where('u_type','staff');
    return $UserModel->findAll();
}

function data_of_currency($currency,$column){
    $ScrapCurrencyTable= new ScrapCurrencyTable;
    $ratee=0;
    $get_rate=$ScrapCurrencyTable->where('currency',$currency)->first();
    if ($get_rate) {
        $ratee=$get_rate[$column];
    }
    return $ratee;
}


function scrap_currency_array(){
    $ScrapCurrencyTable= new ScrapCurrencyTable;
    return $ScrapCurrencyTable->findAll();
}

function raw_materials_array_for_show($product_id,$inovice_id){
    $InvoiceitemsModel= new InvoiceitemsModel;
    $InvoiceitemsModel->where('type','item_kit')->where('product_id',$product_id)->where('invoice_id',$inovice_id);
    return $InvoiceitemsModel->findAll();
}




function bill_type_for_daybook($bill_type){
    if ($bill_type=='sale') {
        return 'Sales';
    }elseif ($bill_type=='purchase') {
        return 'Purchases';
    }elseif ($bill_type=='purchase return') {
        return 'Purchases Return';
    }elseif ($bill_type=='sale return') {
        return 'Sales return';
    }else{
        $bil=str_replace('_', ' ', $bill_type);
        return ucfirst($bil);
    }
}

function expense_type_name($account_name){

    $ExpensestypeModel= new ExpensestypeModel;
    $gh=$ExpensestypeModel->where('id' ,$account_name);
    foreach ($gh->findAll() as $cn) {
        return $cn['expense_name'];
    }
    
}

function expense_types_array($company){
    $ExpensestypeModel= new ExpensestypeModel;
    $ex=$ExpensestypeModel->where('company_id',$company)->where('deleted',0);
    return $ex->findAll();
}

function reduce_chars($title,$max){
    return substr($title, 0, $max);
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}

function file_url($url){
  $parts = parse_url($url);
  $path_parts = array_map('rawurldecode', explode('/', $parts['path']));

  return
  $parts['scheme'] . '://' .
  $parts['host'] .
  implode('/', array_map('rawurlencode', $path_parts))
  ;
}


function scrap_sites_array($company){
    $ScrapModel= new ScrapModel;
    $scrr=$ScrapModel->where('company_id', $company);
    $cus_row=$scrr->findAll();
    return $cus_row;
}

function inventory_prefix($company,$in_type){
    $prefixxxx=get_setting($company,'invoice_prefix');
    if ($in_type=='sales'){
     $prefixxxx.=get_setting($company,'sales_prefix'); 
 }elseif ($in_type=='proforma_invoice'){
     $prefixxxx.=get_setting($company,'proforma_invoice_prefix'); 
 }elseif ($in_type=='purchase'){
     $prefixxxx.=get_setting($company,'purchase_prefix'); 
 }elseif ($in_type=='sales_order'){
     $prefixxxx.=get_setting($company,'sales_order_prefix'); 
 }elseif ($in_type=='sales_quotation'){
     $prefixxxx.=get_setting($company,'sales_quotation_prefix'); 
 }elseif ($in_type=='sales_return'){
     $prefixxxx.=get_setting($company,'sales_return_prefix'); 
 }elseif ($in_type=='sales_delivery_note'){
     $prefixxxx.=get_setting($company,'sales_delivery_prefix'); 
 }elseif ($in_type=='purchase_order'){
  $prefixxxx.=get_setting($company,'purchase_order_prefix'); 
}elseif ($in_type=='purchase_quotation'){
 $prefixxxx.=get_setting($company,'purchase_quotation_prefix'); 
}elseif ($in_type=='purchase_return'){
 $prefixxxx.=get_setting($company,'purchase_return_prefix'); 
}elseif ($in_type=='purchase_delivery_note'){
 $prefixxxx.=get_setting($company,'purchase_delivery_prefix'); 
}else{
    
}
return $prefixxxx;
}

function inventory_type($in_type){
    $typpe='sales';
    if ($in_type=='purchase'){
     $typpe='purchase';
 }elseif ($in_type=='purchase_order'){
  $typpe='purchase';
}elseif ($in_type=='purchase_quotation'){
 $typpe='purchase';
}elseif ($in_type=='purchase_return'){
 $typpe='purchase'; 
}elseif ($in_type=='purchase_delivery_note'){
 $typpe='purchase';
}else{
    
}
return $typpe;
}


function inventory_heading($company,$in_type){
    $prefixxxx='';
    
    if ($in_type=='sales'){
       $prefixxxx='TAX INVOICE';
   }elseif ($in_type=='proforma_invoice'){
       $prefixxxx='PROFORMA INVOICE';
   }elseif ($in_type=='purchase'){
       $prefixxxx='PURCHASE';
   }elseif ($in_type=='sales_order'){
       $prefixxxx='SALES ORDER';
   }elseif ($in_type=='sales_quotation'){
       $prefixxxx='SALES QUOTATION';
   }elseif ($in_type=='sales_return'){
       $prefixxxx='SALES RETURN';
   }elseif ($in_type=='sales_delivery_note'){
       $prefixxxx='SALES DELIVERY NOTE';
   }elseif ($in_type=='purchase_order'){
       $prefixxxx='PURCHASE ORDER';
   }elseif ($in_type=='purchase_quotation'){
       $prefixxxx='PURCHASE QUOTATION';
   }elseif ($in_type=='purchase_return'){
       $prefixxxx='PURCHASE RETURN'; 
   }elseif ($in_type=='purchase_delivery_note'){
       $prefixxxx='PURCHASE DELIVERY NOTE';
   }elseif ($in_type=='challan'){
       $prefixxxx='Challan';
   } 

   return $prefixxxx;
}





function percent_of_tax($tax){ 
    $company_id=company(session()->get('id')); 
    $rest=tax_array($company_id);
    $aaa=array_search($tax, array_column($rest, 'name')); 
    return $rest[$aaa]['percent'];  
}

function invoice_percent_of_tax($tax,$company_id){  
    $rest=tax_array($company_id);
    $aaa=array_search($tax, array_column($rest, 'name')); 
    return $rest[$aaa]['percent'];  
}



function name_of_tax($tax){
    $TaxtypeModel= new TaxtypeModel;
    $tax=$TaxtypeModel->where('id',$tax);
    $rest=$tax->first();

    if ($rest) {
        return $rest['name'];
    }else{
        return 0;
    }
    
}

function id_of_tax($tax){
    $TaxtypeModel= new TaxtypeModel;
    $tax=$TaxtypeModel->where('name',$tax);
    $rest=$tax->first();

    if ($rest) {
        return $rest['id'];
    }else{
        return 0;
    }
    
}

function id_of_tax_having($tax){
    $TaxtypeModel= new TaxtypeModel;
    $tax=$TaxtypeModel->like('name',$tax);
    $rest=$tax->first();

    if ($rest) {
        return $rest['id'];
    }else{
        return 0;
    }
    
}

function tax_name($tax){
        // $TaxtypeModel= new TaxtypeModel;
        // $tax=$TaxtypeModel->where('id', $tax);
        // $rda=$tax->first();
        // if ($rda) {
        //     return $rda['name'];
        // }else{
        //     return '';
        // }

    return $tax;
    
}

function check_permission($user,$permission){
   $myid=session()->get('id');
   $PermissionModel = new PermissionModel;
   $perm=$PermissionModel->where('company_id',company($myid))->where('user',$user)->where($permission,1);
   if(count($perm->findAll())==1) {
    return true;
}else{
    return false;
}
}

function user_profile_pic($id){
    $UserModel = new Main_item_party_table;
    $user_pro_name=$UserModel->where('id', $id)->first();
    if (trim($user_pro_name['profile_pic'])!='') {
        return base_url('public').'/images/avatars/'.$user_pro_name['profile_pic']; 
    }else{
        return base_url('public').'/images/avatars/avatar-icon.png'; 
    }
}





function currency_list(){ ?>
    <option value="AFN">Afghani</option>
    <option value="EUR">Euro</option>
    <option value="ALL">Lek</option>
    <option value="DZD">Algerian Dinar</option>
    <option value="USD">US Dollar</option>
    <option value="EUR">Euro</option>
    <option value="AOA">Kwanza</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="">No universal currency</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="ARS">Argentine Peso</option>
    <option value="AMD">Armenian Dram</option>
    <option value="AWG">Aruban Florin</option>
    <option value="AUD">Australian Dollar</option>
    <option value="EUR">Euro</option>
    <option value="AZN">Azerbaijanian Manat</option>
    <option value="BSD">Bahamian Dollar</option>
    <option value="BHD">Bahraini Dinar</option>
    <option value="BDT">Taka</option>
    <option value="BBD">Barbados Dollar</option>
    <option value="BYR">Belarussian Ruble</option>
    <option value="EUR">Euro</option>
    <option value="BZD">Belize Dollar</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="BMD">Bermudian Dollar</option>
    <option value="BTN">Ngultrum</option>
    <option value="INR">Indian Rupee</option>
    <option value="BOB">Boliviano</option>
    <option value="BOV">Mvdol</option>
    <option value="USD">US Dollar</option>
    <option value="BAM">Convertible Mark</option>
    <option value="BWP">Pula</option>
    <option value="NOK">Norwegian Krone</option>
    <option value="BRL">Brazilian Real</option>
    <option value="USD">US Dollar</option>
    <option value="BND">Brunei Dollar</option>
    <option value="BGN">Bulgarian Lev</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="BIF">Burundi Franc</option>
    <option value="KHR">Riel</option>
    <option value="XAF">CFA Franc BEAC</option>
    <option value="CAD">Canadian Dollar</option>
    <option value="CVE">Cabo Verde Escudo</option>
    <option value="KYD">Cayman Islands Dollar</option>
    <option value="XAF">CFA Franc BEAC</option>
    <option value="XAF">CFA Franc BEAC</option>
    <option value="CLF">Unidad de Fomento</option>
    <option value="CLP">Chilean Peso</option>
    <option value="CNY">Yuan Renminbi</option>
    <option value="AUD">Australian Dollar</option>
    <option value="AUD">Australian Dollar</option>
    <option value="COP">Colombian Peso</option>
    <option value="COU">Unidad de Valor Real</option>
    <option value="KMF">Comoro Franc</option>
    <option value="XAF">CFA Franc BEAC</option>
    <option value="CDF">Congolese Franc</option>
    <option value="NZD">New Zealand Dollar</option>
    <option value="CRC">Costa Rican Colon</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="HRK">Croatian Kuna</option>
    <option value="CUC">Peso Convertible</option>
    <option value="CUP">Cuban Peso</option>
    <option value="ANG">Netherlands Antillean Guilder</option>
    <option value="EUR">Euro</option>
    <option value="CZK">Czech Koruna</option>
    <option value="DKK">Danish Krone</option>
    <option value="DJF">Djibouti Franc</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="DOP">Dominican Peso</option>
    <option value="USD">US Dollar</option>
    <option value="EGP">Egyptian Pound</option>
    <option value="SVC">El Salvador Colon</option>
    <option value="USD">US Dollar</option>
    <option value="XAF">CFA Franc BEAC</option>
    <option value="ERN">Nakfa</option>
    <option value="EUR">Euro</option>
    <option value="ETB">Ethiopian Birr</option>
    <option value="EUR">Euro</option>
    <option value="FKP">Falkland Islands Pound</option>
    <option value="DKK">Danish Krone</option>
    <option value="FJD">Fiji Dollar</option>
    <option value="EUR">Euro</option>
    <option value="EUR">Euro</option>
    <option value="EUR">Euro</option>
    <option value="XPF">CFP Franc</option>
    <option value="EUR">Euro</option>
    <option value="XAF">CFA Franc BEAC</option>
    <option value="GMD">Dalasi</option>
    <option value="GEL">Lari</option>
    <option value="EUR">Euro</option>
    <option value="GHS">Ghana Cedi</option>
    <option value="GIP">Gibraltar Pound</option>
    <option value="EUR">Euro</option>
    <option value="DKK">Danish Krone</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="EUR">Euro</option>
    <option value="USD">US Dollar</option>
    <option value="GTQ">Quetzal</option>
    <option value="GBP">Pound Sterling</option>
    <option value="GNF">Guinea Franc</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="GYD">Guyana Dollar</option>
    <option value="HTG">Gourde</option>
    <option value="USD">US Dollar</option>
    <option value="AUD">Australian Dollar</option>
    <option value="EUR">Euro</option>
    <option value="HNL">Lempira</option>
    <option value="HKD">Hong Kong Dollar</option>
    <option value="HUF">Forint</option>
    <option value="ISK">Iceland Krona</option>
    <option value="INR">Indian Rupee</option>
    <option value="IDR">Rupiah</option>
    <option value="XDR">SDR (Special Drawing Right)</option>
    <option value="IRR">Iranian Rial</option>
    <option value="IQD">Iraqi Dinar</option>
    <option value="EUR">Euro</option>
    <option value="GBP">Pound Sterling</option>
    <option value="ILS">New Israeli Sheqel</option>
    <option value="EUR">Euro</option>
    <option value="JMD">Jamaican Dollar</option>
    <option value="JPY">Yen</option>
    <option value="GBP">Pound Sterling</option>
    <option value="JOD">Jordanian Dinar</option>
    <option value="KZT">Tenge</option>
    <option value="KES">Kenyan Shilling</option>
    <option value="AUD">Australian Dollar</option>
    <option value="KPW">North Korean Won</option>
    <option value="KRW">Won</option>
    <option value="KWD">Kuwaiti Dinar</option>
    <option value="KGS">Som</option>
    <option value="LAK">Kip</option>
    <option value="EUR">Euro</option>
    <option value="LBP">Lebanese Pound</option>
    <option value="LSL">Loti</option>
    <option value="ZAR">Rand</option>
    <option value="LRD">Liberian Dollar</option>
    <option value="LYD">Libyan Dinar</option>
    <option value="CHF">Swiss Franc</option>
    <option value="EUR">Euro</option>
    <option value="EUR">Euro</option>
    <option value="MOP">Pataca</option>
    <option value="MKD">Denar</option>
    <option value="MGA">Malagasy Ariary</option>
    <option value="MWK">Kwacha</option>
    <option value="MYR">Malaysian Ringgit</option>
    <option value="MVR">Rufiyaa</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="EUR">Euro</option>
    <option value="USD">US Dollar</option>
    <option value="EUR">Euro</option>
    <option value="MRO">Ouguiya</option>
    <option value="MUR">Mauritius Rupee</option>
    <option value="EUR">Euro</option>
    <option value="XUA">ADB Unit of Account</option>
    <option value="MXN">Mexican Peso</option>
    <option value="MXV">Mexican Unidad de Inversion (UDI)</option>
    <option value="USD">US Dollar</option>
    <option value="MDL">Moldovan Leu</option>
    <option value="EUR">Euro</option>
    <option value="MNT">Tugrik</option>
    <option value="EUR">Euro</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="MAD">Moroccan Dirham</option>
    <option value="MZN">Mozambique Metical</option>
    <option value="MMK">Kyat</option>
    <option value="NAD">Namibia Dollar</option>
    <option value="ZAR">Rand</option>
    <option value="AUD">Australian Dollar</option>
    <option value="NPR">Nepalese Rupee</option>
    <option value="EUR">Euro</option>
    <option value="XPF">CFP Franc</option>
    <option value="NZD">New Zealand Dollar</option>
    <option value="NIO">Cordoba Oro</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="NGN">Naira</option>
    <option value="NZD">New Zealand Dollar</option>
    <option value="AUD">Australian Dollar</option>
    <option value="USD">US Dollar</option>
    <option value="NOK">Norwegian Krone</option>
    <option value="OMR">Rial Omani</option>
    <option value="PKR">Pakistan Rupee</option>
    <option value="USD">US Dollar</option>
    <option value="">No universal currency</option>
    <option value="PAB">Balboa</option>
    <option value="USD">US Dollar</option>
    <option value="PGK">Kina</option>
    <option value="PYG">Guarani</option>
    <option value="PEN">Nuevo Sol</option>
    <option value="PHP">Philippine Peso</option>
    <option value="NZD">New Zealand Dollar</option>
    <option value="PLN">Zloty</option>
    <option value="EUR">Euro</option>
    <option value="USD">US Dollar</option>
    <option value="QAR">Qatari Rial</option>
    <option value="EUR">Euro</option>
    <option value="RON">New Romanian Leu</option>
    <option value="RUB">Russian Ruble</option>
    <option value="RWF">Rwanda Franc</option>
    <option value="EUR">Euro</option>
    <option value="SHP">Saint Helena Pound</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="EUR">Euro</option>
    <option value="EUR">Euro</option>
    <option value="XCD">East Caribbean Dollar</option>
    <option value="WST">Tala</option>
    <option value="EUR">Euro</option>
    <option value="STD">Dobra</option>
    <option value="SAR">Saudi Riyal</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="RSD">Serbian Dinar</option>
    <option value="SCR">Seychelles Rupee</option>
    <option value="SLL">Leone</option>
    <option value="SGD">Singapore Dollar</option>
    <option value="ANG">Netherlands Antillean Guilder</option>
    <option value="XSU">Sucre</option>
    <option value="EUR">Euro</option>
    <option value="EUR">Euro</option>
    <option value="SBD">Solomon Islands Dollar</option>
    <option value="SOS">Somali Shilling</option>
    <option value="ZAR">Rand</option>
    <option value="">No universal currency</option>
    <option value="SSP">South Sudanese Pound</option>
    <option value="EUR">Euro</option>
    <option value="LKR">Sri Lanka Rupee</option>
    <option value="SDG">Sudanese Pound</option>
    <option value="SRD">Surinam Dollar</option>
    <option value="NOK">Norwegian Krone</option>
    <option value="SZL">Lilangeni</option>
    <option value="SEK">Swedish Krona</option>
    <option value="CHE">WIR Euro</option>
    <option value="CHF">Swiss Franc</option>
    <option value="CHW">WIR Franc</option>
    <option value="SYP">Syrian Pound</option>
    <option value="TWD">New Taiwan Dollar</option>
    <option value="TJS">Somoni</option>
    <option value="TZS">Tanzanian Shilling</option>
    <option value="THB">Baht</option>
    <option value="USD">US Dollar</option>
    <option value="XOF">CFA Franc BCEAO</option>
    <option value="NZD">New Zealand Dollar</option>
    <option value="TOP">Pa’anga</option>
    <option value="TTD">Trinidad and Tobago Dollar</option>
    <option value="TND">Tunisian Dinar</option>
    <option value="TRY">Turkish Lira</option>
    <option value="TMT">Turkmenistan New Manat</option>
    <option value="USD">US Dollar</option>
    <option value="AUD">Australian Dollar</option>
    <option value="UGX">Uganda Shilling</option>
    <option value="UAH">Hryvnia</option>
    <option value="AED">UAE Dirham</option>
    <option value="GBP">Pound Sterling</option>
    <option value="USD">US Dollar</option>
    <option value="USN">US Dollar (Next day)</option>
    <option value="USD">US Dollar</option>
    <option value="UYI">Uruguay Peso en Unidades Indexadas (URUIURUI)</option>
    <option value="UYU">Peso Uruguayo</option>
    <option value="UZS">Uzbekistan Sum</option>
    <option value="VUV">Vatu</option>
    <option value="VEF">Bolivar</option>
    <option value="VND">Dong</option>
    <option value="USD">US Dollar</option>
    <option value="USD">US Dollar</option>
    <option value="XPF">CFP Franc</option>
    <option value="MAD">Moroccan Dirham</option>
    <option value="YER">Yemeni Rial</option>
    <option value="ZMW">Zambian Kwacha</option>
    <option value="ZWL">Zimbabwe Dollar</option>
    <option value="XBA">Bond Markets Unit European Composite Unit (EURCO)</option>
    <option value="XBB">Bond Markets Unit European Monetary Unit (E.M.U.-6)</option>
    <option value="XBC">Bond Markets Unit European Unit of Account 9 (E.U.A.-9)</option>
    <option value="XBD">Bond Markets Unit European Unit of Account 17 (E.U.A.-17)</option>
    <option value="XTS">Codes specifically reserved for testing purposes</option>
    <option value="XXX">The codes assigned for transactions where no currency is involved</option>
    <option value="XAU">Gold</option>
    <option value="XPD">Palladium</option>
    <option value="XPT">Platinum</option>
    <option value="XAG">Silver</option>

    <?php 
}

function timezones_list(){ ?>
    <option value="Africa/Abidjan">Africa/Abidjan</option>
    <option value="Africa/Accra">Africa/Accra</option>
    <option value="Africa/Addis_Ababa">Africa/Addis_Ababa</option>
    <option value="Africa/Algiers">Africa/Algiers</option>
    <option value="Africa/Asmara">Africa/Asmara</option>
    <option value="Africa/Bamako">Africa/Bamako</option>
    <option value="Africa/Bangui">Africa/Bangui</option>
    <option value="Africa/Banjul">Africa/Banjul</option>
    <option value="Africa/Bissau">Africa/Bissau</option>
    <option value="Africa/Blantyre">Africa/Blantyre</option>
    <option value="Africa/Brazzaville">Africa/Brazzaville</option>
    <option value="Africa/Bujumbura">Africa/Bujumbura</option>
    <option value="Africa/Cairo">Africa/Cairo</option>
    <option value="Africa/Casablanca">Africa/Casablanca</option>
    <option value="Africa/Ceuta">Africa/Ceuta</option>
    <option value="Africa/Conakry">Africa/Conakry</option>
    <option value="Africa/Dakar">Africa/Dakar</option>
    <option value="Africa/Dar_es_Salaam">Africa/Dar_es_Salaam</option>
    <option value="Africa/Djibouti">Africa/Djibouti</option>
    <option value="Africa/Douala">Africa/Douala</option>
    <option value="Africa/El_Aaiun">Africa/El_Aaiun</option>
    <option value="Africa/Freetown">Africa/Freetown</option>
    <option value="Africa/Gaborone">Africa/Gaborone</option>
    <option value="Africa/Harare">Africa/Harare</option>
    <option value="Africa/Johannesburg">Africa/Johannesburg</option>
    <option value="Africa/Juba">Africa/Juba</option>
    <option value="Africa/Kampala">Africa/Kampala</option>
    <option value="Africa/Khartoum">Africa/Khartoum</option>
    <option value="Africa/Kigali">Africa/Kigali</option>
    <option value="Africa/Kinshasa">Africa/Kinshasa</option>
    <option value="Africa/Lagos">Africa/Lagos</option>
    <option value="Africa/Libreville">Africa/Libreville</option>
    <option value="Africa/Lome">Africa/Lome</option>
    <option value="Africa/Luanda">Africa/Luanda</option>
    <option value="Africa/Lubumbashi">Africa/Lubumbashi</option>
    <option value="Africa/Lusaka">Africa/Lusaka</option>
    <option value="Africa/Malabo">Africa/Malabo</option>
    <option value="Africa/Maputo">Africa/Maputo</option>
    <option value="Africa/Maseru">Africa/Maseru</option>
    <option value="Africa/Mbabane">Africa/Mbabane</option>
    <option value="Africa/Mogadishu">Africa/Mogadishu</option>
    <option value="Africa/Monrovia">Africa/Monrovia</option>
    <option value="Africa/Nairobi">Africa/Nairobi</option>
    <option value="Africa/Ndjamena">Africa/Ndjamena</option>
    <option value="Africa/Niamey">Africa/Niamey</option>
    <option value="Africa/Nouakchott">Africa/Nouakchott</option>
    <option value="Africa/Ouagadougou">Africa/Ouagadougou</option>
    <option value="Africa/Porto-Novo">Africa/Porto-Novo</option>
    <option value="Africa/Sao_Tome">Africa/Sao_Tome</option>
    <option value="Africa/Timbuktu">Africa/Timbuktu</option>
    <option value="Africa/Tripoli">Africa/Tripoli</option>
    <option value="Africa/Tunis">Africa/Tunis</option>
    <option value="Africa/Windhoek">Africa/Windhoek</option>
    <option value="America/Adak">America/Adak</option>
    <option value="America/Anchorage">America/Anchorage</option>
    <option value="America/Anguilla">America/Anguilla</option>
    <option value="America/Antigua">America/Antigua</option>
    <option value="America/Araguaina">America/Araguaina</option>
    <option value="America/Argentina/Buenos_Aires">America/Argentina/Buenos_Aires</option>
    <option value="America/Argentina/Catamarca">America/Argentina/Catamarca</option>
    <option value="America/Argentina/ComodRivadavia">America/Argentina/ComodRivadavia</option>
    <option value="America/Argentina/Cordoba">America/Argentina/Cordoba</option>
    <option value="America/Argentina/Jujuy">America/Argentina/Jujuy</option>
    <option value="America/Argentina/La_Rioja">America/Argentina/La_Rioja</option>
    <option value="America/Argentina/Mendoza">America/Argentina/Mendoza</option>
    <option value="America/Argentina/Rio_Gallegos">America/Argentina/Rio_Gallegos</option>
    <option value="America/Argentina/Salta">America/Argentina/Salta</option>
    <option value="America/Argentina/San_Juan">America/Argentina/San_Juan</option>
    <option value="America/Argentina/San_Luis">America/Argentina/San_Luis</option>
    <option value="America/Argentina/Tucuman">America/Argentina/Tucuman</option>
    <option value="America/Argentina/Ushuaia">America/Argentina/Ushuaia</option>
    <option value="America/Aruba">America/Aruba</option>
    <option value="America/Asuncion">America/Asuncion</option>
    <option value="America/Atikokan">America/Atikokan</option>
    <option value="America/Atka">America/Atka</option>
    <option value="America/Bahia">America/Bahia</option>
    <option value="America/Bahia_Banderas">America/Bahia_Banderas</option>
    <option value="America/Barbados">America/Barbados</option>
    <option value="America/Belem">America/Belem</option>
    <option value="America/Belize">America/Belize</option>
    <option value="America/Blanc-Sablon">America/Blanc-Sablon</option>
    <option value="America/Boa_Vista">America/Boa_Vista</option>
    <option value="America/Bogota">America/Bogota</option>
    <option value="America/Boise">America/Boise</option>
    <option value="America/Buenos_Aires">America/Buenos_Aires</option>
    <option value="America/Cambridge_Bay">America/Cambridge_Bay</option>
    <option value="America/Campo_Grande">America/Campo_Grande</option>
    <option value="America/Cancun">America/Cancun</option>
    <option value="America/Caracas">America/Caracas</option>
    <option value="America/Catamarca">America/Catamarca</option>
    <option value="America/Cayenne">America/Cayenne</option>
    <option value="America/Cayman">America/Cayman</option>
    <option value="America/Chicago">America/Chicago</option>
    <option value="America/Chihuahua">America/Chihuahua</option>
    <option value="America/Coral_Harbour">America/Coral_Harbour</option>
    <option value="America/Cordoba">America/Cordoba</option>
    <option value="America/Costa_Rica">America/Costa_Rica</option>
    <option value="America/Creston">America/Creston</option>
    <option value="America/Cuiaba">America/Cuiaba</option>
    <option value="America/Curacao">America/Curacao</option>
    <option value="America/Danmarkshavn">America/Danmarkshavn</option>
    <option value="America/Dawson">America/Dawson</option>
    <option value="America/Dawson_Creek">America/Dawson_Creek</option>
    <option value="America/Denver">America/Denver</option>
    <option value="America/Detroit">America/Detroit</option>
    <option value="America/Dominica">America/Dominica</option>
    <option value="America/Edmonton">America/Edmonton</option>
    <option value="America/Eirunepe">America/Eirunepe</option>
    <option value="America/El_Salvador">America/El_Salvador</option>
    <option value="America/Ensenada">America/Ensenada</option>
    <option value="America/Fort_Nelson">America/Fort_Nelson</option>
    <option value="America/Fort_Wayne">America/Fort_Wayne</option>
    <option value="America/Fortaleza">America/Fortaleza</option>
    <option value="America/Glace_Bay">America/Glace_Bay</option>
    <option value="America/Godthab">America/Godthab</option>
    <option value="America/Goose_Bay">America/Goose_Bay</option>
    <option value="America/Grand_Turk">America/Grand_Turk</option>
    <option value="America/Grenada">America/Grenada</option>
    <option value="America/Guadeloupe">America/Guadeloupe</option>
    <option value="America/Guatemala">America/Guatemala</option>
    <option value="America/Guayaquil">America/Guayaquil</option>
    <option value="America/Guyana">America/Guyana</option>
    <option value="America/Halifax">America/Halifax</option>
    <option value="America/Havana">America/Havana</option>
    <option value="America/Hermosillo">America/Hermosillo</option>
    <option value="America/Indiana/Indianapolis">America/Indiana/Indianapolis</option>
    <option value="America/Indiana/Knox">America/Indiana/Knox</option>
    <option value="America/Indiana/Marengo">America/Indiana/Marengo</option>
    <option value="America/Indiana/Petersburg">America/Indiana/Petersburg</option>
    <option value="America/Indiana/Tell_City">America/Indiana/Tell_City</option>
    <option value="America/Indiana/Vevay">America/Indiana/Vevay</option>
    <option value="America/Indiana/Vincennes">America/Indiana/Vincennes</option>
    <option value="America/Indiana/Winamac">America/Indiana/Winamac</option>
    <option value="America/Indianapolis">America/Indianapolis</option>
    <option value="America/Inuvik">America/Inuvik</option>
    <option value="America/Iqaluit">America/Iqaluit</option>
    <option value="America/Jamaica">America/Jamaica</option>
    <option value="America/Jujuy">America/Jujuy</option>
    <option value="America/Juneau">America/Juneau</option>
    <option value="America/Kentucky/Louisville">America/Kentucky/Louisville</option>
    <option value="America/Kentucky/Monticello">America/Kentucky/Monticello</option>
    <option value="America/Knox_IN">America/Knox_IN</option>
    <option value="America/Kralendijk">America/Kralendijk</option>
    <option value="America/La_Paz">America/La_Paz</option>
    <option value="America/Lima">America/Lima</option>
    <option value="America/Los_Angeles">America/Los_Angeles</option>
    <option value="America/Louisville">America/Louisville</option>
    <option value="America/Lower_Princes">America/Lower_Princes</option>
    <option value="America/Maceio">America/Maceio</option>
    <option value="America/Managua">America/Managua</option>
    <option value="America/Manaus">America/Manaus</option>
    <option value="America/Marigot">America/Marigot</option>
    <option value="America/Martinique">America/Martinique</option>
    <option value="America/Matamoros">America/Matamoros</option>
    <option value="America/Mazatlan">America/Mazatlan</option>
    <option value="America/Mendoza">America/Mendoza</option>
    <option value="America/Menominee">America/Menominee</option>
    <option value="America/Merida">America/Merida</option>
    <option value="America/Metlakatla">America/Metlakatla</option>
    <option value="America/Mexico_City">America/Mexico_City</option>
    <option value="America/Miquelon">America/Miquelon</option>
    <option value="America/Moncton">America/Moncton</option>
    <option value="America/Monterrey">America/Monterrey</option>
    <option value="America/Montevideo">America/Montevideo</option>
    <option value="America/Montreal">America/Montreal</option>
    <option value="America/Montserrat">America/Montserrat</option>
    <option value="America/Nassau">America/Nassau</option>
    <option value="America/New_York">America/New_York</option>
    <option value="America/Nipigon">America/Nipigon</option>
    <option value="America/Nome">America/Nome</option>
    <option value="America/Noronha">America/Noronha</option>
    <option value="America/North_Dakota/Beulah">America/North_Dakota/Beulah</option>
    <option value="America/North_Dakota/Center">America/North_Dakota/Center</option>
    <option value="America/North_Dakota/New_Salem">America/North_Dakota/New_Salem</option>
    <option value="America/Ojinaga">America/Ojinaga</option>
    <option value="America/Panama">America/Panama</option>
    <option value="America/Pangnirtung">America/Pangnirtung</option>
    <option value="America/Paramaribo">America/Paramaribo</option>
    <option value="America/Phoenix">America/Phoenix</option>
    <option value="America/Port_of_Spain">America/Port_of_Spain</option>
    <option value="America/Port-au-Prince">America/Port-au-Prince</option>
    <option value="America/Porto_Acre">America/Porto_Acre</option>
    <option value="America/Porto_Velho">America/Porto_Velho</option>
    <option value="America/Puerto_Rico">America/Puerto_Rico</option>
    <option value="America/Punta_Arenas">America/Punta_Arenas</option>
    <option value="America/Rainy_River">America/Rainy_River</option>
    <option value="America/Rankin_Inlet">America/Rankin_Inlet</option>
    <option value="America/Recife">America/Recife</option>
    <option value="America/Regina">America/Regina</option>
    <option value="America/Resolute">America/Resolute</option>
    <option value="America/Rio_Branco">America/Rio_Branco</option>
    <option value="America/Rosario">America/Rosario</option>
    <option value="America/Santa_Isabel">America/Santa_Isabel</option>
    <option value="America/Santarem">America/Santarem</option>
    <option value="America/Santiago">America/Santiago</option>
    <option value="America/Santo_Domingo">America/Santo_Domingo</option>
    <option value="America/Sao_Paulo">America/Sao_Paulo</option>
    <option value="America/Scoresbysund">America/Scoresbysund</option>
    <option value="America/Shiprock">America/Shiprock</option>
    <option value="America/Sitka">America/Sitka</option>
    <option value="America/St_Barthelemy">America/St_Barthelemy</option>
    <option value="America/St_Johns">America/St_Johns</option>
    <option value="America/St_Kitts">America/St_Kitts</option>
    <option value="America/St_Lucia">America/St_Lucia</option>
    <option value="America/St_Thomas">America/St_Thomas</option>
    <option value="America/St_Vincent">America/St_Vincent</option>
    <option value="America/Swift_Current">America/Swift_Current</option>
    <option value="America/Tegucigalpa">America/Tegucigalpa</option>
    <option value="America/Thule">America/Thule</option>
    <option value="America/Thunder_Bay">America/Thunder_Bay</option>
    <option value="America/Tijuana">America/Tijuana</option>
    <option value="America/Toronto">America/Toronto</option>
    <option value="America/Tortola">America/Tortola</option>
    <option value="America/Vancouver">America/Vancouver</option>
    <option value="America/Virgin">America/Virgin</option>
    <option value="America/Whitehorse">America/Whitehorse</option>
    <option value="America/Winnipeg">America/Winnipeg</option>
    <option value="America/Yakutat">America/Yakutat</option>
    <option value="America/Yellowknife">America/Yellowknife</option>
    <option value="Antarctica/Casey">Antarctica/Casey</option>
    <option value="Antarctica/Davis">Antarctica/Davis</option>
    <option value="Antarctica/DumontDUrville">Antarctica/DumontDUrville</option>
    <option value="Antarctica/Macquarie">Antarctica/Macquarie</option>
    <option value="Antarctica/Mawson">Antarctica/Mawson</option>
    <option value="Antarctica/McMurdo">Antarctica/McMurdo</option>
    <option value="Antarctica/Palmer">Antarctica/Palmer</option>
    <option value="Antarctica/Rothera">Antarctica/Rothera</option>
    <option value="Antarctica/South_Pole">Antarctica/South_Pole</option>
    <option value="Antarctica/Syowa">Antarctica/Syowa</option>
    <option value="Antarctica/Troll">Antarctica/Troll</option>
    <option value="Antarctica/Vostok">Antarctica/Vostok</option>
    <option value="Arctic/Longyearbyen">Arctic/Longyearbyen</option>
    <option value="Asia/Aden">Asia/Aden</option>
    <option value="Asia/Almaty">Asia/Almaty</option>
    <option value="Asia/Amman">Asia/Amman</option>
    <option value="Asia/Anadyr">Asia/Anadyr</option>
    <option value="Asia/Aqtau">Asia/Aqtau</option>
    <option value="Asia/Aqtobe">Asia/Aqtobe</option>
    <option value="Asia/Ashgabat">Asia/Ashgabat</option>
    <option value="Asia/Ashkhabad">Asia/Ashkhabad</option>
    <option value="Asia/Atyrau">Asia/Atyrau</option>
    <option value="Asia/Baghdad">Asia/Baghdad</option>
    <option value="Asia/Bahrain">Asia/Bahrain</option>
    <option value="Asia/Baku">Asia/Baku</option>
    <option value="Asia/Bangkok">Asia/Bangkok</option>
    <option value="Asia/Barnaul">Asia/Barnaul</option>
    <option value="Asia/Beirut">Asia/Beirut</option>
    <option value="Asia/Bishkek">Asia/Bishkek</option>
    <option value="Asia/Brunei">Asia/Brunei</option>
    <option value="Asia/Calcutta">Asia/Calcutta</option>
    <option value="Asia/Chita">Asia/Chita</option>
    <option value="Asia/Choibalsan">Asia/Choibalsan</option>
    <option value="Asia/Chongqing">Asia/Chongqing</option>
    <option value="Asia/Chungking">Asia/Chungking</option>
    <option value="Asia/Colombo">Asia/Colombo</option>
    <option value="Asia/Dacca">Asia/Dacca</option>
    <option value="Asia/Damascus">Asia/Damascus</option>
    <option value="Asia/Dhaka">Asia/Dhaka</option>
    <option value="Asia/Dili">Asia/Dili</option>
    <option value="Asia/Dubai">Asia/Dubai</option>
    <option value="Asia/Dushanbe">Asia/Dushanbe</option>
    <option value="Asia/Famagusta">Asia/Famagusta</option>
    <option value="Asia/Gaza">Asia/Gaza</option>
    <option value="Asia/Harbin">Asia/Harbin</option>
    <option value="Asia/Hebron">Asia/Hebron</option>
    <option value="Asia/Ho_Chi_Minh">Asia/Ho_Chi_Minh</option>
    <option value="Asia/Hong_Kong">Asia/Hong_Kong</option>
    <option value="Asia/Hovd">Asia/Hovd</option>
    <option value="Asia/Irkutsk">Asia/Irkutsk</option>
    <option value="Asia/Istanbul">Asia/Istanbul</option>
    <option value="Asia/Jakarta">Asia/Jakarta</option>
    <option value="Asia/Jayapura">Asia/Jayapura</option>
    <option value="Asia/Jerusalem">Asia/Jerusalem</option>
    <option value="Asia/Kabul">Asia/Kabul</option>
    <option value="Asia/Kamchatka">Asia/Kamchatka</option>
    <option value="Asia/Karachi">Asia/Karachi</option>
    <option value="Asia/Kashgar">Asia/Kashgar</option>
    <option value="Asia/Kathmandu">Asia/Kathmandu</option>
    <option value="Asia/Katmandu">Asia/Katmandu</option>
    <option value="Asia/Khandyga">Asia/Khandyga</option>
    <option value="Asia/Kolkata">Asia/Kolkata</option>
    <option value="Asia/Krasnoyarsk">Asia/Krasnoyarsk</option>
    <option value="Asia/Kuala_Lumpur">Asia/Kuala_Lumpur</option>
    <option value="Asia/Kuching">Asia/Kuching</option>
    <option value="Asia/Kuwait">Asia/Kuwait</option>
    <option value="Asia/Macao">Asia/Macao</option>
    <option value="Asia/Macau">Asia/Macau</option>
    <option value="Asia/Magadan">Asia/Magadan</option>
    <option value="Asia/Makassar">Asia/Makassar</option>
    <option value="Asia/Manila">Asia/Manila</option>
    <option value="Asia/Muscat">Asia/Muscat</option>
    <option value="Asia/Novokuznetsk">Asia/Novokuznetsk</option>
    <option value="Asia/Novosibirsk">Asia/Novosibirsk</option>
    <option value="Asia/Omsk">Asia/Omsk</option>
    <option value="Asia/Oral">Asia/Oral</option>
    <option value="Asia/Phnom_Penh">Asia/Phnom_Penh</option>
    <option value="Asia/Pontianak">Asia/Pontianak</option>
    <option value="Asia/Pyongyang">Asia/Pyongyang</option>
    <option value="Asia/Qatar">Asia/Qatar</option>
    <option value="Asia/Qyzylorda">Asia/Qyzylorda</option>
    <option value="Asia/Rangoon">Asia/Rangoon</option>
    <option value="Asia/Riyadh">Asia/Riyadh</option>
    <option value="Asia/Saigon">Asia/Saigon</option>
    <option value="Asia/Sakhalin">Asia/Sakhalin</option>
    <option value="Asia/Samarkand">Asia/Samarkand</option>
    <option value="Asia/Seoul">Asia/Seoul</option>
    <option value="Asia/Shanghai">Asia/Shanghai</option>
    <option value="Asia/Singapore">Asia/Singapore</option>
    <option value="Asia/Srednekolymsk">Asia/Srednekolymsk</option>
    <option value="Asia/Taipei">Asia/Taipei</option>
    <option value="Asia/Tashkent">Asia/Tashkent</option>
    <option value="Asia/Tbilisi">Asia/Tbilisi</option>
    <option value="Asia/Tehran">Asia/Tehran</option>
    <option value="Asia/Tel_Aviv">Asia/Tel_Aviv</option>
    <option value="Asia/Thimbu">Asia/Thimbu</option>
    <option value="Asia/Thimphu">Asia/Thimphu</option>
    <option value="Asia/Tokyo">Asia/Tokyo</option>
    <option value="Asia/Tomsk">Asia/Tomsk</option>
    <option value="Asia/Ujung_Pandang">Asia/Ujung_Pandang</option>
    <option value="Asia/Ulaanbaatar">Asia/Ulaanbaatar</option>
    <option value="Asia/Ulan_Bator">Asia/Ulan_Bator</option>
    <option value="Asia/Urumqi">Asia/Urumqi</option>
    <option value="Asia/Ust-Nera">Asia/Ust-Nera</option>
    <option value="Asia/Vientiane">Asia/Vientiane</option>
    <option value="Asia/Vladivostok">Asia/Vladivostok</option>
    <option value="Asia/Yakutsk">Asia/Yakutsk</option>
    <option value="Asia/Yangon">Asia/Yangon</option>
    <option value="Asia/Yekaterinburg">Asia/Yekaterinburg</option>
    <option value="Asia/Yerevan">Asia/Yerevan</option>
    <option value="Atlantic/Azores">Atlantic/Azores</option>
    <option value="Atlantic/Bermuda">Atlantic/Bermuda</option>
    <option value="Atlantic/Canary">Atlantic/Canary</option>
    <option value="Atlantic/Cape_Verde">Atlantic/Cape_Verde</option>
    <option value="Atlantic/Faeroe">Atlantic/Faeroe</option>
    <option value="Atlantic/Faroe">Atlantic/Faroe</option>
    <option value="Atlantic/Jan_Mayen">Atlantic/Jan_Mayen</option>
    <option value="Atlantic/Madeira">Atlantic/Madeira</option>
    <option value="Atlantic/Reykjavik">Atlantic/Reykjavik</option>
    <option value="Atlantic/South_Georgia">Atlantic/South_Georgia</option>
    <option value="Atlantic/St_Helena">Atlantic/St_Helena</option>
    <option value="Atlantic/Stanley">Atlantic/Stanley</option>
    <option value="Australia/ACT">Australia/ACT</option>
    <option value="Australia/Adelaide">Australia/Adelaide</option>
    <option value="Australia/Brisbane">Australia/Brisbane</option>
    <option value="Australia/Broken_Hill">Australia/Broken_Hill</option>
    <option value="Australia/Canberra">Australia/Canberra</option>
    <option value="Australia/Currie">Australia/Currie</option>
    <option value="Australia/Darwin">Australia/Darwin</option>
    <option value="Australia/Eucla">Australia/Eucla</option>
    <option value="Australia/Hobart">Australia/Hobart</option>
    <option value="Australia/LHI">Australia/LHI</option>
    <option value="Australia/Lindeman">Australia/Lindeman</option>
    <option value="Australia/Lord_Howe">Australia/Lord_Howe</option>
    <option value="Australia/Melbourne">Australia/Melbourne</option>
    <option value="Australia/North">Australia/North</option>
    <option value="Australia/NSW">Australia/NSW</option>
    <option value="Australia/Perth">Australia/Perth</option>
    <option value="Australia/Queensland">Australia/Queensland</option>
    <option value="Australia/South">Australia/South</option>
    <option value="Australia/Sydney">Australia/Sydney</option>
    <option value="Australia/Tasmania">Australia/Tasmania</option>
    <option value="Australia/Victoria">Australia/Victoria</option>
    <option value="Australia/West">Australia/West</option>
    <option value="Australia/Yancowinna">Australia/Yancowinna</option>
    <option value="Brazil/Acre">Brazil/Acre</option>
    <option value="Brazil/DeNoronha">Brazil/DeNoronha</option>
    <option value="Brazil/East">Brazil/East</option>
    <option value="Brazil/West">Brazil/West</option>
    <option value="Canada/Atlantic">Canada/Atlantic</option>
    <option value="Canada/Central">Canada/Central</option>
    <option value="Canada/Eastern">Canada/Eastern</option>
    <option value="Canada/Mountain">Canada/Mountain</option>
    <option value="Canada/Newfoundland">Canada/Newfoundland</option>
    <option value="Canada/Pacific">Canada/Pacific</option>
    <option value="Canada/Saskatchewan">Canada/Saskatchewan</option>
    <option value="Canada/Yukon">Canada/Yukon</option>
    <option value="CET">CET</option>
    <option value="Chile/Continental">Chile/Continental</option>
    <option value="Chile/EasterIsland">Chile/EasterIsland</option>
    <option value="CST6CDT">CST6CDT</option>
    <option value="Cuba">Cuba</option>
    <option value="EET">EET</option>
    <option value="Egypt">Egypt</option>
    <option value="Eire">Eire</option>
    <option value="EST">EST</option>
    <option value="EST5EDT">EST5EDT</option>
    <option value="Etc/GMT">Etc/GMT</option>
    <option value="Etc/GMT+0">Etc/GMT+0</option>
    <option value="Etc/GMT+1">Etc/GMT+1</option>
    <option value="Etc/GMT+10">Etc/GMT+10</option>
    <option value="Etc/GMT+11">Etc/GMT+11</option>
    <option value="Etc/GMT+12">Etc/GMT+12</option>
    <option value="Etc/GMT+2">Etc/GMT+2</option>
    <option value="Etc/GMT+3">Etc/GMT+3</option>
    <option value="Etc/GMT+4">Etc/GMT+4</option>
    <option value="Etc/GMT+5">Etc/GMT+5</option>
    <option value="Etc/GMT+6">Etc/GMT+6</option>
    <option value="Etc/GMT+7">Etc/GMT+7</option>
    <option value="Etc/GMT+8">Etc/GMT+8</option>
    <option value="Etc/GMT+9">Etc/GMT+9</option>
    <option value="Etc/GMT0">Etc/GMT0</option>
    <option value="Etc/GMT-0">Etc/GMT-0</option>
    <option value="Etc/GMT-1">Etc/GMT-1</option>
    <option value="Etc/GMT-10">Etc/GMT-10</option>
    <option value="Etc/GMT-11">Etc/GMT-11</option>
    <option value="Etc/GMT-12">Etc/GMT-12</option>
    <option value="Etc/GMT-13">Etc/GMT-13</option>
    <option value="Etc/GMT-14">Etc/GMT-14</option>
    <option value="Etc/GMT-2">Etc/GMT-2</option>
    <option value="Etc/GMT-3">Etc/GMT-3</option>
    <option value="Etc/GMT-4">Etc/GMT-4</option>
    <option value="Etc/GMT-5">Etc/GMT-5</option>
    <option value="Etc/GMT-6">Etc/GMT-6</option>
    <option value="Etc/GMT-7">Etc/GMT-7</option>
    <option value="Etc/GMT-8">Etc/GMT-8</option>
    <option value="Etc/GMT-9">Etc/GMT-9</option>
    <option value="Etc/Greenwich">Etc/Greenwich</option>
    <option value="Etc/UCT">Etc/UCT</option>
    <option value="Etc/Universal">Etc/Universal</option>
    <option value="Etc/UTC">Etc/UTC</option>
    <option value="Etc/Zulu">Etc/Zulu</option>
    <option value="Europe/Amsterdam">Europe/Amsterdam</option>
    <option value="Europe/Andorra">Europe/Andorra</option>
    <option value="Europe/Astrakhan">Europe/Astrakhan</option>
    <option value="Europe/Athens">Europe/Athens</option>
    <option value="Europe/Belfast">Europe/Belfast</option>
    <option value="Europe/Belgrade">Europe/Belgrade</option>
    <option value="Europe/Sarajevo">Europe/Sarajevo</option>
    <option value="Europe/Berlin">Europe/Berlin</option>
    <option value="Europe/Bratislava">Europe/Bratislava</option>
    <option value="Europe/Brussels">Europe/Brussels</option>
    <option value="Europe/Bucharest">Europe/Bucharest</option>
    <option value="Europe/Budapest">Europe/Budapest</option>
    <option value="Europe/Busingen">Europe/Busingen</option>
    <option value="Europe/Chisinau">Europe/Chisinau</option>
    <option value="Europe/Copenhagen">Europe/Copenhagen</option>
    <option value="Europe/Dublin">Europe/Dublin</option>
    <option value="Europe/Gibraltar">Europe/Gibraltar</option>
    <option value="Europe/Guernsey">Europe/Guernsey</option>
    <option value="Europe/Helsinki">Europe/Helsinki</option>
    <option value="Europe/Isle_of_Man">Europe/Isle_of_Man</option>
    <option value="Europe/Istanbul">Europe/Istanbul</option>
    <option value="Europe/Jersey">Europe/Jersey</option>
    <option value="Europe/Kaliningrad">Europe/Kaliningrad</option>
    <option value="Europe/Kiev">Europe/Kiev</option>
    <option value="Europe/Kirov">Europe/Kirov</option>
    <option value="Europe/Lisbon">Europe/Lisbon</option>
    <option value="Europe/Ljubljana">Europe/Ljubljana</option>
    <option value="Europe/London">Europe/London</option>
    <option value="Europe/Luxembourg">Europe/Luxembourg</option>
    <option value="Europe/Madrid">Europe/Madrid</option>
    <option value="Europe/Malta">Europe/Malta</option>
    <option value="Europe/Mariehamn">Europe/Mariehamn</option>
    <option value="Europe/Minsk">Europe/Minsk</option>
    <option value="Europe/Monaco">Europe/Monaco</option>
    <option value="Europe/Moscow">Europe/Moscow</option>
    <option value="Asia/Nicosia">Asia/Nicosia</option>
    <option value="Europe/Oslo">Europe/Oslo</option>
    <option value="Europe/Paris">Europe/Paris</option>
    <option value="Europe/Podgorica">Europe/Podgorica</option>
    <option value="Europe/Prague">Europe/Prague</option>
    <option value="Europe/Riga">Europe/Riga</option>
    <option value="Europe/Rome">Europe/Rome</option>
    <option value="Europe/Samara">Europe/Samara</option>
    <option value="Europe/San_Marino">Europe/San_Marino</option>
    <option value="Europe/Sarajevo">Europe/Sarajevo</option>
    <option value="Europe/Saratov">Europe/Saratov</option>
    <option value="Europe/Simferopol">Europe/Simferopol</option>
    <option value="Europe/Skopje">Europe/Skopje</option>
    <option value="Europe/Sofia">Europe/Sofia</option>
    <option value="Europe/Stockholm">Europe/Stockholm</option>
    <option value="Europe/Tallinn">Europe/Tallinn</option>
    <option value="Europe/Tirane">Europe/Tirane</option>
    <option value="Europe/Tiraspol">Europe/Tiraspol</option>
    <option value="Europe/Ulyanovsk">Europe/Ulyanovsk</option>
    <option value="Europe/Uzhgorod">Europe/Uzhgorod</option>
    <option value="Europe/Vaduz">Europe/Vaduz</option>
    <option value="Europe/Vatican">Europe/Vatican</option>
    <option value="Europe/Vienna">Europe/Vienna</option>
    <option value="Europe/Vilnius">Europe/Vilnius</option>
    <option value="Europe/Volgograd">Europe/Volgograd</option>
    <option value="Europe/Warsaw">Europe/Warsaw</option>
    <option value="Europe/Zagreb">Europe/Zagreb</option>
    <option value="Europe/Zaporozhye">Europe/Zaporozhye</option>
    <option value="Europe/Zurich">Europe/Zurich</option>
    <option value="GB">GB</option>
    <option value="GB-Eire">GB-Eire</option>
    <option value="GMT">GMT</option>
    <option value="GMT+0">GMT+0</option>
    <option value="GMT0">GMT0</option>
    <option value="GMT-0">GMT-0</option>
    <option value="Greenwich">Greenwich</option>
    <option value="Hongkong">Hongkong</option>
    <option value="HST">HST</option>
    <option value="Iceland">Iceland</option>
    <option value="Indian/Antananarivo">Indian/Antananarivo</option>
    <option value="Indian/Chagos">Indian/Chagos</option>
    <option value="Indian/Christmas">Indian/Christmas</option>
    <option value="Indian/Cocos">Indian/Cocos</option>
    <option value="Indian/Comoro">Indian/Comoro</option>
    <option value="Indian/Kerguelen">Indian/Kerguelen</option>
    <option value="Indian/Mahe">Indian/Mahe</option>
    <option value="Indian/Maldives">Indian/Maldives</option>
    <option value="Indian/Mauritius">Indian/Mauritius</option>
    <option value="Indian/Mayotte">Indian/Mayotte</option>
    <option value="Indian/Reunion">Indian/Reunion</option>
    <option value="Iran">Iran</option>
    <option value="Israel">Israel</option>
    <option value="Jamaica">Jamaica</option>
    <option value="Japan">Japan</option>
    <option value="Kwajalein">Kwajalein</option>
    <option value="Libya">Libya</option>
    <option value="MET">MET</option>
    <option value="Mexico/BajaNorte">Mexico/BajaNorte</option>
    <option value="Mexico/BajaSur">Mexico/BajaSur</option>
    <option value="Mexico/General">Mexico/General</option>
    <option value="MST">MST</option>
    <option value="MST7MDT">MST7MDT</option>
    <option value="Navajo">Navajo</option>
    <option value="NZ">NZ</option>
    <option value="NZ-CHAT">NZ-CHAT</option>
    <option value="Pacific/Apia">Pacific/Apia</option>
    <option value="Pacific/Auckland">Pacific/Auckland</option>
    <option value="Pacific/Bougainville">Pacific/Bougainville</option>
    <option value="Pacific/Chatham">Pacific/Chatham</option>
    <option value="Pacific/Chuuk">Pacific/Chuuk</option>
    <option value="Pacific/Easter">Pacific/Easter</option>
    <option value="Pacific/Efate">Pacific/Efate</option>
    <option value="Pacific/Enderbury">Pacific/Enderbury</option>
    <option value="Pacific/Fakaofo">Pacific/Fakaofo</option>
    <option value="Pacific/Fiji">Pacific/Fiji</option>
    <option value="Pacific/Funafuti">Pacific/Funafuti</option>
    <option value="Pacific/Galapagos">Pacific/Galapagos</option>
    <option value="Pacific/Gambier">Pacific/Gambier</option>
    <option value="Pacific/Guadalcanal">Pacific/Guadalcanal</option>
    <option value="Pacific/Guam">Pacific/Guam</option>
    <option value="Pacific/Honolulu">Pacific/Honolulu</option>
    <option value="Pacific/Johnston">Pacific/Johnston</option>
    <option value="Pacific/Kiritimati">Pacific/Kiritimati</option>
    <option value="Pacific/Kosrae">Pacific/Kosrae</option>
    <option value="Pacific/Kwajalein">Pacific/Kwajalein</option>
    <option value="Pacific/Majuro">Pacific/Majuro</option>
    <option value="Pacific/Marquesas">Pacific/Marquesas</option>
    <option value="Pacific/Midway">Pacific/Midway</option>
    <option value="Pacific/Nauru">Pacific/Nauru</option>
    <option value="Pacific/Niue">Pacific/Niue</option>
    <option value="Pacific/Norfolk">Pacific/Norfolk</option>
    <option value="Pacific/Noumea">Pacific/Noumea</option>
    <option value="Pacific/Pago_Pago">Pacific/Pago_Pago</option>
    <option value="Pacific/Palau">Pacific/Palau</option>
    <option value="Pacific/Pitcairn">Pacific/Pitcairn</option>
    <option value="Pacific/Pohnpei">Pacific/Pohnpei</option>
    <option value="Pacific/Ponape">Pacific/Ponape</option>
    <option value="Pacific/Port_Moresby">Pacific/Port_Moresby</option>
    <option value="Pacific/Rarotonga">Pacific/Rarotonga</option>
    <option value="Pacific/Saipan">Pacific/Saipan</option>
    <option value="Pacific/Samoa">Pacific/Samoa</option>
    <option value="Pacific/Tahiti">Pacific/Tahiti</option>
    <option value="Pacific/Tarawa">Pacific/Tarawa</option>
    <option value="Pacific/Tongatapu">Pacific/Tongatapu</option>
    <option value="Pacific/Truk">Pacific/Truk</option>
    <option value="Pacific/Wake">Pacific/Wake</option>
    <option value="Pacific/Wallis">Pacific/Wallis</option>
    <option value="Pacific/Yap">Pacific/Yap</option>
    <option value="Poland">Poland</option>
    <option value="Portugal">Portugal</option>
    <option value="PRC">PRC</option>
    <option value="PST8PDT">PST8PDT</option>
    <option value="ROC">ROC</option>
    <option value="ROK">ROK</option>
    <option value="Singapore">Singapore</option>
    <option value="Turkey">Turkey</option>
    <option value="UCT">UCT</option>
    <option value="Universal">Universal</option>
    <option value="US/Alaska">US/Alaska</option>
    <option value="US/Aleutian">US/Aleutian</option>
    <option value="US/Arizona">US/Arizona</option>
    <option value="US/Central">US/Central</option>
    <option value="US/Eastern">US/Eastern</option>
    <option value="US/East-Indiana">US/East-Indiana</option>
    <option value="US/Hawaii">US/Hawaii</option>
    <option value="US/Indiana-Starke">US/Indiana-Starke</option>
    <option value="US/Michigan">US/Michigan</option>
    <option value="US/Mountain">US/Mountain</option>
    <option value="US/Pacific">US/Pacific</option>
    <option value="US/Pacific-New">US/Pacific-New</option>
    <option value="US/Samoa">US/Samoa</option>
    <option value="UTC">UTC</option>
    <option value="WET">WET</option>
    <option value="W-SU">W-SU</option>
    <option value="Zulu">Zulu</option>

    <?php
}

function states_array($company_id){
    if (get_company_data($company_id,'country')=='Oman') {
        $states=[
            '1'=>"Musandam", 
            '2'=>"Al Buraimi", 
            '3'=>"Al Batinah North", 
            '4'=>"Al Batinah South", 
            '5'=>"Muscat", 
            '6'=>"A'Dhahirah", 
            '7'=>"A'Dakhiliya", 
            '8'=>"A'Sharqiyah North", 
            '9'=>"A'Sharqiyah South", 
            '10'=>"Al Wusta", 
            '11'=>"Dhofar",   
        ];
    }else{
        $states=[
            '1'=>'Jammu & Kashmir',
            '2'=>'Himachal Pradesh',
            '3'=>'Punjab',
            '4'=>'Chandigarh',
            '5'=>'Uttarakhand',
            '6'=>'Haryana',
            '7'=>'Delhi',
            '8'=>'Rajasthan',
            '9'=>'Uttar Pradesh',
            '10'=>'Bihar',
            '11'=>'Sikkim',
            '12'=>'Arunachal Pradesh',
            '13'=>'Nagaland',
            '14'=>'Manipur',
            '15'=>'Mizoram',
            '16'=>'Tripura',
            '17'=>'Meghalaya',
            '18'=>'Assam ',
            '19'=>'West Bengal',
            '20'=>'Jharkhand',
            '21'=>'Orissa',
            '22'=>'Chhattisgarh',
            '23'=>'Madhya Pradesh',
            '24'=>'Gujarat',
            '25'=>'Daman & Diu',
            '26'=>'Dadra & Nagar Haveli',
            '27'=>'Maharashtra',
            '28'=>'Andhra Pradesh (Old)',
            '29'=>'Karnataka',
            '30'=>'Goa',
            '31'=>'Lakshadweep',
            '32'=>'Kerala',
            '33'=>'Tamil Nadu',
            '34'=>'Puducherry',
            '35'=>'Andaman & Nicobar Islands',
            '36'=>'Telengana',
            '37'=>'Andhra Pradesh (New)'
        ];
    }
    

    return $states;
}

function states_array_for_select($contryname){
    if ($contryname=='Oman') {
        $states=[
            '1'=>"Musandam", 
            '2'=>"Al Buraimi", 
            '3'=>"Al Batinah North", 
            '4'=>"Al Batinah South", 
            '5'=>"Muscat", 
            '6'=>"A'Dhahirah", 
            '7'=>"A'Dakhiliya", 
            '8'=>"A'Sharqiyah North", 
            '9'=>"A'Sharqiyah South", 
            '10'=>"Al Wusta", 
            '11'=>"Dhofar",   
        ];
    }else if ($contryname=='United Arab Emirates') {
        $states=[
            '1'=>"Abu Dhabi", 
            '2'=>"Dubai", 
            '3'=>"Sharjah", 
            '4'=>"Ajman", 
            '5'=>"Umm Al-Quwain", 
            '6'=>"Fujairah", 
        ];
    }else{
        $states=[
            '1'=>'Jammu & Kashmir',
            '2'=>'Himachal Pradesh',
            '3'=>'Punjab',
            '4'=>'Chandigarh',
            '5'=>'Uttarakhand',
            '6'=>'Haryana',
            '7'=>'Delhi',
            '8'=>'Rajasthan',
            '9'=>'Uttar Pradesh',
            '10'=>'Bihar',
            '11'=>'Sikkim',
            '12'=>'Arunachal Pradesh',
            '13'=>'Nagaland',
            '14'=>'Manipur',
            '15'=>'Mizoram',
            '16'=>'Tripura',
            '17'=>'Meghalaya',
            '18'=>'Assam ',
            '19'=>'West Bengal',
            '20'=>'Jharkhand',
            '21'=>'Orissa',
            '22'=>'Chhattisgarh',
            '23'=>'Madhya Pradesh',
            '24'=>'Gujarat',
            '25'=>'Daman & Diu',
            '26'=>'Dadra & Nagar Haveli',
            '27'=>'Maharashtra',
            '28'=>'Andhra Pradesh (Old)',
            '29'=>'Karnataka',
            '30'=>'Goa',
            '31'=>'Lakshadweep',
            '32'=>'Kerala',
            '33'=>'Tamil Nadu',
            '34'=>'Puducherry',
            '35'=>'Andaman & Nicobar Islands',
            '36'=>'Telengana',
            '37'=>'Andhra Pradesh (New)'
        ];
    }
    

    return $states;
}

function countries_array($company_id){
 

    $countries=[
        [
            'country_name'=>'India',
            'country_iso'=>'IND',
            'country_code'=>'+91',
            'country_currency'=>'INR'
        ],
        [
            'country_name'=>'Oman',
            'country_iso'=>'OMN',
            'country_code'=>'+968',
            'country_currency'=>'OMR '
        ],
        [
            'country_name'=>'United Arab Emirates',
            'country_iso'=>'ARE',
            'country_code'=>'+971',
            'country_currency'=>'AED'
        ],

    ];

    return $countries;
}

function user_country_code($userid){
    $UserModel = new Main_item_party_table;
    $get_name=$UserModel->where('id',$userid)->first();
    if ($get_name) {
        return $get_name['country_code'];
    }else{
        return '';
    }
}


function account_name($account_name){
    $AccountCategory = new AccountCategory;
    $gh=$AccountCategory->where('id',$account_name);
    foreach ($gh->findAll() as $cn) {
        return $cn['category_name'];
    }
    
}

function has_converted($invoice){
    $InvoiceModel = new InvoiceModel;
    $cs=$InvoiceModel->where('id',$invoice)->findAll();
    foreach ($cs as $cske) {
        if ($cske['converted']==1) {
            return true;
        }else{
            return false;
        }
    }     
}

function due_amount_of_invoice($company,$invoice){
    $InvoiceModel = new InvoiceModel;
    $acti=activated_year($company);
    $username=$InvoiceModel->where('company_id',$company)->where('id',$invoice)->findAll();
    foreach ($username as $get_r) {
        $name=$get_r['due_amount'];
        return $name;
    } 
}


function account_names_array($company){
    $AccountCategory = new AccountCategory;
    $ex=$AccountCategory->where('company_id',$company)->where('deleted',0);
    return $ex->findAll();
}


function product_name($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
        return $namu['product_name'];
    }else{
        return '';
    }
    
}

function conversion_unit_of_product($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
        return $namu['conversion_unit_rate'];
    }else{
        return 0;
    }
    
}

function get_barcode($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
        return $namu['barcode'];
    }else{
        return '';
    }
    
}


function product_slug($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
        return $namu['slug'];
    }else{
        return '';
    }
}


function selling_price($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
       return $namu['price'];
   }else{
    return 0;
}

}

function purchase_price($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
        return $namu['purchased_price'];
    }else{
        return 0;
    }
    
}

function accounting_purchase_price($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
        return $namu['purchased_price'];
    }else{
        return 0;
    }
    
}



function stock_of_product($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu) {
        return $namu['stock'];
    }else{
        return 0;
    }
    
}

function expiry_date($id){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$id)->first();
    if ($namu['expiry_date']!='0000-00-00') {
        return $namu['expiry_date'];
    }else{
        return '';
    }
    
}

function unit_name($id){
   return $id; 
}

function taxes_of_invoice($invoice){
    $TaxModel = new TaxModel;
    $un=$TaxModel->where('invoice_id',$invoice);
    return $un->findAll();
}




function batch_no($pro){
    $ProductsModel = new Main_item_party_table;
    $namu=$ProductsModel->where('id',$pro)->first();
    if ($namu) {
        return $namu['batch_no'];
    }else{
        return '';
    }
    
}

function invoice_taxes_array($invoice){
    $TaxModel = new TaxModel;
    $invo_items=$TaxModel->where('invoice_id',$invoice);
    return $invo_items->findAll();
}


function invoice_items_array_kits($invoice){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $invo_items=$InvoiceitemsModel->where('invoice_id',$invoice)->where('type','item_kit');
    return $invo_items->findAll();
}

function item_has_transaction($product_id){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $invo_items=$InvoiceitemsModel->where('product_id',$product_id)->where('deleted',0)->first();
    if ($invo_items) {
        return true;
    }else{
        return false;
    } 
}

function delete_from_payments($invoice_id){
    $PaymentsModel = new PaymentsModel;
    $upda=[
        'deleted'=>1,
        // 'edit_effected'=>0,
    ];
    $inss=$PaymentsModel->where('invoice_id',$invoice_id)->findAll();
    foreach ($inss as $pid) {
        $PaymentsModel->update($pid['id'],$upda);
    }
    
}

function restore_from_payments($invoice_id){
    $PaymentsModel = new PaymentsModel;
    $upda=[
        'deleted'=>0
    ];
    $inss=$PaymentsModel->where('invoice_id',$invoice_id)->findAll();
    foreach ($inss as $pid) {
        $PaymentsModel->update($pid['id'],$upda);
    }
    
}






function update_stock_when_restore($invoice_id){
    $InvoiceModel = new InvoiceModel;
    $ProductsModel = new Main_item_party_table;
    $get_invoice=$InvoiceModel->where('id',$invoice_id);
    foreach ($get_invoice->findAll() as $invoice) {

        if ($invoice['invoice_type']=='sales' || ($invoice['invoice_type']=='sales_delivery_note' && $invoice['converted']!=1)) {
            foreach (invoice_items_array($invoice['id']) as $invoice_item) {
                if (get_products_data($invoice_item['product_id'],'product_method')=='product') {
                    $stock_value=stock($invoice_item['product_id'])-$invoice_item['quantity'];
                    $update_stock=[
                        'stock'=>$stock_value
                    ];
                    $ProductsModel->update($invoice_item['product_id'],$update_stock);
                }
            }
        }elseif ($invoice['invoice_type']=='sales_return' && $invoice['converted']!=1) {
            foreach (invoice_items_array($invoice['id']) as $invoice_item) {
                if (get_products_data($invoice_item['product_id'],'product_method')=='product') {
                    $stock_value=stock($invoice_item['product_id'])+$invoice_item['quantity'];
                    $update_stock=[
                        'stock'=>$stock_value
                    ];
                    $ProductsModel->update($invoice_item['product_id'],$update_stock);
                }
            }
        }

    }

}



function update_item_stock_of_sales_when_delete($invoice_id){
    $InvoiceModel=new InvoiceModel;
    $ProductsModel=new Main_item_party_table;
    $get_invoice=$InvoiceModel->where('id',$invoice_id);

    foreach ($get_invoice->findAll() as $invoice) {

        if ($invoice['invoice_type']=='sales' || ($invoice['invoice_type']=='sales_delivery_note' && $invoice['converted']!=1)) {
            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                if (get_products_data($invoice_item['product_id'],'product_method')=='product') {
                    $stock_value=stock($invoice_item['product_id'])+$invoice_item['quantity'];
                    $update_stock=[
                        'stock'=>$stock_value
                    ];
                    $ProductsModel->update($invoice_item['product_id'],$update_stock);
                }
            }
        }elseif ($invoice['invoice_type']=='sales_return' && $invoice['converted']!=1) {
            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                if (get_products_data($invoice_item['product_id'],'product_method')=='product') {
                    $stock_value=stock($invoice_item['product_id'])-$invoice_item['quantity'];
                    $update_stock=[
                        'stock'=>$stock_value
                    ];
                    $ProductsModel->update($invoice_item['product_id'],$update_stock);
                }
            }
        }

    }
}

function update_item_stock_of_purchase_when_delete($invoice_id){
    $InvoiceModel=new InvoiceModel;
    $ProductsModel=new Main_item_party_table;
    $get_invoice=$InvoiceModel->where('id',$invoice_id);
    foreach ($get_invoice->findAll() as $invoice) {

        if ($invoice['invoice_type']=='purchase' || ($invoice['invoice_type']=='purchase_delivery_note' && $invoice['converted']!=1)) {
            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])-$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }elseif ($invoice['invoice_type']=='purchase_return' && $invoice['converted']!=1) {
            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])+$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }

    }
}



function update_item_stock_of_sales_when_restore($invoice_id){
    $InvoiceModel=new InvoiceModel;
    $ProductsModel=new Main_item_party_table;
    $get_invoice=$InvoiceModel->where('id',$invoice_id);
    foreach ($get_invoice->findAll() as $invoice) {

        if ($invoice['invoice_type']=='sales' || ($invoice['invoice_type']=='sales_delivery_note' && $invoice['converted']!=1)) {

            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                if (get_products_data($invoice_item['product_id'],'product_method')=='product') {
                    $stock_value=stock($invoice_item['product_id'])-$invoice_item['quantity'];
                    $update_stock=[
                        'stock'=>$stock_value
                    ];
                    $ProductsModel->update($invoice_item['product_id'],$update_stock);
                }
            }
        }elseif ($invoice['invoice_type']=='sales_return' && $invoice['converted']!=1) {
            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                if (get_products_data($invoice_item['product_id'],'product_method')=='product') {
                    $stock_value=stock($invoice_item['product_id'])+$invoice_item['quantity'];
                    $update_stock=[
                        'stock'=>$stock_value
                    ];
                    $ProductsModel->update($invoice_item['product_id'],$update_stock);
                }
            }
        }

    }
}


function update_item_stock_of_purchase_when_restore($invoice_id){
    $InvoiceModel=new InvoiceModel;
    $ProductsModel=new Main_item_party_table;
    $get_invoice=$InvoiceModel->where('id',$invoice_id);
    foreach ($get_invoice->findAll() as $invoice) {

        if ($invoice['invoice_type']=='purchase' || ($invoice['invoice_type']=='purchase_delivery_note' && $invoice['converted']!=1)) {
            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])+$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }elseif ($invoice['invoice_type']=='purchase_return' && $invoice['converted']!=1) {
            foreach (invoice_items_array_kits($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])-$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }

    }
}



function purchase_update_stock_when_delete($invoice_id){
    $InvoiceModel=new InvoiceModel;
    $ProductsModel=new Main_item_party_table;
    $get_invoice=$InvoiceModel->where('id',$invoice_id);

    foreach ($get_invoice->findAll() as $invoice) {

        if ($invoice['invoice_type']=='purchase' || ($invoice['invoice_type']=='purchase_delivery_note' && $invoice['converted']!=1)) {
            foreach (invoice_items_array($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])-$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }elseif ($invoice['invoice_type']=='purchase_return' && $invoice['converted']!=1) {
            foreach (invoice_items_array($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])+$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }
    }

}

function purchase_update_stock_when_restore($invoice_id){
    $InvoiceModel=new InvoiceModel;
    $ProductsModel=new Main_item_party_table;
    $get_invoice=$InvoiceModel->where('id',$invoice_id);

    foreach ($get_invoice->findAll() as $invoice) {

        if ($invoice['invoice_type']=='purchase' || ($invoice['invoice_type']=='purchase_delivery_note' && $invoice['converted']!=1)) {
            foreach (invoice_items_array($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])+$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }elseif ($invoice['invoice_type']=='purchase_return' && $invoice['converted']!=1) {
            foreach (invoice_items_array($invoice['id']) as $invoice_item) {
                $stock_value=stock($invoice_item['product_id'])-$invoice_item['quantity'];
                $update_stock=[
                    'stock'=>$stock_value
                ];
                $ProductsModel->update($invoice_item['product_id'],$update_stock);
            }
        }
    }
}

function thermal_text($text){
    $final_text='';
    $final_text=str_replace('<br>',"\n",$text);
    return $final_text;
}

function billing_address_of($customer){
    $UserModel = new Main_item_party_table;
    $get_r= $UserModel->where('id',$customer)->first();
    $output='';
    if (!empty($get_r['phone'])) { 
        $phone="".$get_r['phone'];
    }else{
        $phone="";
    }
    if (!empty($get_r['email'])) { 
        $email="".$get_r['email'];
    }else{
        $email="";
    }
    if (!empty($get_r['billing_address'])) { 
        $billing_address="".$get_r['billing_address'];
    }else{
        $billing_address="";
    }

    if (!empty($email)) {
        $output.=''.$email;
    }
    if (!empty($phone)) {
        $output.='<br>'.$get_r['country_code'].' '.$phone;
    }
    $output.="".$billing_address."";
    return $output; 
}


function country_code($customer){
    $UserModel = new Main_item_party_table;
    $get_r= $UserModel->where('id',$customer)->first();
    $output='';
    if (!empty($get_r['country_code'])) { 
        $billing_address="".$get_r['country_code'];
    }else{
        $billing_address="";
    }
    $output.="".$billing_address."";
    return $output; 
}


function gst_no_of($customer){
    $UserModel = new Main_item_party_table;
    $get_r= $UserModel->where('id',$customer)->first();
    $output='';
    if (!empty($get_r['gst_no'])) { 
        $billing_address="".$get_r['gst_no'];
    }else{
        $billing_address="";
    }
    $output.="".$billing_address."";
    return $output; 
}


function mode_of_payment($company,$invoiceid){
    $PaymentsModel = new PaymentsModel;
    
    $PaymentsModel->distinct();
    $PaymentsModel->select('type');
    $PaymentsModel->where('company_id', $company); 
    $PaymentsModel->where('invoice_id', $invoiceid); 
    $PaymentsModel->where('deleted', 0); 
    $getmode= $PaymentsModel->findAll();

    $mode='';
    $cnt=0;
    foreach ($getmode as $md) {
        $cnt++;
        if ($cnt==1) {
            $mode.=get_group_data($md['type'],'group_head');
        }elseif ($cnt>1) {
            $mode.=', '.get_group_data($md['type'],'group_head');
        }
        
    }
    if ($cnt==0) {
        return 'Credit';
    }else{
        return ucwords(str_replace('_', ' ', $mode));
    }
}

function AmountInWords($amt)
{
 $amtt=42.101;

 if (strpos($amt,'.')!==false) {
    $a=explode('.', $amt);
    $rial=word($a[0]);
    

    if (trim(word($a[1]))=='one') {
     $baisa='and hundred baisa';
 }elseif (trim(word($a[1]))=='two') {
     $baisa='and two hundred baisa';
 }elseif (trim(word($a[1]))=='three') {
     $baisa='and three hundred baisa';
 }elseif (trim(word($a[1]))=='four') {
     $baisa='and four hundred';
 }elseif (trim(word($a[1]))=='five') {
     $baisa='and five hundred baisa';
 }elseif (trim(word($a[1]))=='six') {
     $baisa='and six hundred baisa';
 }elseif (trim(word($a[1]))=='seven') {
     $baisa='and seven hundred baisa';
 }elseif (trim(word($a[1]))=='eight') {
     $baisa='and eight hundred baisa';
 }elseif (trim(word($a[1]))=='nine') {
     $baisa='and nine hundred baisa';
 }elseif (trim(word($a[1]))=='') {
     $baisa='';
 }else{
    $baisa='and '.word($a[1]).' baisa';
}

return $rial.' rial '.$baisa.' only';
}else{
    return word($amtt).'rial only';
}

}






function amount_in_words($number) {
       //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
    $words = array(
        '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
        '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
        '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
        '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
        '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
        '80' => 'eighty','90' => 'ninty');
    
    //First find the length of the number
    $number_length = strlen($number);
    //Initialize an empty array
    $number_array = array(0,0,0,0,0,0,0,0,0);        
    $received_number_array = array();
    
    //Store all received numbers into an array
    for($i=0;$i<$number_length;$i++){    
        $received_number_array[$i] = substr($number,$i,1);    
    }

    //Populate the empty array with the numbers received - most critical operation
    for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
        $number_array[$i] = $received_number_array[$j]; 
    }

    $number_to_words_string = "";
    //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for($i=0,$j=1;$i<9;$i++,$j++){
        //"01,23,45,6,78"
        //"00,10,06,7,42"
        //"00,01,90,0,00"
        if($i==0 || $i==2 || $i==4 || $i==7){
            if($number_array[$j]==0 || $number_array[$i] == "1"){
                $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
                $number_array[$i] = 0;
            }
            
        }
    }

    $value = "";
    for($i=0;$i<9;$i++){
        if($i==0 || $i==2 || $i==4 || $i==7){    
            $value = $number_array[$i]*10; 
        }
        else{ 
            $value = $number_array[$i];    
        }            
        if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
        if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
        if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
        if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
        if($i==6 && $value!=0){    $number_to_words_string.= "Hundred &amp; "; }            

    }
    if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
    return ucwords(strtolower($number_to_words_string)." Only.");  
}



function word($val){
    $vall=str_replace('-', '', $val);
    $no = floor((float)$vall);
    
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'fourty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore','trillion');
    while ($i < $digits_1) {
       $divider = ($i == 2) ? 10 : 100;
       $number = floor($no % $divider);
       $no = floor($no / $divider);
       $i += ($divider == 10) ? 1 : 2;
       if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
        " " . $digits[$counter] . $plural . " " . $hundred
        :
        $words[floor($number / 10) * 10]
        . " " . $words[$number % 10] . " "
        . $digits[$counter] . $plural . " " . $hundred;
    } else $str[] = null;
}
$str = array_reverse($str);
$result = implode('', $str);
return $result;
}

function has_show_item($company){
    $CompanySettings = new CompanySettings;

    $cs=$CompanySettings->where('company_id',$company);
    foreach ($cs->findAll() as $cske) {
        if ($cske['items_kit_show']==1) {
            return true;
        }else{
            return false;
        }
    }
    
}


function invoice_items_array($invoice){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $invo_items=$InvoiceitemsModel->where('invoice_id',$invoice)->where('entry_type!=','adjust')->where('type','single')->where('deleted',0);
    return $invo_items->findAll();
}

function invoice_items_array_for_accounts($invoice){
    $InvoiceitemsModel = new InvoiceitemsModel;
    $invo_items=$InvoiceitemsModel->where('invoice_id',$invoice)->where('entry_type!=','adjust')->where('product_priority!=',1)->where('type','single')->where('deleted!=',3);
    return $invo_items->findAll();
}

function voucher_items_array($voucher){
    $PaymentsModel = new PaymentsModel;
    $invo_items=$PaymentsModel->where('voucher_id',$voucher)->where('deleted',0);
    return $invo_items->findAll();
}




function prefixof($company,$invoice){
    $InvoiceModel = new InvoiceModel;
    $get_r=$InvoiceModel->where('company_id',$company)->where('id',$invoice)->first();
    $pref='';
    if ($get_r) {
        if ($get_r['invoice_type']=='sales'): 
         $pref=get_setting($company,'sales_prefix'); 
     elseif ($get_r['invoice_type']=='purchase'): 
         $pref=get_setting($company,'purchase_prefix'); 
     elseif ($get_r['invoice_type']=='sales_order'): 
        $pref=get_setting($company,'sales_order_prefix'); 
    elseif ($get_r['invoice_type']=='sales_quotation'): 
        $pref=get_setting($company,'sales_quotation_prefix'); 
    elseif ($get_r['invoice_type']=='sales_return'): 
        $pref=get_setting($company,'sales_return_prefix'); 
    elseif ($get_r['invoice_type']=='sales_delivery_note'): 
        $pref=get_setting($company,'sales_delivery_prefix'); 
    elseif ($get_r['invoice_type']=='purchase_order'): 
     $pref=get_setting($company,'purchase_order_prefix'); 
 elseif ($get_r['invoice_type']=='purchase_quotation'): 
    $pref=get_setting($company,'purchase_quotation_prefix'); 
elseif ($get_r['invoice_type']=='purchase_return'): 
    $pref=get_setting($company,'purchase_return_prefix'); 
elseif ($get_r['invoice_type']=='purchase_delivery_note'): 
    $pref=get_setting($company,'purchase_delivery_prefix'); 
else: 
endif;

return get_setting($company,'invoice_prefix').$pref;
}else{
    return '';
}
}

function full_invoice_type($invoice_type){
    return strtoupper(str_replace('_', ' ', $invoice_type));
}

function serial_no_cash($company){
    $PaymentsModel = new PaymentsModel;
    $PaymentsModel->selectMax('serial_no');
    $PaymentsModel->where('company_id',$company);
    $get_serial=$PaymentsModel->first();
    return $get_serial['serial_no']+1;
}

function booking_no($company){
    $AppointmentsBookings = new AppointmentsBookings;
    $AppointmentsBookings->selectMax('booking_no');
    $AppointmentsBookings->where('company_id',$company);
    $get_serial=$AppointmentsBookings->first();
    return $get_serial['booking_no']+1;
}


function serial($company,$invoice){
    $InvoiceModel = new InvoiceModel;
    $username=$InvoiceModel->where('company_id',$company)->where('id',$invoice);
    $get_res= $username->findAll();
    foreach ($get_res as $get_r) {
        $name=$get_r['serial_no'];
        return $name;
    } 
}



function add_payment($invoice_id,$type,$amount,$reference_id,$customer,$alternate_name,$payment_note,$now_time,$payment_id,$company_id,$bill_type,$user_id,$install_id=0){
    $PaymentsModel= new PaymentsModel();
    $acti=activated_year($company_id);
    $pay_data=[
        'invoice_id'=>$invoice_id,
        'fees_id'=>invoice_data($invoice_id,'fees_id'),
        'discount'=>invoice_data($invoice_id,'discount'),
        'customer'=>$customer,
        'alternate_name'=>$alternate_name,
        'type'=>$type,
        'amount'=>aitsun_round($amount,get_setting(company($user_id),'round_of_value')),
        'reference_id'=>$reference_id,
        'payment_note'=>$payment_note,
        'datetime'=>$now_time,            
        'payment_id'=>$payment_id,
        'company_id'=>$company_id,
        'bill_type'=>$bill_type,
        'serial_no'=>serial_no_cash($company_id),
        'account_name'=>$customer,
        'install_id'=>$install_id,
        'collected_by'=>$user_id,
        'class_id'=>current_class_of_student(company($user_id),$customer),
    ];
    
    if (aitsun_round($amount,get_setting(company($user_id),'round_of_value'))>0) {
        $PaymentsModel->save($pay_data);
        return $PaymentsModel->insertID();
    }else{
        return 0;
    }
    

    
}

function pos_products_array($company_id,$register_type){
    $ProductsModel=new Main_item_party_table;
    if ($register_type==1) {
        $ProductsModel->where('is_food',1); 
    }
    $ProductsModel->where('is_pos',1); 
    $get_pro = $ProductsModel->where('company_id',$company_id)->orderBy("id", "desc")->where('deleted',0)->findAll();
    return $get_pro;
}

function pos_customers($company_id){
    $UserModel=new Main_item_party_table;
    $posusers=$UserModel->where('u_type!=','staff')->where('u_type!=','driver')->where('u_type!=','teacher')->where('u_type!=','delivery')->where('u_type!=','seller')->where('u_type!=','admin')->where('u_type!=','student')->where('company_id',$company_id)->where('deleted',0)->where('main_type','user')->orderBy('id','DESC')->findAll();
    return $posusers;
}

function pos_order_prefix($company){
    return 'Order ';
}

function serial_no($company,$invoive_type){
    $InvoiceModel = new InvoiceModel;
    
    $InvoiceModel->selectMax('serial_no');
    $InvoiceModel->where('company_id',$company);
    $InvoiceModel->where('invoice_type',$invoive_type);
    $get_serial=$InvoiceModel->first();
    return $get_serial['serial_no']+1;
}

function pos_receipt_no($company,$invoive_type){
    $InvoiceModel = new InvoiceModel;
    
    $InvoiceModel->selectMax('pos_receipt_no');
    $InvoiceModel->where('company_id',$company);
    $InvoiceModel->where('invoice_type',$invoive_type);
    $InvoiceModel->where('bill_from','pos');
    $get_serial=$InvoiceModel->first();
    return $get_serial['pos_receipt_no']+1;
}

function session_serial($company){
    $PosSessions = new PosSessions;
    
    $PosSessions->selectMax('session_serial');
    $PosSessions->where('company_id',$company); 
    $get_serial=$PosSessions->first();
    return $get_serial['session_serial']+1;
}



function add_discount_payment($invoice_id,$amount,$customer,$alternate_name,$now_time,$payment_id,$company_id,$bill_type,$type){
    $PaymentsModel = new PaymentsModel;

    $bill_type_new='';
    $group_head_name='';
    if ($bill_type=='discount_allowed') {
        $bill_type_new='discount_allowed';
        $group_head_name='Discount allowed';
    }elseif ($bill_type=='discount_received') {
        $bill_type_new='discount_received';
        $group_head_name='Discount received';
    }else{

    }



    $acti=activated_year($company_id);
    $pay_data=[
        'invoice_id'=>$invoice_id,
        'customer'=>$customer,
        'alternate_name'=>$alternate_name,
        'type'=>$type,
        'amount'=>$amount,
        'datetime'=>$now_time,            
        'payment_id'=>$payment_id,
        'company_id'=>$company_id, 
        'bill_type'=>$bill_type_new,
        'serial_no'=>serial_no_cash($company_id),
        'account_name'=>id_of_group_head($company_id,$acti,$group_head_name)  
    ];

    if ($amount>0) {
        $PaymentsModel->save($pay_data);
        return $PaymentsModel->insertID();
    }else{
        return 0;
    }
}

function account_name_of_discount($billtype,$company){
    $AccountCategory = new AccountCategory;
    $AccountCategory->where('company_id',$company);
    $AccountCategory->where('slug',$billtype);
    $get_serial=$AccountCategory->first();
    if ($get_serial) {
     return $get_serial['id'];
 }else{
    return 0;
}

}

function stock($product){
    $ProductsModel = new Main_item_party_table;
    $un=$ProductsModel->where('id',$product);
    $namu=$un->first();
    return $namu['stock'];
}

function unit_of_product($product){
    $ProductsModel = new Main_item_party_table;
    $un=$ProductsModel->where('id',$product);
    $namu=$un->first();
    return $namu['unit'];
}




function item_kit_stock($product_id){
    $stockks = array();
    foreach (raw_materials_array($product_id) as $iti) {
        $stockks[]=stock($iti['product_id'])/$iti['quantity'];
    }
    if (count($stockks)>0) {
        return min($stockks);
    }else{
        return 0;
    }
    
}

function raw_materials_array($product_id){
    $RawmwterialsModel = new RawmwterialsModel;
    $invo_items=$RawmwterialsModel->where('product_id',$product_id);
    return $invo_items->findAll();
}

function is_manufactured($product_id){
    $RawmwterialsModel = new RawmwterialsModel;
    $invo_items=$RawmwterialsModel->where('product_id',$product_id)->first();
    if ($invo_items) {
        return true;
    }else{
        return false;
    } 
}



function name_of_brand($categoryid){
    $ProductBrand = new ProductBrand;
    $pr=$ProductBrand->where('id',$categoryid)->first();
    
    if ($pr) {
        return $pr['brand_name'];
    }else{
        return '';
    }
    
}

function get_id_of_brand($company,$brand_id){
    $ProductBrand = new ProductBrand;
    $cnp='';
    $pr=$ProductBrand->like('brand_name',$brand_id,'both')->where('company_id',$company);
    foreach ($pr->findAll() as $cn) {
        $cnp=$cn['id'];
    }
    return $cnp; 
}



function product_sub_categories_array($cat){
    $ProductSubCategories = new ProductSubCategories;
    $pc=$ProductSubCategories->where('parent_id',$cat)->where('deleted',0);
    return $pc->findAll();
}

function print_thermal_show($company){
    $CompanySettings = new CompanySettings;

    $cs=$CompanySettings->where('company_id',$company);
    foreach ($cs->findAll() as $cske) {
        if ($cske['print_thermal']==1) {
            return true;
        }else{
            return false;
        }
    }
    
}

function has_sticky($company){
    $CompanySettings = new CompanySettings;

    $cs=$CompanySettings->where('company_id',$company);
    foreach ($cs->findAll() as $cske) {
        if ($cske['keyboard']==1) {
            return true;
        }else{
            return false;
        }
    }
    
}



function default_taxarray($company){
    $TaxtypeModel = new TaxtypeModel;
    $tax=$TaxtypeModel->where('company_id',$company)->where('deleted',0)->where('default_tax',1);
    return $tax->findAll();
}



function currency_symbolfor_sms($company){
    $CompanySettings = new CompanySettings;
    $cur=$CompanySettings->where('company_id',$company);
    $get_res= $cur->findAll();
    
    foreach ($get_res as $get_r) {
        $currency=$get_r['currency'];
        if ($currency=='INR') {
            return 'Rs. ';
        }elseif ($currency=='OMR') {
            return 'OMR ';
        }else{
            return $currency.' ';
        }
    } 
}

 

function my_company($user){
    $Companies = new Companies;
    $stcnt=$Companies->where('id',$user);
    return $stcnt->findAll();
}

function  my_company_name($user){
    $Companies = new Companies;
    $stcnt=$Companies->where('id',$user);
    $res=$stcnt->first();
    if ($res) {
        return $res['company_name'];
    }else{
        return '';
    }
    
}
function  my_company_logo($user){
    $Companies = new Companies;
    $stcnt=$Companies->where('id',$user);
    $res=$stcnt->first();
    return $res['company_logo'];
}

function  my_company_address($user){
    $Companies = new Companies;
    $address='';
    $stcnt=$Companies->where('id',$user);
    $res=$stcnt->first();
    
    if ($res) {
        if (!empty($res['city'])){
            $address.=$res['city'].', ';
        }
        if (!empty($res['state'])){
            $address.=$res['state'].', ';
        }
        if (!empty($res['country'])){
            $address.=$res['country'].'<br>';
        }
        if (!empty($res['postal_code'])){
            $address.='Pin: '.$res['postal_code'].'<br>';
        }
        if (!empty($res['company_phone'])){
            $address.='Mob: '.$res['company_phone'].'<br>';
        }
        if (!empty($res['company_telephone'])){
            $address.='Land: '.$res['company_telephone'].'<br>';
        }
        if (!empty($res['gstin_vat_no'])){
            $address.='GSTIN: '.$res['gstin_vat_no'].'<br>';;
        } 
        if (!empty($res['website'])){
            $address.=$res['website'];
        }
    }  
    
    return $address;
}



function account_name_of_cus($customer,$company){
    $AccountingModel = new AccountingModel;
    $AccountingModel->where('company_id',$company);
    $AccountingModel->where('customer_id',$customer);
    $gse = $AccountingModel->first();
    if ($gse) {
        return $gse['id'];
    }
    
}

function child_of_unit($parent_id){
    $ProductSubUnit = new ProductSubUnit;
    $user=$ProductSubUnit->where('parent_id',$parent_id)->where('deleted',0)->findAll();
    return $user;
}

function name_of_sub_unit($unitid){
    $ProductSubUnit = new ProductSubUnit;
    $user=$ProductSubUnit->where('id', $unitid)->first();

    if ($user) {
        $fn=$user['sub_unit_name'];
        return $fn;
    }else{
        return '';
    }
    
}

function customers_array($company){
    $myid=session()->get('id');
    $UserModel = new Main_item_party_table;
    $use=$UserModel->where('company_id',$company)->where('deleted',0)->where('u_type','customer');
    return $use->findAll();
}

function vendors_array($company){
    $myid=session()->get('id');
    $UserModel = new Main_item_party_table;
    $use=$UserModel->where('company_id',$company)->where('deleted',0)->where('u_type','vendor');
    return $use->findAll();
}

function all_parties($company){
    $UserModel = new Main_item_party_table;
    $use=$UserModel->where('company_id',$company)->where('deleted',0);
    return $use->findAll();
}

function total_customers($company){
    $UserModel = new Main_item_party_table;
    $use=$UserModel->where('company_id',$company)->where('deleted',0)->where('u_type','customer');
    return count($use->findAll());
}

function total_vendors($company){
    $UserModel = new Main_item_party_table;
    $use=$UserModel->where('company_id',$company)->where('deleted',0)->where('u_type','vendor');
    return count($use->findAll());
}


function tag_status($status){
    if ($status=='paid') {
        return '<div class="badge rounded-pill text-success bg-light-success text-uppercase"><i class="bx bxs-circle me-1"></i>Paid</div>';
    }elseif ($status=='unpaid') {
        return '<div class="badge rounded-pill text-danger bg-light-danger text-uppercase"><i class="bx bxs-circle me-1"></i>Unpaid</div>';
    }elseif ($status=='draft') {
        return '<div class="badge rounded-pill text-warning bg-light-warning text-uppercase"><i class="bx bxs-circle align-middle me-1"></i>Drafted</div>';
    }elseif ($status=='completed') {
        return '<div class="badge rounded-pill text-success bg-light-success text-uppercase"><i class="bx bxs-circle me-1"></i>Completed</div>';
    }elseif ($status=='sent') {
        return '<div class="badge rounded-pill text-info bg-light-info text-uppercase"><i class="bx bxs-circle align-middle me-1"></i>Sent</div>';
    }
}

function balance($company,$customer_id,$column,$type='ledger'){
    $AccountingModel = new Main_item_party_table;

    $hs=$AccountingModel->where('company_id',$company)->where('id',$customer_id)->where('type',$type)->first();
    if ($hs) {
        return $hs[$column];
    }else{
        return 0;
    }
}

function serial_no_customer($company){
    $Main_item_party_table = new Main_item_party_table;

    $Main_item_party_table->selectMax('serial_no');
    $Main_item_party_table->where('company_id',$company);
    $Main_item_party_table->where('u_type','customer');
    $get_serial=$Main_item_party_table->first();
    return $get_serial['serial_no']+1;
}



function count_email($email,$company){
    $UserModel = new Main_item_party_table;
    $check_ac_qry=$UserModel->where('email',$email)->where('deleted',0);
    $count_rows=$check_ac_qry->countAllResults();
    return $count_rows;
}


function due_amount_of_customer($customer){
    $InvoiceModel = new InvoiceModel;
    $un=$InvoiceModel->where('customer',$customer)->where('deleted',0);
    $total_amt=0;
    $paid_amt=0;
    foreach ($un->findAll() as $tt) {
        $total_amt=$total_amt+$tt['total'];
        $paid_amt=$paid_amt+$tt['paid_amount'];
    }
    return aitsun_round($total_amt-$paid_amt,2);
}

function paid_amount($invoice){
    $InvoiceModel = new InvoiceModel;
    $un=$InvoiceModel->where('id',$invoice)->first();
    return $un['paid_amount'];
}

function serial_no_of_id($invoice){
    $InvoiceModel = new InvoiceModel;
    $un=$InvoiceModel->where('id',$invoice)->first();
    return $un['serial_no'];
}

function product_type_name($product_type){
    if ($product_type=='single') {
        return 'Product';
    }elseif ($product_type=='item_kit') {
        return 'Item Kit';
    }
}

function invoice_data($invoice,$column){
    $InvoiceModel = new InvoiceModel;
    $un=$InvoiceModel->where('id',$invoice)->first();
    if ($un) {
        return $un[$column];
    }else{
        return '';
    }
    
}

function cash_customer_of_company($company_id){
    $UserModel=new Main_item_party_table;
    $cus=$UserModel->where('company_id',$company_id)->where('default_user',1)->first();
    if ($cus) {
        return $cus['id'];
    }else{
        return 0;
    }
}


function update_paid_amount($invoice,$paid_amount,$paid_status){
    $myid=session()->get('id');
    $InvoiceModel = new InvoiceModel;
    $UserModel = new Main_item_party_table;
    $due_amount=aitsun_round(total_amount_of_invoice($invoice),get_setting(company($myid),'round_of_value'))-aitsun_round($paid_amount,get_setting(company($myid),'round_of_value'));

    $old_due_amount=invoice_data($invoice,'due_amount'); 
    $in_type=invoice_data($invoice,'invoice_type');

    $pay_data=[        
        'paid_amount'=>$paid_amount,         
        'paid_status'=>$paid_status,         
        'due_amount'=>$due_amount,         
    ];
    
    $success=$InvoiceModel->update($invoice,$pay_data);

    if ($success) {





          // ??????????????????????????  customer and cash balance calculation start ????????????
            // ??????????????????????????  customer and cash balance calculation start ????????????
                    //CUSTOMER
                    $bal_customer=invoice_data($invoice,'customer');

                    $current_closing_balance=user_data($bal_customer,'closing_balance');
                    $new_closing_balance=$current_closing_balance;

                    if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return' || $in_type=='challan') {
                        $new_closing_balance=($new_closing_balance-$old_due_amount)+aitsun_round($due_amount,get_setting(company($myid),'round_of_value'));
                    }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                        $new_closing_balance=($new_closing_balance+$old_due_amount)-aitsun_round($due_amount,get_setting(company($myid),'round_of_value'));
                    }


                    $bal_customer_data=[ 
                        'closing_balance'=>$new_closing_balance,
                    ];
                    $UserModel->update($bal_customer,$bal_customer_data);
            // ??????????????????????????  customer and cash balance calculation end ??????????????
            // ??????????????????????????  customer and cash balance calculation end ??????????????


            



        return true;
    }else{
        return false;
    }
}

function total_amount_of_invoice($invoice){
    $InvoiceModel = new InvoiceModel;
    $tax=$InvoiceModel->where('id',$invoice)->first();
    return $tax['total'];
}


function invoice_of_user($user){
    $InvoiceModel = new InvoiceModel;
    $cur=$InvoiceModel->where('customer',$user)->where('deleted',0);
    return $cur->countAllResults();
}

function currency_symbol($company){
    $CompanySettings = new CompanySettings;
    $cur=$CompanySettings->where('company_id',$company);
    $get_r= $cur->first();

    $currency=$get_r['currency'];
    if ($currency=='INR') {
        return '₹ ';
    }elseif ($currency=='OMR') {
        return 'OMR ';
    }else{
        return $currency.' ';
    }
}


function currency_symbol2($company){
    $CompanySettings = new CompanySettings;
    $cur=$CompanySettings->where('company_id',$company);
    $get_r= $cur->first();

    $currency=$get_r['currency'];
    if ($currency=='INR') {
        return 'INR';
    }elseif ($currency=='OMR') {
        return 'OMR ';
    }else{
        return $currency.' ';
    }
}


function get_setting($company,$option){
    $CompanySettings = new CompanySettings;
    $get_res=$CompanySettings->where('company_id',$company)->first();
    if ($get_res) {
     
     return $get_res[$option];
 }else{
    return '';
}
}


function check_branch_of_main_company($company){
    $Companies = new Companies;
    $username=$Companies->where('id',$company);
    $get_res=$username->countAll();
    if ($get_res>0) {
        return true;
    }else{
        return false;
    }
}



function check_company($companyid){
    $Companies = new Companies;
    $compani=$Companies->where('id',$companyid);
    if ($compani) {
        return true;
    }else{
        return false;
    }
}


function check_main_company($userid){
    $Main_item_party_table = new Main_item_party_table;
    $username=$Main_item_party_table->where('id',$userid);
    $cus_row=$username->first();
    if (check_mm_company(get_parent($cus_row['company_id']))>0) {
        return true;
    }else{
        return false;
    }
}

function get_parent($company){
    $Companies = new Companies;
    $qwr=$Companies->where('id',$company);
    $pcrow=$qwr->first();
    if ($pcrow) {
        return $pcrow['parent_company'];
    }else{
        return 0;
    } 
}

function check_mm_company($company){
    $MainCompanies = new MainCompanies;
    $chkcmp=$MainCompanies->where('id',$company);
    return count($chkcmp->findAll());
}


// function financial_year($company_id){
//     $FinancialYears = new FinancialYears;
//     $gs=$FinancialYears->where('company_id',$company_id)->where('status','0')->first();

//     if ($gs) {
//         return $gs['id'];
//     }else{
//         return '0';
//     }
// }

 function activated_year($company_id){
    $Main_item_party_table = new Main_item_party_table;
    $myid=session()->get('id');
    $gs=$Main_item_party_table->where('id',$myid)->first();

    if ($gs) {
        // return $gs['activated_financial_year'];
        return 0;
    }else{
        return 0;
    }
}

// function activated_year($company_id){
//     $Main_item_party_table = new Main_item_party_table;
//     $myid=session()->get('id');
//     $gs=$Main_item_party_table->where('id',$myid)->first();

//     if ($gs) {
//         return $gs['activated_financial_year'];
//     }else{
//         return '0';
//     }
// }

function receipt_no_generate($chars) 
{
  $data = '1234567890';
  return substr(str_shuffle($data), 0, $chars);
}

// function current_financial_year($ft,$company_id){
//     $FinancialYears = new FinancialYears;
//     $gs=$FinancialYears->where('company_id',$company_id)->where('status','0')->first();

//     if ($gs) {
//         return $gs[$ft];
//     }else{
//         return 'no_financial_years';
//     }
// }








function now_year($myid){

    $CompanySettings = new CompanySettings;
    $get_res=$CompanySettings->where('company_id', company($myid))->first();

    $now = new DateTime();
    if ($get_res) {
        $timezone=$get_res['timezone'];
        $now->setTimezone(new DateTimezone($timezone));
        return $now->format('Y');
    }else{
        return $now->format('Y');
    }
    
}

function user_name($userid){
    $Main_item_party_table = new Main_item_party_table;
    $get_name=$Main_item_party_table->where('id',$userid)->first();
    if ($get_name) {
        return $get_name['display_name'];
    }else{
        return '';
    }
}

function user_phone($userid){
    $UserModel = new Main_item_party_table;
    $get_name=$UserModel->where('id',$userid)->first();
    if ($get_name) {
        return $get_name['phone'];
    }else{
        return '';
    }
}


function user_email($userid){
    $UserModel = new Main_item_party_table;
    $get_name=$UserModel->where('id',$userid)->first();
    if ($get_name) {
        return $get_name['email'];
    }else{
        return '';
    }
}

function get_cust_data($userid,$column){
    $UserModel = new Main_item_party_table;
    $get_name=$UserModel->where('id',$userid)->first();
    if ($get_name) {
        return $get_name[$column];
    }else{
        return '';
    }
}

function no_bills_of_user($userid,$company){
    $InvoiceModel = new InvoiceModel;
    $InvoiceModel->where('customer',$userid);
    $InvoiceModel->where('deleted',0);
    return $InvoiceModel->countAllResults();
}

function no_entries_of_user($userid,$company){
    $PaymentsModel = new PaymentsModel;
    $PaymentsModel->where('account_name',$userid);
    $PaymentsModel->where('deleted',0);
    return $PaymentsModel->countAllResults();
}




function usertype($userid){
    $Main_item_party_table = new Main_item_party_table;
    $get_name=$Main_item_party_table->where('id',$userid)->first();
    if ($get_name) {
        return $get_name['u_type'];
    }else{
        return '';
    }
}

function now_time($myid){
    $CompanySettings = new CompanySettings;
    $get_res=$CompanySettings->where('company_id', company($myid))->first();
    $timezone='Asia/Kolkata';
    $now = new DateTime();
    if ($get_res) {
     
        if (!empty($timezone)) {
           $timezone=$get_res['timezone'];
       }
       
       $now->setTimezone(new DateTimezone($timezone));
       return $now->format('Y-m-d H:i:s');
   }else{
    return $now->format('Y-m-d H:i:s');
}
}


function now_time_of_company($company_id){
    $CompanySettings = new CompanySettings;
    $get_res=$CompanySettings->where('company_id', $company_id)->first();
    $timezone='Asia/Kolkata';
    $now = new DateTime();
    if ($get_res) {
     
        if (!empty($timezone)) {
           $timezone=$get_res['timezone'];
       }
       
       $now->setTimezone(new DateTimezone($timezone));
       return $now->format('Y-m-d H:i:s');
   }else{
    return $now->format('Y-m-d H:i:s');
}
}

function company($userid){
    $Main_item_party_table = new Main_item_party_table;
    $get_name=$Main_item_party_table->where('id',$userid)->first();
    return $get_name['company_id'];

}

function add_log($log_data){
    $Logs = new Logs;
    $Logs->save($log_data);
    $id = $Logs->insertID();
    return $id;
}

function has_show_stock($company){
    $CompanySettings = new CompanySettings();

    $cs=$CompanySettings->where('company_id',$company);
    foreach ($cs->findAll() as $cske) {
        if ($cske['stock_enable']==1) {
            return true;
        }else{
            return false;
        }
    }
    
}

function taxarray($company){
    $TaxtypeModel = new TaxtypeModel();
    $tax=$TaxtypeModel->where('company_id',$company)->where('deleted',0);
    return $tax->findAll();
}

function total_orders($company){
    $RequestModel = new RequestModel;
    $user=$RequestModel->where('company_id',$company)->countAllResults();
    return $user;
}

function total_products($company){
    $ProductsModel = new Main_item_party_table;
    $user=$ProductsModel->where('company_id',$company)->where('deleted',0)->countAllResults();
    return $user;
}

function total_reviews($company){
    $ProductratingsModel = new ProductratingsModel;
    $user=$ProductratingsModel->where('company_id',$company)->where('review_type!=','dummy')->countAllResults();
    return $user;
}

function total_messages($company){
    $MessageModel = new MessageModel;
    $user=$MessageModel->where('company_id',$company)->countAllResults();
    return $user;
}

function user_data($id,$column){
    $Main_item_party_table = new Main_item_party_table;
    $user=$Main_item_party_table->where('id', $id)->first();
    if ($user) {
        $fn=$user[$column];
    }else{
        $fn='';
    }
    return $fn;
}

function user_data_by_code($id,$column){
    $UserModel = new Main_item_party_table;
    $user=$UserModel->where('staff_code', $id)->where('deleted', 0)->first();
    if ($user) {
     $fn=$user[$column];
 }else{
    $fn=0;
}

return $fn;
}

function javascript_date_to_php_date($punched_time){ 

    $dateTime = DateTime::createFromFormat("D M d Y H:i:s e+", $punched_time);

    if ($dateTime !== false) {
        $formattedDateTime = $dateTime->format("Y-m-d H:i:s");
        return $formattedDateTime;
    } else {
        return "0000-00-00 00:00:00";
    }
}

function next_product($proid,$action,$company){
    $ProductsModel = new Main_item_party_table;
    $product='no product';
    if ($action=='next') {
        $ress=$ProductsModel->where('deleted',0)->where('company_id',$company)->where('id<',$proid)->orderBy('id','desc')->findAll(1);
        foreach($ress as $rs){
            $product=$rs['id']; 
        }
    }elseif ($action=='prev') {
        $ress=$ProductsModel->where('deleted',0)->where('company_id',$company)->where('id>',$proid)->orderBy('id','asc')->findAll(1);
        foreach($ress as $rs){
            $product=$rs['id']; 
        }
    }
    
    return $product;
    
}


function next_request($rq_id,$action){
    $RequestModel = new RequestModel;
    $product='no product';
    if ($action=='next') {
        $ress=$RequestModel->where('id<',$rq_id)->orderBy('id','desc')->where('deleted',0)->findAll(1);
        foreach($ress as $rs){
            $product=$rs['id']; 
        }
    }elseif ($action=='prev') {
        $ress=$RequestModel->where('id>',$rq_id)->orderBy('id','asc')->where('deleted',0)->findAll(1);
        foreach($ress as $rs){
            $product=$rs['id']; 
        }
    }
    
    return $product;

    
}



function name_of_category($categoryid){
    $ProductCategories = new ProductCategories;
    $user=$ProductCategories->where('id', $categoryid)->first();
    if ($user) {
        $fn=$user['cat_name'];
        return $fn;
    }else{
        return '';
    } 
}

function name_of_post_category($categoryid){
    $PostCategoryModel = new PostCategoryModel;
    $user=$PostCategoryModel->where('id', $categoryid)->first();
    if ($user) {
        $fn=$user['category_name'];
        return $fn;
    }else{
        return '';
    } 
}




function name_of_unit($unitid){
    if (strtolower($unitid)=='none') {
        return '';
    }else{
        return $unitid;
    }
    
}

function name_of_subunit($unitid){
    return $unitid;
}

function name_of_sub_category($categoryid){
    $ProductSubCategories = new ProductSubCategories;
    $user=$ProductSubCategories->where('id', $categoryid)->first();

    if ($user) {
        $fn=$user['sub_cat_name'];
        return $fn;
    }else{
        return '';
    }
    
}

function name_of_sec_category($categoryid){
    $SecondaryCategories = new SecondaryCategories;
    $user=$SecondaryCategories->where('id', $categoryid)->first();
    
    if ($user) {
        $fn=$user['second_cat_name'];
        return $fn;
    }else{
        return '';
    }
}

function name_of_sub_post_category($categoryid){
    $PostCategoryModel = new PostCategoryModel;
    $user=$PostCategoryModel->where('parent', $categoryid)->first();

    if ($user) {
        $fn=$user['category_name'];
        return $fn;
    }else{
        return '';
    }
    
}

function name_of_sec_post_category($categoryid){
    $PostCategoryModel = new PostCategoryModel;
    $user=$PostCategoryModel->where('category_name', $categoryid)->first();
    
    if ($user) {
        $fn=$user['category_name'];
        return $fn;
    }else{
        return '';
    }
}





function product_subcategories($company_id){
    $ProductSubCategories = new ProductSubCategories;
    $user=$ProductSubCategories->where('company_id',$company_id)->where('deleted',0)->findAll();
    return $user;
}


function product_thumbnails_array($product_id){
    $ProductsImages = new ProductsImages;
    $user=$ProductsImages->where('product_id',$product_id)->findAll();
    return $user;
}



function product_categories_array($company_id){
    $ProductCategories = new ProductCategories;
    $user=$ProductCategories->where('company_id',$company_id)->where('deleted',0)->findAll();
    return $user;
}

function product_second_sub_categories_array($company_id){
    $SecondaryCategories = new SecondaryCategories;
    $user=$SecondaryCategories->where('company_id',$company_id)->where('deleted',0)->findAll();
    return $user;
}

function products_units_array($company_id){

    $units=[ 
        [
            'name'=>'Bags(Bag)',
            'value'=>'Bag'
        ],

        [
            'name'=>'Board(Board)',
            'value'=>'Board'
        ],
        [
            'name'=>'Bottles(Btl)',
            'value'=>'Btl'
        ],
        [
            'name'=>'Box(Box)',
            'value'=>'Box'
        ],
        [
            'name'=>'Bundles(Bdl)',
            'value'=>'Bdl'
        ],
        [
            'name'=>'Cans(Can)',
            'value'=>'Can'
        ],
        [
            'name'=>'Cartons(Ctn)',
            'value'=>'Ctn'
        ],
        [
            'name'=>'Dozens(Dzn)',
            'value'=>'Dzn'
        ],
        [
            'name'=>'Feet(Ft)',
            'value'=>'Ft'
        ],
        [
            'name'=>'Kilograms(Kg)',
            'value'=>'Kg'
        ],
        [
            'name'=>'Kilo(K)',
            'value'=>'K'
        ],
        [
            'name'=>'Grammes(G)',
            'value'=>'G'
        ],
        [
            'name'=>'Litre(Ltr)',
            'value'=>'Ltr'
        ],
 
        [
            'name'=>'Mega tonne(Mt)',
            'value'=>'Mt'
        ],
        [
            'name'=>'Meters(Mtr)',
            'value'=>'Mtr'
        ],
        [
            'name'=>'Mililitre(Ml)',
            'value'=>'Ml'
        ],
        [
            'name'=>'MTS(Mts)',
            'value'=>'Mts'
        ],
        [
            'name'=>'Numbers(Nos)',
            'value'=>'Nos'
        ],
        [
            'name'=>'Packs(Pac)',
            'value'=>'Pac'
        ],
        [
            'name'=>'Pairs(Prs)',
            'value'=>'Prs'
        ],
        [
            'name'=>'Pieces(Pcs)',
            'value'=>'Pcs'
        ],
        [
            'name'=>'Quintal(Qtl)',
            'value'=>'Qtl'
        ],
        [
            'name'=>'Rolls(Rol)',
            'value'=>'Rol'
        ],
        [
            'name'=>'Running Feet(Rft)',
            'value'=>'Rft'
        ],
        [
            'name'=>'Square Feet(Sqf)',
            'value'=>'Sqf'
        ],
        [
            'name'=>'Square Meters(Sqm)',
            'value'=>'Sqm'
        ],
        [
            'name'=>'Tablets(Tbs)',
            'value'=>'Tbs'
        ], 
        [
            'name'=>'Strips(Str)',
            'value'=>'Str'
        ], 
        [
            'name'=>'Units(Units)',
            'value'=>'Units'
        ],
        
    ];

    return $units;
}

function products_brands_array($company_id){
    $ProductBrand = new ProductBrand;
    $user=$ProductBrand->where('company_id',$company_id)->where('deleted',0)->findAll();
    return $user;
}

function home_sliders_array($company_id){
    $HomesliderModel = new HomesliderModel;
    $slider=$HomesliderModel->where('company_id',$company_id)->where('section','slider')->orderBy('id','DESC')->findAll();
    return $slider;
}

function home_grids_array($company_id){
    $HomesliderModel = new HomesliderModel;
    $grids=$HomesliderModel->where('company_id',$company_id)->where('section','grid1')->orderBy('id','DESC')->findAll();
    return $grids;
}
function home_grids_2_array($company_id){
    $HomesliderModel = new HomesliderModel;
    $grids=$HomesliderModel->where('company_id',$company_id)->where('section','grid2')->orderBy('id','DESC')->findAll();
    return $grids;
}
function siderbar_ads_array($company_id){
    $HomesliderModel = new HomesliderModel;
    $sidebar=$HomesliderModel->where('company_id',$company_id)->where('section','mega')->orderBy('id','DESC')->findAll();
    return $sidebar;
}
function ad_block_array($company_id){
    $HomesliderModel = new HomesliderModel;
    $adblack=$HomesliderModel->where('company_id',$company_id)->where('section','ad_block')->orderBy('id','DESC')->findAll();
    return $adblack;
}
function shop_slider_array($company_id){
    $HomesliderModel = new HomesliderModel;
    $slider=$HomesliderModel->where('company_id',$company_id)->where('section','shop_slider')->orderBy('id','DESC')->findAll();
    return $slider;
}

function request_items_array($rq_id){
    $RequestitemsModel = new RequestitemsModel;
    $rqitems=$RequestitemsModel->where('request_id',$rq_id)->findAll();
    return $rqitems;
}

function get_products_data($pro_id,$column){
    $ProductsModel = new Main_item_party_table;
    $productdata= $ProductsModel->where('id',$pro_id)->first();
    if ($productdata) {
        return $productdata[$column];
    }else{
        return 0;
    }
}

function additional_fields_array($productid){
    $AdditionalfieldsModel = new AdditionalfieldsModel;
    $pc=$AdditionalfieldsModel->groupBy('field_name')->where('product_id', $productid);
    return $pc->findAll();
}

function additional_fields_array_by_code($product_code){
    $AdditionalfieldsModel = new AdditionalfieldsModel;
    $pc=$AdditionalfieldsModel->groupBy('field_name')->orderBy('id','ASC')->where('product_code', $product_code);
    return $pc->findAll();
}

function get_value_of_field($field_name,$product_id){
    $AdditionalfieldsModel = new AdditionalfieldsModel;

    $pc=$AdditionalfieldsModel->where('product_id',$product_id)->where('field_name',$field_name)->first();
    if ($pc) {
        return $pc['field_value'];
    }else{
        return '';
    }
    
}

function field_names_array($field_name,$product_code){
    $AdditionalfieldsModel = new AdditionalfieldsModel;
    $pc=$AdditionalfieldsModel->groupBy('field_value')->where('field_name',$field_name)->where('product_code',$product_code);
    return $pc->findAll();
}

function product_slug_of_id($id){
    $ProductsModel = new Main_item_party_table;
    $cur=$ProductsModel->where('id',$id);
    $get_res= $cur->first();
    return $get_res['slug'];
}



function GetMAC(){
        // ob_start();
        // system('getmac');
        // $Content = ob_get_contents();
        // ob_clean();
        // return substr($Content, strpos($Content,'\\')-20, 17);
        // $MAC = exec('getmac');
  
        // // Storing 'getmac' value in $MAC
        // $MAC = strtok($MAC, ' ');
  
        // Updating $MAC value using strtok function, 
        // strtok is used to split the string into tokens
        // split character of strtok is defined as a space
        // because getmac returns transport name after
        // MAC address   
    return session_id();
    
}

    // Function to get the client IP address
function get_client_ip() {
    $ipAddress = '';
    if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            // to get shared ISP IP address
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
        $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipAddressList as $ip) {
            if (! empty($ip)) {
                    // if you prefer, you can check for valid IP address here
                $ipAddress = $ip;
                break;
            }
        }
    } else if (! empty($_SERVER['HTTP_X_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    } else if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (! empty($_SERVER['HTTP_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED'];
    } else if (! empty($_SERVER['REMOTE_ADDR'])) {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    }
    return $ipAddress;
}



function get_date_format($date,$format){
    $newDate = date($format, strtotime($date));
    return $newDate;
}



function cat_title_to_slug($title){
    $slug='';

    $unwanted_array = ['ś'=>'s', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
        'Ś'=>'s', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z']; // Polish letters for example
        $str = strtr( $title, $unwanted_array );

        $slug = strtolower(trim(preg_replace('/[\s-]+/', '-', preg_replace('/[^A-Za-z0-9-]+/', '-', preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $title))))), '-'));


        return $slug;
    }

    function serial_cash($company,$payment){
        $PaymentsModel=new PaymentsModel;
        $get_res=$PaymentsModel->where('company_id',$company)->where('id',$payment)->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }


    function regions_array($company){
        $DeliverylocationModel= new DeliverylocationModel;
        $pc=$DeliverylocationModel->where('company_id', $company)->where('location_type','region')->where('deleted', 0);
        return $pc->findAll();
    }
    function post_office_array($company,$region_id){
        $DeliverylocationModel= new DeliverylocationModel;
        $pc=$DeliverylocationModel->where('company_id',$company)->where('location_type','post')->where('parent_id',$region_id)
        ->where('deleted',0);
        return $pc->findAll();
    }

    function get_sale_of_delivery($delid){
        $InvoiceModel=new InvoiceModel;
        $trkaar=$InvoiceModel->where('converted_id',$delid)->first();
        if ($trkaar) {
            return $trkaar['id'];
        }else{
            return 0;
        }
        
    }

    function delivery_persons_array($company){
        $UserModel=new Main_item_party_table;
        $tax=$UserModel->where('company_id',$company)->where('deleted',0)->where('u_type','delivery');
        return $tax->findAll();
    }

    function product_image($itemid){

        $ProductsModel = new Main_item_party_table;
        $cur=$ProductsModel->where('id', $itemid);
        $get_res= $cur->first();

        return $get_res['pro_img'];

    }

    function order_track($orderid,$after){
        $OrdertrackingModel= new OrdertrackingModel;
        $trkaar=$OrdertrackingModel->where('invoice_id',$orderid)->where('after',$after)->orderBy('id','DESC')->findAll();
        return $trkaar;
    }

    function main_company_id($userid){
        $UserModel= new Main_item_party_table;
        $MainCompanies = new MainCompanies;
        $username=$UserModel->where('id',$userid)->findAll();
        foreach ($username as $re) {
            $get_c=$MainCompanies->where('id',get_parent($re['company_id']));
            $get_cmp= $get_c->findAll();
            foreach ($get_cmp as $fg) {
                $compaNUID=$fg['id'];
                return $compaNUID;
            }
        }
    }

    function count_this_slug($slug,$company){
        $AccountCategory=new AccountCategory;
        $check_ac_qry=$AccountCategory->where('slug',$slug)->where('company_id',$company);
        $count_rows=count($check_ac_qry->findAll());
        return $count_rows;
    }

    function count_group_slug($slug,$company){
        $ExgroupheadsModel=new ExgroupheadsModel;
        $check_ac_qry=$ExgroupheadsModel->where('slug', $slug)->where('company_id',$company);
        $count_rows=count($check_ac_qry->findAll());
        return $count_rows;
    }


    function calculate_month($date,$month,$format){
        $effectiveDate = date($format, strtotime($date . "+".$month."months") ); 
        return $effectiveDate;
    }

    function calculate_day($date,$day,$format){
        $effectiveDate = date($format, strtotime($date . "+".$day."days") ); 
        return $effectiveDate;
    }



    function receipt_show($payment_id,$company,$userid,$bill_type,$customer,$alternate_name,$type,$amount,$payment_note,$account_name,$datetime){
        ?>
        <div class="invoice_page">
           <table class="w-100">
              <tbody>
                  <tr>
                    <td>
                        <?php foreach (my_company($company) as $cmp) { ?>
                            <div class="d-flex">
                              <img src="<?= base_url(); ?>/public/images/company_docs/<?php if($cmp['company_logo'] != ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>" class="company_logo" style="    height: 60px;">
                              <div class="my-auto ml-2 ">
                                  <h5 class=" mb-0 "><?= $cmp['company_name']; ?></h5>
                                  <p class="mb-0">
                                    <?php if (!empty($cmp['city'])): ?>
                                      <?= $cmp['city']; ?>,
                                  <?php endif ?>
                                  <?php if (!empty($cmp['state'])): ?>
                                      <?= $cmp['state']; ?>,
                                  <?php endif ?>
                                  <?php if (!empty($cmp['country'])): ?>
                                      <?= $cmp['country']; ?>
                                  <?php endif ?>
                                  <?php if (!empty($cmp['postal_code'])): ?>
                                      Pin: <?= $cmp['postal_code']; ?><br>
                                  <?php endif ?>
                                  <?php if (!empty($cmp['company_phone'])): ?>
                                      Mob: <?= $cmp['company_phone']; ?>,
                                      <?php endif ?><br>
                                      <?php if (!empty($cmp['company_phone'])): ?>
                                        GST/VAT: <?= $cmp['gstin_vat_no']; ?>
                                    <?php endif ?>
                                </p>
                            </div>
                            
                        </div> 
                    <?php } ?>
                </td>

                <td class="text-right">
                    <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>
                        <h4 class="text-dark m-0">RECEIPT</h4>
                    <?php else: ?>
                        <h4 class="text-dark m-0">PAYMENT</h4>
                    <?php endif ?>
                    
                    Date : <?= get_date_format(now_time($userid),'d M  Y'); ?><br>
                    Voucher No : <?= get_setting(company($userid),'payment_prefix'); ?>
                    <?= serial_cash(company($userid),$payment_id); ?>   
                    
                    <?php if (invoice_id_of_payment($payment_id) != 0) : ?> 
                        Invoice No: <?= inventory_prefix($company,invoice_data(invoice_id_of_payment($payment_id),'invoice_type')); ?><?= invoice_id_of_payment($payment_id);  ?>         
                    <?php endif ?>

                </td>
            </tr>

            <tr>
                <td colspan="2" class="pt-2">
                    <table class="w-100 product_table" border="1">
                     
                        <tbody>
                          
                          <tr >
                             <td class="py-2 px-2" style="width: 50%;">
                               <span>

                                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>

                                <?php else: ?>
                                    <?= get_group_data($account_name,'group_head'); ?><br>
                                <?php endif ?>


                                Party Name:   <b>
                                    <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>
                                        <?php if ($customer!='CASH'): ?>
                                            <?=  user_name($customer); ?>
                                        <?php elseif($alternate_name!='CASH CUSTOMER'): ?>
                                            CASH CUSTOMER ( <?= $alternate_name; ?> )
                                        <?php elseif($alternate_name==''): ?>
                                            CASH CUSTOMER
                                        <?php else: ?>
                                            CASH CUSTOMER
                                        <?php endif ?>
                                    <?php else: ?>
                                        <?=  user_name($customer); ?> <br>
                                        
                                    <?php endif ?>  
                                </b></span><br>
                                <span>Payment: <b><?= get_group_data($type,'group_head'); ?>
                                
                            </b></span>
                        </td>

                        <td class="py-2 px-2 border-all">
                          <table class="w-100 table-borderless">
                              
                            <tr>
                               
                              <td class="border_one">
                                Details:
                                <p><?= $payment_note; ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>

<tr>
  <td colspan="2">
    <div class="amt_ro mt-3">
        <b><?= currency_symbol($company); ?> <?= $amount; ?> /-</b>
    </div>
</td>
</tr>



<tr>
  <td colspan="2" class="pt-2 text-center">
    <p class="m-0 text-muted">If you have any questions about this invoice, please contact <br>
        <?php foreach (my_company($company) as $cmp) { ?>
          <span style="color: <?= get_setting($company,'invoice_font_color'); ?>;"><?= $cmp['company_name']; ?></span>, phone: <span style="color: <?= get_setting($company,'invoice_font_color'); ?>;"><?= $cmp['company_phone']; ?></span>, email: <span style="color: <?= get_setting($company,'invoice_font_color'); ?>;"><?= $cmp['email']; ?></span>
      <?php } ?>
  </p>
  <div class="border-bottom mb-2"></div>
  <h6 class="text-dark"><b><?= get_setting($company,'payment_footer'); ?></b></h6>
</td>
</tr>


</tbody></table>
</div>
<?php
}



function receipt_show1($payment_id,$company,$userid,$bill_type,$customer,$alternate_name,$type,$amount,$payment_note,$account_name,$datetime){
    ?>
    <div>
        <table class="w-100">
            <tr>
                <td class="px-2">
                    <?php foreach (my_company($company) as $cmp) { ?>
                        <div class="d-flex"> 
                          <img src="<?= base_url(); ?>/public/images/company_docs/<?php if($cmp['company_logo'] != ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>" class="company_logo" style="    height: 60px;">
                          <div class="my-auto ml-2 ">
                              <h5 class="mb-0 text-dark"><?= $cmp['company_name']; ?></h5>
                              <p class="mb-0">
                                <?php if (!empty($cmp['city'])): ?>
                                  <?= $cmp['city']; ?>,
                              <?php endif ?>
                              <?php if (!empty($cmp['state'])): ?>
                                  <?= $cmp['state']; ?>,
                              <?php endif ?>
                              <?php if (!empty($cmp['country'])): ?>
                                  <?= $cmp['country']; ?>
                              <?php endif ?>
                              <?php if (!empty($cmp['postal_code'])): ?>
                                  Pin: <?= $cmp['postal_code']; ?><br>
                              <?php endif ?>
                              <?php if (!empty($cmp['company_phone'])): ?>
                                  Mob: <?= $cmp['company_phone']; ?>,
                                  <?php endif ?><br>
                                  <?php if (!empty($cmp['company_phone'])): ?>
                                    GST/VAT: <?= $cmp['gstin_vat_no']; ?>
                                <?php endif ?>
                            </p>
                        </div>

                    </div>
                    
                <?php } ?>
            </td>
            <td class="text-right px-2">
                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>
                    <h3 class="text-dark m-0">RECEIPT</h3>
                <?php else: ?>
                    <h3 class="text-dark m-0">PAYMENT</h3>
                <?php endif ?>
            </td>
        </tr>
        <tr><td colspan="2"><div class="border-bottom mb-2"></div></td></tr>
        <tr>


            <td class="px-2">

                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>

                <?php else: ?>
                  <?= get_group_data($account_name,'group_head'); ?><br>
              <?php endif ?>

              Party Name :  <b>
                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>
                    <?php if ($customer!='CASH'): ?>
                      <?=  user_name($customer); ?>
                      
                  <?php elseif($alternate_name!='CASH CUSTOMER'): ?>
                    CASH CUSTOMER ( <?= $alternate_name; ?> )

                <?php elseif($alternate_name==''): ?>
                    CASH CUSTOMER
                <?php else: ?>
                    CASH CUSTOMER
                <?php endif ?>
            <?php else: ?>
                <?=  user_name($customer); ?> <br>
                <?php endif ?></b>
            </td>
            
            <td class="text-right px-2">
                Date : <?= get_date_format(now_time($userid),'d M Y'); ?><br>
                Voucher No : <?= get_setting(company($userid),'payment_prefix'); ?>
                <?= serial_cash(company($userid),$payment_id); ?><br>

                <?php if (invoice_id_of_payment($payment_id) != 0) : ?> 

                 Invoice No: <?= inventory_prefix($company,invoice_data(invoice_id_of_payment($payment_id),'invoice_type')); ?><?= invoice_id_of_payment($payment_id);  ?>         
             <?php endif ?>

         </td>
     </tr>

     <tr><td colspan="5"><div class="border-bottom mb-2"></div></td></tr>

     <tr>
        <td>
            <table class="w-100">
                <tr>
                    <td class="px-2">Payment: <b><?= get_group_data($type,'group_head'); ?></b></td>
                </tr>
                <tr>
                    <td class="px-2">Details:<br>
                        <?= $payment_note; ?>
                    </td>
                    
                </tr>
            </table>
        </td>
        <td style="width: 40%">
            <table class="w-100">
                <tr>
                    <td class="text-right" width="60%">Amount : </td>
                    <td class="text-center"><b><?= currency_symbol($company); ?> <?= $amount; ?> /-</b></td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td colspan="2" class="pt-2 text-center">
            <br>
            <p class="m-0 text-muted">If you have any questions about this invoice, please contact <br>
                <?php foreach (my_company($company) as $cmp) { ?>
                   <span style="color: <?= get_setting($company,'invoice_font_color'); ?>;"><?= $cmp['company_name']; ?></span>, phone: <span style="color: <?= get_setting($company,'invoice_font_color'); ?>;"><?= $cmp['company_phone']; ?></span>, email: <span style="color: <?= get_setting($company,'invoice_font_color'); ?>;"><?= $cmp['email']; ?></span>
               <?php } ?>
           </p><div class="border-bottom mb-2"></div>
           <h6 class="text-dark"><b><?= get_setting($company,'payment_footer'); ?></b></h6>
       </td>
   </tr>
</table>
</div>
<?php
}

function get_dates_of_month_array($date,$abr){
        $date = get_date_format($date,'F Y');//Current Month Year
        $de_date = get_date_format($date,'Y-m');//Current Month Year
        $dates_array=array();
        while (strtotime($date) <= strtotime($de_date . '-' . date('t', strtotime($date)))) {
            $day_num = date('j', strtotime($date));//Day number
            $day_name = date('l', strtotime($date));//Day name
            $day_abrev = date('S', strtotime($date));//th, nd, st and rd
            $day = "$day_name $day_num $day_abrev";
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));//Adds 1 day onto current date
            if ($abr=='day_name') {
              array_push($dates_array, $day_name);
          }elseif($abr=='day_number'){
           array_push($dates_array, $day_num);
       }else{
           array_push($dates_array, $day);
       } 
   }
   return $dates_array;
}

function get_month_array($date,$abr){
        $date = get_date_format($date,'F Y');//Current Month Year
        $dates_array=array();
        while (strtotime($date) <= strtotime(date('Y-m') . '-' . date('t', strtotime($date)))) {
            $day_num = date('j', strtotime($date));//Day number
            $day_name = date('l', strtotime($date));//Day name
            $day_abrev = date('S', strtotime($date));//th, nd, st and rd
            $day = "$day_name $day_num $day_abrev";
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));//Adds 1 day onto current date
            if ($abr=='day_name') {
              array_push($dates_array, $day_name);
          }elseif($abr=='day_number'){
           array_push($dates_array, $day_num);
       }else{
           array_push($dates_array, $day);
       }
   }
   return $dates_array;

}

function get_user_attendance_by_date($employee_id,$dates){
    $AttendanceModel = new AttendanceModel();
    $attddata= $AttendanceModel->where('date',$dates)->where('employee_id',$employee_id)->first();
    if ($attddata) {
     return $attddata['attendance'];
 }else{
    return '-';
}
}

function offer_image_array($company_id){
    $OffersModel = new OffersModel;
    $fullimage=$OffersModel->where('company_id',$company_id)->orderBy('id','DESC')->findAll();
    return $fullimage;
}










function get_user_attendance_by_month_status($employee_id,$dates,$status){
    $AttendanceModel = new AttendanceModel();
    $atnote='';
    $attddata= $AttendanceModel->where('MONTH(date)',get_date_format($dates,'m'))->where('YEAR(date)',get_date_format($dates,'Y'))->where('employee_id',$employee_id)->where('attendance',$status)->findAll();

    if (get_date_format($dates,'Y-m')<=get_date_format(now_time($employee_id),'Y-m')) {
        if ($attddata) {
            if (count($attddata)>1) {
                return '<b class="text-danger">'.count($attddata).' Leaves</b>';
            }else{
                return '<b class="text-danger">'.count($attddata).' Leave</b>';
            }
            
        }else{
            return '';
        }
    }else{
        return '';
    } 
    
}

function get_icons_of_attendance($status){
    if ($status=='Present'){
        return '✔';
    }elseif($status=='Absent'){
        return 'X';
    }else{
        return $status;
    }
}

function get_color_of_attendance($color){
    if ($color=='Present'){
        return 'present_box';
    }elseif($color=='Absent'){
        return 'absent_box';
    }elseif($color=='W H'){
        return 'wh_box';
    }elseif($color=='OT'){
        return 'ot_box';
    }elseif($color=='H.D'){
        return 'hd_box';
    }elseif($color=='WO'){
        return 'wo_box';
    }        
}

function get_attendance_data($company_id,$date,$employee_id,$column){
    $AttendanceModel = new AttendanceModel();
    $attddata= $AttendanceModel->where('company_id',$company_id)->where('DATE(date)',$date)->where('employee_id',$employee_id)->first();
    if ($attddata) {
     return $attddata[$column];
 }else{
    return '';
}
}


function workshift_array($company_id){
    $WorkshiftModel = new WorkshiftModel;
    $workshift_data=$WorkshiftModel->where('company_id',$company_id)->where('deleted',0)->findAll();
    return $workshift_data;
}


function employee_categories_array($company_id){
    $EmployeeCategoriesModel = new EmployeeCategoriesModel;
    $emp_cat_data=$EmployeeCategoriesModel->where('company_id',$company_id)->where('deleted',0)->findAll();
    return $emp_cat_data;
}



function work_shift_name($shift_id){
    $WorkshiftModel = new WorkshiftModel;
    $shift=$WorkshiftModel->where('id', $shift_id)->first();

    if ($shift) {
        $fn=$shift['shift'];
        return $fn;
    }else{
        return '';
    }
    
}



function get_work_shift_data($shift_id,$column){
    $WorkshiftModel = new WorkshiftModel;
    $shift=$WorkshiftModel->where('id',$shift_id)->first();
    
    if ($shift) {
        return $shift[$column];
    }else{
        return 0;
    }
}

function employee_category_data($ecid,$column){
    $EmployeeCategoriesModel = new EmployeeCategoriesModel;
    $ecdata=$EmployeeCategoriesModel->where('id',$ecid)->first();
    
    if ($ecdata) {
        return $ecdata[$column];
    }else{
        return '';
    }
}

function get_invoice_items_data($invoice_id,$columnnn){
        $InvoiceitemsModel = new InvoiceitemsModel();
        $returnval=false;
        $initemsdata= $InvoiceitemsModel->where('invoice_id',$invoice_id)->first();
        if ($initemsdata) {
            $returnval=$initemsdata[$columnnn];
        }
        return $returnval;
    }


?>