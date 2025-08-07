<?php
require_once 'conexao.php';

// MODO INSEGURO - NÃO FAÇA ISSO!
$email = $_REQUEST['email']; // Ex: 'aluno@email.com'
$senha = $_REQUEST['senha']; // Ex: '123456'
$sql = "SELECT * FROM alunos WHERE email = '$email' AND senha = '$senha'";
$resultado = $conexao->query($sql);
if ($resultado->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Email</th></tr>";
    while ($linha = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $linha['id'] . "</td>";
        echo "<td>" . htmlspecialchars($linha['nome']) . "</td>"; // Usar htmlspecialchars para segurança
        echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
        echo "<td>" . htmlspecialchars($linha['senha']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
