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
    <title>Editar Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Editar Tarefa</h1>

    <?php
        $conn = new mysqli("localhost", "root", "", "sistema_tarefas");

        if ($conn->connect_error) {
            die("<div class='alert alert-danger'>Erro na conexão: " . $conn->connect_error . "</div>");
        }

        $mensagem = "";

        if (isset($_GET["id"])) {
            $id_tarefa = intval($_GET["id"]);
            $usuario_id = $_SESSION["usuario_id"];

            // Buscar os dados da tarefa para preencher o formulário
            $sql = "SELECT * FROM tarefas WHERE id = ? AND usuario_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id_tarefa, $usuario_id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $tarefa = $resultado->fetch_assoc();
            } else {
                echo "<div class='alert alert-warning'>Tarefa não encontrada ou você não tem permissão para editá-la.</div>";
                exit;
            }

            $stmt->close();
        }

        // Atualizar a tarefa ao enviar o formulário
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titulo = trim($_POST["titulo"]);
            $descricao = trim($_POST["descricao"]);
            $id_tarefa = intval($_POST["id"]);

            if (empty($titulo) || empty($descricao)) {
                $mensagem = "<div class='alert alert-warning'>Preencha todos os campos!</div>";
            } else {
                $sql = "UPDATE tarefas SET titulo = ?, descricao = ? WHERE id = ? AND usuario_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssii", $titulo, $descricao, $id_tarefa, $_SESSION["usuario_id"]);

                if ($stmt->execute()) {
                    $mensagem = "<div class='alert alert-success'>Tarefa atualizada com sucesso!</div>";
                    // Atualiza os valores locais para exibir na tela
                    $tarefa["titulo"] = $titulo;
                    $tarefa["descricao"] = $descricao;
                } else {
                    $mensagem = "<div class='alert alert-danger'>Erro ao atualizar tarefa.</div>";
                }

                $stmt->close();
            }
        }

        echo $mensagem;
    ?>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $tarefa["id"]; ?>">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $tarefa["titulo"]; ?>">
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao"><?php echo $tarefa["descricao"]; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
