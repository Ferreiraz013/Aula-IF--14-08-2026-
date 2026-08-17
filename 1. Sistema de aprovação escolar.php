<?php

$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $nota1 = $_POST['nota1'] ?? '';
    $nota2 = $_POST['nota2'] ?? '';
    $nota3 = $_POST['nota3'] ?? '';
    $frequencia = $_POST['frequencia'] ?? '';

    // Verifica se todos os campos foram preenchidos
    if (
        $nome === '' ||
        $nota1 === '' ||
        $nota2 === '' ||
        $nota3 === '' ||
        $frequencia === ''
    ) {

        $resultado = [
            'erro' => 'Preencha todos os campos.'
        ];

    } else {

        // Converte os valores para números
        $nota1 = (float) $nota1;
        $nota2 = (float) $nota2;
        $nota3 = (float) $nota3;
        $frequencia = (float) $frequencia;

        // Calcula a média
        $media = ($nota1 + $nota2 + $nota3) / 3;

        // Verifica a situação do aluno
        if ($frequencia < 75) {

            $situacao = 'REPROVADO POR FREQUÊNCIA';
            $classe = 'freq-fail';

        } elseif ($media >= 7) {

            $situacao = 'APROVADO';
            $classe = 'aprovado';

        } elseif ($media >= 5) {

            $situacao = 'RECUPERAÇÃO';
            $classe = 'recuperacao';

        } else {

            $situacao = 'REPROVADO';
            $classe = 'reprovado';
        }

        $resultado = [
            'nome' => $nome,
            'media' => number_format($media, 1, ',', '.'),
            'frequencia' => number_format($frequencia, 1, ',', '.') . '%',
            'situacao' => $situacao,
            'classe' => $classe
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Aprovação</title>

    <link rel="stylesheet" href="css/global.css">

</head>

<body>

    <div class="box">

        <h2>Sistema de Aprovação</h2>

        <form method="POST">

            <label>
                Nome do aluno

                <input
                    type="text"
                    name="nome"
                    required
                    value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                >
            </label>

            <label>
                Nota 1

                <input
                    type="number"
                    name="nota1"
                    step="0.1"
                    min="0"
                    max="10"
                    required
                    value="<?= htmlspecialchars($_POST['nota1'] ?? '') ?>"
                >
            </label>

            <label>
                Nota 2

                <input
                    type="number"
                    name="nota2"
                    step="0.1"
                    min="0"
                    max="10"
                    required
                    value="<?= htmlspecialchars($_POST['nota2'] ?? '') ?>"
                >
            </label>

            <label>
                Nota 3

                <input
                    type="number"
                    name="nota3"
                    step="0.1"
                    min="0"
                    max="10"
                    required
                    value="<?= htmlspecialchars($_POST['nota3'] ?? '') ?>"
                >
            </label>

            <label>
                Frequência (%)

                <input
                    type="number"
                    name="frequencia"
                    step="0.1"
                    min="0"
                    max="100"
                    required
                    value="<?= htmlspecialchars($_POST['frequencia'] ?? '') ?>"
                >
            </label>

            <button type="submit">
                Verificar situação
            </button>

        </form>


        <?php if ($resultado): ?>

            <?php if (isset($resultado['erro'])): ?>

                <div class="card erro">
                    <?= htmlspecialchars($resultado['erro']) ?>
                </div>

            <?php else: ?>

                <div class="card <?= htmlspecialchars($resultado['classe']) ?>">

                    <strong>
                        <?= htmlspecialchars($resultado['situacao']) ?>
                    </strong>

                    <div>
                        Aluno:
                        <?= htmlspecialchars($resultado['nome']) ?>
                    </div>

                    <div>
                        Média:
                        <?= $resultado['media'] ?>
                    </div>

                    <div>
                        Frequência:
                        <?= $resultado['frequencia'] ?>
                    </div>

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</body>

</html>