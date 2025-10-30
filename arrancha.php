<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="icon" href="./favicon.ico">
<?php 
// ESTE ARQUIVO JÁ CRIA A VARIÁVEL $conexao SEGURA
require_once "./inc/conf.php";

//Verifica se o usuário está logado, se não vai para tela de login
session_start(); 
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)) { 
    unset($_SESSION['login']); 
    unset($_SESSION['senha']); 
    header('location:index.html'); } 
$logado = $_SESSION['login'];
?>
<title>Sistema de Arranchamento / 13º GAC</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body style="background-color: #272729">

<?php

//Hierarquia do militar - Faz busca para encontrar o código do militar
$arranch0 = "select * from militares where cpf='$logado'";
$result0 = $conexao->query($arranch0);
$row = $result0->fetch_object();
$hierarquia = $row->hierarquia;
    
//REALIZA ARRANCHAMENTO
for($i=0;$i<=$nr_dias;$i++){
    $dia_sql = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+$i,date("Y")));
    $seleciona = "select * from arranchamento where cpf='$logado' and data='$dia_sql' ";
    $result = $conexao->query($seleciona);
    $row = $result->fetch_object();
    
    //Variável que pega o $_POST['almoco_justificativa'.$i]) do arquivo arranchamento_form.php
    // Corrigido para evitar 'Undefined array key'
    $justificativa_sexta = isset($_POST['almoco_justificativa'.$i]) ? $_POST['almoco_justificativa'.$i] : NULL;
    
    if($result->num_rows>0 ){//Se já tem registro gravado nesta data "UPDATE"        
        //Se todas as opções não estiverem marcadas, exclui a linha da tabela
        if(empty($_POST['checkcaf'.$i]) and empty($_POST['checkalm'.$i]) and empty($_POST['checkjan'.$i]) ){
            //Código para apagar a linha do banco de dados
            $conexao->query(" delete from arranchamento where data='$dia_sql' and cpf='$logado' ");
        }        
        else {
            //Atualiza registro existentes
            if(isset($_POST['checkcaf'.$i]) ) { $cafaux = 'S'; } else { $cafaux = 'N'; }          
            if(isset($_POST['checkalm'.$i]) ) { $almaux = 'S'; } else { $almaux = 'N'; }
            if(isset($_POST['checkjan'.$i]) ) { $janaux = 'S'; } else { $janaux = 'N'; }  
            
            // Adicionado "mysqli_real_escape_string" para segurança
            $just_segura = mysqli_real_escape_string($conexao, $justificativa_sexta);
            $conexao->query("UPDATE arranchamento SET cafe = '$cafaux', almoco = '$almaux', jantar = '$janaux',     justificativa_sexta = '$just_segura' WHERE data='$dia_sql' and cpf='$logado'");
        }
    }
    else //Se não tem registro gravado nesta data "INSERT"
    {
        // Só insere se pelo menos um estiver marcado
        if(!empty($_POST['checkcaf'.$i]) or !empty($_POST['checkalm'.$i]) or !empty($_POST['checkjan'.$i]) ){
            //Insere os registros novos
            if(isset($_POST['checkcaf'.$i]) ) { $cafaux = 'S'; } else { $cafaux = 'N'; }          
            if(isset($_POST['checkalm'.$i]) ) { $almaux = 'S'; } else { $almaux = 'N'; }
            if(isset($_POST['checkjan'.$i]) ) { $janaux = 'S'; } else { $janaux = 'N'; }
            
            // Adicionado "mysqli_real_escape_string" para segurança
            $just_segura = mysqli_real_escape_string($conexao, $justificativa_sexta);
            $conexao->query("INSERT INTO arranchamento (cpf,data,cafe,almoco,jantar,hierarquia,justificativa_sexta) VALUES ('$logado','$dia_sql','$cafaux','$almaux','$janaux','$hierarquia','$just_segura')"); 
        }
    }
}
?>

<a style="position:absolute;top:50%;left:30%;color: #fe9400;font-family: 'Roboto', 'Helvetica', 'Arial', sans-serif;font-weight: 300;">Arranchamento realizado...</a>


<script>
contatempo();
function contatempo(){
        setTimeout(function(){executa()}, 1500);
}
function executa(){
        window.location.href = 'arranchamento_form.php';
}
</script>

</body>
</html>