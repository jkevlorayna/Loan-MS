<?php 
class PaymentRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_payment.Id as Id FROM tbl_payment  
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_payment.MemberId
			WHERE tbl_payment.Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function GetByMemberId($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_payment.Id as Id FROM tbl_payment  
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_payment.MemberId
			WHERE tbl_payment.MemberId = '$id'");
			return $query->fetchAll(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_payment  WHERE Id = '$id'");
			$query->execute();	
		}
		function DeleteByMemberId($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_payment  WHERE MemberId = '$id'");
			$query->execute();	
		}
		function GetMemberBalance($DateFrom,$DateTo,$MemberId){
			global $conn;
			$where = "";

			if($DateFrom != 'null' && $DateTo != 'null'){
				$where = "And tbl_transaction.Date BETWEEN '$DateFrom' AND '$DateTo'";
			}
				
			$where = "And MemberId = '$MemberId'";
			$query = $conn->query("SELECT (SUM(KAB)+SUM(CBU)+SUM(MBA)) AS Balance FROM  tbl_payment WHERE 1 = 1 $where");
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		function DataList($searchText,$pageNo,$pageSize,$DateFrom,$DateTo,$CenterId){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$where = "";
			if($searchText != ''){
				$where .= "And (CONCAT(tbl_member.FirstName,' ',tbl_member.Middlename,' ',tbl_member.Lastname)  LIKE '%$searchText%')";
			}
			if($DateFrom != 'null' && $DateTo != 'null'){
				$where .= "And Date BETWEEN '$DateFrom' AND '$DateTo'";
			}
			if($CenterId != ''){
				$where .= "And tbl_member.CenterId = '$CenterId'";
			}
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_payment.Id as Id FROM  tbl_payment
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_payment.MemberId
			WHERE 1 = 1 $where ORDER BY tbl_payment.Id Desc $limitCondition");
			$count = $searchText != '' || $searchText == null  ?  $query->rowcount() :  $conn->query("SELECT * FROM  tbl_payment")->rowcount();

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_payment (MemberId,Date,KAB,CBU,MBA,CF,Total,MF,LRF,Cycle) VALUES(:MemberId,:Date,:KAB,:CBU,:MBA,:CF,:Total,:MF,:LRF,:Cycle)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_payment SET MemberId = :MemberId  , Date = :Date , KAB = :KAB , CBU = :CBU , MBA = :MBA , CF = :CF , Total = :Total , MF = :MF , LRF = :LRF , Cycle = :Cycle WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->MemberId = !isset($POST->MemberId) ? '' : $POST->MemberId; 
			$POST->KAB = !isset($POST->KAB) ? '' : $POST->KAB; 
			$POST->CBU = !isset($POST->CBU) ? '' : $POST->CBU; 
			$POST->MBA = !isset($POST->MBA) ? '' : $POST->MBA; 
			$POST->CF = !isset($POST->CF) ? '' : $POST->CF; 
			$POST->MF = !isset($POST->MF) ? '' : $POST->MF; 
			$POST->LRF = !isset($POST->LRF) ? '' : $POST->LRF; 
			$POST->Cycle = !isset($POST->Cycle) ? '' : $POST->Cycle; 
			$POST->Total = !isset($POST->Total) ? '' : $POST->Total; 
			$POST->Date = date('Y-m-d'); 
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
			$query->bindParam(':MBA', $POST->MBA);
			$query->bindParam(':CF', $POST->CF);
			$query->bindParam(':Total', $POST->Total);
			$query->bindParam(':MF', $POST->MF);
			$query->bindParam(':LRF', $POST->LRF);
			$query->bindParam(':Cycle', $POST->Cycle);
			$query->bindParam(':Date', $POST->Date);
			
			
			$query->execute();
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return $POST;			
		}
}


?>