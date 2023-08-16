app.controller("editarPerfilStartupCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', '$routeParams', function ($scope, $http, $window, $location, $rootScope, $routeParams) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
	$scope.usuario = localStorage.getItem("startwe_usuario");
	$scope.idstartup = $routeParams.idstartup;
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}, id startup ${$scope.idstartup}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/registerStartup.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/registerStartup.php?option=';
		var urlUploadPhotoStartup = 'http://localhost:8880/web/startWe/api/uploadFotoStartup.php?idstartup=';
	} else {
		var urlPrefix = '';
	}

	$(document).ready(function(){
    
		$('#cep').focusout(function(){
			var valorCep = $('#cep').val();
			$http.get('http://viacep.com.br/ws/'+valorCep+'/json/').then(function(response){
				if(response.data.erro == true){
					$scope.erro = 'CEP inexistente! Tente novamente.';
				} else {
					$scope.perfilNovaStartup.cep = response.data.cep;
					$scope.perfilNovaStartup.localidade = response.data.localidade;
					$scope.perfilNovaStartup.uf = response.data.uf;
				}
				
			})
		})
	
	});

	var pegarStartup = function(){
		var option = 'pegar startup';
		var idstartup = $scope.idstartup;
		$http.get(urlOptionPrefix + option + '&idstartup=' + idstartup).then(function(response){
			//console.log(response.data)
			$scope.perfilNovaStartup = response.data;
		})

	}
	pegarStartup();

	$scope.atualizarPerfilStartup = function(perfilNovaStartup){
		perfilNovaStartup.option = 'atualizar perfil startup';
		perfilNovaStartup.idstartup = $scope.idstartup;
		//console.log(perfilNovaStartup)
		$http.put(urlPrefix, perfilNovaStartup).then(function(response){
			//console.log(response.data)
			if(response.data.status == 1){
				$location.path('/feed');
			}
		})
	}


	var formData = new FormData();
	$scope.idstartup;
	$scope.idusuario;
	

	$scope.uploadFoto = function(){
        $scope.input.click();
      }
  
      $scope.arquivo = '';
  
      $scope.input = document.createElement("INPUT");
      $scope.input.setAttribute("type", "file");
      $scope.input.addEventListener('change', function(){
			formData.append('file_jpg', $scope.input.files[0]);
	
			$.ajax({
				url: urlUploadPhotoStartup + $scope.idstartup + '&idusuario=' + $scope.idusuario,
				data: formData,
				type: 'POST',
				contentType: false,
				processData: false
			})
				.then(function(response) {
;
				if(response.status != ''){
					showPhoto();
					console.log('Upload feito com sucesso')
				}

	
			}, function(response) {
				console.log("Error "+JSON.stringify(response));
			});
  
	  });
	  
	var showLogo = function(){
		var opcao = 'mostrar logo startup';

		$http.get(urlOptionPrefix + opcao + '&idusuario='+ $scope.idusuario).success(function(response){
			//console.log(response.logoStartup)
			$scope.logoStartup = response.logoStartup;
		})
	}
	showLogo();
	
	
}]);