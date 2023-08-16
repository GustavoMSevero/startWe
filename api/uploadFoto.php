<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

header("Access-Control-Allow-Methods", "POST, PUT, OPTIONS");
header("Access-Control-Allow-Origin", "*.*");
header("Access-Control-Allow-Headers", "Content-Type");

include_once("con.php");

$pdo = conectar();

$uploadDir = "uploadFoto/";

$uploadfile = $uploadDir . $_FILES['file_jpg']['name'];
$idusuario= $_GET['idusuario'];

move_uploaded_file($_FILES['file_jpg']['tmp_name'], $uploadfile);

  $nome = $_FILES[ 'file_jpg' ][ 'name' ];
  $extensao = $_FILES[ 'file_jpg' ][ 'type' ];
  $local = $_FILES[ 'file_jpg' ][ 'tmp_name' ];
  $tamanho = $_FILES[ 'file_jpg' ][ 'size' ];

try {
    $qryUploadImage=$pdo->prepare('INSERT INTO fotoUsuario (idfoto, idusuario, nome, extensao, local) VALUES (?,?,?,?,?)');
    $qryUploadImage->bindValue(1, NULL);
    $qryUploadImage->bindValue(2, $idusuario);
    $qryUploadImage->bindValue(3, $nome);
    $qryUploadImage->bindValue(4, $extensao);
    $qryUploadImage->bindValue(5, $local);
    $qryUploadImage->execute();

    $status = 1;

    $return = array(
      'status' => $status
    );

    echo json_encode($return);

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";

}
  


?>
