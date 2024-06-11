<!DOCTYPE html>
<html>
<head>
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Gerenciador de Tarefas</h1>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Nome de Usuário:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Não tem uma conta? <a href="register.php">Cadastre-se aqui</a></p>
    </div>
</body>
</html>
