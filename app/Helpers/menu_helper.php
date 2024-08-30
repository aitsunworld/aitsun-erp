<?php 

	function menus_array($user_id,$u_type){
		$menuItems = [
		    [
		    	"menu_name"=>'Dashboard', 
		        "url" => base_url(),
		        "icon" => base_url('public/images/menu_icons/home.webp'),
		        "title" => "Dashboard",
		        'class'=>''
		    ], 
		    [
		    	"menu_name"=>'Parties', 
		        "url" => base_url('customers') . "?page=1",
		        "icon" => base_url('public/images/menu_icons/customer_master.webp'),
		        "title" => "Parties"
		    ],
		    [
		    	"menu_name"=>'Class & Subjects',
		        "url" => base_url('class-and-subjects'),
		        "icon" => base_url('public/images/menu_icons/classes.webp'),
		        "title" => "Class & Subjects",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Students Master',
		        "url" => base_url('student-master') . "?page=1",
		        "icon" => base_url('public/images/menu_icons/student_master.webp'),
		        "title" => "Students Master",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Users Master',
		        "url" => base_url('user_master') . "?page=1",
		        "icon" => base_url('public/images/menu_icons/user_master.webp'),
		        "title" => "Users Master"
		    ],
		    [
		    	"menu_name"=>'Products',
		        "url" => base_url('products') . "?page=1",
		        "icon" => base_url('public/images/menu_icons/products.webp'),
		        "title" => "Products",
		    ],
		    [
		    	"menu_name"=>'POS',
		        "url" => base_url('pos'),
		        "icon" => base_url('public/images/menu_icons/pos.webp'),
		        "title" => "POS",
		    ],
		    [
		    	"menu_name"=>'Sales',
		        "url" => base_url('invoices/sales'),
		        "icon" => base_url('public/images/menu_icons/inventories.webp'),
		        "title" => "Sales",
		    ],
		    [
		    	"menu_name"=>'Purchases',
		        "url" => base_url('purchases/purchases'),
		        "icon" => base_url('public/images/menu_icons/inventories.webp'),
		        "title" => "Purchases",
		    ],
		    [
		    	"menu_name"=>'Rental',
		        "url" => base_url('rental'),
		        "icon" => base_url('public/images/menu_icons/rental.webp'),
		        "title" => "Rental"
		    ],
		    [
		    	"menu_name"=>'Vouchers',
		        "url" => base_url('voucher_entries'),
		        "icon" => base_url('public/images/menu_icons/vouchers.webp'),
		        "title" => "Vouchers",
		    ],
		    [
		    	"menu_name"=>'Cheques',
		        "url" => base_url('cheque-management'),
		        "icon" => base_url('public/images/menu_icons/cheque-management.webp'),
		        "title" => "Cheques"
		    ],
		  
		    [
		    	"menu_name"=>'Appointments',
		        "url" => base_url('appointments'),
		        "icon" => base_url('public/images/menu_icons/appoinments.webp'),
		        "title" => "Appointments",
		        "condition" => is_appointments(company($user_id))
		    ],
		    [
		    	"menu_name"=>'My Website',
		        "url" => base_url('website_management'),
		        "icon" => base_url('public/images/menu_icons/website.webp'),
		        "title" => "My Website"
		    ],
		    [
		    	"menu_name"=>'Library',
		        "url" => base_url('library-management') . "?page=1",
		        "icon" => base_url('public/images/menu_icons/library.webp'),
		        "title" => "Library",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Feedbacks',
		        "url" => base_url('feedbacks') . "?page=1",
		        "icon" => base_url('public/images/menu_icons/feedbacks.webp'),
		        "title" => "Feedbacks",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Fees',
		        "url" => base_url('fees_and_payments'),
		        "icon" => base_url('public/images/menu_icons/fees.webp'),
		        "title" => "Fees",
		        "condition" => is_school(company($user_id)) && (check_permission($user_id, 'manage_fees') || $u_type == 'admin')
		    ],
		    [
		    	"menu_name"=>'Messaging',
		        "url" => base_url('messaging'),
		        "icon" => base_url('public/images/menu_icons/message.webp'),
		        "title" => "Messaging",
		        "condition" => is_school(company($user_id)) && (check_permission($user_id, 'manage_messaging') || $u_type == 'admin')
		    ],
		    [
		    	"menu_name"=>'Activities',
		        "url" => base_url('school_activities'),
		        "icon" => base_url('public/images/menu_icons/activities.webp'),
		        "title" => "Activities",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Renews',
		        "url" => base_url('document_renew'),
		        "icon" => base_url('public/images/menu_icons/library.webp'),
		        "title" => "Renews",
		        "condition" => is_crm(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Reports',
		        "url" => base_url('reports_selector'),
		        "icon" => base_url('public/images/menu_icons/reports.webp'),
		        "title" => "Reports",
		    ],
		    [
		    	"menu_name"=>'Calendar',
		        "url" => base_url('calender'),
		        "icon" => base_url('public/images/menu_icons/calender.webp'),
		        "title" => "Calendar",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Exams',
		        "url" => base_url('exams'),
		        "icon" => base_url('public/images/menu_icons/exam.webp'),
		        "title" => "Exams",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Transport',
		        "url" => base_url('school_transport'),
		        "icon" => base_url('public/images/menu_icons/transport.webp'),
		        "title" => "Transport",
		        "condition" => is_school(company($user_id))
			],
		    [
		    	"menu_name"=>'Time Table',
		        "url" => base_url('time_table'),
		        "icon" => base_url('public/images/menu_icons/time_table.webp'),
		        "title" => "Time Table",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Articles',
		        "url" => base_url('magazine_request'),
		        "icon" => base_url('public/images/menu_icons/article.webp'),
		        "title" => "Articles",
		        "condition" => is_school(company($user_id))
		    ],
		    [
		    	"menu_name"=>'Health',
		        "url" => base_url('health'),
		        "icon" => base_url('public/images/menu_icons/health.webp'),
		        "title" => "Health",
		        "condition" => is_school(company($user_id)) && (check_permission($user_id, 'manage_health') || $u_type == 'admin')
		    ],
		    [
		    	"menu_name"=>'Notice',
		        "url" => base_url('notice'),
		        "icon" => base_url('public/images/menu_icons/notice.webp'),
		        "title" => "Notice",
		        "condition" => is_school(company($user_id)) && (check_permission($user_id, 'manage_notices') || $u_type == 'admin')
		    ],
		    [
		    	"menu_name"=>'Aitsun Keys',
		        "url" => base_url('aitsun_keys'),
		        "icon" => base_url('public/images/menu_icons/aitsun_keys.webp'),
		        "title" => "Aitsun Keys",
		        "condition" => is_aitsun(company($user_id))
		    ]
		];

		return $menuItems;
	}

 ?>