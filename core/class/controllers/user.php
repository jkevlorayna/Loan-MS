<?php 
// user
$slim_app->get('/user/:id',function($id){
	$UserRepo = new UserRepository();
	$result = $UserRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/user',function(){
	$UserRepo = new UserRepository();
	$result = $UserRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/user/:id',function($id){
	$UserRepo = new UserRepository();
	$UserRepo->Delete($id);
});
$slim_app->post('/user',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	$UserRepo = new UserRepository();
	
	$UserRepo->Save($UserRepo->Transform($POST));
});

// user type
$slim_app->get('/userType/:id',function($id){
	$UserTypeRepo = new UserTypeRepository();
	$result = $UserTypeRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/userType',function(){
	$UserTypeRepo = new UserTypeRepository();
	$result = $UserTypeRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/userType/:id',function($id){
	 $UserTypeRepo = new UserTypeRepository();
	$UserTypeRepo->Delete($id);
});
$slim_app->post('/userType',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$UserTypeRepo = new UserTypeRepository();
	$UserTypeRepo->Save($UserTypeRepo->Transform($POST));
});

// user role
$slim_app->get('/roles',function(){
	$UserRoleRepo = new UserRoleRepository();
	$result =  $UserRoleRepo->RoleList();
	echo json_encode($result);
});
$slim_app->get('/userRole',function(){
	$UserRoleRepo = new UserRoleRepository();
	$result = $UserRoleRepo->DataList();
	echo json_encode($result);
});
$slim_app->get('/userRole/:id',function($id){
	$UserRoleRepo = new UserRoleRepository();
	$result =  $UserRoleRepo->Get($id);
	echo json_encode($result);
});
$slim_app->delete('/userRole/:id',function($id){
	$UserRoleRepo = new UserRoleRepository();
	$UserRoleRepo->Delete($id);
});
$slim_app->post('/userRole',function(){
	$UserId = $_GET['UserId'];
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$UserRoleRepo = new UserRoleRepository();
	$UserRoleRepo->DeleteByUserId($UserId);
	foreach($POST as $row){	
		$row->UserId = $UserId;	
		$UserRoleRepo->Save($UserRoleRepo->Transform($row));
	}
	

});


?>