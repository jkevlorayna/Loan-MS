<?php 
	$slim_app->get('/withdraw/:id',function($id){
		$WithDrawRepo = new WithDrawRepository();
		$result = $WithDrawRepo->Get($id);
		echo json_encode($result);
	});
	$slim_app->get('/withdraw',function(){
		$WithDrawRepo = new WithDrawRepository();
		$result = $WithDrawRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['DateFrom'],$_GET['DateTo']);
		echo json_encode($result);
	});
	$slim_app->delete('/withdraw/:id',function($id){
		$WithDrawRepo = new WithDrawRepository();
		$WithDrawRepo->Delete($id);
	});
	$slim_app->post('/withdraw',function(){
		$request = \slim\slim::getinstance()->request();
		$POST = json_decode($request->getbody());
			
		$WithDrawRepo = new WithDrawRepository();
		$WithDrawRepo->Save($WithDrawRepo->Transform($POST));
	});
?>