<?php 
class StatusRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_status  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_status  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_status WHERE status LIKE '%$searchText%' $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_status")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
				public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_status (status) VALUES(:status)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_status SET status = :status WHERE Id = :Id");
			return $query;	
		}
		
		function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			
			
			$query->bindParam(':status', !isset($POST->status) ? '' : $POST->status);
			$query->execute();	
		}
}


?>