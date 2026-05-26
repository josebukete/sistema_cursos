<?php
include("verificar_sessao.php");
include("conexao.php");

$id = $_GET['id'];

$sql = "DELETE FROM aulas WHERE id=$id";

mysqli_query($conexao, $sql);

echo "Aula apagada com sucesso!";
echo "<br><a href='listar_aulas.php'>Voltar</a>";
?>