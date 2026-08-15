<?php
if($_POST){
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    $n3 = $_POST['n3'];

    $media = ($n1 + $n2 + $n3) / 3;

    if($media >= 7){
        echo "Aprovado!! parabéns aluno(a)🤩🤩🤩";
    }elseif($media >= 5){
        echo "Recuperação.... Estude mais aluno(a)😐😐😐";
    }else{
        echo "Reprovado.... Não desista aluno(a)💪💪💪";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Média do Aluno</title>
</head>
<body>
    <form action="#" method="post">
        <label for="n1">Digite a 1ª nota:</label>
        <input type="number" step="0.1" name="n1" id="n1"><br><br>

        <label for="n2">Digite a 2ª nota:</label>
        <input type="number" step="0.1" name="n2" id="n2"><br><br>

        <label for="n3">Digite a 3ª nota:</label>
        <input type="number" step="0.1" name="n3" id="n3"><br><br>

        <button type="submit">Calcular</button>
    </form>
</body>
</html>
