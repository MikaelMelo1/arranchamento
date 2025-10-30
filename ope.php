<?php
// session_start inicia a sesso 
session_start();
ini_set('display_errors', '1');
require_once "./inc/conf.php";
// as variáveis login e senha recebem os dados digitados na página anterior 
$login = $_POST['login']; 
$senha = $_POST['senha']; 

// 1. Inicializa o MySQLi
$conexao = mysqli_init();
if (!$conexao) {
    die("mysqli_init falhou");
}

// 2. DIZ AO PHP PARA USAR SSL/TLS
mysqli_ssl_set($conexao, NULL, NULL, NULL, NULL, NULL);

if (!mysqli_real_connect($conexao, $host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Erro ao conectar (" . mysqli_connect_errno() . "): " . mysqli_connect_error());
}
$seleciona = "select * from militares where cpf = '$login' and senha = '$senha' and ativo = 'S'";
$result = $conexao->query($seleciona);
$quant = $result->num_rows;
$row = $result->fetch_object();
//* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idntico o seu valor ser igual a 1, se no, se no tiver registros seu valor ser 0. Dependendo do resultado ele redirecionar para a pagina site.php ou retornara para a pagina do formulrio inicial para que se possa tentar novamente realizar o login */
if($quant > 0)
{
  $_SESSION['login'] = $login;
  $_SESSION['senha'] = $senha;
  $_SESSION['tipo_acesso'] = $row->tipo_acesso; 
  //Grava o último acesso do usuário - Tabela "militares/ultimoacesso"
  if($_SESSION['tipo_acesso']=='ADMINISTRADOR')
  {
    header('location: administrador.php');//Chama o formulário de arranchamento 
        
        }
  else if ($_SESSION['tipo_acesso']=='FURRIEL') 
  {
    header('location: arranchamento_form_furriel.php'); //Chama o formulário furriel
    
  }
        else
  {
    header('location: arranchamento_form.php'); //Chama o formuláriodearranchamento 
        
        }
} 
else
{ 
  unset ($_SESSION['login']); 
  unset ($_SESSION['senha']); 
      unset ($_SESSION['tipo_acesso']);
  echo"<script>alert('Senha errada! Entre em contato com o Administrador.');top.location.href='./';</script>";
} 
?>