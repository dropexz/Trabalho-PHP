<?php
$host = "localhost";
$usuario = "root";
$senha = ""; // ou "root", dependendo do seu ambiente
$banco = "sistema_tarefas";

$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}
?>
    