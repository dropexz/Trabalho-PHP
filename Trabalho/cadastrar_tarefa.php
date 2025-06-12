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
    <title>Nova Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Nova Tarefa</h1>
    <a href="index.php" class="btn btn-secondary mb-3">Voltar</a>

    <?php
        $mensagem = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titulo = trim($_POST["titulo"]);
            $descricao = trim($_POST["descricao"]);

            if (empty($titulo) || empty($descricao)) {
                $mensagem = "<div class='alert alert-warning'>Preencha todos os campos!</div>";
            } else {
                $conn = new mysqli("localhost", "root", "", "sistema_tarefas");

                if ($conn->connect_error) {
                    die("<div class='alert alert-danger'>Erro na conexão: " . $conn->connect_error . "</div>");
                }

                $sql = "INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $titulo, $descricao, $_SESSION["usuario_id"]);

                if ($stmt->execute()) {
                    $mensagem = "<div class='alert alert-success'>Tarefa cadastrada com sucesso!</div>";
                } else {
                    $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar tarefa!</div>";
                }

                $stmt->close();
                $conn->close();
            }
        }

        echo $mensagem;
    ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo">
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
