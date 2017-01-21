app.controller('AppTransactionController', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting) {

		$scope.pageNo = 1;
		$scope.pageSize = 10;

	if($scope.searchText == undefined){ $scope.searchText = '';} 
		
    $scope.load = function () {
		$scope.NewDateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
		$scope.NewDateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");
		
		svcTransaction.List($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.NewDateFrom,$scope.NewDateTo,0,'').then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();

	$scope.pageChanged = function(){
		$scope.load();
	}
	
	
	
	$scope.ChangeStatusModal = function(size,Id,Status){
	
		var modal = $uibModal.open({
		templateUrl: 'views/transaction/changeStatus.html',
		controller: 'AppTransactionChangeStatusModalController',
		size: size,
		resolve: {
			dataId: function () {
				return Id;
			},
			Status: function(){
				return Status;
			}
		}
		});
		modal.result.then(function () { }, function () { 
			$scope.load();
		});

	};
	
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppTransactionModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
			});
	};

});
app.controller('AppTransactionModalController', function ($rootScope,$scope, $http, $q,  $filter, svcTransaction,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcTransaction.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppTransactionChangeStatusModalController', function (svcTransaction,svcStatus,$rootScope,$scope, $http, $q,  $filter, svcMember,growl,$uibModal,dataId,$uibModalInstance,Status) {
	$scope.Id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.Status = Status;
	
	$scope.loadStatus = function(){
		svcStatus.list('',0,0).then(function(r){
			$scope.StatusList = r.Results;
		})
	}
	$scope.loadStatus();
	
	
	$scope.getById = function(){
			svcTransaction.GetById($scope.Id).then(function(r){
				$scope.formData = r;
			})	
	}
	$scope.getById();
	
	$scope.Save = function(){
		svcTransaction.Save($scope.formData).then(function(r){
			growl.success("Data Successfully Saved");
			$uibModalInstance.dismiss();
		})
	}
		
	$scope.delete = function () {
		svcMember.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
app.controller('AppTransactionFormController', function ($rootScope,$scope, $http, $q, $location, svcMember,growl,$uibModal,svcTransaction,svcSetting,$stateParams ) {
	$scope.Id = $stateParams.Id;
	
			$scope.calculate = function(){
				$scope.amount = parseFloat($scope.formData.Amount);
				$scope.formData.KAB = (($scope.amount + ($scope.amount * 0.15)) / 23);
				$scope.totalPayablePerWeek = $scope.formData.KAB + $rootScope.CBU + $rootScope.MBA;
				$scope.formData.WeeklyPayment = $scope.totalPayablePerWeek;
			}
	

			
			if($scope.Id == 0){
				$scope.formData = {
					CBU:$scope.CBU,
					MBA:$scope.MBA,
					WeekPayable:32,
					TransactionStatus:'Pending',
					LoanStatus:'Active',
					Date:new Date()
					}
			}else{
				 
			
				$scope.getById = function(){
					svcTransaction.GetById($scope.Id).then(function(r){
						$scope.formData = r;
						$scope.formData.Date = new Date(r.Date);
						$scope.selected = r;
						$scope.calculate();	
					})
				}
				$scope.getById();
			} 
			

		
	
	$scope.selectCustomer = function(item){
		$scope.formData.MemberId = item.Id;
	}
	$scope.loadMember = function(){
			$scope.spinner.active = true;
		svcMember.list('',0,0).then(function(r){
			$scope.memberList = r.Results;
			$scope.spinner.active = false;
		})
	}
	$scope.loadMember();
	
	$scope.Save = function(){
			$scope.spinner.active = true;
		svcTransaction.Save($scope.formData).then(function(r){
			growl.success("Data Successfully Saved");
			$scope.spinner.active = false;
		})
	}
});
