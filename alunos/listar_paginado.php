<?php
// Inclui o arquivo de conexão PDO
require_once 'conexao_pdo.php';

// 1. Definir os parâmetros da paginação
$itens_por_pagina = 5; // Quantos itens você quer exibir por página

// Pega o número da página da URL, ou assume a página 1 se não for fornecido
// Usamos filter_input para segurança e para garantir que seja um inteiro
$pagina_atual = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;

// Garante que o número da página não seja menor que 1
if ($pagina_atual < 1) {
    $pagina_atual = 1;
}
// 2. Obter o número total de registros na tabela
// O método query() do PDO é usado para consultas SELECT simples
$total_itens_stmt = $conexao->query("SELECT COUNT(*) FROM alunos");
$total_itens = $total_itens_stmt->fetchColumn();

// Calcula o total de páginas necessárias, arredondando para cima
$total_paginas = ceil($total_itens / $itens_por_pagina);

// Valida a página atual para garantir que ela esteja dentro do intervalo válido
if ($pagina_atual > $total_paginas && $total_paginas > 0) {
    // Se a página solicitada for maior que o total, redireciona para a última página
    header("Location: ?page=" . $total_paginas);
    exit; // Encerra o script para o redirecionamento ocorrer
}
if ($pagina_atual < 1) {
    // Se a página solicitada for menor que 1, redireciona para a primeira página
    header("Location: ?page=1");
    exit;
}

// 3. Calcular o offset (deslocamento) para a consulta SQL
$offset = ($pagina_atual - 1) * $itens_por_pagina;
// 4. Buscar os registros para a página atual usando LIMIT e OFFSET
// Usamos prepared statements para segurança
$sql = "SELECT id, nome, email FROM alunos ORDER BY nome LIMIT :limit OFFSET :offset";
$stmt = $conexao->prepare($sql);
// bindValue precisa de um inteiro para LIMIT e OFFSET, por isso o (int)
$stmt->bindValue(':limit', (int) $itens_por_pagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
$stmt->execute();
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos Paginada</title>
    <style>
        /* Estilos simples para a paginação */
        .pagination {
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            margin: 0 2px;
            text-decoration: none;
            color: #007bff;
        }

        .pagination .current-page {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination a:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Lista de Alunos</h1>
    <?php if (count($alunos) > 0): ?>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= htmlspecialchars($aluno['id']) ?></td>
                        <td><?= htmlspecialchars($aluno['nome']) ?></td>
                        <td><?= htmlspecialchars($aluno['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php
            $janela_de_links = 2; // Quantos links queremos mostrar antes e depois da página atual
            // Link "Primeira"
            if ($pagina_atual > 1) {
                echo '<a href="?page=1">Primeira</a>';
            }

            // Link "Anterior"
            if ($pagina_atual > 1) {
                echo '<a href="?page=' . ($pagina_atual - 1) . '">Anterior</a>';
            }

            // Links do meio (a janela de navegação)
            for ($i = $pagina_atual - $janela_de_links; $i <= $pagina_atual + $janela_de_links; $i++) {
                if ($i >= 1 && $i <= $total_paginas) {
                    if ($i == $pagina_atual) {
                        echo '<span class="current-page">' . $i . '</span>';
                    } else {
                        echo '<a href="?page=' . $i . '">' . $i . '</a>';
                    }
                }
            }

            // Link "Próxima"
            if ($pagina_atual < $total_paginas) {
                echo '<a href="?page=' . ($pagina_atual + 1) . '">Próxima</a>';
            }

            // Link "Última"

            if ($pagina_atual < $total_paginas) {
                echo '<a href="?page=' . $total_paginas . '">Última</a>';
            }
            ?>
        </div>

    <?php else: ?>
        <p>Nenhum aluno encontrado.</p>
    <?php endif; ?>
</body>

</html>