<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $path = (file_exists('autenticacao/login.php')) ? 'autenticacao/login.php' : '../autenticacao/login.php';
    header("Location: $path");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['nome'];
$usuario_tipo = $_SESSION['tipo'];

function so_formador() {
    if ($_SESSION['tipo'] != 'formador') {
        echo "Acesso negado. Esta página é apenas para formadores.";
        $path = (file_exists('index.php')) ? 'index.php' : '../index.php';
        echo "<br><a href='$path'>Voltar</a>";
        exit();
    }
}

function so_aluno() {
    if ($_SESSION['tipo'] != 'aluno') {
        echo "Acesso negado. Esta página é apenas para alunos.";
        $path = (file_exists('index.php')) ? 'index.php' : '../index.php';
        echo "<br><a href='$path'>Voltar</a>";
        exit();
    }
}
?>