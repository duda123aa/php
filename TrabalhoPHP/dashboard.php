<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Gerenciador de Tarefas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <div class="welcome-container">
            <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
            <form action="logout.php" method="POST">
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>
    <div class="container">
        <h2>Suas Tarefas</h2>
        <table class="task-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Data de Vencimento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT id, title, description, priority, due_date, status FROM tasks WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['priority']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>
                            <a href='edit_task.php?id=" . $row['id'] . "'>Editar</a>
                            <a href='delete_task.php?id=" . $row['id'] . "'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }

                $stmt->close();
                ?>
            </tbody>
        </table>
        <h2>Criar Nova Tarefa</h2>
        <form action="create_task.php" method="POST">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Prioridade:</label>
                <select id="priority" name="priority">
                    <option value="Low">Baixa</option>
                    <option value="Medium">Média</option>
                    <option value="High">Alta</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Data de Vencimento:</label>
                <input type="date" id="due_date" name="due_date" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Pending">Pendente</option>
                    <option value="In Progress">Em Progresso</option>
                    <option value="Completed">Concluída</option>
                </select>
            </div>
            <button type="submit" class="btn">Criar Tarefa</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
