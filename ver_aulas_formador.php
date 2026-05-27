<?php
include("verificar_sessao.php");
so_formador();
include("conexao.php");

$curso_id = $_GET['curso_id'];

// Verificar se o curso pertence ao formador
$verificar = "SELECT id, nome FROM cursos WHERE id=$curso_id AND formador_id=$usuario_id";
$resultado = mysqli_query($conexao, $verificar);

if (mysqli_num_rows($resultado) == 0) {
    echo "Acesso negado. Este curso não te pertence.";
    echo "<br><a href='index.php'>Voltar</a>";
    exit();
}

$curso = mysqli_fetch_assoc($resultado);

// Buscar aulas do curso
$aulas = mysqli_query($conexao, 
    "SELECT * FROM aulas WHERE curso_id=$curso_id ORDER BY ordem_aula");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Aulas — <?= $curso['nome'] ?></title>
</head>
<body>

<h1><?= $curso['nome'] ?></h1>
<a href="index.php">← Voltar</a> |
<a href="criar_aula.php?curso_id=<?= $curso_id ?>">+ Adicionar aula</a>
<hr>

<?php if (mysqli_num_rows($aulas) == 0): ?>
    <p>Este curso ainda não tem aulas.</p>
<?php else: ?>
    <?php while($aula = mysqli_fetch_assoc($aulas)): ?>
    <div class="aula-item">

        <?php if ($aula['thumbnail']): ?>
            <img src="<?= $aula['thumbnail'] ?>" alt="Thumbnail" width="200"><br><br>
        <?php endif; ?>

        <h3>Aula <?= $aula['ordem_aula'] ?> — <?= $aula['titulo'] ?></h3>
        <p><?= $aula['conteudo'] ?></p>

        <?php if (!$aula['video']): ?>
            <p>⚠️ Esta aula não tem vídeo.</p>
        <?php endif; ?>

        <a href="editar_aula.php?id=<?= $aula['id'] ?>">Editar</a> |
        <a href="apagar_aula.php?id=<?= $aula['id'] ?>"
           onclick="return confirm('Apagar esta aula?')">Apagar</a>
    </div>
    <hr>
    <?php endwhile; ?>
<?php endif; ?>

</body>
</html>