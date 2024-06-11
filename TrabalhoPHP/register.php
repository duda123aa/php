<!DOCTYPE html>
<html>
<head>
    <title>Registro - Gerenciador de Tarefas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Cadastro</h2>
    <form action="register_process.php" method="POST">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
