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
	@$option = $_GET['option'];
}

switch ($option) {
    case 'get all users':

		try {

			$getAllUsers=$pdo->prepare("SELECT * FROM user");
            $getAllUsers->execute();
            
            $quantity = $getAllUsers->rowCount();
            //echo 'quantity '.$quantity;

			$return = array();

            $return = array(
                'userQuantity' => $quantity
            );

            echo json_encode($return);
			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        break;

    case 'get startups':

        try {

            $getStartups=$pdo->prepare("SELECT * FROM perfilStartup");
            $getStartups->execute();
            
            $quantity = $getStartups->rowCount();
            //echo 'quantity '.$quantity;

            $return = array();

            $return = array(
                'startupsQuantity' => $quantity
            );

            echo json_encode($return);
            
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        break;

    case 'get notifications':

        try {

            $getNotifications=$pdo->prepare("SELECT * FROM notificacoes");
            $getNotifications->execute();
            
            $quantity = $getNotifications->rowCount();
            //echo 'quantity '.$quantity;

            $return = array();

            $return = array(
                'notificationsQuantity' => $quantity
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