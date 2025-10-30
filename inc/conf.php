<?php

require_once __DIR__.'/envloader.php';

// 1. Carrega as variáveis de ambiente
$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db   = $_ENV['DB_NAME'];
$port = $_ENV['DB_PORT'];
$nr_dias = $_ENV['NR_DIAS'];
$lock = $_ENV['LOCK'];

// Inicializa o MySQLi
$conexao = mysqli_init();
if (!$conexao) {
    die("mysqli_init falhou");
}

// DIZ AO PHP PARA USAR SSL/TLS
mysqli_ssl_set($conexao, NULL, NULL, NULL, NULL, NULL);

// Conecta usando as variáveis
if (!mysqli_real_connect($conexao, $host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Erro ao conectar (" . mysqli_connect_errno() . "): " . mysqli_connect_error());
}

// Define o charset APÓS a conexão
mysqli_set_charset($conexao , "utf8");

?>