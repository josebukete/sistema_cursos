<?php
include("verificar_sessao.php");
include("conexao.php");

$sql = "SELECT * FROM cursos";

$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cursos</title>
</head>
<body>

<h1>Lista de Cursos</h1>

<?php

while($curso = mysqli_fetch_assoc($resultado)) {

    echo "<h3>" . $curso['nome'] . "</h3>";
    echo "<p>" . $curso['descricao'] . "</p>";
    echo "<p>" . $curso['categoria'] . "</p>";
    ECHO "<p>" . $curso['nivel']. "</p>";

    echo "<a href='editar_curso.php?id=".$curso['id']."'>Editar</a> | ";

    echo "<a href='apagar_curso.php?id=".$curso['id']."' onclick=\"return confirm('Tens a certeza?')\">Apagar</a>";
    echo "<hr>";
}

?>

<a href="logout.php">Terminar sessão</a>

</body>
</html>