app.controller("painelAdminCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

    // $scope.idusuario = localStorage.getItem("startwe_idusuario");
    // $scope.usuario = localStorage.getItem("startwe_usuario");
    // console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/startWe/api/admin/painel-admin.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/startWe/api/admin/painel-admin.php?option=';
	} else {
		var urlPrefix = 'api/registerStartup.php';
		var urlOptionPrefix = 'api/registerStartup.php?option=';
	}

	var getAllUsers = function(){
        var option = 'get all users';
        $http.get(urlOptionPrefix + option).then(function(response){
            //console.log(response.data)
            $scope.quantidadeUsusarios = response.data.userQuantity;
        })
    }
    getAllUsers();

    var getStartups = function(){
        var option = 'get startups';
        $http.get(urlOptionPrefix + option).then(function(response){
            //console.log(response.data)
            $scope.quantidadeStartups = response.data.startupsQuantity;
        })
    }
    getStartups();

    var getNotifications = function(){
        var option = 'get notifications';
        $http.get(urlOptionPrefix + option).then(function(response){
            //console.log(response.data)
            $scope.notificationsQuantity = response.data.notificationsQuantity;
        })
    }
    getNotifications();
	
}]);