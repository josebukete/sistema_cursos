<?php
include("verificar_sessao.php");
so_aluno();
include("conexao.php");

$aula_id = $_GET['id'];
$curso_id = $_GET['curso_id'];

// Verificar se o aluno está inscrito no curso
$verificar = "SELECT id FROM inscricoes 
              WHERE usuario_id=$usuario_id AND curso_id=$curso_id";
$resultado = mysqli_query($conexao, $verificar);

if (mysqli_num_rows($resultado) == 0) {
    echo "Não tens acesso a este curso.";
    echo "<br><a href='cursos.php'>Ver cursos disponíveis</a>";
    exit();
}

// Buscar dados da aula
$sql = "SELECT aulas.*, progresso_aulas.concluida
        FROM aulas
        LEFT JOIN progresso_aulas ON progresso_aulas.aula_id = aulas.id
                                  AND progresso_aulas.usuario_id = $usuario_id
        WHERE aulas.id = $aula_id";

$aula = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

// Buscar nome do curso
$curso = mysqli_fetch_assoc(mysqli_query($conexao,
         "SELECT nome FROM cursos WHERE id=$curso_id"));
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= $aula['titulo'] ?></title>
</head>
<body>

<a href="ver_aulas.php?curso_id=<?= $curso_id ?>">← Voltar às aulas</a>
<hr>

<h1>Aula <?= $aula['ordem_aula'] ?> — <?= $aula['titulo'] ?></h1>
<p><strong>Curso:</strong> <?= $curso['nome'] ?></p>

<?php if ($aula['video']): ?>
    <video width="700" controls autoplay>
        <source src="<?= $aula['video'] ?>" type="video/mp4">
        O teu browser não suporta vídeo.
    </video><br><br>
<?php else: ?>
    <p><em>Esta aula não tem vídeo.</em></p>
<?php endif; ?>

<h2>Conteúdo</h2>
<p><?= $aula['conteudo'] ?></p>

<hr>

<?php if ($aula['concluida']): ?>
    <p>✅ Já concluíste esta aula.</p>
    <a href="ver_aulas.php?curso_id=<?= $curso_id ?>">Voltar às aulas</a>
<?php else: ?>
    <form method="POST" action="marcar_concluida.php">
        <input type="hidden" name="aula_id" value="<?= $aula['id'] ?>">
        <input type="hidden" name="curso_id" value="<?= $curso_id ?>">
        <button type="submit">✅ Marcar como concluída</button>
    </form>
<?php endif; ?>

</body>
</html>