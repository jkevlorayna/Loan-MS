var MainFolder = 'sams';
var MainFolder = 'sams';
var BasePath = 'core';
var app = angular.module('app', ['ui.router','ui.bootstrap','ngSanitize', 'ui.select','angular-growl','ngCookies','ngAnimate','checklist-model','treasure-overlay-spinner']);
app.run(function ($rootScope, $location,$cookieStore,$window,svcLogin) {
   var cookieCheck = $cookieStore.get('credentials');
   


    $rootScope.$on("$stateChangeStart",function() { 
   		svcLogin.auth().then(function (r) {
			if(r == "false"){ 
				$location.path("/login");
			}
		});
    });
   


});
app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise("/login")
    $stateProvider
	    .state('home',
        {
            url: '/',
            templateUrl: "views/home.html",
            controller: "",
        })
        .state('login',
        {
            url: '/login',
            templateUrl: "views/login.html",
            controller: "AppLoginController",
        })
		
		// member
			.state('member',
			{
				url: '/member',
				templateUrl: "views/member/index.html",
				controller: "",
			})
			.state('member.list',
			{
				url: '/list',
				templateUrl: "views/member/list.html",
				controller: "AppMemberController",
			})
			.state('member.form',
			{
				url: '/form/:Id',
				templateUrl: "views/member/form.html",
				controller: "AppMemberFormController",
			})
			.state('member.type',
			{
				url: '/type',
				templateUrl: "views/member/type.html",
				controller: "AppMemberTypeController",
			})
			// payment 
						.state('member.payment',
						{
							url: '/payment/list',
							templateUrl: "views/member/payment/list.html",
							controller: "AppPaymentListController",
						})
						.state('member.paymentForm',
						{
							url: '/payment/form/:Id',
							templateUrl: "views/member/payment/form.html",
							controller: "AppPaymentFormController",
						})
			// end payment
		// end member
		
		//user 
			.state('user',
			{
				url: '/user',
				templateUrl: "views/user/index.html",
				controller: "",
			})
			.state('user.list',
			{
				url: '/list',
				templateUrl: "views/user/list.html",
				controller: "AppUserController",
			})
			.state('user.type',
			{
				url: '/type',
				templateUrl: "views/user/type.html",
				controller: "AppUserTypeController",
			})
			.state('user.roles',
			{
				url: '/roles/:UserId',
				templateUrl: "views/user/roles.html",
				controller: "AppUserRoleController",
			})
		// end user

		.state('userType',
        {
            url: '/usertype',
            templateUrl: "views/user_type.html",
            controller: "AppUserTypeController",
        })


		.state('status',
		{
			url: '/status',
			templateUrl: "views/status.html",
			controller: "AppStatusController",
		})
		.state('center',
		{
			url: '/center',
			templateUrl: "views/center.html",
			controller: "AppCenterController",
		})
		
		.state('setting',
		{
			url: '/setting',
			templateUrl: "views/setting.html",
			controller: "AppSettingController",
		})
		// transaction
		.state('transaction',
		{
			url: '/transaction',
			templateUrl: "views/transaction/index.html",
			controller: "",
		})
		.state('transaction.list',
		{
			url: '/list',
			templateUrl: "views/transaction/list.html",
			controller: "AppTransactionController",
		})
		.state('transaction.form',
		{
			url: '/form/:Id',
			templateUrl: "views/transaction/form.html",
			controller: "AppTransactionFormController",
		})
		
		// report
		.state('report',
		{
			url: '/report',
			templateUrl: "views/report/index.html",
			controller: "",
		})
		.state('report.dts',
		{
			url: '/dts',
			templateUrl: "views/report/dts.html",
			controller: "AppReportDTS",
		})
		.state('report.soe',
		{
			url: '/soe',
			templateUrl: "views/report/soe.html",
			controller: "AppReportSOE",
		})
		.state('report.loanListing',
		{
			url: '/loanListing',
			templateUrl: "views/report/loanListing.html",
			controller: "AppReportLoanListing",
		})	
		.state('report.member',
		{
			url: '/member',
			templateUrl: "views/report/member.html",
			controller: "AppMemberController",
		})	
		.state('report.balance',
		{
			url: '/balance',
			templateUrl: "views/report/balance.html",
			controller: "AppReportBalance",
		})		
		.state('report.mli',
		{
			url: '/mli',
			templateUrl: "views/report/mli.html",
			controller: "AppReportMLIController",
		})			
		// end report
		
		// withdraw 
					.state('withdraw',
					{
						url: '/withdraw',
						templateUrl: "views/withdraw/index.html",
						controller: "",
					})
					.state('withdraw.list',
					{
						url: '/list',
						templateUrl: "views/withdraw/list.html",
						controller: "AppWithdrawListController",
					})
					.state('withdraw.form',
					{
						url: '/form/:Id',
						templateUrl: "views/withdraw/form.html",
						controller: "AppWithdrawFormController",
					})
		// end withdraw
}]);
app.config(['growlProvider', function(growlProvider) {
  growlProvider.globalTimeToLive(5000);
  growlProvider.globalDisableCountDown(true);
}]);