<?php
include("conexao.php");
include("verificar_sessao.php");

// Buscar aulas juntas com o nome do curso
$sql = "SELECT aulas.id, aulas.titulo, aulas.conteudo, aulas.ordem_aula, cursos.nome AS nome_curso
        FROM aulas
        JOIN cursos ON aulas.curso_id = cursos.id
        ORDER BY cursos.nome, aulas.ordem_aula";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Aulas</title>
</head>
<body>

<h1>Lista de Aulas</h1>

<a href="criar_aula.php">+ Nova Aula</a> |
<a href="index.php">Início</a>

<hr>

<?php while($aula = mysqli_fetch_assoc($resultado)): ?>

    <div class="aula">
        <small>Curso: <strong><?= $aula['nome_curso'] ?></strong></small>
        <h3>Aula <?= $aula['ordem_aula'] ?> — <?= $aula['titulo'] ?></h3>
        <p><?= $aula['conteudo'] ?></p>

        <a href="editar_aula.php?id=<?= $aula['id'] ?>">Editar</a> |
        <a href="apagar_aula.php?id=<?= $aula['id'] ?>"
           onclick="return confirm('Apagar esta aula?')">Apagar</a>
    </div>

    <hr>

<?php endwhile; ?>

<a href="logout.php">Terminar sessão</a>
</body>
</html>