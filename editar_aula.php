<?php
include("verificar_sessao.php");
so_formador();
include("conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM aulas WHERE id=$id";
$resultado = mysqli_query($conexao, $sql);
$aula = mysqli_fetch_assoc($resultado);

$cursos = mysqli_query($conexao, "SELECT id, nome FROM cursos WHERE formador_id=$usuario_id");

if (isset($_POST['atualizar'])) {

    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $curso_id = $_POST['curso_id'];
    $thumbnail = $aula['thumbnail']; // mantém a atual por defeito
    $video = $aula['video']; // mantém o atual por defeito

    if (!empty($_FILES['thumbnail']['name'])) {
        $nome_thumb = time() . '_' . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "uploads/thumbs/$nome_thumb");
        $thumbnail = "uploads/thumbs/$nome_thumb";
    }

    if (!empty($_FILES['video']['name'])) {
        $nome_video = time() . '_' . $_FILES['video']['name'];
        move_uploaded_file($_FILES['video']['tmp_name'], "uploads/videos/$nome_video");
        $video = "uploads/videos/$nome_video";
    }

    $sql = "UPDATE aulas SET
            titulo='$titulo',
            conteudo='$conteudo',
            curso_id='$curso_id',
            thumbnail='$thumbnail',
            video='$video'
            WHERE id=$id";

    mysqli_query($conexao, $sql);

    header("Location: ver_aulas_formador.php?curso_id=$curso_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Aula</title>
</head>
<body>

<h2>Editar Aula</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Curso:</label><br>
    <select name="curso_id">
        <?php while($curso = mysqli_fetch_assoc($cursos)): ?>
            <option value="<?= $curso['id'] ?>"
                <?= $curso['id'] == $aula['curso_id'] ? 'selected' : '' ?>>
                <?= $curso['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= $aula['titulo'] ?>" required><br><br>

    <label>Conteúdo:</label><br>
    <textarea name="conteudo" rows="6" cols="50"><?= $aula['conteudo'] ?></textarea><br><br>

    <label>Thumbnail actual:</label><br>
    <?php if ($aula['thumbnail']): ?>
        <img src="<?= $aula['thumbnail'] ?>" alt="Thumbnail" width="200"><br><br>
    <?php else: ?>
        <p>Sem thumbnail.</p>
    <?php endif; ?>

    <label>Nova thumbnail (deixa vazio para manter a actual):</label><br>
    <input type="file" name="thumbnail" accept="image/*"><br><br>

    <label>Vídeo actual:</label><br>
    <?php if ($aula['video']): ?>
        <video width="400" controls>
            <source src="<?= $aula['video'] ?>" type="video/mp4">
        </video><br><br>
    <?php else: ?>
        <p>Sem vídeo.</p>
    <?php endif; ?>

    <label>Novo vídeo (deixa vazio para manter o actual):</label><br>
    <input type="file" name="video" accept="video/*"><br><br>

    <button type="submit" name="atualizar">Atualizar</button>

</form>

<br>
<a href="ver_aulas_formador.php?curso_id=<?= $aula['curso_id'] ?>">Voltar</a>

</body>
</html>