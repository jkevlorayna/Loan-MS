app.controller('AppReportSOE', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting) {
	$scope.DateFrom = new Date();
	$scope.DateTo = new Date();
	
	$scope.load = function(){
		var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
		var DateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");
			
		svcTransaction.List('',0,0,null,null).then(function(r){
			$scope.list = r.Results;
			$scope.AmountBorrowedTotal = 0;
			$scope.BalanceTotal = 0;
			angular.forEach(r.Results,function(row,index){
				$scope.AmountBorrowedTotal += parseFloat(row.Amount);
				if(row.Payment != false){
					$scope.BalanceTotal += parseFloat(row.Payment.Balance);
				}
			})
		})
	}
	$scope.load();
	

});
app.controller('AppReportLoanListing', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting) {
	$scope.DateFrom = new Date();
	$scope.DateTo = new Date();
	
	$scope.load = function(){
		var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
		var DateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");
			
		svcTransaction.List('',0,0,DateFrom,DateTo).then(function(r){
			$scope.list = r.Results;
			$scope.AmountBorrowedTotal = 0;
			$scope.BalanceTotal = 0;
			angular.forEach(r.Results,function(row,index){
				$scope.AmountBorrowedTotal += parseFloat(row.Amount);
				if(row.Payment != false){
					$scope.BalanceTotal += parseFloat(row.Payment.Balance);
				}
			})
		})
	}
	$scope.load();
	

});
