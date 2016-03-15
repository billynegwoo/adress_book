var App = angular.module('app',[]);

App.controller('AdressBookCtrl', ['$scope','$http', function($scope, $http) {

    $http.get('http://127.0.0.1:8000/contact/'+ user).then(
        function successCallback(data){
            $scope.contacts = data.data.contacts;
        }
    );

    $scope.details = function(id){
        $http.get('http://127.0.0.1:8000/user/'+ id).then(
            function successCallback(data){
                console.log(data);
                $scope.userDetail = data;
            }
        );
    }
}]);


App.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('||');
    $interpolateProvider.endSymbol('||');
});