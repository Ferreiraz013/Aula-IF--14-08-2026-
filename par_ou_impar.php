<?php
if($_POST){
    $numero = $_POST['numero'];

    if($numero % 2 == 0){
        echo $numero . " = Número par 🟢";
    }else{
        echo $numero . " = Número ímpar 🔴";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Par ou Ímpar</title>
</head>
<body>
    <form action="#" method="post">
        <label for="numero">Digite um número</label>
        <input type="number" name="numero" id="numero">
        <button type="submit">Verificar</button>
    </form>
</body>
</html>
