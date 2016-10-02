<?php 
$slim_app->get('/member/:id',function($id){
	$MemberRepo = new MemberRepository();
	$result = $MemberRepo->Get($id);
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
	$MemberRepo = new MemberRepository();
	 $MemberRepo->SignUp();
});
$slim_app->post('/member/changepassword',function(){
	$MemberRepo = new MemberRepository();
	 $MemberRepo->ChangePassword();
});
?>