var app = angular.module("startwe", ["ngRoute", "ui.utils.masks"]);

app.config(['$routeProvider', function($routeProvider){

	$routeProvider

	.when("/", {
        templateUrl: "views/login.html",
    })

    .when("/register", {
        templateUrl: "views/register.html",
    })

    .when("/seleciona-perfil", {
        templateUrl: "views/seleciona-perfil.html",
    })

    .when("/perfil-startup", {
        templateUrl: "views/perfil-startup.html",
    })

    .when("/feed", {
        templateUrl: "views/feed.html",
    })

    .when("/minhas-startups", {
        templateUrl: "views/minhas-startups.html",
    })

    .when("/perfil-participar", {
        templateUrl: "views/perfil-participar.html",
    })

    .when("/criar-perfil-participante", {
        templateUrl: "views/criar-perfil-participante.html",
    })

    .when("/editar-perfil-startup/:idstartup", {
        templateUrl: "views/editar-perfil-startup.html",
    })

    .when("/criar-nova-startup/", {
        templateUrl: "views/criar-nova-startup.html",
    })

    .when("/editar-perfil-usuario/:idusuario", {
        templateUrl: "views/editar-perfil-usuario.html",
    })

    .when("/editar-perfil-participante/", {
        templateUrl: "views/editar-perfil-participante.html",
    })

    .when("/editar-perfil-startup/:idstartup", {
        templateUrl: "views/editar-perfil-startup.html",
    })

    .when("/participar/:idusuario/:nomeStartup/:nomeResponsavel", {
    //.when("/participar", {
        templateUrl: "views/participar.html",
    })

    .when("/minhas-notificacoes", {
        templateUrl: "views/minhas-notificacoes.html",
    })

    .when("/ver-perfil/:idusuarioInteressado", {
        templateUrl: "views/ver-perfil.html",
    })

    .when("/responder/:idusuarioInteressado/:idusuarioNotificado", {
        templateUrl: "views/responder.html",
    })

    .when("/login-painel-admin", {
        templateUrl: "views/admin/login-painel-admin.html",
    })

    .when("/painel-admin", {
        templateUrl: "views/admin/painel-admin.html",
    })

    .when("/lista-startups", {
        templateUrl: "views/admin/lista-startups.html",
    })

    .when("/delete-startups/:idstartup", {
        templateUrl: "views/admin/delete-startups.html",
    })

}]);
