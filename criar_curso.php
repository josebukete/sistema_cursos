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

    $sql = "INSERT INTO cursos (nome, descricao, categoria, nivel, formador_id)
            VALUES ('$nome', '$descricao', '$categoria', '$nivel', '$formador_id')";

    mysqli_query($conexao, $sql);

    echo "Curso criado com sucesso!";
}
?>

<h2>Criar Curso</h2>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome do curso" required><br><br>

    <textarea name="descricao" placeholder="Descrição"></textarea><br><br>

    <input type="text" name="categoria" placeholder="Categoria"><br><br>

    <select name="nivel">
        <option value="iniciante">Iniciante</option>
        <option value="intermediario">Intermediário</option>
        <option value="avancado">Avançado</option>
    </select><br><br>

    <button type="submit" name="enviar">Criar</button>
</form>