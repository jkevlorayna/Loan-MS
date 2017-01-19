<?php 
	$slim_app->get('/transaction/:id',function($id){
		$TransactionRepo = new TransactionRepository();
		$result = $TransactionRepo->Get($id);
		echo json_encode($result);
	});
	$slim_app->get('/transaction/member/:id',function($id){
		$TransactionRepo = new TransactionRepository();
		$result = $TransactionRepo->GetByMemberId($id);
		echo json_encode($result);
	});
	$slim_app->get('/transaction/payment-list/:Cycle/:MemberId',function($Cycle,$MemberId){
		$TransactionRepo = new TransactionRepository();
		$result = $TransactionRepo->PaymentList($Cycle,$MemberId);
		echo json_encode($result);
	});
	$slim_app->get('/transaction',function(){
		$TransactionRepo = new TransactionRepository();
		$PaymentRepo = new PaymentRepository();
		
		$result = $TransactionRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['DateFrom'],$_GET['DateTo'],$_GET['CenterId'],$_GET['Status']);
		
		foreach($result['Results'] as $row){
			$row->Amount =  (float) $row->Amount;
			$row->RemainingBalance = (float) $row->Amount - (float) $PaymentRepo->GetMemberBalance($_GET['DateFrom'],$_GET['DateTo'],$row->MemberId)->Balance;
		}
		
		echo json_encode($result);
	});
	$slim_app->delete('/transaction/:id',function($id){
		$TransactionRepo = new TransactionRepository();
		$TransactionRepo->Delete($id);
	});
	$slim_app->post('/transaction',function(){
		$request = \Slim\Slim::getInstance()->request();
		$TransactionRepo = new TransactionRepository();
		
		$POST = json_decode($request->getBody());
		$POST = $TransactionRepo->Transform($POST);
		if($POST->Id == 0){
			$POST->Cycle = $TransactionRepo->GetByMemberId($POST->MemberId)['Count'] + 1;	
		}
		
		
		$TransactionRepo->Save($POST);
	});
?>