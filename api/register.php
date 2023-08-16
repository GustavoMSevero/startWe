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
	case "cadastro":
		//print_r($data);
		$usuario = $data->usuario;
		$senha = md5($data->password);
		$cpf = $data->cpf;
		$sexo = $data->sexo;
		$dataNascimento = $data->dataNascimento;
		$cidade = $data->cidade;
		$email = $data->email;
		//$confirPassword = md5($data->confirPassword);

		$dataNascimentoP = explode('/', $dataNascimento);
		$dataNascimento = $dataNascimentoP[2].'-'.$dataNascimentoP[1].'-'.$dataNascimentoP[0];
		
		try {

			$searchCia=$pdo->prepare("SELECT * FROM user WHERE cpf=:cpf");
            $searchCia->bindValue(":cpf", $cpf);
			$searchCia->execute();
			
			$exists = $searchCia->rowCount();

			if($exists == 1){

				$msg = 'usuário já existente! Tente outro';

				$return = array(
					'exists' => $exists,
					'status' => 0,
					'msg' => $msg
				);

				echo json_encode($return);
				 
			} else {

				$registerCia=$pdo->prepare("INSERT INTO user (id, usuario, senha, cpf, sexo, dataNascimento, cidade, email)
									 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
				$registerCia->bindValue(1, NULL);
				$registerCia->bindValue(2, $usuario);
				$registerCia->bindValue(3, $senha);
				$registerCia->bindValue(4, $cpf);
				$registerCia->bindValue(5, $sexo);
				$registerCia->bindValue(6, $dataNascimento);
				$registerCia->bindValue(7, $cidade);
				$registerCia->bindValue(8, $email);

				$registerCia->execute();
				
				$id = $pdo->lastInsertId();

				$return = array(
					'usuario' => $usuario,
					'idusuario' => $id
				);

				echo json_encode($return);

			}
			

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

		break;

	case 'login': //Login
		
		// $email = $data->email;
		// $password = md5($data->password);

		// $getCia=$pdo->prepare("SELECT * FROM empresa WHERE email=:email AND password=:password");
		// $getCia->bindValue(":email", $email);
		// $getCia->bindValue(":password", $password);

		// $getCia->execute();

		// $return = array();

		// try {

		// 	while ($linha=$getCia->fetch(PDO::FETCH_ASSOC)) {

		// 		$idempresa = $linha['idempresa'];
		// 		$nome = $linha['nome'];
		// 		$tipo = $linha['tipo'];
	
		// 		$return = array(
		// 			'idempresa'	=> $idempresa,
		// 			'nome'	=> $nome,
		// 			'tipo'	=> $tipo
		// 		);
	
		// 	}
	
		// 	echo json_encode($return);


		// } catch (Exception $e) {
		// 	echo 'Caught exception: ',  $e->getMessage(), "\n";
		// }

		break;

	case 'pegar empresa':

		// $idempresa = $_GET['idempresa'];

		// $getCia=$pdo->prepare("SELECT * FROM empresa WHERE idempresa=:idempresa");
		// $getCia->bindValue(":idempresa", $idempresa);
		// $getCia->execute();

		// $return = array();

		// try {

		// 	while ($linha=$getCia->fetch(PDO::FETCH_ASSOC)) {

		// 		$dono = $linha['dono'];
		// 		$nome = $linha['nome'];
		// 		$email = $linha['email'];
	
		// 		$return = array(
		// 			'dono'	=> $dono,
		// 			'email'	=> $email,
		// 			'nome'	=> $nome
		// 		);
	
		// 	}
	
		// 	echo json_encode($return);


		// } catch (Exception $e) {
		// 	echo 'Caught exception: ',  $e->getMessage(), "\n";
		// }

		break;

	case 'mostrar foto':

		// $idempresa = $_GET['idempresa'];
		// $idfoto = 0;
		// $imagem = '';
		// $nome = '';

		// $qryMostrarFoto=$pdo->prepare('SELECT * FROM foto WHERE idempresa=:idempresa');
		// $qryMostrarFoto->bindValue('idempresa', $idempresa);
		// $qryMostrarFoto->execute();

		// $return = array();

		// while ($linha=$qryMostrarFoto->fetch(PDO::FETCH_ASSOC)) {

		// 	$id = $linha['id'];
		// 	$nome = $linha['nome'];
		// 	$imagem = "api/uploadFoto/".$nome;

		// }
			
		// 	if($imagem == ""){
		// 		$imagem = "api/uploadFoto/empresa.png";

		// 		$return = array(
		// 			'imagem' => $imagem
		// 		);

		// 	} else {

		// 		$return = array(
		// 			'id' => $id,
		// 			'imagem' => $imagem,
		// 		);

		// 	}

		// 	echo json_encode($return);


		break;

	case "atualizar empresa":

		// $owner = $data->dono;
		// $nome = $data->nome;
		// $email = $data->email;
		// $idempresa = $data->idempresa;

        // try {
        //     $updateCia=$pdo->prepare("UPDATE empresa SET dono=:dono, nome=:nome, email=:email WHERE idempresa=:idempresa");
        //     $updateCia->bindValue(':dono', $owner);
        //     $updateCia->bindValue(':nome', $nome);
        //     $updateCia->bindValue(':email', $email);
        //     $updateCia->bindValue(':idempresa', $idempresa);
		// 	$updateCia->execute();

		// 	$status = 1;
		// 	$msg = "Dados atualizados com Sucesso.";

        //     $return = array(
        //         'status' => $status,
        //         'msg' => $msg
        //     );

        //     echo json_encode($return);

        // } catch (Exception $e) {
        //     echo 'Caught exception: ',  $e->getMessage(), "\n";
        // }

		break;
	
	default:
		# code...
		break;
}




?>