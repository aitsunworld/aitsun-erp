<?php 

use App\Models\InvoiceitemsModel as InvoiceitemsModel;
use App\Models\PriceQueue as PriceQueue;

function stock_value_of_item($product_id){
	// $st_val=0;
	// $PriceQueue=new PriceQueue;
	// $get_value=$PriceQueue->select('sum(amt) as total_s_value')->where('product_id',$product_id)->first();
	// if ($get_value) {
	// 	$st_val=$get_value['total_s_value'];
	// }
	// return $st_val;
}

function add_to_price_queue($invoice_id,$product_id,$quantity,$price,$amt,$type='inv'){
	// $PriceQueue=new PriceQueue;
	// $q_data=[
	// 	'product_id'=>$product_id,
	// 	'qty'=>$quantity,
	// 	'price'=>$price,
	// 	'amt'=>$amt,
	// 	'invoice_id'=>$invoice_id,
	// 	'type'=>$type
	// ];
	// $PriceQueue->save($q_data);
}

function remove_from_price_queue($product_id,$q_quantity){


	// $PriceQueue=new PriceQueue;
	  

     
    // $price_que_array=$PriceQueue->where('product_id',$product_id)->orderBy('id','ASC')->findAll();
    // $price_que_array_count=$PriceQueue->where('product_id',$product_id)->orderBy('id','ASC')->countAllResults();
    // $row_no=0;
    // foreach ($price_que_array as $pq) {
    // 	$row_no++;
    // 	if ($price_que_array_count==$row_no) {
    // 		///update
    //     	$PriceQueue->update($pq['id'],[
    //     		'qty'=>$pq['qty']-$q_quantity,
    //     		'amt'=>$pq['price']*($pq['qty']-$q_quantity)
    //     	]);


    //         $q_quantity=$q_quantity-$pq['qty'];



    // 	}else{
    // 		if ($q_quantity>0) {
	//             if ($q_quantity >= $pq['qty']) {
	                 
	//             	//delete
	//             	$PriceQueue->where('id',$pq['id'])->delete();

	//                  $q_quantity=$q_quantity-$pq['qty'];
	//             }else{
	               
	//                 //update
	//             	$PriceQueue->update($pq['id'],[
	//             		'qty'=>$pq['qty']-$q_quantity,
	//             		'amt'=>$pq['price']*($pq['qty']-$q_quantity)
	//             	]);


	//                 $q_quantity=$q_quantity-$pq['qty'];
	//             }  
	//         }else{
	//            break;
	//         }
    // 	}
        
    // }
}

function update_price_queue($invoice_id,$product_id,$quantity,$price,$amt,$old_qty,$c_rate,$type='inv'){
	// $PriceQueue=new PriceQueue;

	// $get_pq_row=$PriceQueue->where('invoice_id',$invoice_id)->where('product_id',$product_id)->where('type',$type)->first();
	// if ($get_pq_row) {
	// 	$currenty_quantity=$get_pq_row['qty'];
	// 	$old_quantity=$old_qty;
	// 	$new_quantity=$quantity;

	// 	$final_qty=$currenty_quantity-$old_quantity+$new_quantity;

	// 	$q_data=[ 
	// 		'qty'=>$final_qty,
	// 		'price'=>$price,
	// 		'amt'=>($final_qty*$c_rate)*$price,
	// 	];
	// 	$PriceQueue->update($get_pq_row['id'],$q_data);
	// }
	
}