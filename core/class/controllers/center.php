<?php 
	$slim_app->get('/center/:id',function($id){
		$CenterRepo = new CenterRepository();
		$result = $CenterRepo->Get($id);
		echo json_encode($result);
	});
	$slim_app->get('/center',function(){
		$CenterRepo = new CenterRepository();
		$result = $CenterRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
		echo json_encode($result);
	});
	$slim_app->delete('/center/:id',function($id){
		$CenterRepo = new CenterRepository();
		$CenterRepo->Delete($id);
	});
	$slim_app->post('/center',function(){
		$request = \slim\slim::getinstance()->request();
		$POST = json_decode($request->getbody());
			
		$CenterRepo = new CenterRepository();
		$CenterRepo->Save($CenterRepo->Transform($POST));
	});
?>