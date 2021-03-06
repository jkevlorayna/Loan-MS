﻿app.controller('AppReportSOE', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting,svcCenter) {
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
			
		svcTransaction.List('',0,0,DateFrom,DateTo,$scope.CenterId,'Release').then(function(r){
			$scope.list = r.Results;
			$scope.AmountBorrowedTotal = 0;
			angular.forEach(r.Results,function(row,index){
				$scope.AmountBorrowedTotal += parseFloat(row.Amount);
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
			
		svcTransaction.List('',0,0,DateFrom,DateTo,0,'Release').then(function(r){
			$scope.list = r.Results;
			$scope.AmountBorrowedTotal = 0;
			$scope.RemainingBalanceTotal = 0;
			angular.forEach(r.Results,function(row,index){
				$scope.AmountBorrowedTotal += parseFloat(row.Amount);
				$scope.RemainingBalanceTotal += parseFloat(row.RemainingBalance);
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
			
		svcTransaction.List('',0,0,DateFrom,DateTo,$scope.CenterId,'Release').then(function(r){
			$scope.list = r.Results;
			$scope.AmountBorrowedTotal = 0;
			$scope.RemainingBalanceTotal = 0;
			angular.forEach(r.Results,function(row,index){
				$scope.AmountBorrowedTotal += parseFloat(row.Amount);
				$scope.RemainingBalanceTotal += parseFloat(row.RemainingBalance);
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
app.controller('AppReportDTS', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting,svcPayment,svcCenter) {
	$scope.DateFrom = new Date();
	$scope.DateTo = new Date();

	if($scope.CenterId == undefined){$scope.CenterId = '';}
	$scope.loadCenter = function(){
		svcCenter.list('',0,0).then(function(r){
			$scope.centerList = r.Results;
		})
	}
	$scope.loadCenter();
	
		
    $scope.load = function () {
			$scope.KABTotal = 0;
			$scope.CBUTotal = 0;
			$scope.MBATotal = 0;
			$scope.CFTotal = 0;
			$scope.MFTotal = 0;
			$scope.LRFTotal = 0;
			$scope.GrandTotal = 0;
	
			var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
			var Dateto = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");

			svcPayment.List('',0,0,DateFrom,Dateto,$scope.CenterId).then(function (r) {
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

	
		
    $scope.load = function () {
			$scope.KABTotal = 0;
			$scope.CBUTotal = 0;
			$scope.MBATotal = 0;
			$scope.CFTotal = 0;
			$scope.MFTotal = 0;
			$scope.LRFTotal = 0;
			$scope.GrandTotal = 0;
	
			var DateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
			var Dateto = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");

			$scope.spinner.active = true;
			svcPayment.List('',0,0,DateFrom,Dateto,'').then(function (r) {
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