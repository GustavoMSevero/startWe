app.controller("listaStartupsCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/startWe/api/admin/startup.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/startWe/api/admin/startup.php?option=';
	} else {
		var urlPrefix = 'api/startup.php';
		var urlOptionPrefix = 'api/startup.php?option=';
	}

	var getAllStartups = function(){
        var option = 'get all startups';

        $http.get(urlOptionPrefix + option).then(function(response){
            //console.log(response.data)
            $scope.listaStartups = response.data;
        })

    }
    getAllStartups();

    $scope.deleteStartup = function(ls){
        var option = 'delete startup';
        var idstartup = ls;

        $http.delete(urlOptionPrefix + option + '&idstartup=' + idstartup).then(function(response){
            //console.log(response.data)
            getAllStartups();
        })

    }
	
}]);