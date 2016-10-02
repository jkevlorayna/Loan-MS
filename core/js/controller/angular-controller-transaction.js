app.controller('AppTransactionFormController', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting) {
	$scope.loadKey = function(){
		$q.all([svcSetting.getByKey('CBU'),svcSetting.getByKey('MBA'),svcSetting.getByKey('LRF'),svcSetting.getByKey('CF'),svcSetting.getByKey('MF'),svcSetting.getByKey('KAB')]).then(function(r){
			$scope.CBU =  parseFloat(r[0].value);
			$scope.MBA =  parseFloat(r[1].value);
			$scope.LRF =  parseFloat(r[2].value);
			$scope.CF =  parseFloat(r[3].value);
			$scope.MF =  parseFloat(r[4].value);
			$scope.KAB =  parseFloat(r[5].value);
			$scope.formData = {CBU:$scope.CBU,MBA:$scope.MBA,WeekPayable:32}
	
			$scope.calculate = function(){
				$scope.amount = parseFloat($scope.formData.Amount);
				$scope.payableWeekly = (($scope.amount + ($scope.amount * 0.15)) / 23);
				$scope.totalPayablePerWeek = $scope.payableWeekly + $scope.CBU + $scope.MBA;
				$scope.totalPayableUponLoan = $scope.payableWeekly + $scope.CBU + $scope.MBA + $scope.LRF + $scope.CF + $scope.MF + $scope.KAB;
			}
		
		})
	}

	$scope.loadKey();
	

	
	
	
	$scope.selectCustomer = function(item){
		$scope.formData.MemberId = item.Id;
	}
	$scope.loadMember = function(){
		svcMember.list('',0,0).then(function(r){
			$scope.memberList = r.Results;
		})
	}
	$scope.loadMember();
	
	$scope.Save = function(){
		svcTransaction.Save($scope.formData).then(function(r){
			growl.success("Data Successfully Saved");
		})
	}
});
