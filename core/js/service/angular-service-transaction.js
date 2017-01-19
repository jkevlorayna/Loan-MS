app.factory('svcTransaction', function ($rootScope, $http, $q) {
    $this = {
        List: function (searchText,pageNo,pageSize,DateFrom,DateTo,CenterId,Status) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/transaction?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize+'&DateFrom='+DateFrom+'&DateTo='+DateTo+'&CenterId='+CenterId+'&Status='+Status
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		PaymentDetails: function (Cycle,MemberId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/transaction/payment-list/'+Cycle+'/'+MemberId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		GetById: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/transaction/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },GetByMemberId: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/transaction/member/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		Delete: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/transaction/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,Save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/transaction',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
    return $this;
});