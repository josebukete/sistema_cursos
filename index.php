<?php
include("verificar_sessao.php");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Cursos</title>
</head>
<body>

<h1>Sistema de Cursos Online</h1>
<hr>

<h2>📚 Cursos</h2>
<a href="listar_cursos.php">Ver todos os cursos</a> |
<a href="criar_curso.php">Criar novo curso</a>

<h2>🎓 Aulas</h2>
<a href="listar_aulas.php">Ver todas as aulas</a> |
<a href="criar_aula.php">Criar nova aula</a>

<h2>👤 Aluno</h2>
<a href="inscrever.php">Inscrever em curso</a> |
<a href="meus_cursos.php">Meus cursos</a>
<hr>
<a href="logout.php">Terminar sessão</a>
</body>
</html>