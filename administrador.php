<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="./favicon.ico">  
    <title>Arranchamento</title>
    
    <?php
    //Includes e teste de sessão
    require_once "./inc/conf.php";
    require_once "./inc/funcoes.php";
    session_start(); 
        
    if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true) ) {
        unset($_SESSION['login']); 
        unset($_SESSION['senha']); 
        header('location:index.html'); } 
    
    //Se usuário não é administrador sai da página
    if($_SESSION['tipo_acesso']!='ADMINISTRADOR'){
        echo"<script>
                alert('Você não é administrador!');
                history.back();            
            </script>
            ";        
    }
    
    //Se chegou até aqui, a página abre
    $logado = $_SESSION['login'];
    ?>
    
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
    <style>
        .panel { border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .panel-heading { padding: 12px 16px; }
        .header-flex { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .header-title { display: inline-flex; align-items: center; gap: 8px; margin: 0; font-size: 18px; }
        @media (min-width: 576px) { .header-title { font-size: 20px; } }
        .icon-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 16px; }
        .icon-grid a { text-decoration: none; }
    </style>
    
    </head>
<body onload="tamanho_elemento();" class="fundo" id="bodyy">

<div class="container" id="container">
    <div class="panel panel-info" style="margin-top: -21px">
        <div class="panel-heading">
            <div class="header-flex">
                <h1 class="header-title">
                    <img src="./img/arranchamento_72x72.png" height="40" alt="Arranchamento">
                    <b>Administrador</b>
                </h1>
                <div>
                    <a href="inserir_cardapio.php" title="Inserir Cardápio" class="btn btn-primary btn-sm">Inserir Cardápio</a>
                    <a href="logout.php" title="Sair" class="btn btn-outline-danger btn-sm">Sair</a>
                </div>
            </div>
        </div>
    </div>



    <!--Ícones da área de Administrador-->
    <div class="panel-body">
        <div class="icon-grid" style="margin-top:0px;">
            <?php

        //icone_adm('','./img/bloquear.png','Bloqueio de Rancho - Em breve');
        //icone_adm('','./img/expedientes_diferenciados.png','Expedientes Diferenciados - Em breve');
        //icone_adm('','./img/configuracoes.png','Gerenciamento de Contas - Em breve');
        icone_adm('./relatorio','./img/relatorios.png','<b><font color="#??????">Relatórios</font></b>');
        ?>
        </div>
        <div class="icon-grid" style="margin-top:0px;">
            <?php

        //icone_adm('','./img/bloquear.png','Bloqueio de Rancho - Em breve');
        //icone_adm('','./img/expedientes_diferenciados.png','Expedientes Diferenciados - Em breve');
        //icone_adm('','./img/configuracoes.png','Gerenciamento de Contas - Em breve');
        icone_adm('./inserir_cardapio.php','./img/cardapio.jpg','<b><font color="#??        ????">Cardápio</font></b>');
        ?>
        </div>
    </div>
</div>

<script>
    <!--Função para determinar o tamanho de um elemento-->
    function tamanho_elemento(id_destino,id_base,porcentagem){
        var width = window.getComputedStyle(document.getElementById(id_base), null).getPropertyValue("width");
        width = width.replace("px","");
        document.getElementById(id_destino).style.width = (width*(porcentagem/100))+"px";
    }
</script>

<script>   
    <!--Função para determinar o tamanho fundo-->
    function tamanho_elemento() {
        var height = window.innerHeight;
        document.getElementById('bodyy').style.height = height + "px";
    }
    window.onresize = function () {
        tamanho_elemento();        
    }    
    <!--Fim___________________________________-->
</script>


</body>
</html>
