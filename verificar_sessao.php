<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['nome'];
$usuario_tipo = $_SESSION['tipo'];

function so_formador() {
    if ($_SESSION['tipo'] != 'formador') {
        echo "Acesso negado. Esta página é apenas para formadores.";
        echo "<br><a href='index.php'>Voltar</a>";
        exit();
    }
}

function so_aluno() {
    if ($_SESSION['tipo'] != 'aluno') {
        echo "Acesso negado. Esta página é apenas para alunos.";
        echo "<br><a href='index.php'>Voltar</a>";
        exit();
    }
}
?>