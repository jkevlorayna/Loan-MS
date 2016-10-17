<?php $path = 'core/' ?> 
<?php 
session_start(); 
if(!isset($_SESSION['isAuthenticated'])){ $isAuthenticated = false; }else{ $isAuthenticated = true; }
?>
<?php include('core/header.php'); ?>
<body class="texture" ng-controller="AppMainController" ng-init="<?php echo $isAuthenticated; ?>">
<treasure-overlay-spinner active='spinner.active'>
	<div style="width:400px;" growl></div>
	  
<div id="cl-wrapper">

  <div class="cl-sidebar" ng-show="session.isAuthenticated">
    <div class="cl-toggle"><i class="fa fa-bars"></i></div>
    <div class="cl-navblock">
      <div class="menu-space">
        <div class="content">
          <ul class="cl-vnavigation">
			    <li><a href="#/"><i class="fa fa-home"></i> Home</a></li>
				<li>
					<a href="#"><i class="fa fa-folder"></i><span>Loan Application</span></a> 
					<ul class="sub-menu">						
						<li><a href="#/transaction/form/0"><i class="fa fa-edit"></i> Form</a></li>
						<li><a href="#/transaction/list"><i class="fa fa-file"></i> List</a></li>

					</ul>		
				</li>
				<li>
					<a href="#"><i class="fa fa-group"></i><span>Member</span></a> 
					<ul class="sub-menu">						
						<li><a href="#/member/list"><i class="fa fa-file"></i> List</a></li>
						<li><a href="#/member/form/0"><i class="fa fa-edit"></i> Form</a></li>
					</ul>		
				</li>
				<li>
					<a href="#"><i class="fa fa-money"></i><span>Payment</span></a> 
					<ul class="sub-menu">						
						<li><a href="#/member/payment/form/0"><i class="fa fa-edit"></i> Form</a></li>
						<li><a href="#/member/payment/list"><i class="fa fa-file"></i>List</a></li>
					</ul>		
				</li>
			    <li><a href="#/center"><i class="fa fa-building-o"></i> Center</a></li>
				<li><a href="#/user/list"><i class="fa fa-group"></i> User List</a></li>
				<li><a href="#/user/type"><i class="fa fa-group"></i>  User Type</a></li>
				<li><a href="#/status"><i class="fa fa-file"></i>  Loan Status</a></li>
				<li>
					<a href="#"><i class="fa fa-folder"></i><span>Reports</span></a> 
					<ul class="sub-menu">						
							<li><a href="#/report/dts">Daily Transaction Sheet</a></li>
							<li><a href="#/report/soe">Summary of Expenses</a></li>
							<li><a href="#/report/loanListing">Loan Listing</a></li>
							<li><a href="#/report/member">Member Report</a></li>
							<li><a href="#/report/balance">Balance Account</a></li>

					</ul>		
				</li>
				<li><a href="#/setting"><i class="fa fa-gears"></i>  Setting</a></li>
          </ul>
		  
		  
		  
        </div>
      </div>
    </div>
  </div>


	
		<div class="container-fluid" id="pcont">
				
				  <div id="head-nav" class="navbar navbar-default" ng-show="session.isAuthenticated">
    <div class="container-fluid">
      <div class="navbar-collapse">
        <ul class="nav navbar-nav navbar-right user-nav">	
          <li class="dropdown profile_menu">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
				<span>Welcome: {{session.userData.name}}</span> <b class="caret"></b>
			</a>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)" ng-click="passwordModal('md',session.userData.user_id,'Admin')"> Change Password</a></li>
			  <li class="divider"></li>
              <li><a href="javascript:void(0)" ng-click="logout()"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </li>
        </ul>	
			<h3>PAG-INUPDANAY, INCORPORATED</h3>
      </div>
    </div>
  </div>

				
				<div class="cl-mcont main_con" ng-class="{nopadding:!session.isAuthenticated}">
						<div ui-view></div>
				</div>
	</div> 
	
</div>
</treasure-overlay-spinner>

<?php include('core/script.php') ?>

</body>
</html>
