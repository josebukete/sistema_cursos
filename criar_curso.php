<?php
include("verificar_sessao.php");
so_formador();
include("conexao.php");

if (isset($_POST['enviar'])) {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $nivel = $_POST['nivel'];
    $formador_id = $usuario_id;

    // Upload da thumbnail
    $thumbnail = null;
    if (!empty($_FILES['thumbnail']['name'])) {
        $nome_thumb = time() . '_' . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "uploads/thumbs/$nome_thumb");
        $thumbnail = "uploads/thumbs/$nome_thumb";
    }

    $sql = "INSERT INTO cursos (nome, descricao, categoria, nivel, formador_id, thumbnail)
            VALUES ('$nome', '$descricao', '$categoria', '$nivel', '$formador_id', '$thumbnail')";

    mysqli_query($conexao, $sql);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Curso</title>
</head>
<body>

<h2>Criar Curso</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Nome:</label><br>
    <input type="text" name="nome" placeholder="Nome do curso" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" placeholder="Descrição"></textarea><br><br>

    <label>Categoria:</label><br>
    <input type="text" name="categoria" placeholder="Categoria"><br><br>

    <label>Nível:</label><br>
    <select name="nivel">
        <option value="iniciante">Iniciante</option>
        <option value="intermediario">Intermediário</option>
        <option value="avancado">Avançado</option>
    </select><br><br>

    <label>Thumbnail do Curso:</label><br>
    <input type="file" name="thumbnail" accept="image/*"><br><br>

    <button type="submit" name="enviar">Criar Curso</button>

</form>

<br>
<a href="index.php">Início</a>

</body>
</html>