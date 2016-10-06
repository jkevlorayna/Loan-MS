<?php 
class TransactionRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT *,tbl_transaction.Id AS Id FROM tbl_transaction
			LEFT JOIN tbl_member ON tbl_transaction.MemberId = tbl_member.Id
			WHERE tbl_transaction.Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_transaction  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_transaction.Id as Id FROM  tbl_transaction
			LEFT JOIN tbl_member ON tbl_transaction.MemberId = tbl_member.Id
			$limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_transaction")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
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
			$query = $conn->prepare("INSERT INTO tbl_transaction (MemberId,Amount,Date,CBU,MBA,WeeklyPayment,KAB,TransactionStatus,LoanStatus) 
			VALUES(:MemberId,:Amount,:Date,:CBU,:MBA,:WeeklyPayment,:KAB,:TransactionStatus,LoanStatus)");
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
			LoanStatus = :LoanStatus
			WHERE Id = :Id");
			return $query;	
		}
		
		function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			
			
			$query->bindParam(':MemberId', !isset($POST->MemberId) ? '' : $POST->MemberId);
			$query->bindParam(':Amount', !isset($POST->Amount) ? '' : $POST->Amount);
			$query->bindParam(':Date', date('Y-m-d'));
			$query->bindParam(':KAB', !isset($POST->KAB) ? '' : $POST->KAB);
			$query->bindParam(':CBU', !isset($POST->CBU) ? '' : $POST->CBU);
			$query->bindParam(':MBA', !isset($POST->MBA) ? '' : $POST->MBA);
			$query->bindParam(':WeeklyPayment', !isset($POST->WeeklyPayment) ? '' : $POST->WeeklyPayment);
			$query->bindParam(':TransactionStatus', !isset($POST->TransactionStatus) ? '' : $POST->TransactionStatus);
			$query->bindParam(':LoanStatus', !isset($POST->LoanStatus) ? '' : $POST->LoanStatus);
			$query->execute();	
		}
}


?>