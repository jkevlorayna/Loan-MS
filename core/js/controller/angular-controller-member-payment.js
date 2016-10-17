app.controller('AppPaymentListController', function ($scope, $http, $q, $location, svcMember,growl,$uibModal,svcPayment,svcSetting) {

		$scope.pageNo = 1;
		$scope.pageSize = 10;

		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
    $scope.load = function () {
			$scope.NewDateFrom = $scope.DateFrom == undefined ? null : moment($scope.DateFrom).format("YYYY-MM-DD");
			$scope.NewDateTo = $scope.DateTo == undefined ? null : moment($scope.DateTo).format("YYYY-MM-DD");

			$scope.spinner.active = true;
			svcPayment.List($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.NewDateFrom,$scope.NewDateTo).then(function (r) {
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

});
app.controller('AppPaymentFormController', function ($rootScope,$scope, $http, $q, $location, svcMember,growl,$uibModal,svcPayment,svcSetting,$stateParams ) {
	$scope.Id = $stateParams.Id;
			$q.all([svcSetting.getByKey('MBA')]).then(function(){
				
							if($scope.Id == 0){
				$scope.formData = { Date:new Date(), MBA : $scope.MBA }
				console.log($scope.formData);
			}else{
				$scope.getById = function(){
					svcPayment.GetById($scope.Id).then(function(r){
						$scope.formData = r;
						$scope.formData.Date = new Date(r.Date);
						$scope.selected = r;
						$scope.calculate();	
					})
				}
				$scope.getById();
			} 
				
			})
			$scope.calculate = function(){
				var KAB = $scope.formData.KAB == undefined ? 0 : parseFloat($scope.formData.KAB);
				var CBU = $scope.formData.CBU == undefined ? 0 : parseFloat($scope.formData.CBU);
				var CBA = $scope.formData.CBA == undefined ? 0 : parseFloat($scope.formData.CBA);
				var CF =  $scope.formData.CF == undefined ? 0 : parseFloat($scope.formData.CF);
				$scope.formData.Total = KAB + CBU + CBA + CF;
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
		svcPayment.Save($scope.formData).then(function(r){
			growl.success("Data Successfully Saved");
			$scope.spinner.active = false;
		})
	}
});
