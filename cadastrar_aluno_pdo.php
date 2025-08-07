<?php
// cadastrar_aluno_pdo.php
// 1. Incluir a conexão PDO
require_once 'conexao_pdo.php';
// 2. Receber os dados do formulário
$nome = $_POST['nome'] ?? null;
$email = $_POST['email'] ?? null;
// VALIDAÇÃO
if (!$nome || !$email) {
    die("Erro: Nome e email são obrigatórios.");
}
// 3. Preparar a consulta SQL com parâmetros nomeados
$sql = "INSERT INTO alunos (nome, email) VALUES (:nome, :email)";
// O bloco try...catch irá capturar qualquer erro na preparação ou execução
try {
    // 4. Preparar a declaração
    $stmt = $conexao->prepare($sql);
    // 5. Vincular os valores aos parâmetros nomeados
    // Com PDO, podemos fazer isso de duas formas:
    // Opção A: bindValue() ou bindParam()
    // $stmt->bindValue(':nome', $nome);
    // $stmt->bindValue(':email', $email);
    // Opção B: Passar um array para o execute() - Mais comum e prático!
    // A chave do array deve corresponder ao nome do parâmetro.
    $parametros = [
        ':nome' => $nome,
        ':email' => $email
    ];
    // 6. Executar a declaração, passando os dados
    if ($stmt->execute($parametros)) {
        echo "<h1>Aluno cadastrado com sucesso usando PDO!</h1>";
        echo "<p><a href='form_cadastro.html'>Cadastrar outro</a></p>";
    } else {
        // Este 'else' raramente será atingido com o modo de exceção ativado,
        // pois um erro na execução lançaria uma PDOException.
        echo "Ocorreu um erro desconhecido.";
    }
} catch (PDOException $e) {
    // Tratar erros específicos, como email duplicado (código de erro 1062)
    if ($e->getCode() == '23000') { // 23000 é o código SQLSTATE para violação de integridade
        echo "Erro: O email informado ('$email') já está cadastrado. Por favor, utilize outro.";
    } else {
        // Para outros erros, exibe uma mensagem genérica e grava o erro real em um log.
        error_log("Erro ao cadastrar aluno: " . $e->getMessage()); // Grava no log de erros do servidor
        die("Ocorreu um erro ao tentar cadastrar o aluno. Tente novamente mais tarde.");
    }
}
// Com PDO, não é estritamente necessário fechar a conexão ($conexao = null;),
// pois o PHP faz isso automaticamente no final do script.
