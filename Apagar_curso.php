<?php
include("verificar_sessao.php");
so_formador();
include("conexao.php");

$id = $_GET['id'];

$sql = "DELETE FROM cursos WHERE id=$id";

mysqli_query($conexao, $sql);

echo "Curso apagado com sucesso!";
echo "<br><a href='cursos.php'>Voltar</a>";
?>