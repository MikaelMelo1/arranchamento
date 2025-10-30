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
    
    //As variáveis recebem os dados digitados da página anterior 
    $nomecompleto = $_POST['nomecompleto']; 
    $posto = $_POST['graduacao'];
    $nomeguerra = $_POST['nomeguerra'];
    $numero = $_POST['numero'];
    $turma = $_POST['turma'];
    $arma = $_POST['arma'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['inputPassword'];
    $tipo_acesso = $_POST['tipo_acesso'];
    $datacadastro = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
    //CAMPO "USUARIO_NOVO", futuramente quando a conta do militar for setada como inativo, o campo "usuário_novo deve ser alterado para "N"
    $usuario_novo = 'S';
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

    //Testa se o cpf já está cadastrado no banco, se sim não insere o novo usuário
    $arranch0 = " SELECT * FROM militares WHERE cpf = '$cpf'  ";
    $result0 = $conexao->query($arranch0);
    $numcpf = $result0->num_rows;
    if($numcpf >= 1)
    {
        print("<p class=\"text-success\" style=\"position:absolute;top:50%;left:30%;color: #fe9400;\">Este número de CPF já está cadastrado no Sistema!</p>");
        print("<p onclick=\"history.back();\" class=\"text-success\" style=\"position:absolute;top:60%;left:30%;color: #fe9400;\">Clique aqui para tentar novamente</p>");
    }
    else
    {
        //Insere o novo usuário
        if(!$conexao->query("INSERT INTO militares (nomeguerra,nomecompleto,numero,arma,turma,ativo,cpf,senha,tipo_acesso,datacadastro,usuario_novo,funcao,posto,hierarquia) VALUES ('$nomeguerra','$nomecompleto',$numero,'$arma','$turma','S','$cpf','$senha','$tipo_acesso','$datacadastro','$usuario_novo','$funcao','$graduacao',$hierarquia[$graduacao])"))
        {
            printf("Errormessage: %s\n", $mysqli->error);
        }
        print("<a style=\"position:absolute;top:50%;left:30%;color: #fe9400;font-family: 'Roboto', 'Helvetica', 'Arial', sans-serif;font-weight: 300;\">Usuário cadastrado com sucesso!</a>");
        //Aqui conta o tempo determinado e volta para a página de login
        echo "<script>";
        echo "contatempo();";
        echo "function contatempo(){setTimeout(function(){executa()}, 3000);}";
        echo "function executa(){window.location.href = './';}";
        echo "</script>";
    }
    

    
    
    //Fecha a conexão
    $conexao->close();
    ?>
    
 
    
    
    
    
    
<!-- Função para retornar a página de login-->
<!-- 2000 = 2 segundos - Tempo para executar-->


</body>

</html>
