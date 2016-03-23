var App = angular.module('app', []);

App.controller('AdressBookCtrl', ['$scope', '$http', function ($scope, $http) {

    var user;

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: {lat: -34.397, lng: 150.644}
    });

    var geocoder = new google.maps.Geocoder();

    var init = function () {
        $http.get('/contact/').then(
            function (data) {
                $scope.contacts = data.data;
            });

    };

    var geocodeAddress = function (geocoder, resultsMap, address) {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                resultsMap.setCenter(results[0].geometry.location);
                new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        })
    };

    $scope.delete = function (id) {
        $http.post('/contact/delete', {
            id: id
        }).then(function () {
                init()
            }
        );
    };

    $scope.search = function () {
        $http.get('/contact/find/' + $scope.value).then(
            function (data) {
                $scope.searchResult = data.data;
            }
        );
    };
    $scope.add = function (id) {
        $http.post('/contact/add', {
            id: id
        }).then(function (data) {
                console.log(data);
            init();
            }
        );
    };

    $scope.locate = function (adress) {
        geocodeAddress(geocoder, map, adress);
    };

    init()
}]);


App.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('||');
    $interpolateProvider.endSymbol('||');
});