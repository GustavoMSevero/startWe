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

	case 'numero notificacoes':

		$idusuario = $_GET['idusuario'];
		$lido = 'no';

		try {

			$getNumerNotificationsUser=$pdo->prepare("SELECT * FROM notificacoes WHERE iddestinatario=:idusuario AND lido=:lido");
			$getNumerNotificationsUser->bindValue(":idusuario", $idusuario);
			$getNumerNotificationsUser->bindValue(":lido", $lido);
			$getNumerNotificationsUser->execute();

			$quantity = $getNumerNotificationsUser->rowCount();
			
			if($quantity > 0){
				$return = array();

				$return = array(
					'quantity' => $quantity
				);

				echo json_encode($return);
			} else {
				$return = array();

				$return = array(
					'quantity' => ''
				);

				echo json_encode($return);
			}

			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'pegar notificacoes':

		$idusuario = $_GET['idusuario'];

		try {

			$getNotifications=$pdo->prepare("SELECT * FROM notificacoes WHERE iddestinatario=:idusuario");
			$getNotifications->bindValue(":idusuario", $idusuario);
			$getNotifications->execute();

			while ($linha=$getNotifications->fetch(PDO::FETCH_ASSOC)) {

				$mensagem = $linha['mensagem'];
				$usuarioInteressado = $linha['usuarioInteressado'];
				$idusuarioInteressado = $linha['idusuarioInteressado'];
				$idusuarioNotificado = $linha['idusuarioNotificado'];

				$idremetente = $linha['idremetente'];
				$iddestinatario = $linha['iddestinatario'];

				$nomeRemetente = $linha['nomeRemetente'];
				$nomeDestinatario = $linha['nomeDestinatario'];

				$qtd = str_word_count($nomeRemetente);

				if($qtd != 0){
					$nomeRemetenteP = explode(" ", $nomeRemetente);
					$nomeRemetente = $nomeRemetenteP[0];
				}
	
				$return[] = array(
					'idremetente'	=> $idremetente,
					'iddestinatario'	=> $iddestinatario,
					'idusuarioInteressado'	=> $idusuarioInteressado,
					'idusuarioNotificado'	=> $idusuarioNotificado,
					'mensagem'	=> $mensagem,
					'nomeRemetente'	=> $nomeRemetente
				);
	
			}
	
			echo json_encode($return);
			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'pegar mensagem do usuário interessado':

		$idusuarioInteressado = $_GET['idusuarioInteressado'];
		$idusuarioNotificado = $_GET['idusuarioNotificado'];

		try {

			$getNotification=$pdo->prepare("SELECT * FROM notificacoes WHERE idusuarioNotificado=:idusuarioNotificado 
											AND idusuarioInteressado=:idusuarioInteressado");
			$getNotification->bindValue(":idusuarioNotificado", $idusuarioNotificado);
			$getNotification->bindValue(":idusuarioInteressado", $idusuarioInteressado);
			$getNotification->execute();

			while ($linha=$getNotification->fetch(PDO::FETCH_ASSOC)) {

				$mensagem = $linha['mensagem'];
				$usuarioInteressado = $linha['usuarioInteressado'];
				$idusuarioInteressado = $linha['idusuarioInteressado'];
				$idusuarioNotificado = $linha['idusuarioNotificado'];
				$responsavel = $linha['responsavel'];
				$emailDonoStartup = $linha['emailDonoStartup'];
				$emailUsuarioInteressado = $linha['emailUsuarioInteressado'];
				$startup = $linha['startup'];
				$idremetente = $linha['idremetente'];
				$iddestinatario = $linha['iddestinatario'];

				$nomeRemetente = $linha['nomeRemetente'];
				$nomeDestinatario = $linha['nomeDestinatario'];

				//Quantas nomes tem o nome
				$qtd = str_word_count($usuarioInteressado);

				//Se for maior que maior que 1, separa o 1o. nome do 2o.
				if($qtd != 0){
					$usuarioInteressadoP = explode(" ", $usuarioInteressado);
					$usuarioInteressado = $usuarioInteressadoP[0];
				}

				//Quantas nomes tem o nome
				$qtd = str_word_count($nomeRemetente);

				//Se for maior que maior que 1, separa o 1o. nome do 2o.
				if($qtd != 0){
					$nomeRemetenteP = explode(" ", $nomeRemetente);
					$nomeRemetente = $nomeRemetenteP[0];
				}
	
				$return = array(
					'startup'	=> $startup,
					'idusuarioNotificado'	=> $idusuarioNotificado,
					'responsavel'	=> $responsavel,
					'emailDonoStartup'	=> $emailDonoStartup,
					'mensagem'	=> $mensagem,
					'usuarioInteressado'	=> $usuarioInteressado,
					'idusuarioInteressado'	=> $idusuarioInteressado,
					'emailUsuarioInteressado'	=> $emailUsuarioInteressado,
					'idremetente'	=> $idremetente,
					'iddestinatario'	=> $iddestinatario,

					'nomeRemetente'	=> $nomeRemetente,  //Leonel
					'nomeDestinatario'	=> $nomeDestinatario //Gustavo
				);
	
			}
	
			echo json_encode($return);
			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'salvar resposta':

		$startup = $data->startup;
		$idusuarioNotificado = $data->idusuarioNotificado;
		$responsavel = $data->responsavel;
		$emailDonoStartup = $data->emailDonoStartup;
		$usuarioInteressado = $data->usuarioInteressado;
		$idusuarioInteressado = $data->idusuarioInteressado;
		$emailUsuarioInteressado = $data->emailUsuarioInteressado;
		$mensagem = $data->mensagemResposta;

		$iddestinatario = $data->idremetente;
		$idremetente = $data->iddestinatario;

		$nomeDestinatario = $data->nomeRemetente;
		$nomeRemetente = $data->nomeDestinatario;

		$qtd = str_word_count($nomeRemetente);

		if($qtd != 0){
			$nomeRemetenteP = explode(" ", $nomeRemetente);
			$nomeRemetente = $nomeRemetenteP[0];
		}

		$lido = 'no';

		try {

			$saveAnswer=$pdo->prepare("INSERT INTO notificacoes (idnotificacao, idremetente, iddestinatario, nomeRemetente, nomeDestinatario, idusuarioNotificado, mensagem, startup, responsavel, 
									emailDonoStartup, emailUsuarioInteressado, idusuarioInteressado ,usuarioInteressado, lido) 
										VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$saveAnswer->bindValue(1, NULL);
			$saveAnswer->bindValue(2, $idremetente);
			$saveAnswer->bindValue(3, $iddestinatario);
			$saveAnswer->bindValue(4, $nomeRemetente);
			$saveAnswer->bindValue(5, $nomeDestinatario);
			$saveAnswer->bindValue(6, $idusuarioNotificado);
			$saveAnswer->bindValue(7, $mensagem);
			$saveAnswer->bindValue(8, $startup);
			$saveAnswer->bindValue(9, $responsavel);
			$saveAnswer->bindValue(10, $emailDonoStartup);
			$saveAnswer->bindValue(11, $emailUsuarioInteressado);
			$saveAnswer->bindValue(12, $idusuarioInteressado);
			$saveAnswer->bindValue(13, $usuarioInteressado);
			$saveAnswer->bindValue(14, $lido);
			
			$saveAnswer->execute();

			$msg = 'Mensagem enviada com sucesso!';

			$return = array(
				'status'	=> 1,
				'msg'	=> $msg
			);
	
		
	
			echo json_encode($return);
			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;
	
	default:
		# code...
		break;
}




?>