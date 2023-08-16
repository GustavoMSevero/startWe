app.controller("participarCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', '$routeParams', function ($scope, $http, $window, $location, $rootScope, $routeParams) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");
    $rootScope.emailDonoStartup = '';

    $scope.idusuarioStartup = $routeParams.idusuario; // id usuario dono da startup
    $scope.nomeStartup = $routeParams.nomeStartup; // nome startup
    $scope.nomeResponsavel = $routeParams.nomeResponsavel; // nome do responsável pela startup

    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}, idusuario startup ${$scope.idusuarioStartup}, startup ${$scope.nomeStartup}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/mensagemParticipar.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/mensagemParticipar.php?option=';
		var urlOptionUserPrefix = 'http://localhost:8880/web/startWe/api/users.php?option=';
		var urlOptionHasProfilePrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php?option=';
	} else {
        var urlPrefix = 'api/mensagemParticipar.php';
		var urlOptionPrefix = 'api/mensagemParticipar.php?option=';
		var urlOptionUserPrefix = 'api/users.php?option=';
		var urlOptionHasProfilePrefix = 'api/perfilParticipante.php?option=';
	} 

	var getEmailUserInterested = function(){
        var option = 'usuario interessado';
        $http.get(urlOptionUserPrefix + option + '&idusuarioInteressado=' +$scope.idusuario).then(function(response){
            //console.log(response.data)
            $scope.emailUsuarioInteressado = response.data.email;
        })
    }
    getEmailUserInterested();

    var ownerStartup = function(){
        var option = 'usuario startup';
        $http.get(urlOptionUserPrefix + option + '&idusuarioStartup='+ $scope.idusuarioStartup).then(function(response){
            $scope.emailDonoStartup = response.data.email;
        })
    }
    ownerStartup();

    var checkUserInterestedHasProfile = function(){
        var option = 'has profile';

        $http.get(urlOptionHasProfilePrefix + option + '&idusuario=' + $scope.idusuario).then(function(response){
            //console.log(response.data)
            $scope.checked = response.data.checked;
            $scope.msgProfile = response.data.msgProfile;
        })
    }
    checkUserInterestedHasProfile();

    $scope.enviarMensagem = function(interesse){
        interesse.nomeStartup = $scope.nomeStartup;
        interesse.nomeResponsavel = $scope.nomeResponsavel;
        interesse.emailDonoStartup = $scope.emailDonoStartup;
        interesse.idusuarioStartup = $scope.idusuarioStartup

        interesse.emailUsuarioInteressado = $scope.emailUsuarioInteressado;
        interesse.idusuariologado = $scope.idusuario;
        interesse.usuarioInteressado = $scope.usuario;
        //console.log(interesse)
        $http.post(urlPrefix, interesse).then(function(response){
            console.log(response.data)
            $scope.msg = response.data.msg;
        })

    }
	
}]);