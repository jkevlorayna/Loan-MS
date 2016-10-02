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
		
		function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			$query  = $Id == 0 ? $this->Create() : $this->UPDATE() ;
				
		
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			$query->bindParam(':Name', !isset($POST->Name) ? '' : $POST->Name);
			$query->bindParam(':Address', !isset($POST->Address) ? '' : $POST->Address);
			
			$query->execute();	
		}
}
?>