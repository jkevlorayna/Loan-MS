app.controller('AppReportSOE', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting,svcCenter) {
	$scope.DateFrom = new Date();
	$scope.DateTo = new Date();
	$scope.loadCenter = function(){
		svcCenter.list('',0,0).then(function(r){
			$scope.centerList = r.Results;
		})
	}
	$scope.loadCenter();
	
	$scope.load = function(){
		var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
		var DateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");
			
		svcTransaction.List('',0,0,DateFrom,DateTo,$scope.CenterId).then(function(r){
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
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
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
	
		$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	

});
app.controller('AppReportBalance', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting,svcCenter) {
	$scope.DateFrom = new Date();
	$scope.DateTo = new Date();
	$scope.CenterId = 0;
	if($scope.CenterId == undefined){ $scope.CenterId = 0;}
	$scope.loadCenter = function(){
		svcCenter.list('',0,0).then(function(r){
			$scope.centerList = r.Results;
		})
	}
	$scope.loadCenter();
	
	$scope.load = function(){
		var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
		var DateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");
			
		svcTransaction.List('',0,0,DateFrom,DateTo,$scope.CenterId).then(function(r){
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
	
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	

});
app.controller('AppReportDTS', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting,svcPayment) {
	$scope.DateFrom = new Date();
	$scope.DateTo = new Date();
	$scope.KABTotal = 0;
	$scope.CBUTotal = 0;
	$scope.MBATotal = 0;
	$scope.CFTotal = 0;
	$scope.MFTotal = 0;
	$scope.LRFTotal = 0;
	$scope.GrandTotal = 0;
	
		
    $scope.load = function () {
			var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
			var Dateto = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");

			$scope.spinner.active = true;
			svcPayment.List(null,0,0,DateFrom,Dateto).then(function (r) {
				$scope.list = r.Results;
				$scope.list.map(function(value){
					$scope.KABTotal += parseFloat(value.KAB);
					$scope.CBUTotal += parseFloat(value.CBU);
					$scope.MBATotal += parseFloat(value.MBA);
					$scope.CFTotal += parseFloat(value.CF);
					$scope.LRFTotal += parseFloat(value.LRF);
					$scope.GrandTotal += parseFloat(value.Total);
				})
				$scope.count = r.Count;
				$scope.spinner.active = false;
			})
    }
    $scope.load();
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	

});
app.controller('AppReportMLIController', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting,svcPayment) {
	$scope.DateFrom = new Date();
	$scope.DateTo = new Date();
	$scope.KABTotal = 0;
	$scope.CBUTotal = 0;
	$scope.MBATotal = 0;
	$scope.CFTotal = 0;
	$scope.MFTotal = 0;
	$scope.LRFTotal = 0;
	$scope.GrandTotal = 0;
	
		
    $scope.load = function () {
			var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
			var Dateto = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");

			$scope.spinner.active = true;
			svcPayment.List(null,0,0,DateFrom,Dateto).then(function (r) {
				$scope.list = r.Results;
				$scope.list.map(function(value){
					$scope.KABTotal += parseFloat(value.KAB);
					$scope.CBUTotal += parseFloat(value.CBU);
					$scope.MBATotal += parseFloat(value.MBA);
					$scope.CFTotal += parseFloat(value.CF);
					$scope.LRFTotal += parseFloat(value.LRF);
					$scope.GrandTotal += parseFloat(value.Total);
				})
				$scope.count = r.Count;
				$scope.spinner.active = false;
			})
    }
    $scope.load();
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
});