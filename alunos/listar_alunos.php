<?php
// listar_alunos.php
// 1. Incluir o arquivo de conexão
// require_once garante que o arquivo seja incluído apenas uma vez.
require_once 'conexao.php';
echo "<h1>Lista de Alunos</h1>";
// 2. Criar a consulta SQL para buscar os dados
$sql = "SELECT id, nome, email FROM alunos ORDER BY nome";
// 3. Executar a consulta no banco de dados
// O método query() do objeto $conexao executa a string SQL.
// O resultado é um objeto especial (MySQLi Result) que contém os dados encontrados.
$resultado = $conexao->query($sql);
// 4. Verificar se a consulta retornou resultados
// A propriedade num_rows do objeto $resultado nos diz quantos registros foram encontrados.
if ($resultado->num_rows > 0) {
    // Cria o cabeçalho da tabela HTML
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Email</th></tr>";
    // 5. Percorrer os resultados e exibir cada linha
    // O método fetch_assoc() busca uma linha do resultado como um array
    // associativo (onde as chaves são os nomes das colunas da tabela).
    // O loop while continuará enquanto houver linhas a serem buscadas.
    while ($linha = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $linha['id'] . "</td>";
        echo "<td>" . htmlspecialchars($linha['nome']) . "</td>"; // Usar htmlspecialchars para segurança
        echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // Se num_rows for 0, significa que a tabela está vazia.
    echo "Nenhum aluno encontrado.";
}
// 6. Fechar a conexão com o banco de dados
// É uma boa prática liberar os recursos ao final do script.
$conexao->close();
