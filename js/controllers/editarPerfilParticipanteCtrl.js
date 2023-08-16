app.controller("editarPerfilParticipanteCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', '$routeParams', function ($scope, $http, $window, $location, $rootScope, $routeParams) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
	  $scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/perfilParticipante.php?option=';
	} else {
		var urlPrefix = '';
    }
    

    $(document).ready(function(){
    
      $('#cep').focusout(function(){
          var valorCep = $('#cep').val();
          $http.get('http://viacep.com.br/ws/'+valorCep+'/json/').then(function(response){
            //console.log(response.data)
            if(response.data.erro == true){
              $scope.erro = 'CEP inexistente! Tente novamente.';
            } else {
              $scope.novoParticipante.cep = response.data.cep;
              $scope.novoParticipante.localidade = response.data.localidade;
              $scope.novoParticipante.uf = response.data.uf;
            }
            
          })
      })
	
    });

    
    
    var pegarParticipante = function(){
        var option = 'pegar participante';
        var idusuario = $scope.idusuario;

        $http.get(urlOptionPrefix + option + '&idusuario=' + idusuario).then(function(response){
          //console.log(response.data)
          $scope.novoParticipante = response.data;
        })
    }
    pegarParticipante();
    
    $scope.atuaizarParticipante = function(novoParticipante){
        novoParticipante.option = 'atualizar participante';
        //console.log(novoParticipante)
        $http.put(urlPrefix, novoParticipante).then(function(response){
          //console.log(response.data)
          if(response.data.status == 1){
            $location.path('/feed');
          }
        })
    }


	
}]);