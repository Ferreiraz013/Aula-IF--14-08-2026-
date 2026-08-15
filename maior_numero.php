<?php
if($_POST){
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];

    if($num1 > $num2){
        echo $num1 . " é maior que " . $num2;
    }elseif($num2 > $num1){
        echo $num2 . " é maior que " . $num1;
    }else{
        echo "Os números são iguais 🤔";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maior Número</title>
</head>
<body>
    <form action="#" method="post">
        <label for="num1">Digite o primeiro número</label>
        <input type="number" name="num1" id="num1"><br><br>

        <label for="num2">Digite o segundo número</label>
        <input type="number" name="num2" id="num2"><br><br>

        <button type="submit">Verificar</button>
    </form>
</body>
</html>
