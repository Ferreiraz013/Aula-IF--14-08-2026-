<?php
if ($_POST) {
    $numero = $_POST['numero'];

    if ($numero > 0) {
        echo $numero . " = Número positivo👍";
    } elseif ($numero == 0) {
        echo $numero . " = Número igual a zero🤷‍♂️";
    } else {
        echo $numero . " = Número negativo🤦‍♂️";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Número Positivo</title>
</head>
<body>
    <form action="#" method="post">
        <label for="numero">Digite um número:</label>
        <input type="number" name="numero" id="numero">
        <button type="submit">Verificar</button>
    </form>
</body>
</html>
