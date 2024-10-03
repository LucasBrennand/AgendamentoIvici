<?php
// agendar.php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "agendamentos";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pegar dados do POST
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$data = $_POST['data'];
$hora = $_POST['hora'];
$tipoExame = $_POST['tipo_exame'];
$observacao = $_POST['observacao'];

// Inserir dados no banco de dados
$sql = "INSERT INTO agendamentos (nome, cpf, data, hora, tipo_exame, observacao) VALUES ('$nome', '$cpf', '$data', '$hora', '$tipoExame', '$observacao')";

if ($conn->query($sql) === TRUE) {
    // Enviar e-mail
    $to = "admin_email@gmail.com";
    $subject = "Novo Agendamento";
    $message = "Novo agendamento de $nome para $data às $hora.";
    $headers = "From: seu_email@gmail.com";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["message" => "Agendamento realizado com sucesso!"]);
    } else {
        echo json_encode(["message" => "Erro ao enviar e-mail."]);
    }
} else {
    echo json_encode(["message" => "Erro ao salvar no banco de dados: " . $conn->error]);
}

$conn->close();
?>
