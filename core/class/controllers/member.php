<?php 
$slim_app->get('/member/:id',function($id){
	$MemberRepo = new MemberRepository();
	$BeneficiaryRepo = new BeneficiaryRepository();
	$result = $MemberRepo->Get($id);
	$result->Beneficiary = 	$BeneficiaryRepo->DataList('',0,0,$result->Id)['Results'];
	echo json_encode($result);
});
$slim_app->get('/member/totalsaving/:id',function($id){
	$MemberRepo = new MemberRepository();
	$result = $MemberRepo->TotalSavings($id);
	echo json_encode($result);
});
$slim_app->get('/member/with-transaction/',function(){
	$MemberRepo = new MemberRepository();
	$TransactionRepo = new TransactionRepository();
	$result = $MemberRepo->ListWithTransaction($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['TransactionStatus']);
	foreach($result['Results'] as $row){
		$row->Loan = $TransactionRepo->TransactionByMemberId($row->Id);
	}
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
	 $TransactionRepo = new TransactionRepository();
	 $PaymentRepo = new PaymentRepository();
	 $BeneficiaryRepo = new BeneficiaryRepository();
	 
	 $MemberRepo->Delete($id);
	 $TransactionRepo->DeleteByMemberId($id);
	 $PaymentRepo->DeleteByMemberId($id);
	 $BeneficiaryRepo->DeleteByMemberId($id);
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
	
	$Member = $MemberRepo->SignUp($MemberRepo->Transform($POST));
	echo json_encode($Member);
	 if(isset($POST->Beneficiary)){
		foreach($POST->Beneficiary as $row){
			$row->MemberId = $Member->Id;
			$BeneficiaryRepo->Save($BeneficiaryRepo->Transform($row));
		}
	}
});
$slim_app->post('/member/changepassword',function(){
	$MemberRepo = new MemberRepository();
	 $MemberRepo->ChangePassword();
});
$slim_app->post('/member/upload/:Id',function($Id){
	$MemberRepo = new MemberRepository();
	$result = $MemberRepo->Get($Id);

		if ( !empty( $_FILES ) ) {
			foreach($_FILES as $row){
				$tempPath = $row[ 'tmp_name' ];
				$rd2 = mt_rand(1000, 9999);
				$filename = $rd2. "_" .$row[ 'name' ];
				$uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '../uploads/' . DIRECTORY_SEPARATOR . $filename;
				
				
				$result->ImageUrl = $filename;
				$MemberRepo->SignUp($result);
				$location = move_uploaded_file( $tempPath, $uploadPath );
				$answer = array( 'answer' => 'File transfer completed' );
				$json = json_encode( $answer );
			
				echo $json;
			}
		} else {
		
			echo 'No files';
		}
});
?>