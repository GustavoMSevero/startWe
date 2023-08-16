app.controller("criarPerfilParticipanteCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', '$routeParams', function ($scope, $http, $window, $location, $rootScope, $routeParams) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
	$scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php?option=';
	} else {
		var urlPrefix = 'api/perfilParticipante.php';
		var urlOptionPrefix = 'api/perfilParticipante.php?option=';
    }
    
    $scope.criarPerfilParticipante = function(participante){
        participante.option = 'cadastrar perfil participante';
        participante.idusuario = $scope.idusuario;
        //console.log(participante)
        $http.post(urlPrefix, participante).then(function(response){
            //console.log(response.data)
            $location.path('/feed');
        })
    }
    
	
}]);