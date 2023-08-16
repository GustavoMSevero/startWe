<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

header("Access-Control-Allow-Methods", "POST, PUT, OPTIONS");
header("Access-Control-Allow-Origin", "*.*");
header("Access-Control-Allow-Headers", "Content-Type");

include_once("con.php");

$pdo = conectar();

$uploadDir = "uploadFotoStartup/";

$uploadfile = $uploadDir . $_FILES['file_jpg']['name'];
$idstartup= $_GET['idstartup'];
$idusuario= $_GET['idusuario'];

move_uploaded_file($_FILES['file_jpg']['tmp_name'], $uploadfile);

  $nome = $_FILES[ 'file_jpg' ][ 'name' ];
  $extensao = $_FILES[ 'file_jpg' ][ 'type' ];
  $local = $_FILES[ 'file_jpg' ][ 'tmp_name' ];
  $tamanho = $_FILES[ 'file_jpg' ][ 'size' ];

  echo 'nome '.$nome.'| extensao '.$extensao.'| local '.$local.'| tamanho '.$tamanho;

try {
    $qryUploadLogo=$pdo->prepare('INSERT INTO logoStartup (idlogo, idstartup, idusuario, nome, extensao, local) VALUES (?,?,?,?,?,?)');
    $qryUploadLogo->bindValue(1, NULL);
    $qryUploadLogo->bindValue(2, $idstartup);
    $qryUploadLogo->bindValue(3, $idusuario);
    $qryUploadLogo->bindValue(4, $nome);
    $qryUploadLogo->bindValue(5, $extensao);
    $qryUploadLogo->bindValue(6, $local);
    $qryUploadLogo->execute();

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
