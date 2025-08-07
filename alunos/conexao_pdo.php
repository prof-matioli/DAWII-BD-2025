<?php
// 1. Definição dos parâmetros
$servidor = "mysql"; // O tipo do banco de dados
$host = "localhost"; // O endereço do servidor
// O nome do banco. Se aluno do COTIL utilize seu BD baseado no seu RA.
$nomeBanco = "meubanco";
$usuario = "root"; // Usuário
$senha = ""; // Senha
// 2. Conexão usando PDO com tratamento de exceções (try...catch)
try {
    // Criação do DSN (Data Source Name)
    $dsn = "$servidor:host=$host;dbname=$nomeBanco;charset=utf8";
    // Criação da instância de PDO
    // O array de opções configura o modo de erro para lançar exceções
    // e desativa a emulação de prepares, usando prepares nativos do MySQL.
    $conexao = new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Define o modo de busca padrão como array associativo
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    // Se o script chegou aqui, a conexão foi bem-sucedida!
    // echo "Conexão via PDO estabelecida com sucesso!";
} catch (PDOException $e) {
    // Se ocorrer um erro (exceção), ele será capturado aqui.
    // Em um ambiente de produção, não é recomendado exibir detalhes do erro
    // para o usuário. Grave em um log, por exemplo.
    die("Erro na conexão com o banco de dados via PDO: " . $e->getMessage());
}
