app.controller('AppPaymentListController', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcPayment,svcSetting) {

		$scope.pageNo = 1;
		$scope.pageSize = 10;

		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
    $scope.load = function () {
			$scope.NewDateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
			$scope.NewDateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");

			$scope.spinner.active = true;
			svcPayment.List($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.NewDateFrom,$scope.NewDateTo,'').then(function (r) {
				$scope.list = r.Results;
				$scope.count = r.Count;
				$scope.spinner.active = false;
			})
    }
    $scope.load();

	$scope.ChangeStatusModal = function(size,Id){
	
		var modal = $uibModal.open({
		templateUrl: 'views/transaction/changeStatus.html',
		controller: 'AppTransactionChangeStatusModalController',
		size: size,
		resolve: {
			dataId: function () {
				return Id;
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
			controller: 'AppPaymentModalController',
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
app.controller('AppPaymentModalController', function ($rootScope,$scope, $http, $q,  $filter, svcPayment,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcPayment.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppPaymentFormController', function ($rootScope,$scope, $http, $q, $location, svcMember,growl,$uibModal,svcPayment,svcSetting,$stateParams ) {
	$scope.Id = $stateParams.Id;
	$scope.member = { selected:''}
			$q.all([svcSetting.getByKey('MBA')]).then(function(){
				
							if($scope.Id == 0){
				$scope.formData = { Date:new Date(), MBA : $scope.MBA }
				console.log($scope.formData);
			}else{
				$scope.getById = function(){
					svcPayment.GetById($scope.Id).then(function(r){
						$scope.formData = r;
						$scope.formData.Date = new Date(r.Date);
						$scope.member.selected = r;
						$scope.calculate();	
					})
				}
				$scope.getById();
			} 
				
			})
			$scope.calculate = function(){
				var KAB = $scope.formData.KAB == undefined ? 0 : parseFloat($scope.formData.KAB);
				var CBU = $scope.formData.CBU == undefined ? 0 : parseFloat($scope.formData.CBU);
				var MBA = $scope.formData.MBA == undefined ? 0 : parseFloat($scope.formData.MBA);
				var CF =  $scope.formData.CF == undefined ? 0 : parseFloat($scope.formData.CF);
				var MF =  $scope.formData.MF == undefined ? 0 : parseFloat($scope.formData.MF);
				var LRF =  $scope.formData.LRF == undefined ? 0 : parseFloat($scope.formData.LRF);
				$scope.formData.Total = KAB + CBU + MBA + CF + MF + LRF;
			}
	

			

			

		
	
	$scope.selectCustomer = function(item){
		$scope.formData.MemberId = item.Id;
		$scope.formData.Cycle = item.Cycle;
		$scope.member.selected = item;
	}
	$scope.loadMember = function(){
		svcMember.listWithTransaction('',0,0,'Release').then(function(r){
			$scope.memberList = r.Results;
		})
	}
	$scope.loadMember();
	
	$scope.Save = function(){
		svcPayment.Save($scope.formData).then(function(r){
			growl.success("Data Successfully Saved");
		})
	}
});
