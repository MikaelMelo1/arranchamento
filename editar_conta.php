<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="./favicon.ico">  
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
    ?>
  
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">


  <title>Arranchamento</title>
  
  <!-- Complemento -->
  <link rel="stylesheet" href="./complemento.css" type="text/css">  

  <!-- Material Design fonts -->
  <link rel="stylesheet" href="./material_design/dependencias/roboto.css" type="text/css">
  <link href="./material_design/dependencias/materialicons" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="./material_design/dependencias/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Material Design -->
  <link href="material_design/dist/css/bootstrap-material-design.css" rel="stylesheet">
  <link href="material_design/dist/css/ripples.min.css" rel="stylesheet">


  <link href="./material_design/dependencias/snackbar.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body onload="tamanho_elemento('titulo_page','container','45');">

    <!--VARIÁVEIS DE DATAS E CONEXÃO-->
    <?php
    //Conexão ao banco
    $conexao = new mysqli($host,$user,$pass,$db);
    mysqli_set_charset($conexao , "utf8");
    if (!$conexao){die("A conexão falhou: " . $conexao->connect_error);}

    $seleciona = "select * from militares where cpf='$logado'";
    $result = $conexao->query($seleciona);
    $row = $result->fetch_object();
    
?>

        <div class="container" id="container">
            <!-- Form Arranchamento
================================================== -->
            <div class="panel panel-info" style="margin-top: -21px">
                <div class="panel-heading">
                    <table style="width:100%">
                        <tr>
                            <th id="titulo_page">
                                <img src="./img/arranchamento_72x72.png" height="48">
                                <font style="font-size:20px;margin-left:10px;position: relative;top: 7px"><b>Editar Conta</font>
                            </th>
                            <th style="text-align:right">
                                <a href="logout.php" title="Sair" class="botaosair"><img src="./img/sair.png"></a>
                                <?php //se é administrador mostra botão de retorno para a área administrativa
                                if($_SESSION['tipo_acesso']=='ADMINISTRADOR'){
                                    print("
                                    <a href=\"administrador.php\" title=\"Voltar\" class=\"botaosair\"><img src=\"./img/administrador.png\" width=\"27px\"></a>
                                    ");
                                    }
                                ?>
                                <a onclick="history.back();" title="Voltar" class="botaosair" style="cursor:pointer;"><img src="./img/voltar.png"></a>
                            </th>
                        </tr>
                    </table>

                </div>
                <div class="panel-body">

                        <center>
                            <h3 style="color:#fe9400">
            <?php
            //Retorna a saudação: Bom dia, Boa tarde...
            echo "Usuário: "; echo "$row->posto"." "."$row->nomeguerra"; ?></h3></center>
                        <br>
                        <?php echo "".hora();
            echo " - ".$_SESSION['tipo_acesso'];
            
            
          //Formulario de cadastro do aluno
          if($_SESSION['tipo_acesso']=='ALUNO'){
              print("
                <form method=\"post\" class=\"form-horizontal\" name=\"formulario\" action=\"editar_conta_gravar.php\" id=\"usuario_novo\" name=\"usuario_novo\">

                    <div class=\"form-group\">
                      <label for=\"inputNGuerra\" class=\"col-md-2 control-label\">Nome Completo</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" onkeyup=\"visibilidade();\" onFocus=\"proximoCampo ='graduacao'; \" class=\"form-control\" id=\"nomecompleto\" name=\"nomecompleto\" placeholder=\"\"  onBlur=\"upperCaseF(this)\" value=\"$row->nomecompleto\">
                      </div>
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Graduação</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" id=\"graduacao\" name=\"graduacao\" class=\"form-control\" onFocus=\"proximoCampo ='nomeguerra';\"  value=\"$row->posto\" readonly>
                        </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Nome de Guerra</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" onkeyup=\"visibilidade();\" class=\"form-control\" name=\"nomeguerra\" id=\"nomeguerra\" placeholder=\"\" onBlur=\"upperCaseF(this)\" onFocus=\"proximoCampo ='numero';\" value=\"$row->nomeguerra\">
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputCPF\" class=\"col-md-2 control-label\">Número</label>        
                      <div class=\"col-md-10\">
                        <input type=\"number\" onkeyup=\"visibilidade();\" class=\"form-control\" name=\"numero\" id=\"numero\" placeholder=\"\" onFocus=\"proximoCampo ='turma'; \" value=\"$row->numero\">
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Turma</label>        
                      <div class=\"col-md-10\">
                        <select id=\"turma\" name=\"turma\" class=\"form-control\" onFocus=\"proximoCampo ='arma'; \" value=\"$row->turma\">
                          <option value=\"$row->turma\">Atual: $row->turma</option>
                          <option value=\"TURMA 1\">TURMA 1</option>
                          <option value=\"TURMA 2\">TURMA 2</option>
                          <option value=\"TURMA 3\">TURMA 3</option>
                          <option value=\"TURMA 4\">TURMA 4</option>
                          <option value=\"TURMA 5\">TURMA 5</option>
                          <option value=\"TURMA 6\">TURMA 6</option>
                          <option value=\"TURMA 7\">TURMA 7</option>
                          <option value=\"OUTRAS\">OUTRAS</option>                  
                        </select>
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Arma</label>        
                      <div class=\"col-md-10\">
                        <select id=\"arma\" name=\"arma\" class=\"form-control\" onFocus=\"proximoCampo ='cpf'; \" >
                          <option value=\"$row->arma\">Atual: $row->arma</option>
                          <option value=\"INFANTARIA\">INFANTARIA</option>
                          <option value=\"CAVALARIA\">CAVALARIA</option>
                          <option value=\"ARTILHARIA\">ARTILHARIA</option>
                          <option value=\"ENGENHARIA\">ENGENHARIA</option>
                          <option value=\"COMUNICAÇÕES\">COMUNICAÇÕES</option>
                          <option value=\"INTENDÊNCIA\">INTENDÊNCIA</option>
                          <option value=\"MATERIAL BÉLICO\">MATERIAL BÉLICO</option>
                          <option value=\"OUTRAS\">OUTRAS</option>                  
                        </select>
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputCPF\" class=\"col-md-2 control-label\">Nr do CPF</label>        
                      <div class=\"col-md-10\">
                        <input type=\"number\" onkeyup=\"visibilidade();\" class=\"form-control\" id=\"cpf\" name=\"cpf\" placeholder=\"\" onFocus=\"proximoCampo ='inputPassword'; \" value=\"$row->cpf\" readonly>
                      </div>              
                    </div>            

                    <input type=\"text\" name=\"funcao\" value=\"$row->funcao\" style=\"display: none;\">
                    
                    <button type=\"submit\" id=\"gravar\" style=\"background: url(./img/like_48x48.png);border:0;          display:block;height:48px;width:48px;position: relative;left:80%;z-index: 1;\"></button>

                </form>
                "
                   );}
                    
                    
          if($_SESSION['tipo_acesso']!='ALUNO'){
              print("<br><br>Em breve!");}
                        ?>







                </div>
            </div>




        </div>

</body>

<script>
    <!--Função para determinar o tamanho de um elemento-->
    function tamanho_elemento(id_destino,id_base,porcentagem){
        var width = window.getComputedStyle(document.getElementById(id_base), null).getPropertyValue("width");
        width = width.replace("px","");
        document.getElementById(id_destino).style.width = (width*(porcentagem/100))+"px";
    }        

    function upperCaseF(a){
        setTimeout(function(){
            a.value = a.value.toUpperCase();
            }, 1);
        }    
    
</script>

</html>
