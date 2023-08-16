app.controller("perfilStartupCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/registerStartup.php';
	} else {
		var urlPrefix = '';
	}

	$scope.cadastrarPerfilStartup = function(perfilStartup){
		perfilStartup.option = 'cadastro startup';
		perfilStartup.idusuario = $scope.idusuario;
		//console.log(perfilStartup)
		$http.post(urlPrefix, perfilStartup).then(function(response){
			//console.log(response.data)
			$location.path('/feed')	
		})

	}

	
}]);