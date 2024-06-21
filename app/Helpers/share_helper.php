<?php 
	function aitsun_share_data($type,$template){
		$message_data=[
			'email'=>[
				'invoice_share'=>[
					'subject'=>'Your [invoice-type] from [company-name]', 
					'message'=>"Dear [customer-name],\n\nI hope this message finds you well.\n\nPlease find your latest [invoice-type] below: \n\n[invoice-type] Number: [invoice-number]\nTotal Amount: [currency-icon] [total-amount]\nDue Amount: [currency-icon] [due-amount]\n\nYou can view your [invoice-type] using the following link:\n\n[invoice-link]\n\nWe appreciate your prompt attention to this matter. If you have any questions or need further assistance, please do not hesitate tocontact us.\n\nThank you for your business!\nBest regards,\n[company-name]\nContact: [company-contact]"
				]
			],
			'whatsapp'=>[
				'invoice_share'=>[
					'subject'=>'Your [invoice-type] from [company-name]', 
					'message'=>"Dear [customer-name],\n\nI hope this message finds you well.\n\nPlease find your latest [invoice-type] below: \n\n[invoice-type] Number: [invoice-number]\nTotal Amount: [currency-icon] [total-amount]\nDue Amount: [currency-icon] [due-amount]\n\nYou can view your [invoice-type] using the following link:\n\n[invoice-link]\n\nWe appreciate your prompt attention to this matter. If you have any questions or need further assistance, please do not hesitate tocontact us.\n\nThank you for your business!\nBest regards,\n[company-name]\nContact: [company-contact]"
				]
			]
		];


		return $message_data[$type][$template];
	}	
?>