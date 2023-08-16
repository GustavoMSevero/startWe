<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', true);
error_reporting(E_ALL);

include_once("con.php");

$pdo = conectar();

$data = file_get_contents("php://input");
$data = json_decode($data);

if($data){
	$option = $data->option;
}else{
	$option = $_GET['option'];
}

switch ($option) {
	case "cadastro startup":
		//print_r($data);
		$nomeStartup = $data->nomeStartup;
		$resumo = $data->resumo;
		$localidade = $data->localidade;
		$uf = $data->uf;
		$nomeResponsavel = $data->nomeResponsavel;

		if (!property_exists($data, 'necessidadeInvestimento')) {
			$necessidadeInvestimento = $data->necessidadeInvestimento = '0';
		} else {
			$necessidadeInvestimento = $data->necessidadeInvestimento;
		}

		if (!property_exists($data, 'pnComercial')) {
			$pnComercial = $data->pnComercial = '0';
		} else {
			$pnComercial = $data->pnComercial;
		}

		if (!property_exists($data, 'pnContabil')) {
			$pnContabil = $data->pnContabil = '0';
		} else {
			$pnContabil = $data->pnContabil;
		}

		if (!property_exists($data, 'pnDesenvolvedor')) {
			$pnDesenvolvedor = $data->pnDesenvolvedor = '0';
		} else {
			$pnDesenvolvedor = $data->pnDesenvolvedor;
		}

		if (!property_exists($data, 'pnDesigner')) {
			$pnDesigner = $data->pnDesigner = '0';
		} else {
			$pnDesigner = $data->pnDesigner;
		}

		if (!property_exists($data, 'pnFinanceiro')) {
			$pnFinanceiro = $data->pnFinanceiro = '0';
		} else {
			$pnFinanceiro = $data->pnFinanceiro;
		}

		if (!property_exists($data, 'pnGestao')) {
			$pnGestao = $data->pnGestao = '0';
		} else {
			$pnGestao = $data->pnGestao;
		}

		if (!property_exists($data, 'pnJuridico')) {
			$pnJuridico = $data->pnJuridico = '0';
		} else {
			$pnJuridico = $data->pnJuridico;
		}

		if (!property_exists($data, 'pnMarketing')) {
			$pnMarketing = $data->pnMarketing = '0';
		} else {
			$pnMarketing = $data->pnMarketing;
		}

		if (!property_exists($data, 'pnOutro')) {
			$pnOutro = $data->pnOutro = '0';
		} else {
			$pnOutro = $data->pnOutro;
		}

		if (!property_exists($data, 'pnEspecifique')) {
			$pnEspecifique = $data->pnEspecifique = '';
		} else {
			$pnEspecifique = $data->pnEspecifique;
		}

		

		if (!property_exists($data, 'psComercial')) {
			$psComercial = $data->psComercial = '0';
		} else {
			$psComercial = $data->psComercial;
		}

		if (!property_exists($data, 'psContabil')) {
			$psContabil = $data->psContabil = '0';
		} else {
			$psContabil = $data->psContabil;
		}

		if (!property_exists($data, 'psDesenvolvedor')) {
			$psDesenvolvedor = $data->psDesenvolvedor = '0';
		} else {
			$psDesenvolvedor = $data->psDesenvolvedor;
		}

		if (!property_exists($data, 'psDesigner')) {
			$psDesigner = $data->psDesigner = '0';
		} else {
			$psDesigner = $data->psDesigner;
		}

		if (!property_exists($data, 'psFinanceiro')) {
			$psFinanceiro = $data->psFinanceiro = '0';
		} else {
			$psFinanceiro = $data->psFinanceiro;
		}

		if (!property_exists($data, 'psGestao')) {
			$psGestao = $data->psGestao = '0';
		} else {
			$psGestao = $data->psGestao;
		}

		if (!property_exists($data, 'psJuridico')) {
			$psJuridico = $data->psJuridico = '0';
		} else {
			$psJuridico = $data->psJuridico;
		}

		if (!property_exists($data, 'psMarketing')) {
			$psMarketing = $data->psMarketing = '0';
		} else {
			$psMarketing = $data->psMarketing;
		}

		if (!property_exists($data, 'psOutro')) {
			$psOutro = $data->psOutro = '0';
		} else {
			$psOutro = $data->psOutro;
		}

		if (!property_exists($data, 'psEspecifique')) {
			$psEspecifique = $data->psEspecifique = '';
		} else {
			$psEspecifique = $data->psEspecifique;
		}

		if (!property_exists($data, 'estagio')) {
			$estagio = $data->estagio = '';
		} else {
			$estagio = $data->estagio;
		}

		$idusuario = $data->idusuario;

		$problema = $data->problema;
		$solucao = $data->solucao;
		$diferencial = $data->diferencial;

		$searchStartup=$pdo->prepare("SELECT * FROM perfilStartup WHERE nomeStartup=:nomeStartup");
		$searchStartup->bindValue(":nomeStartup", $nomeStartup);
		$searchStartup->execute();
		
		$exists = $searchStartup->rowCount();

		if($exists == 1){

			$msg = 'Startup já existente! Tente outro';

			$return = array(
				'exists' => $exists,
				'status' => 0,
				'msg' => $msg
			);

			echo json_encode($return);
				
		} 

			try {

				$registerStartup=$pdo->prepare("INSERT INTO perfilStartup (idstartup, idusuario, nomeStartup, nomeResponsavel, resumo,
					localidade, uf, psComercial, psContabil, psDesenvolvedor, psDesigner, psEspecifique, psFinanceiro, psJuridico, 
					psMarketing, psOutro, psGestao, estagioStartup, necessidadeInvestimento, pnMarketing, pnDesenvolvedor, pnDesigner, 
					pnGestao, pnFinanceiro, pnComercial, pnContabil, pnEspecifique, pnJuridico, pnOutro, problema, solucao, diferencial)
				 		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$registerStartup->bindValue(1, NULL);
				$registerStartup->bindValue(2, $idusuario);
				$registerStartup->bindValue(3, $nomeStartup);
				$registerStartup->bindValue(4, $nomeResponsavel);
				$registerStartup->bindValue(5, $resumo);
				$registerStartup->bindValue(6, $localidade);
				$registerStartup->bindValue(7, $uf);
				$registerStartup->bindValue(8, $psComercial);
				$registerStartup->bindValue(9, $psContabil);
				$registerStartup->bindValue(10, $psDesenvolvedor);
				$registerStartup->bindValue(11, $psDesigner);
				$registerStartup->bindValue(12, $psEspecifique);
				$registerStartup->bindValue(13, $psFinanceiro);
				$registerStartup->bindValue(14, $psJuridico);
				$registerStartup->bindValue(15, $psMarketing);
				$registerStartup->bindValue(16, $psOutro);
				$registerStartup->bindValue(17, $psGestao);
				$registerStartup->bindValue(18, $estagio);
				$registerStartup->bindValue(19, $necessidadeInvestimento);
				$registerStartup->bindValue(20, $pnMarketing);
				$registerStartup->bindValue(21, $pnDesenvolvedor);
				$registerStartup->bindValue(22, $pnDesigner);
				$registerStartup->bindValue(23, $pnGestao);
				$registerStartup->bindValue(24, $pnFinanceiro);
				$registerStartup->bindValue(25, $pnComercial);
				$registerStartup->bindValue(26, $pnContabil);
				$registerStartup->bindValue(27, $pnEspecifique);
				$registerStartup->bindValue(28, $pnJuridico);
				$registerStartup->bindValue(29, $pnOutro);
				$registerStartup->bindValue(30, $problema);
				$registerStartup->bindValue(31, $solucao);
				$registerStartup->bindValue(32, $diferencial);
				
				$registerStartup->execute();
			
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
		};


		break;

	case 'verifica se tem startup': //Login
		
		$idusuario = $_GET['idusuario'];

		try {

			$checkForStartup=$pdo->prepare("SELECT * FROM perfilStartup WHERE idusuario=:idusuario");
			$checkForStartup->bindValue(":idusuario", $idusuario);

			$checkForStartup->execute();

			$exists = $checkForStartup->rowCount();

			if($exists != 0){

				$return = array();

				while ($linha=$checkForStartup->fetch(PDO::FETCH_ASSOC)) {

					$idstartup = $linha['idstartup'];
		
					$return = array(
						'checked'	=> true
					);
		
				}
		
				echo json_encode($return);

			}


		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'exibir startups':

		$getStartups=$pdo->prepare("SELECT * FROM perfilStartup");
		$getStartups->execute();

		$return = array();

		try {

			while ($linha=$getStartups->fetch(PDO::FETCH_ASSOC)) {

				$pnOutros = '';
				$psOutros = '';
				$pnOut = true;
				$psOut = true;
				
				$idusuario = $linha['idusuario'];
				$nomeStartup = $linha['nomeStartup'];
				@$nomeResponsavel = $linha['nomeResponsavel'];
				$resumo = $linha['resumo'];

				$necessidadeInvestimento = $linha['necessidadeInvestimento'];
				if($necessidadeInvestimento == 1){
					$necessidadeInvestimento = 'Sim';
					$nI = true;
				} 
				else {
					$nI = false;
				}

				$psComercial = $linha['psComercial'];
				if($psComercial == 1){
					$psComercial = 'Sim';
					$psCom = true;
				} 
				else {
					$psCom = false;
				}

				$psContabil = $linha['psContabil'];
				if($psContabil == 1){
					$psContabil = 'Sim';
					$psCon = true;
				} else {
					$psCon = false;
				}

				$psDesenvolvedor = $linha['psDesenvolvedor'];
				if($psDesenvolvedor == 1){
					$psDesenvolvedor = 'Sim';
					$psDese = true;
				} else {
					$psDese = false;
				}

				$psDesigner = $linha['psDesigner'];
				if($psDesigner == 1){
					$psDesigner = 'Sim';
					$psDesi = true;
				} else {
					$psDesi = false;
				}

				$psFinanceiro = $linha['psFinanceiro'];
				if($psFinanceiro == 1){
					$psFinanceiro = 'Sim';
					$psFin = true;
				} else {
					$psFin = false;
				}

				$psJuridico = $linha['psJuridico'];
				if($psJuridico == 1){
					$psJuridico = 'Sim';
					$psJur = true;
				} else {
					$psJur = false;
				}

				$psMarketing = $linha['psMarketing'];
				if($psMarketing == 1){
					$psMarketing = 'Sim';
					$psMar = true;
				} else {
					$psMar = false;
				}

				$psGestao = $linha['psGestao'];
				if($psGestao == 1){
					$psGestao = 'Sim';
					$psGes = true;
				} else {
					$psGes = false;
				}

				$psOutro = $linha['psOutro'];
				if($psOutro == 1){
					$psOutro = 'Sim';
					$psOut = true;
				} else {
					$psOut = false;
				}

				$psEspecifique = $linha['psEspecifique'];
				if($psEspecifique != ''){
					$psEsp = true;
				} else {
					$psEsp = false;
				}


				

				$pnComercial = $linha['pnComercial'];
				if($pnComercial == 1){
					$pnComercial = 'Sim';
					$pnCom = true;
				} 
				else {
					$pnCom = false;
				}

				$pnContabil = $linha['pnContabil'];
				if($pnContabil == 1){
					$pnContabil = 'Sim';
					$pnCon = true;
				} else {
					$pnCon = false;
				}

				$pnDesenvolvedor = $linha['pnDesenvolvedor'];
				if($pnDesenvolvedor == 1){
					$pnDesenvolvedor = 'Sim';
					$pnDese = true;
				} else {
					$pnDese = false;
				}

				$pnDesigner = $linha['pnDesigner'];
				if($pnDesigner == 1){
					$pnDesigner = 'Sim';
					$pnDesi = true;
				} else {
					$pnDesi = false;
				}

				$pnFinanceiro = $linha['pnFinanceiro'];
				if($pnFinanceiro == 1){
					$pnFinanceiro = 'Sim';
					$pnFin = true;
				} else {
					$pnFin = false;
				}

				$pnJuridico = $linha['pnJuridico'];
				if($pnJuridico == 1){
					$pnJuridico = 'Sim';
					$pnJur = true;
				} else {
					$pnJur = false;
				}

				$pnMarketing = $linha['pnMarketing'];
				if($pnMarketing == 1){
					$pnMarketing = 'Sim';
					$pnMar = true;
				} else {
					$pnMar = false;
				}

				$pnGestao = $linha['pnGestao'];
				if($pnGestao == 1){
					$pnGestao = 'Sim';
					$pnGes = true;
				} else {
					$pnGes = false;
				}

				$pnOutro = $linha['pnOutro'];
				if($pnOutro == 1){
					$pnOutro = 'Sim';
					$pnOut = true;
				} else {
					$pnOut = false;
				}

				$pnEspecifique = $linha['pnEspecifique'];
				if($pnEspecifique != ''){
					$pnEsp = true;
				} else {
					$pnEsp = false;
				}

				$estagioStartup = $linha['estagioStartup'];
				$problema = $linha['problema'];
				$solucao = $linha['solucao'];
				$diferencial = $linha['diferencial'];

				if($necessidadeInvestimento == 1){
					$necessidadeInvestimento = 'Sim';
				}

				$getLogoStartups=$pdo->prepare("SELECT * FROM logoStartup WHERE idusuario=:idusuario");
				$getLogoStartups->bindValue(":idusuario", $idusuario);
				$getLogoStartups->execute();

				$qtd = $getLogoStartups->rowCount();

				if($qtd == 0){
					$logoStartup = "./imgs/ideia.png";
				} else {
					while ($linhaLogo=$getLogoStartups->fetch(PDO::FETCH_ASSOC)) {
						$nome = $linhaLogo['nome'];
						$logoStartup = "./api/uploadFotoStartup/".$nome;
					}
				}

				$return[] = array(
					'idusuario'	=> $idusuario,
					'nomeStartup'	=> $nomeStartup,
					'nomeResponsavel'	=> $nomeResponsavel,
					'resumo'	=> $resumo,

					'necessidadeInvestimento'	=> $necessidadeInvestimento,
					'nI'	=> $nI,
					'psComercial'	=> $psComercial,
					'psCom'	=> $psCom,
					'psContabil'	=> $psContabil,
					'psCon'	=> $psCon,
					'psDesenvolvedor'	=> $psDesenvolvedor,
					'psDese'	=> $psDese,
					'psDesigner'	=> $psDesigner,
					'psDesi'	=> $psDesi,
					'psFinanceiro'	=> $psFinanceiro,
					'psFin'	=> $psFin,
					'psJuridico'	=> $psJuridico,
					'psJur'	=> $psJur,
					'psMarketing'	=> $psMarketing,
					'psGestao'	=> $psGestao,
					'psGes' => $psGes,
					'psMar'	=> $psMar,
					'psOutro'	=> $psOutro,
					'psOut'	=> $psOut,
					'psEspecifique'	=> $psEspecifique,
					'psEsp'	=> $psEsp,

					'pnComercial'	=> $pnComercial,
					'pnCom'	=> $pnCom,
					'pnContabil'	=> $pnContabil,
					'pnCon'	=> $pnCon,
					'pnDesenvolvedor'	=> $pnDesenvolvedor,
					'pnDese'	=> $pnDese,
					'pnDesigner'	=> $pnDesigner,
					'pnDesi'	=> $pnDesi,
					'pnFinanceiro'	=> $pnFinanceiro,
					'pnFin'	=> $pnFin,
					'pnJuridico'	=> $pnJuridico,
					'pnJur'	=> $pnJur,
					'pnMarketing'	=> $pnMarketing,
					'pnGestao'	=> $pnGestao,
					'pnGes' => $pnGes,
					'pnMar'	=> $pnMar,
					'pnOutro'	=> $pnOutro,
					'pnOut'	=> $pnOut,
					'pnEspecifique'	=> $pnEspecifique,
					'pnEsp'	=> $pnEsp,
					'estagioStartup'	=> $estagioStartup,
					'problema'	=> $problema,
					'solucao'	=> $solucao,
					'diferencial'	=> $diferencial,
					'logoStartup'	=> $logoStartup
				);


			}
	
			echo json_encode($return);


		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'pegar minhas startups': //listar startups de um usuario

		$idusuario = $_GET['idusuario'];

		$getMyStartups=$pdo->prepare("SELECT * FROM perfilStartup WHERE idusuario=:idusuario");
		$getMyStartups->bindValue(":idusuario", $idusuario);
		$getMyStartups->execute();

		$return = array();

		try {

			while ($linha=$getMyStartups->fetch(PDO::FETCH_ASSOC)) {

				$nomeStartup = $linha['nomeStartup'];
				@$idstartup = $linha['idstartup'];
	
				$return[] = array(
					'nomeStartup'	=> $nomeStartup,
					'idstartup'	=> $idstartup
				);
	
			}
	
			echo json_encode($return);


		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'pegar startup': //pegar startups do usuario

		$idstartup = $_GET['idstartup'];

		$getStartup=$pdo->prepare("SELECT * FROM perfilStartup WHERE idstartup=:idstartup");
		$getStartup->bindValue(":idstartup", $idstartup);
		$getStartup->execute();

		$return = array();

		try {

			while ($linha=$getStartup->fetch(PDO::FETCH_ASSOC)) {

				$idstartup = $linha['idstartup'];
				$nomeStartup = $linha['nomeStartup'];
				@$nomeResponsavel = $linha['nomeResponsavel'];
				$resumo = $linha['resumo'];
				$localidade = $linha['localidade'];
				$uf = $linha['uf'];

				$pnGestao = $linha['pnGestao'];
				if($pnGestao == 1){
					$pnGestao = true;
				} else {
					$pnGestao = false;
				}

				$psGestao = $linha['psGestao'];
				if($psGestao == 1){
					$psGestao = true;
				} else {
					$psGestao = false;
				}

				$necessidadeInvestimento = $linha['necessidadeInvestimento'];
				if($necessidadeInvestimento == 1){
					$necessidadeInvestimento = true;
				} else {
					$necessidadeInvestimento = false;
				}

				$psComercial = $linha['psComercial'];
				if($psComercial == 1){
					$psComercial = true;
				} else {
					$psComercial = false;
				}

				$psContabil = $linha['psContabil'];
				if($psContabil == 1){
					$psContabil = true;
				} else {
					$psContabil = false;
				}

				$psDesenvolvedor = $linha['psDesenvolvedor'];
				if($psDesenvolvedor == 1){
					$psDesenvolvedor = true;
				} else {
					$psDesenvolvedor = false;
				}

				$psDesigner = $linha['psDesigner'];
				if($psDesigner == 1){
					$psDesigner = true;
				} else {
					$psDesigner = false;
				}

				$psFinanceiro = $linha['psFinanceiro'];
				if($psFinanceiro == 1){
					$psFinanceiro = true;
				} else {
					$psFinanceiro = false;
				}

				$psJuridico = $linha['psJuridico'];
				if($psJuridico == 1){
					$psJuridico = true;
				} else {
					$psJuridico = false;
				}

				$psMarketing = $linha['psMarketing'];
				if($psMarketing == 1){
					$psMarketing = true;
				} else {
					$psMarketing = false;
				}

				$psOutro = $linha['psOutro'];
				if($psOutro == 1){
					$psOutro = true;
				} else {
					$psOutro = false;
				}

				$psEspecifique = $linha['psEspecifique'];
	
				$pnComercial = $linha['pnComercial'];
				if($pnComercial == 1){
					$pnComercial = true;
				} else {
					$pnComercial = false;
				}

				$pnContabil = $linha['pnContabil'];
				if($pnContabil == 1){
					$pnContabil = true;
				} else {
					$pnContabil = false;
				}

				$pnDesenvolvedor = $linha['pnDesenvolvedor'];
				if($pnDesenvolvedor == 1){
					$pnDesenvolvedor = true;
				} else {
					$pnDesenvolvedor = false;
				}

				$pnDesigner = $linha['pnDesigner'];
				if($pnDesigner == 1){
					$pnDesigner = true;
				} else {
					$pnDesigner = false;
				}

				$pnFinanceiro = $linha['pnFinanceiro'];
				if($pnFinanceiro == 1){
					$pnFinanceiro = true;
				} else {
					$pnFinanceiro = false;
				}

				$pnJuridico = $linha['pnJuridico'];
				if($pnJuridico == 1){
					$pnJuridico = true;
				} else {
					$pnJuridico = false;
				}

				$pnMarketing = $linha['pnMarketing'];
				if($pnMarketing == 1){
					$pnMarketing = true;
				} else {
					$pnMarketing = false;
				}

				$pnOutro = $linha['pnOutro'];
				if($pnOutro == 1){
					$pnOutro = true;
				} else {
					$pnOutro = false;
				}

				$pnEspecifique = $linha['pnEspecifique'];
				$estagioStartup = $linha['estagioStartup'];
				$problema = $linha['problema'];
				$solucao = $linha['solucao'];
				$diferencial = $linha['diferencial'];
	
				$return = array(
					'idstartup'	=> $idstartup,
					'nomeStartup'	=> $nomeStartup,
					'nomeResponsavel'	=> $nomeResponsavel,
					'resumo'	=> $resumo,
					'localidade'	=> $localidade,
					'uf'	=> $uf,
					'necessidadeInvestimento'	=> $necessidadeInvestimento,

					'psComercial'	=> $psComercial,
					'psContabil'	=> $psContabil,
					'psDesenvolvedor'	=> $psDesenvolvedor,
					'psDesigner'	=> $psDesigner,
					'psFinanceiro'	=> $psFinanceiro,
					'psJuridico'	=> $psJuridico,
					'psMarketing'	=> $psMarketing,
					'psGestao'	=> $psGestao,
					'psOutro'	=> $psOutro,
					'psEspecifique'	=> $psEspecifique,

					'pnComercial'	=> $pnComercial,
					'pnContabil'	=> $pnContabil,
					'pnDesenvolvedor'	=> $pnDesenvolvedor,
					'pnDesigner'	=> $pnDesigner,
					'pnFinanceiro'	=> $pnFinanceiro,
					'pnJuridico'	=> $pnJuridico,
					'pnMarketing'	=> $pnMarketing,
					'pnGestao'	=> $pnGestao,
					'pnOutro'	=> $pnOutro,
					'pnEspecifique'	=> $pnEspecifique,

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

	case 'mostrar logo startup':

		$idusuario = $_GET['idusuario'];
		$idfoto = 0;
		$logoStartup = '';
		$nome = '';

		$qryMostrarLogo=$pdo->prepare('SELECT * FROM logoStartup WHERE idusuario=:idusuario');
		$qryMostrarLogo->bindValue('idusuario', $idusuario);
		$qryMostrarLogo->execute();

		$return = array();

		while ($linha=$qryMostrarLogo->fetch(PDO::FETCH_ASSOC)) {

			$idlogo = $linha['idlogo'];
			$nome = $linha['nome'];
			$logoStartup = "api/uploadFotoStartup/".$nome;

		}
			
			if($logoStartup == ""){
				$logoStartup = "./imgs/ideia.png";

				$return = array(
					'logoStartup' => $logoStartup
				);

			} else {

				$return = array(
					'id' => $idlogo,
					'logoStartup' => $logoStartup,
				);

			}

			echo json_encode($return);


		break;

	case "atualizar perfil startup":
		//var_dump($data);
		$idstartup = $data->idstartup;
		$nomeStartup = $data->nomeStartup;
		$nomeResponsavel = $data->nomeResponsavel;
		$resumo = $data->resumo;
		$localidade = $data->localidade;
		$uf = $data->uf;

		$necessidadeInvestimento = $data->necessidadeInvestimento;
		$psComercial = $data->psComercial;
		$psContabil = $data->psContabil;
		$psDesenvolvedor = $data->psDesenvolvedor;
		$psDesigner = $data->psDesigner;
		$psFinanceiro = $data->psFinanceiro;
		@$psGestao = $data->psGestao;
		$psJuridico = $data->psJuridico;
		$psMarketing = $data->psMarketing;
		$psOutro = $data->psOutro;
		$psEspecifique = $data->psEspecifique;

		$pnComercial = $data->pnComercial;
		$pnContabil = $data->pnContabil;
		$pnDesenvolvedor = $data->pnDesenvolvedor;
		$pnDesigner = $data->pnDesigner;
		$pnFinanceiro = $data->pnFinanceiro;
		@$pnGestao = $data->pnGestao;
		$pnJuridico = $data->pnJuridico;
		$pnMarketing = $data->pnMarketing;
		$pnOutro = $data->pnOutro;
		$pnEspecifique = $data->pnEspecifique;

		$estagioStartup = $data->estagioStartup;
		$problema = $data->problema;
		$solucao = $data->solucao;
		$diferencial = $data->diferencial;

        try {
            $updatePerfilStartup=$pdo->prepare("UPDATE perfilStartup SET 
			nomeStartup=:nomeStartup, 
			nomeResponsavel=:nomeResponsavel, 
			resumo=:resumo, 
			localidade=:localidade, 
			uf=:uf,
			necessidadeInvestimento=:necessidadeInvestimento, 
			psComercial=:psComercial, 
			psContabil=:psContabil,
			psDesenvolvedor=:psDesenvolvedor, 
			psDesigner=:psDesigner, 
			psFinanceiro=:psFinanceiro, 
			psGestao=:psGestao,
			psJuridico=:psJuridico, 
			psMarketing=:psMarketing, 
			psOutro=:psOutro, 
			psEspecifique=:psEspecifique,

			pnComercial=:pnComercial, 
			pnContabil=:pnContabil, 
			pnDesenvolvedor=:pnDesenvolvedor, 
			pnDesigner=:pnDesigner, 
			pnFinanceiro=:pnFinanceiro, 
			pnGestao=:pnGestao, 
			pnJuridico=:pnJuridico, 
			pnMarketing=:pnMarketing, 
			pnOutro=:pnOutro, 
			pnEspecifique=:pnEspecifique,

			estagioStartup=:estagioStartup, 
			problema=:problema,
			solucao=:solucao, 
			diferencial=:diferencial
			WHERE idstartup=:idstartup");

            $updatePerfilStartup->bindValue(':nomeStartup', $nomeStartup);
            $updatePerfilStartup->bindValue(':nomeResponsavel', $nomeResponsavel);
            $updatePerfilStartup->bindValue(':resumo', $resumo);
            $updatePerfilStartup->bindValue(':localidade', $localidade);
            $updatePerfilStartup->bindValue(':uf', $uf);
            $updatePerfilStartup->bindValue(':necessidadeInvestimento', $necessidadeInvestimento);
            $updatePerfilStartup->bindValue(':psComercial', $psComercial);
            $updatePerfilStartup->bindValue(':psContabil', $psContabil);
			$updatePerfilStartup->bindValue(':psDesenvolvedor', $psDesenvolvedor);
			$updatePerfilStartup->bindValue(':psDesigner', $psDesigner);
			$updatePerfilStartup->bindValue(':psFinanceiro', $psFinanceiro);
			$updatePerfilStartup->bindValue(':psGestao', $psGestao);
			$updatePerfilStartup->bindValue(':psJuridico', $psJuridico);
			$updatePerfilStartup->bindValue(':psMarketing', $psMarketing);
			$updatePerfilStartup->bindValue(':psOutro', $psOutro);
			$updatePerfilStartup->bindValue(':psEspecifique', $psEspecifique);
			$updatePerfilStartup->bindValue(':pnComercial', $pnComercial);
            $updatePerfilStartup->bindValue(':pnContabil', $pnContabil);
			$updatePerfilStartup->bindValue(':pnDesenvolvedor', $pnDesenvolvedor);
			$updatePerfilStartup->bindValue(':pnDesigner', $pnDesigner);
			$updatePerfilStartup->bindValue(':pnFinanceiro', $pnFinanceiro);
			$updatePerfilStartup->bindValue(':pnGestao', $pnGestao);
			$updatePerfilStartup->bindValue(':pnJuridico', $pnJuridico);
			$updatePerfilStartup->bindValue(':pnMarketing', $pnMarketing);
			$updatePerfilStartup->bindValue(':pnOutro', $pnOutro);
			$updatePerfilStartup->bindValue(':pnEspecifique', $pnEspecifique);
			$updatePerfilStartup->bindValue(':estagioStartup', $estagioStartup);
			$updatePerfilStartup->bindValue(':problema', $problema);
			$updatePerfilStartup->bindValue(':solucao', $solucao);
			$updatePerfilStartup->bindValue(':diferencial', $diferencial);
			
            $updatePerfilStartup->bindValue(':idstartup', $idstartup);
			$updatePerfilStartup->execute();

			$status = 1;
			$msg = "Dados atualizados com Sucesso.";

            $return = array(
                'status' => $status,
                'msg' => $msg
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

		break;

	case "cadastrar nova startup":
        //print_r($data);
		$nomeStartup = $data->nomeStartup;
		$resumo = $data->resumo;
		@$nomeResponsavel = $data->nomeResponsavel;
		@$necessidadeInvestimento = $data->necessidadeInvestimento;
		@$pnComercial = $data->pnComercial;
		@$pnContabil = $data->pnContabil;
		@$pnDesenvolvedor = $data->pnDesenvolvedor;
		@$pnDesigner = $data->pnDesigner;
		@$pnFinanceiro = $data->pnFinanceiro;
		@$pnGestao = $data->pnGestao;
		@$pnJuridico = $data->pnJuridico;
		@$pnMarketing = $data->pnMarketing;
		@$pnOutro = $data->pnOutro;
		@$pnEspecifique = $data->pnEspecifique;
		@$psComercial = $data->psComercial;
		@$psContabil = $data->psContabil;
		@$psDesenvolvedor = $data->psDesenvolvedor;
		@$psDesigner = $data->psDesigner;
		@$psFinanceiro = $data->psFinanceiro;
		@$psGestao = $data->psgestao;
		@$psJuridico = $data->psJuridico;
		@$psMarketing = $data->psMarketing;
		@$psOutro = $data->psOutro;
		@$psEspecifique = $data->psEspecifique;
		$estagioStartup = $data->estagio;
		$problema = $data->problema;
		$solucao = $data->solucao;
		$diferencial = $data->diferencial;
		$option = $data->option;
		$idusuario = $data->idusuario;

		$problema = $data->problema;
		$solucao = $data->solucao;
		$diferencial = $data->diferencial;

		try {

			$searchStartup=$pdo->prepare("SELECT * FROM perfilStartup WHERE nomeStartup=:nomeStartup AND nomeResponsavel=:nomeResponsavel ");
            $searchStartup->bindValue(":nomeStartup", $nomeStartup);
            $searchStartup->bindValue(":nomeResponsavel", $nomeResponsavel);
			$searchStartup->execute();
			
			$exists = $searchStartup->rowCount();

			if($exists == 1){

				$msg = 'Startup já existente! Tente outro';

				$return = array(
					'exists' => $exists,
					'status' => 0,
					'msg' => $msg
				);

				echo json_encode($return);
			
			} else {

				$registerStartup=$pdo->prepare("INSERT INTO perfilStartup (
					idstartup, 
					idusuario, 
					nomeStartup, 
					nomeResponsavel, 
					resumo,
					psComercial, 
					psContabil, 
					psDesenvolvedor, 
					psDesigner, 
					psEspecifique, 
					psFinanceiro, 
					psJuridico, 
					psMarketing, 
					psOutro, 
					psGestao, 
					estagioStartup, 
					necessidadeInvestimento,
					pnMarketing, 
					pnDesenvolvedor, 
					pnDesigner, 
					pnGestao, 
					pnFinanceiro, 
					pnComercial, 
					pnContabil, 
					pnEspecifique, 
					pnJuridico, 
					pnOutro,
					problema.
					solucao,
					diferencial)
						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$registerStartup->bindValue(1, NULL);
				$registerStartup->bindValue(2, $idusuario);
				$registerStartup->bindValue(3, $nomeStartup);
				$registerStartup->bindValue(4, $nomeResponsavel);
				$registerStartup->bindValue(5, $resumo);
				$registerStartup->bindValue(6, $psComercial);
				$registerStartup->bindValue(7, $psContabil);
				$registerStartup->bindValue(8, $psDesenvolvedor);
				$registerStartup->bindValue(9, $psDesigner);
				$registerStartup->bindValue(10, $psEspecifique);
				$registerStartup->bindValue(11, $psFinanceiro);
				$registerStartup->bindValue(12, $psJuridico);
				$registerStartup->bindValue(13, $psMarketing);
				$registerStartup->bindValue(14, $psOutro);
				$registerStartup->bindValue(15, $psGestao);
				$registerStartup->bindValue(16, $estagioStartup);
				$registerStartup->bindValue(17, $necessidadeInvestimento);
				$registerStartup->bindValue(18, $pnMarketing);
				$registerStartup->bindValue(19, $pnDesenvolvedor);
				$registerStartup->bindValue(20, $pnDesigner);
				$registerStartup->bindValue(21, $pnGestao);
				$registerStartup->bindValue(22, $pnFinanceiro);
				$registerStartup->bindValue(23, $pnComercial);
				$registerStartup->bindValue(24, $pnContabil);
				$registerStartup->bindValue(25, $pnEspecifique);
				$registerStartup->bindValue(26, $pnJuridico);
				$registerStartup->bindValue(27, $pnOutro);
				$registerStartup->bindValue(28, $problema);
				$registerStartup->bindValue(29, $solucao);
				$registerStartup->bindValue(30, $diferencial);
				$registerStartup->execute();

			}
			

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
		};


		break;
	
	default:
		# code...
		break;
}




?>