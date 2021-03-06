<?php 
class MemberRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_center.Name as Center,tbl_member.Address as Address,tbl_member.Id As Id FROM tbl_member 
			LEFT JOIN tbl_center on tbl_center.Id = tbl_member.CenterId
			WHERE tbl_member.Id = '$id'");
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		function TotalSavings($id){
			global $conn;
			$query = $conn->query("
			Select TotalSavings - TableB.TotalWithDraw as TotalSavings,TotalSavings as TotalSavingNoWindraw from (SELECT MemberId,SUM(CBU) as TotalSavings FROM tbl_payment  
			WHERE MemberId = '$id') TableA
			LEFT JOIN        
			(SELECT SUM(Amount) as TotalWithDraw,MemberId FROM tbl_withdraw  
			WHERE MemberId = '$id') TableB On TableB.MemberId = TableA.MemberId");
			$row = $query->fetch(PDO::FETCH_OBJ);	
			if($row->TotalSavings == ''){
				 $row->TotalSavings = $row->TotalSavingNoWindraw;
			}
			return $row;
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_member  WHERE Id = '$id'");
			$query->execute();	
		}
		public function ListWithTransaction($searchText,$pageNo,$pageSize,$TransactionStatus){
			global $conn;
			$where = "";
			if($searchText != ''){
				$where .= "And (firstname  LIKE '%$searchText%' OR middlename  LIKE '%$searchText%' OR lastname  LIKE '%$searchText%')";
			}
				$where .= "And tbl_transaction.TransactionStatus = '$TransactionStatus'";
	
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$query = $conn->query("SELECT *,tbl_member.Id As Id,tbl_center.Name As CenterName FROM  tbl_member
			LEFT JOIN tbl_transaction On tbl_member.Id = tbl_transaction.MemberId
			LEFT JOIN tbl_center On tbl_member.CenterId = tbl_center.Id
			WHERE 1 = 1 $where $limitCondition ");
			$count = $query->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			
			return $data;	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$where = "";
			if($searchText != ''){
				$where = "And (firstname  LIKE '%$searchText%' OR middlename  LIKE '%$searchText%' OR lastname  LIKE '%$searchText%')";
			}

	
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$query = $conn->query("SELECT *,tbl_member.Id As Id,tbl_center.Name As CenterName FROM  tbl_member
			LEFT JOIN tbl_center On tbl_member.CenterId = tbl_center.Id
			WHERE 1 = 1 $where $limitCondition ");
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
					  (Firstname,Lastname,Middlename,Gender,Address,MobileNo,Email,DateRegistered,Status,Age,Business,CenterId,BirthDate,ImageUrl,MarriedTo) 
				VALUES(:Firstname,:Lastname,:Middlename,:Gender,:Address,:MobileNo,:Email,:DateRegistered,:Status,:Age,:Business,:CenterId,:BirthDate,:ImageUrl,:MarriedTo)
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
					   Status = :Status,
					   BirthDate = :BirthDate,
					   ImageUrl = :ImageUrl,
					   MarriedTo = :MarriedTo
					   WHERE Id = :Id
				");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Firstname = !isset($POST->Firstname) ? '' : $POST->Firstname; 
			$POST->Lastname = !isset($POST->Lastname) ? '' : $POST->Lastname; 
			$POST->Middlename = !isset($POST->Middlename) ? '' : $POST->Middlename; 
			$POST->Gender = !isset($POST->Gender) ? '' : $POST->Gender; 
			$POST->Address = !isset($POST->Address) ? '' : $POST->Address; 
			$POST->MobileNo = !isset($POST->MobileNo) ? '' : $POST->MobileNo; 
			$POST->Email = !isset($POST->Email) ? '' : $POST->Email; 
			$POST->Age = !isset($POST->Age) ? '' : $POST->Age; 
			$POST->Business = !isset($POST->Business) ? '' : $POST->Business; 
			$POST->CenterId = !isset($POST->CenterId) ? '' : $POST->CenterId; 
			$POST->Status = !isset($POST->Status) ? '' : $POST->Status; 
			$POST->BirthDate = !isset($POST->BirthDate) ? '0000-00-00' : $POST->BirthDate; 
			$POST->ImageUrl = !isset($POST->ImageUrl) ? '' : $POST->ImageUrl; 
			$POST->MarriedTo = !isset($POST->MarriedTo) ? '' : $POST->MarriedTo; 
			$POST->Date = date('Y-m-d'); 

			return $POST;
		}
		public function Save($POST ){
			global $conn;
			if($POST->Id == 0){
				$query = $this->Create();
				$query->bindParam(':DateRegistered', $POST->Date);
			}else{
				$query = $this->UPDATE();
				$query->bindParam(':Id', $POST->Id);
			}
		
			$query->bindParam(':Firstname', $POST->Firstname);
			$query->bindParam(':Lastname', $POST->Lastname);
			$query->bindParam(':Middlename', $POST->Middlename);
			$query->bindParam(':Gender', $POST->Gender);
			$query->bindParam(':Address', $POST->Address );
			$query->bindParam(':MobileNo',$POST->MobileNo );
			$query->bindParam(':Email', $POST->Email );
			$query->bindParam(':Status', $POST->Status );
			$query->bindParam(':Age', $POST->Age );
			$query->bindParam(':Business', $POST->Business );
			$query->bindParam(':CenterId', $POST->CenterId );
			$query->bindParam(':Status', $POST->Status );
			$query->bindParam(':BirthDate', $POST->BirthDate );
			$query->bindParam(':ImageUrl', $POST->ImageUrl );
			$query->bindParam(':MarriedTo', $POST->MarriedTo );
			
			$query->execute();	
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }	
			return $POST;
		}
		public function SignUp($POST){
			return $this->Save($POST);		
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