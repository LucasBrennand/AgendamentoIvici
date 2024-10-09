<?php
// Conexão com o banco de dados
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

    // Prepara a query para inserir os dados no banco de dados na tabela form_input
    $stmt = $conn->prepare("INSERT INTO form_input (nome, cpf, `data`, hora, tipo_servico, observacao) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome, $cpf, $data, $hora, $tipo, $observacao);
    
    // ...
    
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Agendamento realizado com sucesso!</p>";
    
        // Enviar email
        $to = "seu_email@example.com"; // Insira o endereço de email que você deseja enviar
        $subject = "Agendamento Realizado";
        $message = "Olá, seu agendamento foi realizado com sucesso! Os detalhes do agendamento são:\n\n";
        $message .= "Nome: $nome\n";
        $message .= "CPF: $cpf\n";
        $message .= "Data: $data\n";
        $message .= "Hora: $hora\n";
        $message .= "Tipo de serviço: $tipo\n";
        $message .= "Observação: $observacao";
        $headers = "From: seu_nome <seu_email@example.com>";
    
        mail($to, $subject, $message, $headers);
    } else {
        echo "<p style='color:red;'>Erro ao realizar o agendamento: " . $conn->error . "</p>";
    }
    

    $stmt->close();
}

$conn->close();
?>
