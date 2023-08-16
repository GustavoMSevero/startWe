<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

header("Access-Control-Allow-Methods", "POST, PUT, OPTIONS");
header("Access-Control-Allow-Origin", "*.*");
header("Access-Control-Allow-Headers", "Content-Type");

include_once("con.php");

$pdo = conectar();

$uploadDir = "uploadCurriculo/";

$uploadfile = $uploadDir . $_FILES['file_jpg']['name'];
$idusuario= $_GET['idusuario'];

move_uploaded_file($_FILES['file_jpg']['tmp_name'], $uploadfile);

  $nome = $_FILES[ 'file_pdf' ][ 'name' ];
  $extensao = $_FILES[ 'file_pdf' ][ 'type' ];
  $local = $_FILES[ 'file_pdf' ][ 'tmp_name' ];
  $tamanho = $_FILES[ 'file_pdf' ][ 'size' ];

try {
    $qryUploadCV=$pdo->prepare('INSERT INTO curriculo (idusuario, nome, extensao, local) VALUES (?,?,?,?)');
    $qryUploadCV->bindValue(1, $idusuario);
    $qryUploadCV->bindValue(2, $nome);
    $qryUploadCV->bindValue(3, $extensao);
    $qryUploadCV->bindValue(4, $local);
    $qryUploadCV->execute();

    $status = 1;
    //$msg = 'OK';

    $return = array(
      //'msg' => 
      'status' => $status
    );

    echo json_encode($return);

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";

}
  


?>
