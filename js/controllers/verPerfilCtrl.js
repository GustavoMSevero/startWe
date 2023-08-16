app.controller("verPerfilCtrl", ['$scope', '$http', '$window', '$location', '$routeParams', function ($scope, $http, $window, $location, $routeParams) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");
    $scope.idusuarioInteressado = $routeParams.idusuarioInteressado;

    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}, idusuarioInteressado ${$scope.idusuarioInteressado}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php?option=';
	} else {
		var urlPrefix = 'api/perfilParticipante.php';
		var urlOptionPrefix = 'api/perfilParticipante.php?option=';
    }
    
    var getProfile = function(){
        var option = 'pegar perfil';
        var idusuario = $scope.idusuarioInteressado;

        $http.get(urlOptionPrefix + option + '&idusuario=' + idusuario).then(function(response){
            console.log(response.data)
        })
    }
    getProfile();

	
}]);