<?php 
class TransactionRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_transaction.Id AS Id FROM tbl_transaction
			LEFT JOIN tbl_member ON tbl_transaction.MemberId = tbl_member.Id
			WHERE tbl_transaction.Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function PaymentList($Cycle,$MemberId){
			global $conn;
			$where = "";
			$where .= "And Cycle = '$Cycle'";
			$where .= "And MemberId = '$MemberId'";
			$query = $conn->query("SELECT * FROM tbl_payment
			WHERE 1 = 1 $where");
			return $query->fetchAll(PDO::FETCH_OBJ);	
		}
		function GetByMemberId($id){
			global $conn;
			$where = "";
			$where = "AND MemberId = '$id'";

			$query = $conn->query("SELECT * FROM tbl_transaction WHERE 1 = 1 $where");
			$count = $query->rowcount();
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			return $data;	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_transaction  WHERE Id = '$id'");
			$query->execute();	
		}
		function DeleteByMemberId($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_transaction  WHERE MemberId = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize,$DateFrom,$DateTo,$CenterId){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
		
			$where = "";
			if($searchText != ''){
				$where .= "And (CONCAT(tbl_member.FirstName,' ',tbl_member.Middlename,' ',tbl_member.Lastname)  LIKE '%$searchText%')";
			}
			if($DateFrom != 'null' && $DateTo != 'null'){
				$where .= "And tbl_transaction.Date BETWEEN '$DateFrom' AND '$DateTo'";
			}
			if($CenterId != 0){
				$where .= "And tbl_member.CenterId  = '$CenterId'";
			}
				$where .= "And TransactionStatus  = 'Release'";
				
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_center.Name as Center,tbl_transaction.Id as Id FROM  tbl_transaction
			LEFT JOIN tbl_member ON tbl_transaction.MemberId = tbl_member.Id
			LEFT JOIN tbl_center ON tbl_member.CenterId = tbl_center.Id
			WHERE  1 = 1  $where 
			$limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_transaction")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_OBJ);
			$data['Count'] = $count;
			return $data;	
		}
		function TransactionByMemberId($MemberId){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_transaction WHERE MemberId = '$MemberId'");
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_transaction (MemberId,Amount,Date,CBU,MBA,WeeklyPayment,KAB,TransactionStatus,LoanStatus,Cycle) 
			VALUES(:MemberId,:Amount,:Date,:CBU,:MBA,:WeeklyPayment,:KAB,:TransactionStatus,:LoanStatus,:Cycle)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_transaction SET 
			MemberId = :MemberId , 
			Amount = :Amount ,
			Date = :Date,
			CBU = :CBU,
			MBA = :MBA,
			WeeklyPayment = :WeeklyPayment,
			KAB = :KAB,
			TransactionStatus = :TransactionStatus,
			LoanStatus = :LoanStatus,
			DateApproved = :DateApproved,
			DateReleased = :DateReleased,
			Cycle = :Cycle
			WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->MemberId = !isset($POST->MemberId) ? '' : $POST->MemberId; 
			$POST->Amount = !isset($POST->Amount) ? '' : $POST->Amount; 
			$POST->KAB = !isset($POST->KAB) ? '' : $POST->KAB; 
			$POST->CBU = !isset($POST->CBU) ? '' : $POST->CBU; 
			$POST->MBA = !isset($POST->MBA) ? '' : $POST->MBA; 
			$POST->WeeklyPayment = !isset($POST->WeeklyPayment) ? '' : $POST->WeeklyPayment; 
			$POST->TransactionStatus = !isset($POST->TransactionStatus) ? '' : $POST->TransactionStatus; 
			$POST->LoanStatus = !isset($POST->LoanStatus) ? '' : $POST->LoanStatus; 
			$POST->DateReleased = !isset($POST->DateReleased) ? '0000-00-00' : $POST->DateReleased; 
			$POST->DateApproved = !isset($POST->DateApproved) ? '0000-00-00' : $POST->DateApproved; 
			$POST->Cycle = !isset($POST->Cycle) ? 0 : $POST->Cycle;
			$POST->Date = date('Y-m-d'); 

			return $POST;
		}
		function Save($POST){
			global $conn;
			if($POST->Id == 0){
				$query = $this->Create();
			}else{
				$query = $this->UPDATE();
					if($POST->TransactionStatus == 'Approved'){
					$POST->DateApproved = date("Y-m-d");
					}
					if($POST->TransactionStatus == 'Release'){
						$POST->DateReleased = date("Y-m-d");
					}
				
				$query->bindParam(':Id', $POST->Id);
				$query->bindParam(':DateReleased', $POST->DateReleased);
				$query->bindParam(':DateApproved', $POST->DateApproved);
			}


			
			$query->bindParam(':MemberId', $POST->MemberId);
			$query->bindParam(':Amount', $POST->Amount);
			$query->bindParam(':Date', $POST->Date);
			$query->bindParam(':KAB', $POST->KAB);
			$query->bindParam(':CBU', $POST->CBU);
			$query->bindParam(':MBA', $POST->MBA);
			$query->bindParam(':WeeklyPayment', $POST->WeeklyPayment);
			$query->bindParam(':TransactionStatus', $POST->TransactionStatus);
			$query->bindParam(':LoanStatus', $POST->LoanStatus);
			$query->bindParam(':Cycle', $POST->Cycle);

			$query->execute();
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return $POST;			
		}
}


?>