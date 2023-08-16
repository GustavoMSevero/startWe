app.controller("criarNovaStartupCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
    $scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/registerStartup.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/registerStartup.php?option=';
	} else {
		var urlPrefix = 'api/registerStartup.php';
		var urlOptionPrefix = 'api/registerStartup.php?option=';
    }

    $(document).ready(function(){
		$('#cep').focusout(function(){
			var valorCep = $('#cep').val();
			$http.get('http://viacep.com.br/ws/'+valorCep+'/json/').then(function(response){
				if(response.data.erro == true){
					$scope.erro = 'CEP inexistente! Tente novamente.';
				} else {
					$scope.perfilStartup.cep = response.data.cep;
					$scope.perfilStartup.localidade = response.data.localidade;
					$scope.perfilStartup.uf = response.data.uf;
				}
				
			})
		})
	
	});
	
	$scope.cadastrarPerfilStartup = function(perfilStartup){
		perfilStartup.option = 'cadastro startup';
		perfilStartup.idusuario = $scope.idusuario;
		perfilStartup.idusuario = $scope.idusuario;
		perfilStartup.nomeResponsavel = $scope.usuario;

		$http.post(urlPrefix, perfilStartup).then(function(response){
			//console.log(response.data)
			$location.path('/feed');
		})
	}
	
	$scope.uploadFoto = function(){
        $scope.input.click();
      }
  
      $scope.arquivo = '';
  
      $scope.input = document.createElement("INPUT");
      $scope.input.setAttribute("type", "file");
      $scope.input.addEventListener('change', function(){
			formData.append('file_jpg', $scope.input.files[0]);
	
			$.ajax({
				url: urlUploadPhotoParticipant + $scope.idusuario,
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
	  
	var showPhoto = function(){
	var opcao = 'mostrar logo startup';

		$http.get(urlOptionPrefix + opcao + '&idusuario='+ $scope.idusuario).success(function(response){
			//console.log(response.logoStartup)
			$scope.logoStartup = response.logoStartup;
		})
	}
	showPhoto();

	
}]);