app.controller('AppReportLoanListing', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting) {

	$scope.loadMember = function(){
		svcMember.list('',0,0).then(function(r){
			$scope.memberList = r.Results;
		})
	}
	$scope.loadMember();
	

});
