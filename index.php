<?php
include("verificar_sessao.php");
include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Cursos</title>
</head>
<body>

<h1>Olá, <?= $usuario_nome ?>!</h1>
<hr>

<?php if ($usuario_tipo == 'formador'): ?>

    <h2>📚 Os meus cursos</h2>
    <?php
    $meus_cursos = mysqli_query($conexao, "SELECT id, nome, thumbnail FROM cursos WHERE formador_id=$usuario_id");
    if (mysqli_num_rows($meus_cursos) == 0):
    ?>
        <p>Ainda não criaste nenhum curso.</p>
    <?php else: ?>
        <?php while($c = mysqli_fetch_assoc($meus_cursos)): ?>
            <div class="curso-card">
                <?php if ($c['thumbnail']): ?>
                    <img src="<?= $c['thumbnail'] ?>" alt="Thumbnail" width="150"><br>
                <?php endif; ?>
                <p>
                    <strong><?= $c['nome'] ?></strong> —
                    <a href="ver_aulas_formador.php?curso_id=<?= $c['id'] ?>">Ver aulas</a>
                    &nbsp;|&nbsp;
                    <a href="criar_aula.php?curso_id=<?= $c['id'] ?>">Adicionar aula</a>
                    &nbsp;|&nbsp;
                    <a href="editar_curso.php?id=<?= $c['id'] ?>">Editar</a>
                    &nbsp;|&nbsp;
                    <a href="Apagar_curso.php?id=<?= $c['id'] ?>" onclick="return confirm('Tens a certeza?')">Apagar</a>
                </p>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php endif; ?>

    <br>
    <a href="criar_curso.php">+ Criar novo curso</a> |
    <a href="cursos.php">Ver todos os cursos</a>

<?php else: ?>

    <h2>📚 Cursos inscritos</h2>
    <?php
    $inscritos = mysqli_query($conexao,
        "SELECT cursos.id, cursos.nome, cursos.thumbnail,
                COUNT(DISTINCT aulas.id) AS total_aulas,
                SUM(CASE WHEN progresso_aulas.concluida = 1 THEN 1 ELSE 0 END) AS aulas_concluidas
         FROM inscricoes
         JOIN cursos ON inscricoes.curso_id = cursos.id
         LEFT JOIN aulas ON aulas.curso_id = cursos.id
         LEFT JOIN progresso_aulas ON progresso_aulas.aula_id = aulas.id
                                   AND progresso_aulas.usuario_id = $usuario_id
         WHERE inscricoes.usuario_id = $usuario_id
         GROUP BY cursos.id, cursos.nome, cursos.thumbnail");

    if (mysqli_num_rows($inscritos) == 0):
    ?>
        <p>Ainda não estás inscrito em nenhum curso.</p>
    <?php else: ?>
        <?php while($c = mysqli_fetch_assoc($inscritos)): ?>
            <?php
                $total = $c['total_aulas'];
                $concluidas = $c['aulas_concluidas'];
                $percentagem = $total > 0 ? round(($concluidas / $total) * 100) : 0;
            ?>
            <div class="curso-card">
                <?php if ($c['thumbnail']): ?>
                    <img src="<?= $c['thumbnail'] ?>" alt="Thumbnail" width="150"><br>
                <?php endif; ?>
                <p><strong><?= $c['nome'] ?></strong></p>
                <p>Progresso: <?= $concluidas ?>/<?= $total ?> aulas concluídas</p>
                <progress value="<?= $percentagem ?>" max="100"></progress>
                <span><?= $percentagem ?>%</span> —
                <a href="ver_aulas.php?curso_id=<?= $c['id'] ?>">Ver Aulas</a>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php endif; ?>

    <br>
    <a href="cursos.php">+ Inscrever em novo curso</a>

<?php endif; ?>

<hr>
<a href="logout.php">Terminar sessão</a>

</body>
</html>