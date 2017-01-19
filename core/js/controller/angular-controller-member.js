
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

	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print-landscape.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
	$scope.ChangePicture = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/changePicture.html',
			controller: 'AppChangePictureModalController',
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

app.controller('AppMemberReportController', function ($scope, $http, $q, $filter, svcMember,svcMemberType,growl,$uibModal,$stateParams ) {

    $scope.load = function () {
		svcMember.list('',0,0, $stateParams.type).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
	}
   
    $scope.load();
		$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print-landscape.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 

	
});



app.controller('AppChangePictureModalController', function ($rootScope,$scope, $http, $q,  $filter, svcMember,growl,$uibModal,dataId,$uibModalInstance) {
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
	
	$scope.fileData = new FormData();
    $scope.getTheFiles = function (files) {
        angular.forEach(files, function (value, key) {
            $scope.fileData.append(key, value);
        });
    };
		$scope.save = function () {
		svcMember.signUp($scope.formData).then(function (r) { 
				console.log(r);
				svcMember.Upload($scope.fileData,r.Id).then(function(r){
					$scope.close();
				})
        },function(){
			growl.error('Ops Something Went Wrong');
		});
    }


	
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

app.controller('AppMemberFormController', function ($scope, $http, $q,$uibModal,$filter, svcMember,growl,svcCourse,svcCourseYear,svcSection,$stateParams,svcCenter,svcTransaction,svcPayment) {
	$scope.Id = $stateParams.Id;
	$scope.type = $stateParams.type;
	$scope.loadCenter = function(){
		svcCenter.list('',0,0).then(function(r){
			$scope.centerList = r.Results;	
		})
	}	
	$scope.loadCenter();
	$scope.pageTitle = $scope.Id == 0 ? 'Create New Member' : 'Update Member Data';
	
	$scope.fileData = new FormData();
    $scope.getTheFiles = function (files) {
        angular.forEach(files, function (value, key) {
            $scope.fileData.append(key, value);
        });
    };
	
	$scope.save = function () {
		$scope.spinner.active = true;
		svcMember.signUp($scope.formData).then(function (r) {
			growl.success('Data Successfully Saved');
				svcMember.Upload($scope.fileData,r.Id).then(function(r){
					// $location.path('/member/list/'+$scope.type);
				})
			$scope.spinner.active = false;
        },function(){
			growl.error('Ops Something Went Wrong');
		});
    }
	



		$scope.calculateAge = function calculateAge() { // birthday is a date
			if($scope.formData.BirthDate != undefined){
				var ageDifMs = Date.now() - $scope.formData.BirthDate.getTime();
				var ageDate = new Date(ageDifMs); // miliseconds from epoch
				$scope.formData.Age =  Math.abs(ageDate.getUTCFullYear() - 1970);
			}
		}
		
		
	$scope.getById = function(){
		svcMember.getById($scope.Id).then(function (r) {
			$scope.formData = r;
			$scope.formData.BirthDate = new Date(r.BirthDate);
        });
	}
	$scope.loadTransactionList = function(){
		svcTransaction.GetByMemberId($scope.Id).then(function (r) {
			$scope.transactionList = r.Results;
        });
	}
	$scope.loadTransactionList();
	
	
	$scope.loadPayment = function(){
		$scope.SavingTotal = 0;
		svcPayment.GetByMemberId($scope.Id).then(function(r){
			$scope.paymentList = r;
			angular.forEach(r,function(row,index){
				$scope.SavingTotal += parseFloat(row.CBU);
			})
			
		})
	}
	$scope.loadPayment();
	
	$scope.addBeneficiary = function(){
		$scope.formData.Beneficiary.push({Name:'',MemberId:$scope.Id,Relationship:''})
	}
	
		$scope.OpenPaymentDetails = function (size,Cycle,MemberId,TransactionId) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/transactionDetails.html',
			controller: 'AppTransactionPaymentController',
			size: size,
			resolve: {
				Cycle: function () {
					return Cycle;
				},
				MemberId:function(){
					return MemberId;
				},
				TransactionId:function(){
					return TransactionId;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.getById() 
			});
	};

	
	
				$scope.OpenPromisoryNote = function (size,MemberId,TransactionId) {
			var modal = $uibModal.open({
			templateUrl: 'views/member/promisoryNote.html',
			controller: 'AppPromisoryNoteController',
			size: size,
			resolve: {
				MemberId:function(){
					return MemberId;
				},
				TransactionId:function(){
					return TransactionId;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.getById() 
			});
				}
	
	$scope.formData = $scope.Id == 0 ? { Beneficiary:[] } : $scope.getById() ;
});


app.controller('AppTransactionPaymentController', function (svcMember,$scope, $http, $q, $filter,growl,$uibModal,$stateParams,Cycle,MemberId,svcTransaction,$uibModalInstance,TransactionId) {
	$scope.TotalTotal = 0;
	svcTransaction.GetById(TransactionId).then(function(r){
		$scope.Transaction = r;
	})
	
	svcMember.getById(MemberId).then(function(r){
		$scope.formData = r;
	})
	$scope.Cycle = Cycle;

	svcTransaction.PaymentDetails(Cycle,MemberId).then(function(r){
		$scope.list = r;
		angular.forEach($scope.list,function(row){
			$scope.TotalTotal += parseFloat(row.Total);
		})
	})
	
	$scope.close = function(){
			$uibModalInstance.dismiss();
	}
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
});


app.controller('AppPromisoryNoteController', function (svcMember,$scope, $http, $q, $filter,growl,$uibModal,$stateParams,MemberId,svcTransaction,$uibModalInstance,TransactionId) {
	svcTransaction.GetById(TransactionId).then(function(r){
		$scope.Transaction = r;
		$scope.Total = parseFloat($scope.Transaction.KAB) + parseFloat($scope.Transaction.CBU) + parseFloat($scope.Transaction.MBA);
	})
	svcMember.getById(MemberId).then(function(r){
		$scope.formData = r;
	})



	
	$scope.close = function(){
			$uibModalInstance.dismiss();
	}
	
	$scope.printDiv = function(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var popupWin = window.open('', '_blank', 'width=700,height=700');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="core/css/print.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
		popupWin.document.close();
	} 
	
});
