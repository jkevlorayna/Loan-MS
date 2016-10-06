<?php 
class MemberRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_member  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
	
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$query = $conn->query("SELECT *,tbl_member.Id As Id,tbl_center.Name As CenterName FROM  tbl_member
			LEFT JOIN tbl_center On tbl_member.CenterId = tbl_center.Id
			WHERE FirstName LIKE '%$searchText%' $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_member")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("
				INSERT INTO 
					   tbl_member 
					  (Firstname,Lastname,Middlename,Gender,Address,MobileNo,Email,DateRegistered,Status,Age,Business,CenterId) 
				VALUES(:Firstname,:Lastname,:Middlename,:Gender,:Address,:MobileNo,:Email,:DateRegistered,:Status,:Age,:Business,:CenterId)
				");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("
				UPDATE
					   tbl_member SET
					   Firstname = :Firstname,
					   Lastname = :Lastname,
					   middlename = :Middlename,
					   Gender = :Gender,
					   Address = :Address,
					   MobileNo = :MobileNo,
					   Email = :Email,
					   Status = :Status,
					   Age = :Age,
					   Business = :Business,
					   CenterId = :CenterId,
					   Status = :Status
					   WHERE Id = :Id
				");
			return $query;	
		}
		public function Save($POST ){
			global $conn;

			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
		
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			$query->bindParam(':Firstname', $POST->Firstname);
			$query->bindParam(':Lastname', $POST->Lastname);
			$query->bindParam(':Middlename', $POST->Middlename);
			$query->bindParam(':Gender', $POST->Gender);
			$query->bindParam(':Address', !isset($POST->Address) ? '' : $POST->Address );
			$query->bindParam(':MobileNo', !isset($POST->MobileNo) ? '' : $POST->MobileNo );
			$query->bindParam(':Email', !isset($POST->Email) ? '' : $POST->Email );
			$query->bindParam(':Status', !isset($POST->Status) ? '' : $POST->Status );
			$query->bindParam(':Age', !isset($POST->Age) ? '' : $POST->Age );
			$query->bindParam(':Business', !isset($POST->Business) ? '' : $POST->Business );
			$query->bindParam(':CenterId', !isset($POST->CenterId) ? '' : $POST->CenterId );
			$query->bindParam(':Status', !isset($POST->Status) ? '' : $POST->Status );
			
		
			if($Id == 0){ $query->bindParam(':DateRegistered', date('Y-m-d')); }
			
			
			$query->execute();	
			
		}
		public function SignUp($POST){
			$this->Save($POST);		
		}
		public function ChangePassword(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
	
			$Id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$cpassword =  $POST->cpassword;
			$newpassword =  $POST->newpassword;
			
			$count = $conn->query("SELECT * FROM tbl_member WHERE  password = '$cpassword' AND Id = '$Id' ")->rowcount();

			if($count > 0){
				$query = $conn->prepare("UPDATE tbl_member SET password = ? WHERE Id = ? ");
				$query->execute(array($newpassword,$Id));
			}else{
				 return 'cpFalse';
			}
			
		}
}
?>