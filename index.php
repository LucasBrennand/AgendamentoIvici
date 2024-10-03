<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "agendamentos";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe os dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $tipo_exame = $_POST['tipo-exame'];
    $observacao = $_POST['observacao'];

    // Insere os dados no banco de dados
    $stmt = $conn->prepare("INSERT INTO agendamentos (nome, cpf, `data`, hora, tipo_exame, observacao) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome, $cpf, $data, $hora, $tipo_exame, $observacao);

    if ($stmt->execute()) {
        echo "Agendamento realizado com sucesso!";
    } else {
        echo "Erro ao realizar agendamento: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
