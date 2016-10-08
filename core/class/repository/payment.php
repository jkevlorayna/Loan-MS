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
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_payment.Id as Id FROM  tbl_payment
			LEFT JOIN tbl_member ON tbl_member.Id = tbl_payment.MemberId
			WHERE MemberId LIKE '%$searchText%' $limitCondition");
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
		
		function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$Id = !isset($POST->Id) ? 0 : $POST->Id;
			
			$Id == 0 ? $query = $this->Create() : $query = $this->UPDATE() ;
			if($Id != 0){ $query->bindParam(':Id', $Id); }
			
			
			$query->bindParam(':MemberId', !isset($POST->MemberId) ? '' : $POST->MemberId);
			$query->bindParam(':KAB', !isset($POST->KAB) ? '' : $POST->KAB);
			$query->bindParam(':CBU', !isset($POST->CBU) ? '' : $POST->CBU);
			$query->bindParam(':CBA', !isset($POST->CBA) ? '' : $POST->CBA);
			$query->bindParam(':CF', !isset($POST->CF) ? '' : $POST->CF);
			$query->bindParam(':Total', !isset($POST->Total) ? '' : $POST->Total);
			$query->bindParam(':Date', date('Y-m-d'));
			
			
			$query->execute();	
		}
}


?>