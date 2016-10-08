<?php 
class SettingRepository{
		public function GetByKey($key){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_setting  WHERE settingKey = '$key'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_setting  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_setting  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_setting  $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_setting")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_setting (title,settingKey,value) VALUES(:title,:settingKey,:value)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_setting SET title = :title , settingKey = :settingKey , value = :value WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->title = !isset($POST->title) ? '' : $POST->title; 
			$POST->settingKey = !isset($POST->settingKey) ? '' : $POST->settingKey; 
			$POST->value = !isset($POST->value) ? '' : $POST->value; 
			return $POST;
		}
		public function Save($POST){
			global $conn;
			if($POST->Id == 0){
				$query = $this->Create();
			}else{
				$query = $this->UPDATE();
				$query->bindParam(':Id', $POST->Id);
			}
			
			$query->bindParam(':title',$POST->title);
			$query->bindParam(':settingKey',$POST->settingKey);
			$query->bindParam(':value',$POST->value);
			$query->execute();	
			
			
		}
}

?>