<?php 
	function aitsun_share_data($type,$template){
		$message_data=[
			'email'=>[
				'invoice_share'=>[
					'subject'=>'Your Purchase invoice details',
					'message'=>"Dear [customer-name], \n\nWith Secure Private Limited truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. \nWe sincerely hope you are satisfied with your purchase, and look forward to serving you again. \n\nAmount: [currency-icon] [total-amount] \n\nDue Amount: [currency-icon] [due-amount]  \n\nThanks and Regards \nWith \n[company-name]"
				]
			]
		];

		return $message_data[$type][$template];
	}	
?>