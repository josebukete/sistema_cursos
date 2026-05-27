<?php
include("../config/verificar_sessao.php");
include("../config/conexao.php");

// Inscrição quando aluno clica "Inscrever-me"
if (isset($_POST['inscrever'])) {
    $curso_id = $_POST['curso_id'];

    $verificar = "SELECT id FROM inscricoes WHERE usuario_id=$usuario_id AND curso_id=$curso_id";
    $resultado = mysqli_query($conexao, $verificar);

    if (mysqli_num_rows($resultado) == 0) {
        mysqli_query($conexao, "INSERT INTO inscricoes (usuario_id, curso_id) VALUES ($usuario_id, $curso_id)");
    }

    header("Location: cursos.php");
    exit();
}

// Buscar todos os cursos com progresso do aluno logado
$sql = "SELECT cursos.*,
               usuarios.nome AS nome_formador,
               COUNT(DISTINCT aulas.id) AS total_aulas,
               SUM(CASE WHEN progresso_aulas.concluida = 1 THEN 1 ELSE 0 END) AS aulas_concluidas,
               MAX(CASE WHEN inscricoes.usuario_id = $usuario_id THEN 1 ELSE 0 END) AS inscrito
        FROM cursos
        JOIN usuarios ON cursos.formador_id = usuarios.id
        LEFT JOIN aulas ON aulas.curso_id = cursos.id
        LEFT JOIN progresso_aulas ON progresso_aulas.aula_id = aulas.id
                                  AND progresso_aulas.usuario_id = $usuario_id
        LEFT JOIN inscricoes ON inscricoes.curso_id = cursos.id
                             AND inscricoes.usuario_id = $usuario_id
        GROUP BY cursos.id";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cursos</title>
</head>
<body>

<h1>Cursos</h1>
<a href="../index.php">Início</a>
<hr>

<?php while($curso = mysqli_fetch_assoc($resultado)): ?>

    <h3><?= $curso['nome'] ?></h3>
    <?php if ($curso['thumbnail']): ?>
    <img src="../<?= $curso['thumbnail'] ?>" alt="Thumbnail" width="250"><br><br>
    <?php endif; ?>
    <p>Por: <?= $curso['nome_formador'] ?></p>
    <p><?= $curso['descricao'] ?></p>
    <p>Categoria: <?= $curso['categoria'] ?> | Nível: <?= $curso['nivel'] ?></p>

    <?php if ($curso['inscrito']): ?>

        <?php
            $total = $curso['total_aulas'];
            $concluidas = $curso['aulas_concluidas'];
            $percentagem = $total > 0 ? round(($concluidas / $total) * 100) : 0;
        ?>
        <p>Progresso: <?= $concluidas ?>/<?= $total ?> aulas</p>
        <progress value="<?= $percentagem ?>" max="100"></progress>
        <span><?= $percentagem ?>%</span><br><br>
        <a href="../aulas/ver_aulas.php?curso_id=<?= $curso['id'] ?>">Ver Aulas</a>

    <?php elseif ($usuario_tipo == 'aluno'): ?>

        <form method="POST">
            <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
            <button type="submit" name="inscrever">Inscrever-me</button>
        </form>

    <?php endif; ?>

    <?php if ($usuario_tipo == 'formador' && $curso['formador_id'] == $usuario_id): ?>
    <a href="../aulas/ver_aulas_formador.php?curso_id=<?= $curso['id'] ?>">Ver aulas</a> |
    <a href="editar_curso.php?id=<?= $curso['id'] ?>">Editar</a> |
    <a href="apagar_curso.php?id=<?= $curso['id'] ?>"
       onclick="return confirm('Tens a certeza?')">Apagar</a>
<?php endif; ?>

    <hr>

<?php endwhile; ?>

<a href="../autenticacao/logout.php">Terminar sessão</a>

</body>
</html>