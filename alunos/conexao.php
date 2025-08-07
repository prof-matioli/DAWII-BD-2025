<?php
    // conexao.php
    // 1. Definição dos parâmetros de conexão
    $servidor = "localhost"; // Endereço do servidor do banco de dados
    $usuario = "root"; // Usuário do banco de dados
    $senha = ""; // Senha do usuário (vazia no XAMPP padrão)
    $nomeBanco = "meubanco"; // Nome do banco de dados que vamos usar
    // 2. Criação da conexão usando a classe MySQLi
    // O '@' antes de new mysqli suprime mensagens de erro padrão do PHP,
    // permitindo que nós mesmos tratemos o erro de forma personalizada
    // no passo seguinte.
    $conexao = @new mysqli($servidor, $usuario, $senha, $nomeBanco);
    // 3. Verificação da conexão
    // A propriedade 'connect_error' do objeto $conexao conterá uma mensagem
    // de erro se a conexão falhar. Se estiver tudo OK, ela será nula.
    if ($conexao->connect_error) {
        // Se houve um erro, o script é interrompido e uma mensagem de erro é exibida.
        // die() encerra a execução do script.
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }
    // Se o script chegou até aqui, a conexão foi bem-sucedida!
    // echo "Conexão estabelecida com sucesso!"; // Descomente para testar a conexão
    // É importante definir o charset para UTF-8 para evitar problemas com acentuação
    $conexao->set_charset("utf8");
?>