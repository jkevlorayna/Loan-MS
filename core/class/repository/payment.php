<?php 
class PaymentRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_payment.Id as Id FROM tbl_payment  
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_payment.MemberId
			WHERE tbl_payment.Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_payment  WHERE Id = '$id'");
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
				$where = "And tbl_transaction.Date BETWEEN '$DateFrom' AND '$DateTo'";
			}
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_payment.Id as Id FROM  tbl_payment
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_payment.MemberId
			WHERE 1 = 1 $where ORDER BY tbl_payment.Id Desc $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_payment")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_payment (MemberId,Date,KAB,CBU,CBA,CF,Total) VALUES(:MemberId,:Date,:KAB,:CBU,:CBA,:CF,:Total)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_payment SET MemberId = :MemberId  , Date = :Date , KAB = :KAB , CBU = :CBU , CBA = :CBA , CF = :CF , Total = :Total WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->MemberId = !isset($POST->MemberId) ? '' : $POST->MemberId; 
			$POST->KAB = !isset($POST->KAB) ? '' : $POST->KAB; 
			$POST->CBU = !isset($POST->CBU) ? '' : $POST->CBU; 
			$POST->CBA = !isset($POST->CBA) ? '' : $POST->CBA; 
			$POST->CF = !isset($POST->CF) ? '' : $POST->CF; 
			$POST->Total = !isset($POST->Total) ? '' : $POST->Total; 
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
			
			$query->bindParam(':MemberId', $POST->MemberId);
			$query->bindParam(':KAB', $POST->KAB);
			$query->bindParam(':CBU', $POST->CBU);
			$query->bindParam(':CBA', $POST->CBA);
			$query->bindParam(':CF', $POST->CF);
			$query->bindParam(':Total', $POST->Total);
			$query->bindParam(':Date', date('Y-m-d'));
			
			
			$query->execute();	
		}
}


?>