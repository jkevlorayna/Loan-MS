<?php 
$slim_app->get('/member/:id',function($id){
	$MemberRepo = new MemberRepository();
	$BeneficiaryRepo = new BeneficiaryRepository();
	$result = $MemberRepo->Get($id);
	$result->Beneficiary = 	$BeneficiaryRepo->DataList('',0,0,$result->Id)['Results'];
	echo json_encode($result);
});
$slim_app->get('/member',function(){
	$MemberRepo = new MemberRepository();
	$TransactionRepo = new TransactionRepository();
	$result = $MemberRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	foreach($result['Results'] as $row){
		 
		$row->Loan = $TransactionRepo->TransactionByMemberId($row->Id);
	}

	 echo json_encode($result);
});
$slim_app->delete('/member/:id',function($id){
	$MemberRepo = new MemberRepository();
	 $MemberRepo->Delete($id);
});
$slim_app->post('/member',function(){
	$MemberRepo = new MemberRepository();
	 $MemberRepo->Save();
});
$slim_app->post('/signup',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$MemberRepo = new MemberRepository();
	$BeneficiaryRepo = new BeneficiaryRepository();
	
	$MemberRepo->SignUp($MemberRepo->Transform($POST));
	 if(isset($POST->Beneficiary)){
		foreach($POST->Beneficiary as $row){
			print_r($row);
			$BeneficiaryRepo->Save($row);
		}
	}
});
$slim_app->post('/member/changepassword',function(){
	$MemberRepo = new MemberRepository();
	 $MemberRepo->ChangePassword();
});
?>