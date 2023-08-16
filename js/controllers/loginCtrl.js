app.controller("loginCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

	$scope.admin = {};

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8880/web/startWe/api/users.php';
	} else {
		var urlPrefix = 'api/users.php';
		console.log('externo')
	}

	$scope.login = function(user){
		user.option = 'login';
		//console.log(user)
		$http.post(urlPrefix, user).then(function(response){
			//console.log(response.data)
			if(response.data.status == 1){
				localStorage.setItem('startwe_idusuario', response.data.idusuario);
				localStorage.setItem('startwe_usuario', response.data.usuario);
				$location.path('/feed')

			}else{
				$scope.msg = response.data.msg;
			}
		})

	}


	
}]);