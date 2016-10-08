<?php 
class CenterRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_center  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_center  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_center WHERE Name LIKE '%$searchText%' ORDER BY Name Desc $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_center")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
				public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_center (Name,Address) VALUES(:Name,:Address)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_center SET Name = :Name , Address = :Address WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name; 
			$POST->Address = !isset($POST->Address) ? '' : $POST->Address; 
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
			
			$query->bindParam(':Name',$POST->Name);
			$query->bindParam(':Address',$POST->Address);
			$query->execute();	
		}
}
?>