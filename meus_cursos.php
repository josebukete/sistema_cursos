<?php
include("conexao.php");


include("verificar_sessao.php");


$sql = "SELECT cursos.id, cursos.nome, cursos.categoria, cursos.nivel,
               COUNT(aulas.id) AS total_aulas,
               SUM(CASE WHEN progresso_aulas.concluida = 1 THEN 1 ELSE 0 END) AS aulas_concluidas
        FROM inscricoes
        JOIN cursos ON inscricoes.curso_id = cursos.id
        LEFT JOIN aulas ON aulas.curso_id = cursos.id
        LEFT JOIN progresso_aulas ON progresso_aulas.aula_id = aulas.id 
                                  AND progresso_aulas.usuario_id = $usuario_id
        WHERE inscricoes.usuario_id = $usuario_id
        GROUP BY cursos.id, cursos.nome, cursos.categoria, cursos.nivel";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Meus Cursos</title>
</head>
<body>

<h1>Meus Cursos</h1>

<a href="inscrever.php">Ver mais cursos</a> |
<a href="index.php">Início</a>

<hr>

<?php while($curso = mysqli_fetch_assoc($resultado)): ?>

    <?php
        $total = $curso['total_aulas'];
        $concluidas = $curso['aulas_concluidas'];
        $percentagem = $total > 0 ? round(($concluidas / $total) * 100) : 0;
    ?>

    <div class="meu-curso">
        <h3><?= $curso['nome'] ?></h3>
        <p>Categoria: <?= $curso['categoria'] ?> | Nível: <?= $curso['nivel'] ?></p>

        <p>Progresso: <?= $concluidas ?>/<?= $total ?> aulas concluídas</p>

        <!-- Barra de progresso simples em HTML -->
        <progress value="<?= $percentagem ?>" max="100"></progress>
        <span><?= $percentagem ?>%</span>

        <br><br>
        <a href="ver_aulas.php?curso_id=<?= $curso['id'] ?>">Ver Aulas</a>
    </div>

    <hr>

<?php endwhile; ?>

</body>
</html>