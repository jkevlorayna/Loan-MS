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
		<img src="core/images/logo.png" class="sidebarLogo">
          <ul class="cl-vnavigation">
			    <li><a href="#/"><i class="fa fa-home"></i> Home</a></li>
				<li ng-if="checkRole('Loan Application','AllowAdd') || checkRole('Loan Application','AllowView')">
					<a href="#"><i class="fa fa-folder"></i><span>Loan Application</span></a> 
					<ul class="sub-menu">						
						<li ng-if="checkRole('Loan Application','AllowAdd')"><a href="#/transaction/form/0"><i class="fa fa-edit"></i> Form</a></li>
						<li ng-if="checkRole('Loan Application','AllowView')"><a href="#/transaction/list"><i class="fa fa-file"></i> List</a></li>
					</ul>		
				</li>
				<li ng-if="checkRole('Member','AllowAdd') || checkRole('Member','AllowView')">
					<a href="#"><i class="fa fa-group"></i><span>Member</span></a> 
					<ul class="sub-menu">						
						<li ng-if="checkRole('Member','AllowView')"><a href="#/member/list"><i class="fa fa-file"></i> List</a></li>
						<li ng-if="checkRole('Member','AllowAdd')"><a href="#/member/form/0"><i class="fa fa-edit"></i> Form</a></li>
					</ul>		
				</li>
				<li ng-if="checkRole('Payment','AllowAdd') || checkRole('Payment','AllowView')">
					<a href="#"><i class="fa fa-money"></i><span>Payment</span></a> 
					<ul class="sub-menu">						
						<li ng-if="checkRole('Payment','AllowAdd')"><a href="#/member/payment/form/0"><i class="fa fa-edit"></i> Form</a></li>
						<li ng-if="checkRole('Payment','AllowView')"><a href="#/member/payment/list"><i class="fa fa-file"></i>List</a></li>
					</ul>		
				</li>
				<li ng-if="checkRole('WithDraw','AllowAdd') || checkRole('WithDraw','AllowView')">
					<a href="#"><i class="fa fa-money"></i><span>WithDraw</span></a> 
					<ul class="sub-menu">						
						<li ng-if="checkRole('WithDraw','AllowAdd')"><a href="#/withdraw/form/0"><i class="fa fa-edit"></i> Form</a></li>
						<li ng-if="checkRole('WithDraw','AllowView')"><a href="#/withdraw/list"><i class="fa fa-file"></i>List</a></li>
					</ul>		
				</li>
			    <li ng-if="checkRole('Center','AllowView')"><a href="#/center"><i class="fa fa-building-o"></i> Center</a></li>
				<li ng-if="checkRole('User List','AllowView')"><a href="#/user/list"><i class="fa fa-group"></i> User List</a></li>
				<li ng-if="checkRole('User Type','AllowView')"><a href="#/user/type"><i class="fa fa-group"></i>  User Type</a></li>
				<li ng-if="checkRole('Loan Status','AllowView')"><a href="#/status"><i class="fa fa-file"></i>  Loan Status</a></li>
				<li ng-if="checkRole('Reports','AllowView')">
					<a href="#"><i class="fa fa-folder"></i><span>Reports</span></a> 
					<ul class="sub-menu">						
							<li><a href="#/report/dts">Daily Transaction Sheet</a></li>
							<li><a href="#/report/soe">Summary of Expenses</a></li>
							<li><a href="#/report/loanListing">Loan Listing</a></li>
							<li><a href="#/report/member">Member Report</a></li>
							<li><a href="#/report/balance">Balance Account</a></li>
							<li><a href="#/report/mli">MLI</a></li>

					</ul>		
				</li>
				<li ng-if="checkRole('Setting','AllowView')"><a href="#/setting"><i class="fa fa-gears"></i>  Setting</a></li>
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
