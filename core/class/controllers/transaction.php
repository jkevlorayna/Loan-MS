<?php 
	$slim_app->get('/transaction/:id',function($id){
		$TransactionRepo = new TransactionRepository();
		$result = $TransactionRepo->Get($id);
		echo json_encode($result);
	});
	$slim_app->get('/transaction',function(){
		$TransactionRepo = new TransactionRepository();
		$result = $TransactionRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['DateFrom'],$_GET['DateTo']);
		echo json_encode($result);
	});
	$slim_app->delete('/transaction/:id',function($id){
		$TransactionRepo = new TransactionRepository();
		$TransactionRepo->Delete($id);
	});
	$slim_app->post('/transaction',function(){
		$request = \Slim\Slim::getInstance()->request();
		$POST = json_decode($request->getBody());
			
		$TransactionRepo = new TransactionRepository();
		$TransactionRepo->Save($TransactionRepo->Transform($POST));
	});
?>