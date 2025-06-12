<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Login</h1>

    <?php
    $mensagem = "";

    $conn = new mysqli("localhost", "root", "", "sistema_tarefas");

    if ($conn->connect_error) {
        die("<div class='alert alert-danger'>Erro na conexão: " . $conn->connect_error . "</div>");
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST["email"]);
        $senha = trim($_POST["senha"]);

        if (empty($email) || empty($senha)) {
            $mensagem = "<div class='alert alert-warning'>Preencha todos os campos!</div>";
        } else {
           
            $sql = "SELECT id, nome_usuario, senha FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("<div class='alert alert-danger'>Erro ao preparar a consulta: " . $conn->error . "</div>");
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $usuario = $resultado->fetch_assoc();

                if (password_verify($senha, $usuario["senha"])) {
                    // Salvando os dados na sessão corretamente
                    $_SESSION["usuario_id"] = $usuario["id"];
                    $_SESSION["nome_usuario"] = $usuario["nome_usuario"];
                    $_SESSION["email"] = $email;

                    header("Location: index.php");
                    exit;
                } else {
                    $mensagem = "<div class='alert alert-danger'>Senha incorreta!</div>";
                }
            } else {
                $mensagem = "<div class='alert alert-danger'>E-mail não encontrado!</div>";
            }

            $stmt->close();
        }
    }

    echo $mensagem;
    $conn->close();
    ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha">
        </div>
        <button type="submit" class="btn btn-success">Entrar</button>
        <a href="cadastro_usuario.php" class="btn btn-link">Criar conta</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
