app.controller("perfilParticiparCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php';
		var urlPrefixUploadCV = 'http://localhost:8880/web/startWe/api/uploadCurriculo.php';
	} else {
		var urlPrefix = '';
    }

    $scope.cadastrarParticipante = function(participante){
        participante.option = 'cadastrar perfil participante';
        participante.idusuario = $scope.idusuario;
        participante.nome = $scope.usuario;
        //console.log(participante)
        $http.post(urlPrefix, participante).then(function(response){
            //console.log(response.data)
            if(response.data.status == 1){
                $scope.msg = response.data.msg;
            } else {
                $location.path('/feed');
            }


        })
    }



	
}]);