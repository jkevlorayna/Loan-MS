app.controller('AppWithdrawListController', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcWithdraw,svcSetting) {

		$scope.pageNo = 1;
		$scope.pageSize = 10;

		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
    $scope.load = function () {
			$scope.NewDateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
			$scope.NewDateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");

			$scope.spinner.active = true;
			svcWithdraw.List($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.NewDateFrom,$scope.NewDateTo).then(function (r) {
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
			controller: 'AppWithdrawModalController',
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
app.controller('AppWithdrawModalController', function ($rootScope,$scope, $http, $q,  $filter, svcWithdraw,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcWithdraw.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppWithdrawFormController', function ($rootScope,$scope, $http, $q, $location, svcMember,growl,$uibModal,svcWithdraw,svcSetting,$stateParams ) {
	$scope.Id = $stateParams.Id;
	$scope.member = { selected:''}	
				
			if($scope.Id == 0){
				$scope.formData = { Date:new Date() , Amount:'' }

			}else{
				$scope.getById = function(){
					svcWithdraw.GetById($scope.Id).then(function(r){
						
						$scope.formData = r;
						$scope.formData.Date = new Date(r.Date);
						$scope.member.selected = r;
					})
				}
				$scope.getById();
			} 
				
	

			

			

		
	
	$scope.SelectMember = function(item){
		$scope.formData.MemberId = item.Id;
		svcMember.TotalSaving($scope.formData.MemberId).then(function(r){
			$scope.formData.RemainingSaving = r.TotalSavings;
		})
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
		svcWithdraw.Save($scope.formData).then(function(r){
			growl.success("Data Successfully Saved");
			$scope.spinner.active = false;
			$scope.formData = {};
			$scope.member = { selected:''}	
			// $location.path('/withdraw/list')
		})
	}
});
