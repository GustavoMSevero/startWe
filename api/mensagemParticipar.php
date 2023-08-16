<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', true);
error_reporting(E_ALL);

include_once("con.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

require 'vendor/autoload.php';

$pdo = conectar();

$data = file_get_contents("php://input");
$data = json_decode($data);

//var_dump($data);

$mensagem = $data->mensagem;
$nomeStartup = $data->nomeStartup;
$nomeResponsavel = $data->nomeResponsavel;
$emailDonoStartup = $data->emailDonoStartup;
$idusuarioStartup = $data->idusuarioStartup;
$idusuarioNotificado = $data->idusuarioStartup;

$emailUsuarioInteressado = $data->emailUsuarioInteressado;
$idUsuarioInteressado = $data->idusuariologado;
$usuarioInteressado = $data->usuarioInteressado;

$idRemetente = $idUsuarioInteressado; // id do usuário logado
$idDestinatario = $idusuarioStartup; // id usuário da Startup

$nomeRemetente = $usuarioInteressado;
$nomeDestinatario = $nomeResponsavel;

$qtd = str_word_count($nomeRemetente);

if($qtd != 0){
    $nomeRemetenteP = explode(" ", $nomeRemetente);
    $nomeRemetente = $nomeRemetenteP[0];
}

$lido = 'no';

$saveMessage=$pdo->prepare('INSERT INTO notificacoes (idnotificacao, idremetente, iddestinatario, nomeRemetente, nomeDestinatario, idusuarioNotificado ,mensagem, startup, responsavel, emailDonoStartup, 
                            emailUsuarioInteressado, idusuarioInteressado, usuarioInteressado, lido) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
$saveMessage->bindValue(1, NULL);
$saveMessage->bindValue(2, $idRemetente);
$saveMessage->bindValue(3, $idDestinatario);
$saveMessage->bindValue(4, $nomeRemetente);
$saveMessage->bindValue(5, $nomeDestinatario);
$saveMessage->bindValue(6, $idusuarioNotificado);
$saveMessage->bindValue(7, $mensagem);
$saveMessage->bindValue(8, $nomeStartup);
$saveMessage->bindValue(9, $nomeResponsavel);
$saveMessage->bindValue(10, $emailDonoStartup);
$saveMessage->bindValue(11, $emailUsuarioInteressado);
$saveMessage->bindValue(12, $idUsuarioInteressado);
$saveMessage->bindValue(13, $usuarioInteressado);
$saveMessage->bindValue(14, $lido);
$saveMessage->execute();

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = 'smtp.startwe.com.br';                 // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.uni5.net';                        // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'participar@startwe.com.br';            // SMTP username
    $mail->Password   = 'Participar@2019';                      // SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('participar@startwe.com.br', 'StartWe');
    $mail->addAddress($emailDonoStartup, $nomeResponsavel);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'INTERESSE NA SUA STARTUP';
    $mail->Body    = $mensagem;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //$mail->send();
    //echo 'Message has been sent';

    $msg = 'Sua mensagem foi enviada com sucesso!';

    $return = array(
        'msg' => $msg
    );

    echo json_encode($return);

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}





?>