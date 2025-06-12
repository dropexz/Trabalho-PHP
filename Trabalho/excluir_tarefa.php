<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id"])) {
    $id_tarefa = intval($_GET["id"]);
    $usuario_id = $_SESSION["usuario_id"];

    $conn = new mysqli("localhost", "root", "", "sistema_tarefas");

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $sql = "DELETE FROM tarefas WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_tarefa, $usuario_id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=excluido");
        exit;
    } else {
        echo "Erro ao excluir a tarefa.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID inválido.";
}
?>
