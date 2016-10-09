<?php 
class UserRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user  WHERE user_id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		 public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_user WHERE user_id = '$id'");
			$query->execute();	
		}
		 public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$query = $conn->query("SELECT * FROM  tbl_user 
			LEFT JOIN tbl_user_type ON tbl_user.UserTypeId =  tbl_user_type.Id
			WHERE name LIKE '%$searchText%' AND UserTypeId != 0 LIMIT $pageNo,$pageSize  ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_user")->rowcount() ;
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_user (name,username,password,UserTypeId,status) VALUES(:name,:username,:password,:UserTypeId,:status)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_user SET name = :name , status = :status , username = :username , password = :password , UserTypeId = :UserTypeId  WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->name = !isset($POST->name) ? '' : $POST->name; 
			$POST->status = !isset($POST->status) ? '' : $POST->status; 
			$POST->username = !isset($POST->username) ? '' : $POST->username; 
			$POST->password = !isset($POST->password) ? '' : $POST->password; 
			$POST->UserTypeId = !isset($POST->UserTypeId) ? '' : $POST->UserTypeId; 
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
			
			$query->bindParam(':name',$POST->name);
			$query->bindParam(':status',$POST->status);
			$query->bindParam(':username',$POST->username);
			$query->bindParam(':password',$POST->password);
			$query->bindParam(':UserTypeId',$POST->UserTypeId);
			$query->execute();	
		}
}

class UserTypeRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user_type  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_user_type  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize ){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			$query = $conn->query("SELECT * FROM  tbl_user_type  LIMIT $pageNo,$pageSize  ");
			if($searchText != ''){
				$count = $query->rowcount();
			}else{
				$count = $conn->query("SELECT * FROM  tbl_user_type")->rowcount();
			}
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_user_type (user_type) VALUES(:user_type)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_user_type SET user_type = :user_type  WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->user_type = !isset($POST->user_type) ? '' : $POST->user_type; 
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
			
			$query->bindParam(':user_type',$POST->user_type);
			$query->execute();	
		}
}


	
class UserRoleRepository{		
		public function RoleList(){
			global $conn;
			$query = $conn->query("SELECT * FROM  tbl_roles");
			$count = $query->rowcount();

			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user_roles  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_user_roles  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DeleteByUserId($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM tbl_user_roles WHERE UserId = ?");
			$query->execute(array($id));
		}

		public function DataList(){
			global $conn;
			$UserId = $_GET['UserId'];
			$query = $conn->query("SELECT tbl_user_roles.RoleId As Id,tbl_roles.role FROM  tbl_user_roles
			LEFT JOIN tbl_roles ON tbl_user_roles.RoleId = tbl_roles.Id
			WHERE UserId = '$UserId'
			");
			$count = $query->rowcount();

			$query1 = $conn->query("SELECT * FROM  tbl_roles");
			
			$data = array();
			$data['Roles'] = $query1->fetchAll(PDO::FETCH_ASSOC);
			$data['UserRole'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_user_roles (UserId,RoleId) VALUES(:UserId,:RoleId)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_user_roles SET UserId = :UserId , RoleId = :RoleId  WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->UserId = !isset($POST->UserId) ? '' : $POST->UserId; 
			$POST->RoleId = !isset($POST->Id) ? '' : $POST->Id; 
			return $POST;
		}
		
		public function Save($POST){
			global $conn;
			
			$query = $this->Create();

			$query->bindParam(':UserId',$POST->UserId);
			$query->bindParam(':RoleId',$POST->RoleId);
			$query->execute();	
		}
}		
$GLOBALS['UserRoleRepo'] = new UserRoleRepository();	
?>