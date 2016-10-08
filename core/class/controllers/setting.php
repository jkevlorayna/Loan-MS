<?php 
$slim_app->get('/setting/:id',function($id){
	$SettingRepo = new SettingRepository();
	$result = $SettingRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/setting/key/:key',function($id){
	$SettingRepo = new SettingRepository();
	$result = $SettingRepo->GetByKey($id);
	echo json_encode($result);
});
$slim_app->get('/setting',function(){
	$SettingRepo = new SettingRepository();
	$result =  $SettingRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/setting/:id',function($id){
	$SettingRepo = new SettingRepository();
	$SettingRepo->Delete($id);
});
$slim_app->post('/setting',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	$SettingRepo = new SettingRepository();
					
	$SettingRepo->Save($SettingRepo->Transform($POST));
});
?>