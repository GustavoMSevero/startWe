app.controller("responderCtrl", ['$scope', '$http', '$window', '$location', '$routeParams', function ($scope, $http, $window, $location, $routeParams) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");

    $scope.idusuarioInteressado = $routeParams.idusuarioInteressado;
    $scope.idusuarioNotificado = $routeParams.idusuarioNotificado;

    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)
    console.log(`idusuarioInteressado ${$scope.idusuarioInteressado}, idusuarioNotificado ${$scope.idusuarioNotificado}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/notifications.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/notifications.php?option=';
	} else {
		var urlPrefix = 'api/notifications.php';
		var urlOptionPrefix = 'api/notifications.php?option=';
	}

    var getMessageFromUserInterested = function(){
        var option = 'pegar mensagem do usuário interessado';
        var idusuarioInteressado = $scope.idusuarioInteressado;
        var idusuarioNotificado = $scope.idusuarioNotificado;
        $http.get(urlOptionPrefix + option + '&idusuarioInteressado=' + idusuarioInteressado + '&idusuarioNotificado=' + idusuarioNotificado).then(function(response){
            //console.log(response.data)
            $scope.resposta = response.data;
        })

    }
    getMessageFromUserInterested();

    $scope.responderMensagem = function(resposta){
        resposta.option = 'salvar resposta';
        //console.log(resposta)
        $http.post(urlPrefix, resposta).then(function(response){
            //console.log(response.data)
            $scope.msg = response.data.msg;
        })
    }
	
}]);