app.controller("editarPerfilUsuarioCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', '$routeParams', function ($scope, $http, $window, $location, $rootScope, $routeParams) {

    $scope.idusuario = localStorage.getItem("startwe_idusuario");
	$scope.usuario = localStorage.getItem("startwe_usuario");
    console.log(`id usuario ${$scope.idusuario}, usuario ${$scope.usuario}`)

	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8880/web/startWe/api/perfilUsers.php';
		var urlOptionPrefix = 'http://localhost:8880/web/startWe/api/perfilUsers.php?option=';
		var urlOptionPrefixParticipant = 'http://localhost:8880/web/startWe/api/perfilParticipante.php?option=';
		var urlUploadPhotoParticipant = 'http://localhost:8880/web/startWe/api/uploadFoto.php?idusuario=';
	} else {
		var urlPrefix = '';
    }
    
    //function que verifica se usuário tem ou não cadastro de participante
	var usuarioTemCadastroParticipante = function(){
		var option = 'verifica se tem cadastro participante';
		var idusuario = $scope.idusuario

		$http.get(urlOptionPrefixParticipant + option + '&idusuario=' + idusuario).then(function(response){
			$scope.checked = response.data.checked;
		})
    }
    

	usuarioTemCadastroParticipante();
    
    var pegarUsuario = function(){
		var option = 'pegar usuario para editar';

        $http.get(urlOptionPrefix + option + '&idusuario=' + $scope.idusuario).then(function(response){
            //console.log(response)
            $scope.newUser = response.data;
        })

    }
    pegarUsuario();

    $scope.updateUser = function(newUser){
        newUser.option = 'atualizar usuario';
        newUser.idusuario = $scope.idusuario;
        //console.log(newUser)
        $http.put(urlPrefix, newUser).then(function(response){
            console.log(response.data)
            if(response.data.status == 1){
				localStorage.setItem('startwe_usuario', response.data.usuario);
               $location.path('/feed');
            }
        })
    }


    var formData = new FormData();
    $scope.idusuario;
	//console.log($scope.idempresa + $scope.nome);
	

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
	var opcao = 'mostrar foto';

		$http.get(urlOptionPrefix + opcao + '&idusuario='+ $scope.idusuario).success(function(response){
			//console.log(response)
			$scope.imagem = response.imagem;
		})
	}
	showPhoto();
	
}]);