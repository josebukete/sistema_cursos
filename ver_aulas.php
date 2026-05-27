<?php
include("verificar_sessao.php");
so_aluno();
include("conexao.php");

$curso_id = $_GET['curso_id'];

$verificar = "SELECT id FROM inscricoes 
              WHERE usuario_id=$usuario_id AND curso_id=$curso_id";
$resultado = mysqli_query($conexao, $verificar);

if (mysqli_num_rows($resultado) == 0) {
    echo "Não tens acesso a este curso.";
    echo "<br><a href='cursos.php'>Ver cursos disponíveis</a>";
    exit();
}

$sql = "SELECT aulas.id, aulas.titulo, aulas.conteudo, aulas.ordem_aula,
               aulas.thumbnail, aulas.video,
               progresso_aulas.concluida
        FROM aulas
        LEFT JOIN progresso_aulas ON progresso_aulas.aula_id = aulas.id
                                  AND progresso_aulas.usuario_id = $usuario_id
        WHERE aulas.curso_id = $curso_id
        ORDER BY aulas.ordem_aula";

$aulas = mysqli_query($conexao, $sql);

$curso = mysqli_fetch_assoc(mysqli_query($conexao,
         "SELECT nome FROM cursos WHERE id=$curso_id"));
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Aulas — <?= $curso['nome'] ?></title>
</head>
<body>

<h1><?= $curso['nome'] ?></h1>
<a href="cursos.php">← Voltar aos cursos</a>
<hr>

<?php while($aula = mysqli_fetch_assoc($aulas)): ?>

    <div class="aula-item <?= $aula['concluida'] ? 'concluida' : '' ?>">

        <?php if ($aula['thumbnail']): ?>
            <img src="<?= $aula['thumbnail'] ?>" alt="Thumbnail" width="200">
        <?php endif; ?>

        <h3>Aula <?= $aula['ordem_aula'] ?> — <?= $aula['titulo'] ?></h3>

        <?php if ($aula['concluida']): ?>
            <p>✅ Concluída</p>
        <?php endif; ?>

        <a href="ver_aula.php?id=<?= $aula['id'] ?>&curso_id=<?= $curso_id ?>">Ver Aula</a>

    </div>

    <hr>

<?php endwhile; ?>

</body>
</html>