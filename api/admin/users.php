<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', true);
error_reporting(E_ALL);

include_once("../con.php");

$pdo = conectar();

$data = file_get_contents("php://input");
$data = json_decode($data);

//print_r($data);

if($data){
	$option = $data->option;
}else{
	@$option = $_GET['option'];
}

switch ($option) {
    case 'login admin':
        
        $email = $data->email;
        $senha = $data->password;

		try {

			$getUser=$pdo->prepare("SELECT * FROM userAdmin WHERE email=:email AND senha=:senha");
			$getUser->bindValue(":email", $email);
			$getUser->bindValue(":senha", $senha);
			$getUser->execute();

			$exists = $getUser->rowCount();

			$return = array();

            while ($linha=$getUser->fetch(PDO::FETCH_ASSOC)) {

                    $idusuario = $linha['idusuario'];
                    $nome = $linha['nome'];
        
                    $return = array(
                        'idusuario' => $idusuario,
                        'nome' => $nome
                    );
    
                    echo json_encode($return);
        
                }
			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        break;
    
    default:
        # code...
        break;
}


?>