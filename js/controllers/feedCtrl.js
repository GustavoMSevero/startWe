app.controller("feedCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/registerStartup.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/registerStartup.php?option=';
		var urlOptionPhotoPrefix = 'http://localhost:8880/web/startWe/api/perfilUsers.php?option=';
		var urlOptionNotificationsPrefix = 'http://localhost:8880/web/startWe/api/notifications.php?option=';
	} else {
		var urlPrefix = 'api/registerStartup.php';
		var urlOptionPrefix = 'api/registerStartup.php?option=';
		var urlOptionPhotoPrefix = 'api/perfilUsers.php?option=';
		var urlOptionNotificationsPrefix = 'api/notifications.php?option=';
	}

	var numberNotifications = function(){
		var option = 'numero notificacoes';
		$http.get(urlOptionNotificationsPrefix + option + '&idusuario=' + $scope.idusuario).then(function(response){
			//console.log(response.data)
			$scope.quantidadeNotificacoes = response.data.quantity;
		})
	}
	numberNotifications();

	var showPhotoUser = function(){
		var opcao = 'mostrar foto';
	
		$http.get(urlOptionPhotoPrefix + opcao + '&idusuario='+ $scope.idusuario).success(function(response){
			console.log(response)
			$scope.imagem = response.imagem;
		})
	}
	showPhotoUser();
	
	var exibirStartups = function(){
		var option = 'exibir startups';
		
		$http.get(urlOptionPrefix + option).then(function(response){
			console.log(response.data)
			$scope.startups = response.data;
		})

	}
	exibirStartups();

	$scope.sair = function(){
        localStorage.removeItem("startwe_idusuario");
        localStorage.removeItem("startwe_usuario");
	}
	
}]);