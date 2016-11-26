<?php 
class BeneficiaryRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_beneficiary  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_OBJ);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_beneficiary  WHERE Id = '$id'");
			$query->execute();	
		}
		function DeleteByMemberId($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_beneficiary  WHERE MemberId = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize,$MemberId){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_beneficiary WHERE MemberId = '$MemberId'  $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_beneficiary")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			return $data;	
		}
				public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_beneficiary (Name,MemberId,Relationship) VALUES(:Name,:MemberId,:Relationship)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_beneficiary SET Name = :Name , MemberId = :MemberId , Relationship = :Relationship WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name; 
			$POST->MemberId = !isset($POST->MemberId) ? '' : $POST->MemberId; 
			$POST->Relationship = !isset($POST->Relationship) ? '' : $POST->Relationship; 


			return $POST;
		}
		function Save($POST){		
			global $conn;
			if($POST->Id == 0){
				$query = $this->Create();
			}else{
				$query = $this->UPDATE();
				$query->bindParam(':Id', $POST->Id);
			}
		
			$query->bindParam(':Name', $POST->Name);
			$query->bindParam(':MemberId', $POST->MemberId);
			$query->bindParam(':Relationship', $POST->Relationship);

			$query->execute();	
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return $POST;			
		}
}


?>