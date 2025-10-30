<?php
session_start(); //iniciamos a sessão que foi aberta

session_destroy(); //destruimos a sessão ;)

session_unset(); //limpamos as variaveis globais das sessões

?>

<title>Arranchamento Logout</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

  <!-- Material Design fonts -->
  <link rel="stylesheet" href="./material_design/dependencias/roboto.css" type="text/css">
  <link href="./material_design/dependencias/materialicons" rel="stylesheet">
  


  <!-- Bootstrap Material Design -->
  <link href="material_design/dist/css/bootstrap-material-design.css" rel="stylesheet">
  <link href="material_design/dist/css/ripples.min.css" rel="stylesheet">


  <link href="./material_design/dependencias/snackbar.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">  

<html style="background-color: #272729">
        <head></head>
        <body>
                <p class="text-success" style="position:absolute;top:50%;left:30%;color: #fe9400;">Sessão Encerrada!</p>
        </body>
</html>
       

<!-- Função para retornar a página do arranchamento-->
<!-- 2000 = 2 segundos - Tempo para executar-->
<script>
contatempo();
function contatempo(){
        setTimeout(function(){executa()}, 2000);
}
function executa(){
        window.location.href = 'index.html';
}
</script>
