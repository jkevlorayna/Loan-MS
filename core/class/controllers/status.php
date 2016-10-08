<?php 
	$slim_app->get('/status/:id',function($id){
		$StatusRepo = new StatusRepository();
		$result = $StatusRepo->Get($id);
		echo json_encode($result);
	});
	$slim_app->get('/status',function(){
		$StatusRepo = new StatusRepository();
		$result = $StatusRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
		echo json_encode($result);
	});
	$slim_app->delete('/status/:id',function($id){
		$StatusRepo = new StatusRepository();
		$StatusRepo->Delete($id);
	});
	$slim_app->post('/status',function(){
		$request = \Slim\Slim::getInstance()->request();
		$POST = json_decode($request->getBody());
			
		$StatusRepo = new StatusRepository();
		$StatusRepo->Save($StatusRepo->Transform($POST));
	});
?>