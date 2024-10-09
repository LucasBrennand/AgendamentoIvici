<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';
header('Content-Type: application/json');
$response = [];
switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "agendamentos";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Verifica se o formulário foi submetido
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $data = $_POST['data'];
            $hora = $_POST['hora'];
            $tipo = $_POST['tipo'];
            $observacao = $_POST['observacao'];
            $data = date('Y-m-d', strtotime(str_replace('/', '-', $data)));
            $email = $_POST['email'];


            // Prepara a query para inserir os dados no banco de dados na tabela form_input
            $stmt = $conn->prepare("INSERT INTO form_input (nome, cpf, `data`, hora, tipo_servico, observacao) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nome, $cpf, $data, $hora, $tipo, $observacao);
            
            // ...
            
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Agendamento realizado com sucesso!</p>";
            
                // Enviar email
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;   
                    $mail->isSMTP();
                    $mail->Host = 'smtp.hostinger.com';
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 465;
                    $mail->CharSet = 'UTF-8';
                    $mail->Username = 'contato@ivici.com.br';
                    $mail->Password = '!Contatoivici11contatoivici$';

                    $mail->setFrom($email);
                    $mail->addAddress('contato@ivici.com.br', 'Ivici');

                    $mail->isHTML(true);
                    $mail->Subject = 'Agendamento realizado';
                    $mail->Body = 'O agendamento foi realizado com sucesso!';
                    if($mail->send()){
                        $response = ['status' => 'success', 'message' => 'Email enviado com sucesso.'];
                    }
                } catch (Exception $e) {
                    //echo "Erro ao enviar o email: {$mail->ErrorInfo}";
                    $response = ["status"=> "error","message"=> "Erro ao enviar o email: {$mail->ErrorInfo}"];
                }
            } else {
                echo "<p style='color:red;'>Erro ao realizar o agendamento: " . $conn->error . "</p>";
            }
            
            $stmt->close();
        }

        
        $conn->close();
        break;
        default:
            $response['error'] = true;
            $response['message'] = 'Request method not allowed';
            $conn->close();
        }
