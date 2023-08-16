app.controller("loginPainelAdminCtrl", ['$scope', '$http', '$window', '$location', '$rootScope', function ($scope, $http, $window, $location, $rootScope) {

	$scope.admin = {};

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/startWe/api/admin/users.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/startWe/api/admin/users.php?option=';
	} else {
        var urlPrefix = 'api/admin/users.php';
        var urlOptionPrefix = 'api/admin/users.php?option=';
		console.log('externo')
	}

    $scope.loginAdmin = function(user){
        user.option = 'login admin';

        $http.post(urlPrefix, user).then(function(response){
            if(response.data != ''){
                $location.path('/painel-admin')
            } else {

            }
        })
    }


	
}]);