<?php 
	$slim_app->get('/payment/:id',function($id){
		$PaymentRepo = new PaymentRepository();
		$result = $PaymentRepo->Get($id);
		echo json_encode($result);
	});
	$slim_app->get('/payment',function(){
		$PaymentRepo = new PaymentRepository();
		$result = $PaymentRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
		echo json_encode($result);
	});
	$slim_app->delete('/payment/:id',function($id){
		$PaymentRepo = new PaymentRepository();
		$PaymentRepo->Delete($id);
	});
	$slim_app->post('/payment',function(){
		$PaymentRepo = new PaymentRepository();
		$PaymentRepo->Save();
	});
?>