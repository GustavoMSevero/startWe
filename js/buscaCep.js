$(document).ready(function(){

    $('#cep').focusout(function(){
        var valorCep = $('#cep').val();
        //console.log(valorCep)
        $http.get('http://viacep.com.br/ws/'+valorCep+'/json/').then(function(response){
            $('#logradouro').val(response.data.logradouro)
            $('#bairro').val(response.data.bairro)
            $('#localidade').val(response.data.localidade)
        })
    })

    $('#cep').focusout(function(){
        var valorCep = $('#cep').val();
        console.log(valorCep)
        $http.get('http://viacep.com.br/ws/'+valorCep+'/json/').then(function(response){
            console.log(response.data)
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