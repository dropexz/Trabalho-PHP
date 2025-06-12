<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1>Cadastro de Usuário</h1>

    <?php
        // Mensagem padrão
        $mensagem = "";

        // Conexão com o banco de dados
        $conn = new mysqli("localhost", "root", "", "sistema_tarefas");

        if ($conn->connect_error) {
            die("<div class='alert alert-danger'>Erro na conexão: " . $conn->connect_error . "</div>");
        }

        // Se o formulário for enviado
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome  = trim($_POST["nome_usuario"]);
            $email = trim($_POST["email"]);
            $senha = trim($_POST["senha"]);

            if (empty($nome) || empty($email) || empty($senha)) {
                $mensagem = "<div class='alert alert-warning'>Preencha todos os campos!</div>";
            } else {
                // Verifica se usuário já existe
                $sql = "SELECT id FROM usuarios WHERE nome_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $nome);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $mensagem = "<div class='alert alert-danger'>Nome de usuário já cadastrado!</div>";
                } else {
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO usuarios (nome_usuario, email, senha) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $nome, $email, $senha_hash);

                    if ($stmt->execute()) {
                        $mensagem = "<div class='alert alert-success'>Cadastro realizado com sucesso! <a href='login.php'>Fazer login</a></div>";
                    } else {
                        $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar usuário.</div>";
                    }
                }

                $stmt->close();
            }
        }

        // Mostra a mensagem final
        echo $mensagem;

        // Não esquecer de fechar a conexão
        $conn->close();
    ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="nome_usuario" class="form-label">Nome de Usuário</label>
            <input type="text" class="form-control" id="nome_usuario" name="nome_usuario">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha">
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="login.php" class="btn btn-link">Já tenho conta</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
