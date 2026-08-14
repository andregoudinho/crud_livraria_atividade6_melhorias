<?php

include "../infra/conexao.php";

$id = $_GET["id"];
$sql = "SELECT * FROM livros WHERE id = $id";
$resultado = mysqli_query($conexao, $sql );

$livro =mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Livraria</title>
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
    <header>
        <h1>CRUD - Livraria</h1>
    </header>
    <main>
        <h2>Editando o livro <?php echo $livro["titulo"]?>!</h2>
        <form action="atualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $livro["id"]?>">

            <label for="titulo">Título:</label>
            <input type="text" name="titulo" value="<?php echo $livro["titulo"]?>" required>
            <br>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" value="<?php echo $livro["autor"]?>" required>
            <br>
            <label for="ano">Ano de Publicação:</label>
            <input type="number" name="ano" value="<?php echo $livro["ano"]?>" required>
            <br>
            <button type="submit">Atualizar</button>
        </form>

    </main>
    <footer>

    </footer>


</body>

</html>