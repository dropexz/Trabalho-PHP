<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Bem-vindo(a), <?php echo $_SESSION["nome_usuario"]; ?>!</h1>
    <p>
        <a href="cadastrar_tarefa.php" class="btn btn-primary">Nova Tarefa</a>
        <a href="logout.php" class="btn btn-danger">Sair</a>
    </p>

    <?php
        if (isset($_GET["msg"]) && $_GET["msg"] === "excluido") {
            echo "<div class='alert alert-success'>Tarefa excluída com sucesso!</div>";
        }

        $conn = new mysqli("localhost", "root", "", "sistema_tarefas");

        if ($conn->connect_error) {
            die("<div class='alert alert-danger'>Erro na conexão: " . $conn->connect_error . "</div>");
        }

        $usuario_id = $_SESSION["usuario_id"];

        $sql = "SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY id DESC";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("<div class='alert alert-danger'>Erro ao preparar a query: " . $conn->error . "</div>");
        }

        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead class='table-light'><tr><th>ID</th><th>Título</th><th>Descrição</th><th>Ações</th></tr></thead>";
            echo "<tbody>";

            while($tarefa = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo    "<td>" . $tarefa['id']        . "</td>";
                echo    "<td>" . $tarefa['titulo']    . "</td>";
                echo    "<td>" . $tarefa['descricao'] . "</td>";
                echo    "<td>";
                echo        '<a class="btn btn-sm btn-warning me-1" href="editar_tarefa.php?id=' . $tarefa['id'] . '">Editar</a>';
                echo        '<a class="btn btn-sm btn-danger" href="excluir_tarefa.php?id=' . $tarefa['id'] . '" onclick="return confirm(\'Tem certeza que deseja excluir esta tarefa?\');">Excluir</a>';
                echo    "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info'>Nenhuma tarefa cadastrada ainda.</div>";
        }

        $stmt->close();
        $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
