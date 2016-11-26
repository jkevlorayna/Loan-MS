<?php 
class WithDrawRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_withdraw
			LEFT JOIN tbl_member On tbl_member.Id = tbl_withdraw.MemberId
			WHERE tbl_withdraw.Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_withdraw  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize,$DateFrom,$DateTo){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			$where = "";
			if($searchText != ''){
				$where = "And (CONCAT(tbl_member.FirstName,' ',tbl_member.Middlename,' ',tbl_member.Lastname)  LIKE '%$searchText%')";
			}
			if($DateFrom != 'null' && $DateTo != 'null'){
				$where = "And Date BETWEEN '$DateFrom' AND '$DateTo'";
			}
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_withdraw.Id as Id FROM  tbl_withdraw
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_withdraw.MemberId
			WHERE 1 = 1 $where   $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_withdraw")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_withdraw (Date,MemberId,Amount) VALUES(:Date,:MemberId,:Amount)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_withdraw SET Date = :Date , MemberId = :MemberId , Amount = :Amount WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Date = !isset($POST->Date) ? '0000-00-00' : $POST->Date; 
			$POST->MemberId = !isset($POST->MemberId) ? '' : $POST->MemberId; 
			$POST->Amount = !isset($POST->Amount) ? '' : $POST->Amount; 
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

			$query->bindParam(':Date',$POST->Date);
			$query->bindParam(':MemberId',$POST->MemberId);
			$query->bindParam(':Amount',$POST->Amount);
			$query->execute();	
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return $POST;				
		}
}
?>