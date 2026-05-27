<?php
include("../config/verificar_sessao.php");
so_formador();
include("../config/conexao.php");

if (isset($_POST['enviar'])) {

    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $curso_id = $_POST['curso_id'];

    // Ordem automática
    $total = mysqli_fetch_assoc(mysqli_query($conexao,
             "SELECT COUNT(*) AS total FROM aulas WHERE curso_id=$curso_id"));
    $ordem_aula = $total['total'] + 1;

    // Upload do vídeo
    $video = null;
    if (!empty($_FILES['video']['name'])) {
        $nome_video = time() . '_' . $_FILES['video']['name'];
        move_uploaded_file($_FILES['video']['tmp_name'], "../uploads/videos/$nome_video");
        $video = "uploads/videos/$nome_video";
    }

    // Upload da thumbnail
    $thumbnail = null;
    if (!empty($_FILES['thumbnail']['name'])) {
        $nome_thumb = time() . '_' . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "../uploads/thumbs/$nome_thumb");
        $thumbnail = "uploads/thumbs/$nome_thumb";
    }

    $sql = "INSERT INTO aulas (titulo, conteudo, curso_id, ordem_aula, video, thumbnail)
            VALUES ('$titulo', '$conteudo', '$curso_id', '$ordem_aula', '$video', '$thumbnail')";

    mysqli_query($conexao, $sql);

    header("Location: ver_aulas_formador.php?curso_id=$curso_id");
    exit();
}

$curso_id_selecionado = isset($_GET['curso_id']) ? $_GET['curso_id'] : null;
$cursos = mysqli_query($conexao, "SELECT id, nome FROM cursos WHERE formador_id=$usuario_id");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Aula</title>
</head>
<body>

<h2>Criar Aula</h2>

<!-- enctype obrigatório para upload de ficheiros -->
<form method="POST" enctype="multipart/form-data">

    <label>Curso:</label><br>
    <select name="curso_id">
        <?php while($curso = mysqli_fetch_assoc($cursos)): ?>
            <option value="<?= $curso['id'] ?>"
                <?= $curso['id'] == $curso_id_selecionado ? 'selected' : '' ?>>
                <?= $curso['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Título da Aula:</label><br>
    <input type="text" name="titulo" placeholder="Ex: Introdução ao HTML" required><br><br>

    <label>Conteúdo:</label><br>
    <textarea name="conteudo" rows="6" cols="50" placeholder="Descreve o conteúdo da aula"></textarea><br><br>

    <label>Vídeo da Aula:</label><br>
    <input type="file" name="video" accept="video/*"><br><br>

    <label>Thumbnail da Aula:</label><br>
    <input type="file" name="thumbnail" accept="image/*"><br><br>

    <button type="submit" name="enviar">Criar Aula</button>

</form>

<br>
<a href="../index.php">Início</a>

</body>
</html>