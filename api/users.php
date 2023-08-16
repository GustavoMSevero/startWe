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

	case 'login': //Login

		$email = $data->email;
        $senha = md5($data->password);

		try {

			$getUser=$pdo->prepare("SELECT * FROM user WHERE email=:email AND senha=:senha");
			$getUser->bindValue(":email", $email);
			$getUser->bindValue(":senha", $senha);
			$getUser->execute();

			$exists = $getUser->rowCount();

			$return = array();

			if($exists == 1){

				while ($linha=$getUser->fetch(PDO::FETCH_ASSOC)) {

						$id = $linha['id'];
						$usuario = $linha['usuario'];
			
						$return = array(
							'status' => 1,
							'idusuario' => $id,
							'usuario' => $usuario
						);
		
						echo json_encode($return);
			
					}

			}else{

				$msg = 'Usuário ou senha inválido';
				$return = array(
					'status' => 0,
					'msg' => $msg
				);

				echo json_encode($return);

			}

			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'usuario interessado':

		$idusuarioInteressado = $_GET['idusuarioInteressado'];

		$getUserInterested=$pdo->prepare("SELECT email FROM user WHERE id=:idusuarioInteressado");
		$getUserInterested->bindValue(":idusuarioInteressado", $idusuarioInteressado);
		$getUserInterested->execute();

		$return = array();

		try {

			while ($linha=$getUserInterested->fetch(PDO::FETCH_ASSOC)) {

				$email = $linha['email'];
	
				$return = array(
					'email'	=> $email
				);
	
			}
	
			echo json_encode($return);


		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'usuario startup':

		$idusuarioStartup = $_GET['idusuarioStartup'];

		$qrygetUserStartup=$pdo->prepare('SELECT email FROM user WHERE id=:idusuario');
		$qrygetUserStartup->bindValue('idusuario', $idusuarioStartup);
		$qrygetUserStartup->execute();

		$return = array();

		while ($linha=$qrygetUserStartup->fetch(PDO::FETCH_ASSOC)) {

			$email = $linha['email'];

		}

			$return = array(
				'email' => $email,
			);

			echo json_encode($return);

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