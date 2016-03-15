var App = angular.module('app',[]);

App.controller('AdressBookCtrl', ['$scope','$http', function($scope, $http) {
console.log(user);
    $http.get('http://127.0.0.1:8000/contact/'+ user).then(
        function successCallback(data){
            $scope.contacts = data.data.contacts;
        }
    );

    $scope.getDetails= function(id){
        $http.get('http://localhost:8000/user/'+ id).then(
            function successCallback(data){
                console.log(data);
                $scope.userDetail = data.data;
            }
        );
    };

    $scope.delete = function(id){
        $http.post('/contact/delete', {
            id : id,
            me: user
        });
    };

    $scope.search = function(){
        $http.get('http://localhost:8000/contact/find/'+ $scope.value).then(
            function successCallback(data){
                $scope.searchResult = data.data;
            }
        );
    }
}]);


App.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('||');
    $interpolateProvider.endSymbol('||');
});