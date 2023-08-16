<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', true);
error_reporting(E_ALL);

include_once("../con.php");

$pdo = conectar();

$data = file_get_contents("php://input");
$data = json_decode($data);

if($data){
	$option = $data->option;
}else{
	$option = $_GET['option'];
}

switch ($option) {
	
	case 'get all startups': //pegar startups do usuario

		$getAllStartup=$pdo->prepare("SELECT * FROM perfilStartup");
		$getAllStartup->execute();

		$return = array();

		try {

			while ($linha=$getAllStartup->fetch(PDO::FETCH_ASSOC)) {

				$idstartup = $linha['idstartup'];
				$nomeStartup = $linha['nomeStartup'];
				@$nomeResponsavel = $linha['nomeResponsavel'];
				$resumo = $linha['resumo'];
				$localidade = $linha['localidade'];
				$uf = $linha['uf'];

				$pnEspecifique = $linha['pnEspecifique'];
				$estagioStartup = $linha['estagioStartup'];
				$problema = $linha['problema'];
				$solucao = $linha['solucao'];
				$diferencial = $linha['diferencial'];
	
				$return[] = array(
					'idstartup'	=> $idstartup,
					'nomeStartup'	=> $nomeStartup,
					'nomeResponsavel'	=> $nomeResponsavel,
					'resumo'	=> $resumo,
					'localidade'	=> $localidade,
					'uf'	=> $uf,
					'estagioStartup'	=> $estagioStartup,
					'problema'	=> $problema,
					'solucao'	=> $solucao,
					'diferencial'	=> $diferencial
				);
	
			}
	
			echo json_encode($return);


		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

        break;
        
    case 'delete startup':

        $idstartup = $_GET['idstartup'];
        //echo 'idstartup '.$idstartup;

        try {

            $deleteStartup=$pdo->prepare("DELETE FROM perfilStartup WHERE idstartup=:idstartup");
            $deleteStartup->bindValue(':idstartup', $idstartup);;
            $deleteStartup->execute();

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;
	
	default:
		# code...
		break;
}




?>