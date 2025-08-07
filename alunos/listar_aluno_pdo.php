<?php
// listar_alunos_pdo.php
require_once 'conexao_pdo.php';
echo "<h1>Lista de Alunos (via PDO)</h1>";
try {
    $sql = "SELECT id, nome, email FROM alunos ORDER BY nome";
    // O método query() do PDO é usado para consultas SELECT simples sem parâmetros.
    $resultado = $conexao->query($sql);
    // rowCount() é o equivalente do num_rows
    if ($resultado->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Email</th></tr>";
        // Como definimos FETCH_ASSOC na conexão, o loop já retorna um array associativo.
        // O loop 'foreach' é uma forma elegante de percorrer o resultado.
        foreach ($resultado as $linha) {
            echo "<tr>";
            echo "<td>" . $linha['id'] . "</td>";
            echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum aluno encontrado.";
    }
} catch (PDOException $e) {
    die("Erro ao consultar os dados: " . $e->getMessage());
}

echo "<p><a href='form_cadastro.html'>Cadastrar novo aluno</a></p>";

