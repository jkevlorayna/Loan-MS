
app.controller('AppMemberController', function ($scope, $http, $q, $filter, svcMember,svcMemberType,growl,$uibModal,$stateParams ) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		$scope.type = $stateParams.type;
		if($scope.searchText == undefined){ $scope.searchText = '';} 
		
    $scope.load = function () {
		$scope.spinner.active = true;
		svcMember.list($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.type).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
			$scope.spinner.active = false;
        })
    }
    $scope.load();
	
		

	
	$scope.pageChanged = function () { $scope.load(); }
	
	
	$scope.formData = {}
	$scope.save = function () {
		$scope.spinner.active = true;
		svcMember.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Saved!")
			$scope.load();
			$scope.formData = {}
			$scope.spinner.active = false;
        });
    }
	
	$scope.getById = function (id) {
		svcMember.getById(id).then(function (r) {
				$scope.formData =  r
        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppMemberModalController',
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

	$scope.moveToModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/moveModal.html',
			controller: 'AppMemberMoveModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { 
				$scope.load();
			}, function () { 
				$scope.load();
			});
	};
	
		$scope.viewFullInfoModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/fullInfo.html',
			controller: 'AppMemberFullInfoModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { 
				$scope.load();
			}, function () { 
				$scope.load();
			});
	};
	
});
app.controller('AppMemberModalController', function ($rootScope,$scope, $http, $q,  $filter, svcMember,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcMember.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	

app.controller('AppMemberFullInfoModalController', function ($rootScope,$scope, $http, $q,  $filter, svcMember,svcMemberType,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.formData = {};
	$scope.getById = function(){
		svcMember.getById($scope.id).then(function(r){
			$scope.formData = r;
		})
	}
	$scope.getById();	
});	
app.controller('AppSignUpController', function ($scope, $http, $q, $filter, svcMember,growl,$stateParams) {

	$scope.save = function () {
		console.log($scope.formData);
			svcMember.signUp($scope.formData).then(function (r) {
			 growl.success('Data Successfully Saved');
        });
    }
});


app.controller('AppMemberFormController', function ($scope, $http, $q, $filter, svcMember,growl,svcCourse,svcCourseYear,svcSection,$stateParams,svcCenter) {
	$scope.Id = $stateParams.Id;
	$scope.type = $stateParams.type;
		
	$scope.loadCenter = function(){
		svcCenter.list('',0,0).then(function(r){
			$scope.centerList = r.Results;	
		})
	}	
	$scope.loadCenter();
	
	$scope.save = function () {
		svcMember.signUp($scope.formData).then(function (r) {
			growl.success('Data Successfully Saved');
        },function(){
			growl.error('Ops Something Went Wrong');
		});
    }
	

	$scope.getById = function(){
		svcMember.getById($scope.Id).then(function (r) {
			$scope.formData = r;
			
        });
	}
	
	$scope.formData = $scope.Id == 0 ? { MemberTypeId:$scope.type } : $scope.getById() ;
});
