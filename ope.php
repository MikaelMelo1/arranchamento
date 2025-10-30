<?php
// session_start inicia a sess�o 
session_start();
ini_set('display_errors', '1');
require_once "./inc/conf.php";
// as variáveis login e senha recebem os dados digitados na página anterior 
$login = $_POST['login']; 
$senha = $_POST['senha']; 
$conexao = new mysqli($host,$user,$pass,$db);
if (!$conexao)
{
	die("A conexão falhou:" . $conexao->connect_error);
}
//Confere usuario, senha e se o militar está ativo
$seleciona = "select * from militares where cpf = '$login' and senha = '$senha' and ativo = 'S'";
$result = $conexao->query($seleciona);
$quant = $result->num_rows;
$row = $result->fetch_object();
//* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro id�ntico o seu valor ser� igual a 1, se n�o, se n�o tiver registros seu valor ser� 0. Dependendo do resultado ele redirecionar� para a pagina site.php ou retornara para a pagina do formul�rio inicial para que se possa tentar novamente realizar o login */
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
