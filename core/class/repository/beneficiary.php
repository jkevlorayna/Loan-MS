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
		
		function Save($POST){
			global $conn;			
			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			
			
			$query->bindParam(':Name', !isset($POST->Name) ? '' : $POST->Name);
			$query->bindParam(':MemberId', !isset($POST->MemberId) ? '' : $POST->MemberId);
			$query->bindParam(':Relationship', !isset($POST->Relationship) ? '' : $POST->Relationship);
			$query->execute();	
		}
}


?>