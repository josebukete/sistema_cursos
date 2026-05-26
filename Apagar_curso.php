<?php
include("verificar_sessao.php");
include("conexao.php");

$id = $_GET['id'];

$sql = "DELETE FROM cursos WHERE id=$id";

mysqli_query($conexao, $sql);

echo "Curso apagado com sucesso!";
echo "<br><a href='listar_cursos.php'>Voltar</a>";
?>