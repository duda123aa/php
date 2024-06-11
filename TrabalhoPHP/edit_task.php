<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT title, description, priority, due_date, status FROM tasks WHERE id = ? AND user_id = ?");
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($title, $description, $priority, $due_date, $status);
    $stmt->fetch();
    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $task_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, priority = ?, due_date = ?, status = ? WHERE id = ?");
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("sssssi", $title, $description, $priority, $due_date, $status, $task_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erro: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Tarefa - Gerenciador de Tarefas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Editar Tarefa</h2>
        <form action="edit_task.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($task_id); ?>">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Prioridade:</label>
                <select id="priority" name="priority">
                    <option value="Low" <?php echo ($priority == 'Low') ? 'selected' : ''; ?>>Baixa</option>
                    <option value="Medium" <?php echo ($priority == 'Medium') ? 'selected' : ''; ?>>Média</option>
                    <option value="High" <?php echo ($priority == 'High') ? 'selected' : ''; ?>>Alta</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Data de Vencimento:</label>
                <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($due_date); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pendente</option>
                    <option value="In Progress" <?php echo ($status == 'In Progress') ? 'selected' : ''; ?>>Em Progresso</option>
                    <option value="Completed" <?php echo ($status == 'Completed') ? 'selected' : ''; ?>>Concluída</option>
                </select>
            </div>
            <button type="submit" class="btn">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
