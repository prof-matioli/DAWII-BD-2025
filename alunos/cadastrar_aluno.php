<?php
// cadastrar_aluno.php
// 1. Incluir a conexão
require_once 'conexao.php';
// 2. Receber os dados do formulário via POST
$nome = $_POST['nome'];
$email = $_POST['email'];
// VALIDAÇÃO: Verificar se os dados não estão vazios
if (empty($nome) || empty($email)) {
    die("Erro: Nome e email são obrigatórios.");
}
// 3. Preparar a consulta SQL (usando ? como placeholders)
// A consulta SQL é um "molde".
$sql = "INSERT INTO alunos (nome, email) VALUES (?, ?)";
// 4. Preparar a declaração
// O método prepare() do objeto $conexao cria um objeto de declaração preparada.
// stmt é uma abreviação comum para "statement" (declaração).
$stmt = $conexao->prepare($sql);
if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $conexao->error);
}
// 5. Vincular os parâmetros (Bind Parameters)
// O método bind_param() vincula as variáveis PHP aos placeholders '?'.
// O primeiro argumento "ss" define os tipos dos dados:
// s - string
// i - integer
// d - double (float)
// b - blob (binary)
// Neste caso, temos duas strings (nome e email), então usamos "ss".
$stmt->bind_param("ss", $nome, $email);
// 6. Executar a declaração preparada
if ($stmt->execute()) {
    echo "<h1>Aluno cadastrado com sucesso!</h1>";
    echo "<p><a href='form_cadastro.html'>Cadastrar outro aluno</a></p>";
    echo "<p><a href='listar_alunos.php'>Ver lista de alunos</a></p>";
} else {
    // Se a execução falhar, exibe o erro específico da declaração.
    echo "Erro ao cadastrar o aluno: " . $stmt->error;
}
// 7. Fechar a declaração e a conexão
$stmt->close();
$conexao->close();
