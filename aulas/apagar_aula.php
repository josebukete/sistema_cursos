<?php
include("../config/verificar_sessao.php");
so_formador();
include("../config/conexao.php");

$id = $_GET['id'];

// Buscar o curso_id antes de apagar
$aula = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT curso_id FROM aulas WHERE id=$id"));
$curso_id = $aula['curso_id'];

$sql = "DELETE FROM aulas WHERE id=$id";
mysqli_query($conexao, $sql);

header("Location: ver_aulas_formador.php?curso_id=$curso_id");
exit();
?>