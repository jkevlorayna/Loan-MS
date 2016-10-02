app.controller('AppCenterController', function ($scope, $http, $q, $location, $filter, svcCenter,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
		
		svcCenter.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	
	
	$scope.pageChanged = function () { $scope.load(); }
	

	
	$scope.formData = { }
	$scope.save = function () {
		svcCenter.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
			$scope.formData = { }
			$scope.load();
        });
    }
	
	$scope.getById = function (id) {
		svcCenter.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }

	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppCenterModalController',
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
app.controller('AppCenterModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcCenter,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcCenter.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	