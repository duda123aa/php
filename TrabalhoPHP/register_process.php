<?php
include 'db.php'; // Inclui o arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepara a instrução SQL
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . htmlspecialchars($conn->error));
    }

    // Vincula os parâmetros
    $stmt->bind_param("sss", $username, $email, $password);

    // Executa a instrução
    if ($stmt->execute()) {
        echo "Usuário registrado com sucesso!";
        header('Location:index.php');
    } else {
        echo "Erro: " . htmlspecialchars($stmt->error);
    }

    // Fecha a instrução e a conexão
    $stmt->close();
    $conn->close();
}
?>
