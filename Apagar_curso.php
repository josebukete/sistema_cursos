<?php
include("verificar_sessao.php");
so_formador();
include("conexao.php");

$id = $_GET['id'];

// Verificar se o curso pertence ao formador logado
$verificar = "SELECT id FROM cursos WHERE id=$id AND formador_id=$usuario_id";
$resultado = mysqli_query($conexao, $verificar);

if (mysqli_num_rows($resultado) == 0) {
    echo "Acesso negado. Este curso não te pertence.";
    echo "<br><a href='index.php'>Voltar</a>";
    exit();
}

mysqli_query($conexao, "DELETE FROM cursos WHERE id=$id");

header("Location: index.php");
exit();
?>