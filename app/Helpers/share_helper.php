<?php 
	use App\Models\MessageTemplatesModel as MessageTemplatesModel;

	function get_template($company_id,$template,$element){
		$MessageTemplatesModel=new MessageTemplatesModel;
		$temp_data='';
		$get_template=$MessageTemplatesModel->where('company_id',$company_id)->where('template_name',$template)->first();
		if ($get_template) {
			if(!empty(trim($get_template[$element]))){
				$temp_data=$get_template[$element];
			}else{
				$temp_data=aitsun_share_data($template,$element);
			}
		}else{
			$temp_data=aitsun_share_data($template,$element);
		}
		return $temp_data;
	}

	function aitsun_share_data($template,$element){
		$message_data=[ 
			'email_invoice_share'=>[
				'subject'=>'Your [invoice-type] from [company-name]', 
				'message'=>"Dear [customer-name],\n\nI hope this message finds you well.\n\nPlease find your latest [invoice-type] below: \n\n[invoice-type] Number: [invoice-number]\nTotal Amount: [currency-icon] [total-amount]\nDue Amount: [currency-icon] [due-amount]\n\nYou can view your [invoice-type] using the following link:\n\n[invoice-link]\n\nWe appreciate your prompt attention to this matter. If you have any questions or need further assistance, please do not hesitate tocontact us.\n\nThank you for your business!\nBest regards,\n[company-name]\nContact: [company-contact]"
			],
			'whatsapp_invoice_share'=>[
				'subject'=>'Your [invoice-type] from [company-name]', 
				'message'=>"Dear [customer-name],\n\nI hope this message finds you well.\n\nPlease find your latest [invoice-type] below: \n\n[invoice-type] Number: [invoice-number]\nTotal Amount: [currency-icon] [total-amount]\nDue Amount: [currency-icon] [due-amount]\n\nYou can view your [invoice-type] using the following link:\n\n[invoice-link]\n\nWe appreciate your prompt attention to this matter. If you have any questions or need further assistance, please do not hesitate tocontact us.\n\nThank you for your business!\nBest regards,\n[company-name]\nContact: [company-contact]"
			],
			'email_appointmnt'=>[
				'subject'=>'', 
				'message'=>""
			],
			'whatsapp_appointmnt'=>[
				'subject'=>'', 
				'message'=>""
			]
		];
 
		return $message_data[$template][$element];
	}

	function templates_list(){
		$template_list=[
			[
				'template_heading'=>'Inventory share',
				'em_template_name'=>'email_invoice_share',
				'wa_template_name'=>'whatsapp_invoice_share',
				'short_codes'=>[
					'[customer-name]',
					'[currency-icon]',
					'[total-amount]',
					'[due-amount]',
					'[company-name]',
					'[company-contact]',
					'[invoice-number]',
					'[invoice-link]',
					'[invoice-type]'
				]
			],
			[
				'template_heading'=>'Appointments',
				'em_template_name'=>'email_appointmnt',
				'wa_template_name'=>'whatsapp_appointmnt',
				'short_codes'=>[
					
				]
			],
		];
		return $template_list;
	}
?>