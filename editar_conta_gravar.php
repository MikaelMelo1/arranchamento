<!DOCTYPE html>
<html>

<head >
    <title>Arranchamento</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    
      <!-- Material Design fonts -->
      <link rel="stylesheet" href="./material_design/dependencias/roboto.css" type="text/css">
      <link href="./material_design/dependencias/materialicons" rel="stylesheet">

      <!-- Bootstrap Material Design -->
      <link href="material_design/dist/css/bootstrap-material-design.css" rel="stylesheet">
      <link href="material_design/dist/css/ripples.min.css" rel="stylesheet">

      <link href="./material_design/dependencias/snackbar.min.css" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1">      

   <?php    
    //Includes e teste de sessão
    require_once "./inc/conf.php";
    require_once "./inc/funcoes.php";
    session_start(); 
    if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)) { 
        unset($_SESSION['login']); 
        unset($_SESSION['senha']); 
        header('location:index.html'); } 
    $logado = $_SESSION['login'];
    
    //As variáveis recebem os dados digitados da página anterior 
    $nomecompleto = $_POST['nomecompleto']; 
    $posto = $_POST['graduacao'];
    $nomeguerra = $_POST['nomeguerra'];
    $numero=$_POST['numero'];
    $turma = $_POST['turma'];
    $arma = $_POST['arma'];
    $cpf = $_POST['cpf'];

    //CAMPO "USUARIO_NOVO", futuramente quando a conta do militar for setada como inativo, o campo "usuário_novo deve ser alterado para "N"
    $funcao = $_POST['funcao'];
    $graduacao = $_POST['graduacao'];
    
    //Conexão ao banco
    $conexao = new mysqli($host,$user,$pass,$db);
    mysqli_set_charset($conexao , "utf8");
    if (!$conexao){die("A conexão falhou: " . $conexao->connect_error);}
    
    //Códicos de hierarquia
    $hierarquia = array(
        'GEN' => '0',
        'CEL' => '1',
        'TC' => '2',
        'MAJ' => '3',
        'CAP' => '4',
        '1º TEN' => '5',
        '2º TEN' => '6',
        'ASP OF' => '7',
        'ST' => '8',        
        '1º SGT' => '9',
        '2º SGT' => '10',
        '3º SGT' => '11',
        'CB' => '12',
        'SD' => '13',
    );
    ?>
</head>

<body style="background-color: #272729">
    <?php 

        //Altera usuário ALUNO
    if($_SESSION['tipo_acesso']=='ALUNO'){
        $conexao->query(" UPDATE militares SET nomeguerra='$nomeguerra', nomecompleto='$nomecompleto', numero=$numero, turma='$turma', arma='$arma' WHERE cpf='$cpf' ");
        print("<a style=\"position:absolute;top:50%;left:30%;color: #fe9400;font-family: 'Roboto', 'Helvetica', 'Arial', sans-serif;font-weight: 300;\">Informações do usuário ".$nomeguerra." atualizadas com sucesso!</a>");
        }
    
        //Aqui conta o tempo determinado e volta para a página anterior
        echo "<script>";
        echo "contatempo();";
        echo "function contatempo(){setTimeout(function(){executa()}, 1000);}";
        echo "function executa(){history.back();}";
        echo "</script>";
    
        //Fecha a conexão
        $conexao->close();
    ?>

</body>

</html>
