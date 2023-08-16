app.controller("minhasNotificacoesCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/notifications.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/notifications.php?option=';
	} else {
		var urlPrefix = 'api/notifications.php';
		var urlOptionPrefix = 'api/notifications.php?option=';
	}

	var getNotifications = function(){
		var option = 'pegar notificacoes'

		$http.get(urlOptionPrefix + option + '&idusuario=' + $scope.idusuario).then(function(response){
			console.log(response.data)
			$scope.notificacoes = response.data;
		})
	}
	getNotifications();
	
}]);