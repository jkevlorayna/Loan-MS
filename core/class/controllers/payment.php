<?php 
	$slim_app->get('/payment/:id',function($id){
		$PaymentRepo = new PaymentRepository();
		$result = $PaymentRepo->Get($id);
		echo json_encode($result);
	});
	$slim_app->get('/payment',function(){
		$PaymentRepo = new PaymentRepository();
		$result = $PaymentRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['DateFrom'],$_GET['DateTo']);
		echo json_encode($result);
	});
	$slim_app->delete('/payment/:id',function($id){
		$PaymentRepo = new PaymentRepository();
		$PaymentRepo->Delete($id);
	});
	$slim_app->post('/payment',function(){
		$request = \Slim\Slim::getInstance()->request();
		$POST = json_decode($request->getBody());
			
		$PaymentRepo = new PaymentRepository();
		$PaymentRepo->Save($PaymentRepo->Transform($POST));
	});
?>