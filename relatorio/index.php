<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="../favicon.ico">
  

  <!--Includes do Calendário-->  
<link rel="stylesheet" type="text/css" href="./calendario/calpopup.css">
<script src="./calendario/calpopup.js" type="text/javascript"></script>
<script type="text/javascript" src="./calendario/dateparse.js"></script>  
  
  <title>Arranchamento Digital - 13º GAC</title>
  
  <!--CSS de complemento-->
  <link href="../complemento.css" rel="stylesheet">    

  <!-- Material Design fonts -->
  <link rel="stylesheet" href="../material_design/dependencias/roboto.css" type="text/css">
  <link href="../material_design/dependencias/materialicons" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="../material_design/dependencias/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Material Design comentado -->
  <!--
  <link href="../material_design/dist/css/bootstrap-material-design.css" rel="stylesheet">
  <link href="../material_design/dist/css/ripples.min.css" rel="stylesheet">
-->
  <link href="../material_design/dependencias/snackbar.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body onLoad="document.formlogin.login.focus();" onclick="diminui();">


<div class="container">

  <!-- Form 
================================================== -->  
  <div class="panel panel-info" >

    <div class="panel-heading">
        <table style="width:100%">
            <tr>
                <th> <img src="../img/arranchamento_72x72.png" height="48">
                    <font style="font-size:16px;margin-left:2px;position: relative;top: 7px"><b>Opções de Relatório</font>
                </th>
                <th >
                    <button onclick="history.back();" class="buttonvoltar"></button>
                </th>
            </tr>
        </table>
    </div>

    <div class="panel-body" method="post" onclick="diminui();">
        <form class="form-horizontal" method="post" action="relatorio.php" id="frm" name="frm">
           <center>
            <label >Selecione a data no calendário</label><br>

            <div id="inputsss" style="height:30px;">
                <input onfocus="diminui();visivel();" style="border:none;width:230px;height:30px;text-align:center;font-size:1.5em;background-color:#404040;" type="text" name="calendario_data" id="calendario_data" size="11" onblur="dp_dateFormat='d-mm-yyyy';magicDate(this)" onfocus="if (this.className != 'error') this.select()" readonly> 
                <a  href="javascript:void(0);" onclick="g_Calendar.show(event, 'calendario_data', 'd-mm-yyyy');" title="Show popup calendar"><img onclick="aumenta();" src="./calendario/calendar-flat.png" border="0" style="width:34px;position:relative;top:-5px"></a>      
            </div>
            </center>

       
        <div class="form-group" style="width:230px;margin-left:auto;margin-right:auto;">  
            <div class="col-md-10" style="padding:0px">
               <div class="radio radio-primary" >
                           <label><input name="optionsRadios" id="optionsRadios1" value="arranchamento.hierarquia<=6" checked="" type="radio">Oficiais</label><br>
                           <label><input name="optionsRadios" id="optionsRadios2" value="arranchamento.hierarquia>=8 and arranchamento.hierarquia<=11 and militares.tipo_acesso<>'ALUNO'" type="radio">Sub Ten e Sgt</label><br>
                           <label><input name="optionsRadios" id="optionsRadios3" value="arranchamento.hierarquia>=12 and arranchamento.hierarquia<=13 and militares.tipo_acesso<>'ALUNO'" type="radio">Cabos e Soldados</label><br>
                           <label><input name="optionsRadios" id="optionsRadios11" value="militares.turma='OUTRAS' and militares.tipo_acesso='ALUNO'" type="radio">Outras</label>
                           <button id="gerar" type="submit" style="background: url(../img/like_48x48.png);border:0; display:block;height:48px;width:48px;z-index: 1;position:relative;left:85%;"></button>

               </div>
            </div>
        </div>           
        </form>
    </div>
  </div>

<br>


<script>
    //Aumenta e diminui tamanho da div
    function aumenta() {
        var d = document.getElementById('inputsss');
        d.style.height="300px";
    }
    function diminui() {
        var d = document.getElementById('inputsss');
        d.style.height="30px";
    }    
</script>


<script src="../material_design/dependencias/jquery-1.10.2.min.js"></script>
<script src="../material_design/dependencias/bootstrap.min.js"></script>
<script>
</script>
<script src="../material_design/dist/js/ripples.min.js"></script>
<script src="../material_design/dist/js/material.min.js"></script>
<script src="../material_design/dependencias/snackbar.min.js"></script>

<script src="../material_design/dependencias/jquery.nouislider.min.js"></script>

<script>
    //Função para ocultar o botão de gerar
    function visivel(){
        document.getElementById('gerar').style.visibility = 'visible';
    }    
</script>

<script>
  $(function () {
    $.material.init();
    $(".shor").noUiSlider({
      start: 40,
      connect: "lower",
      range: {
        min: 0,
        max: 100
      }
    });

    $(".svert").noUiSlider({
      orientation: "vertical",
      start: 40,
      connect: "lower",
      range: {
        min: 0,
        max: 100
      }
    });
  });
</script>
</body>
</html>
