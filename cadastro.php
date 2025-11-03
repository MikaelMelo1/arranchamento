<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="./favicon.ico">

  <title>Arranchamento Digital - 13º GAC</title>
  
  <!--CSS de complemento-->
  <link href="./complemento.css" rel="stylesheet">  

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
  </style>
  
</head>
<body>


<div class="container">
  <!-- Form -->
    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="header-flex">
          <h1 class="header-title">
            <img src="./img/arranchamento_72x72.png" height="40" alt="Arranchamento">
            <b>Nova conta</b>
          </h1>
          <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm">← Voltar</a>
        </div>
      </div>
      <div class="panel-body" method="post" >
        <?php


          //Formulario de cadastro do efetivo profissional
          if($_POST['optionsRadios']=='cp'){
              print("
                <form method=\"post\" class=\"form-horizontal\" name=\"formulario\" action=\"usuario_novo.php\" id=\"usuario_novo\" name=\"usuario_novo\">
                  <center>Cadastro do Efetivo Profissional</center>
                    <div class=\"form-group\">
                      <label for=\"inputNGuerra\" class=\"col-md-2 control-label\">Nome Completo</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" onkeyup=\"visibilidade_cp();\" onFocus=\"proximoCampo ='graduacao'; \" class=\"form-control\" id=\"nomecompleto\" name=\"nomecompleto\" placeholder=\"\"  onBlur=\"upperCaseF(this)\" >
                      </div>
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Graduação</label>        
                      <div class=\"col-md-10\">
                        <select id=\"graduacao\" name=\"graduacao\" class=\"form-control\" onFocus=\"proximoCampo ='nomeguerra'; \"  \">
                          <option value=\"GEN\">GEN</option>
                          <option value=\"CEL\">CEL</option>
                          <option value=\"TC\">TC</option>
                          <option value=\"MAJ\">MAJ</option>
                          <option value=\"CAP\">CAP</option>
                          <option value=\"1º TEN\">1º TEN</option>
                          <option value=\"2º TEN\">2º TEN</option>
                          <option value=\"ASP OF\">ASP OF</option>
                          <option value=\"ST\">ST</option>
                          <option value=\"1º SGT\">1º SGT</option>
                          <option value=\"2º SGT\">2º SGT</option>
                          <option value=\"3º SGT\">3º SGT</option>
                          <option value=\"CB\">CB</option>
                          <option value=\"SD\">SD</option>
                        </select>
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Nome de Guerra</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" onkeyup=\"visibilidade_cp();\" class=\"form-control\" name=\"nomeguerra\" id=\"nomeguerra\" placeholder=\"\" onBlur=\"upperCaseF(this)\" onFocus=\"proximoCampo ='arma'; \">
                      </div>              
                    </div>
                    
                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Arma</label>        
                      <div class=\"col-md-10\">
                        <select id=\"arma\" name=\"arma\" class=\"form-control\" onFocus=\"proximoCampo ='funcao'; \">
                          <option value=\"ARTILHARIA\">ARTILHARIA</option>
                          <option value=\"COMUNICAÇÕES\">COMUNICAÇÕES</option>
                          <option value=\"INTENDÊNCIA\">INTENDÊNCIA</option>
                          <option value=\"MATERIAL BÉLICO\">MATERIAL BÉLICO</option>
                          <option value=\"OUTRAS\">OUTRAS</option>                  
                        </select>
                      </div>              
                    </div>                    

                    <div class=\"form-group\">
                      <label for=\"inputCPF\" class=\"col-md-2 control-label\">Seção/Função</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" onkeyup=\"visibilidade_cp();\" class=\"form-control\" name=\"funcao\" id=\"funcao\" placeholder=\"\" onBlur=\"upperCaseF(this)\" onFocus=\"proximoCampo ='cpf'; \">
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputCPF\" class=\"col-md-2 control-label\">Nr do CPF</label>        
                      <div class=\"col-md-10\">
                        <input type=\"number\" onkeyup=\"visibilidade_cp();\" class=\"form-control\" id=\"cpf\" name=\"cpf\" placeholder=\"\" onFocus=\"proximoCampo ='inputPassword'; \">
                      </div>              
                    </div>            

                    <div class=\"form-group\">
                          <label for=\"inputPassword\" class=\"col-md-2 control-label\">Senha</label>            
                          <div class=\"col-md-10\">
                            <input onkeyup=\"visibilidade_cp();\" type=\"password\" class=\"form-control\" id=\"inputPassword\" name=\"inputPassword\" placeholder=\"\" onFocus=\"proximoCampo ='inputPassword2'; \">
                          </div>
                    </div>
                    <div class=\"form-group\">
                          <label for=\"inputPassword2\" class=\"col-md-2 control-label\">Redigite sua senha</label>            
                          <div class=\"col-md-10\">
                            <input onkeyup=\"visibilidade_cp();\" type=\"password\" class=\"form-control\" id=\"inputPassword2\" placeholder=\"\">
                          </div>
                    </div> 

                    <input type=\"hidden\" name=\"tipo_acesso\" value=\"CORPO PERMANENTE\" >
                    <input type=\"hidden\" name=\"numero\" value=\"NULL\" >
                    <input type=\"hidden\" name=\"turma\" value=\"\" >

                    <div id=\"msg\" style=\"font-weight:100;font-size:12px;position: fixed;left:30%;bottom: 15px;z-index: 1;visibility:visible\">O botão para gravar só aparece depois que todos os campos estão preenchidos corretamente!</div>

                    <button type=\"submit\" id=\"gravar\" style=\"background: url(./img/like_48x48.png);border:0;          display:block;height:48px;width:48px;position: fixed;left:80%;bottom: 15px;z-index: 1;visibility:hidden\"></button>

                </form>
                "
                   );}          
          
          //Formulario de cadastro do efetivo variavel
          if($_POST['optionsRadios']=='alu'){
              print("
                <form method=\"post\" class=\"form-horizontal\" name=\"formulario\" action=\"usuario_novo.php\" id=\"usuario_novo\" name=\"usuario_novo\">
                  <center>Cadastro do Efetivo Variável</center>
                    <div class=\"form-group\">
                      <label for=\"inputNGuerra\" class=\"col-md-2 control-label\">Nome Completo</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" onkeyup=\"visibilidade();\" onFocus=\"proximoCampo ='graduacao'; \" class=\"form-control\" id=\"nomecompleto\" name=\"nomecompleto\" placeholder=\"\"  onBlur=\"upperCaseF(this)\" >
                      </div>
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Graduação</label>        
                      <div class=\"col-md-10\">
                        <select id=\"graduacao\" name=\"graduacao\" class=\"form-control\" onFocus=\"proximoCampo ='nomeguerra'; \"  \">
                          <option value=\"CB\">CB</option>
                          <option value=\"SD\">SD</option>
                        </select>
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Nome de Guerra</label>        
                      <div class=\"col-md-10\">
                        <input type=\"text\" onkeyup=\"visibilidade();\" class=\"form-control\" name=\"nomeguerra\" id=\"nomeguerra\" placeholder=\"\" onBlur=\"upperCaseF(this)\" onFocus=\"proximoCampo ='numero'; \">
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputCPF\" class=\"col-md-2 control-label\">Número</label>        
                      <div class=\"col-md-10\">
                        <input type=\"number\" onkeyup=\"visibilidade();\" class=\"form-control\" name=\"numero\" id=\"numero\" placeholder=\"\" onFocus=\"proximoCampo ='turma'; \">
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputNome\" class=\"col-md-2 control-label\">Bateria</label>        
                      <div class=\"col-md-10\">
                        <select id=\"Bateria\" name=\"Bateria\" class=\"form-control\" onFocus=\"proximoCampo ='arma'; \">
                          <option value=\"BIA C\">BIA C</option>
                          <option value=\"1ª BIA O\">1ª BIA O</option>
                          <option value=\"2ª BIA O\">2ª BIA O</option>
                          <option value=\"OUTRAS\">OUTRAS</option>                  
                        </select>
                      </div>              
                    </div>

                    <div class=\"form-group\">
                      <label for=\"inputCPF\" class=\"col-md-2 control-label\">Nr do CPF</label>        
                      <div class=\"col-md-10\">
                        <input type=\"number\" onkeyup=\"visibilidade();\" class=\"form-control\" id=\"cpf\" name=\"cpf\" placeholder=\"\" onFocus=\"proximoCampo ='inputPassword'; \">
                      </div>              
                    </div>            

                    <div class=\"form-group\">
                          <label for=\"inputPassword\" class=\"col-md-2 control-label\">Senha</label>            
                          <div class=\"col-md-10\">
                            <input onkeyup=\"visibilidade();\" type=\"password\" class=\"form-control\" id=\"inputPassword\" name=\"inputPassword\" placeholder=\"\" onFocus=\"proximoCampo ='inputPassword2'; \">
                          </div>
                    </div>
                    <div class=\"form-group\">
                          <label for=\"inputPassword2\" class=\"col-md-2 control-label\">Redigite sua senha</label>            
                          <div class=\"col-md-10\">
                            <input onkeyup=\"visibilidade();\" type=\"password\" class=\"form-control\" id=\"inputPassword2\" placeholder=\"\">
                          </div>
                    </div> 

                    <input type=\"hidden\" name=\"tipo_acesso\" value=\"ALUNO\" />
                    <input type=\"hidden\" name=\"funcao\" value=\"NULL\" />

                    <div id=\"msg\" style=\"font-weight:100;font-size:12px;position: fixed;left:30%;bottom: 15px;z-index: 1;visibility:visible\">O botão para gravar só aparece depois que todos os campos estão preenchidos corretamente!</div>

                    <button type=\"submit\" id=\"gravar\" style=\"background: url(./img/like_48x48.png);border:0;          display:block;height:48px;width:48px;position: fixed;left:80%;bottom: 15px;z-index: 1;visibility:hidden\"></button>

                </form>
                "
                   );}
          ?>
        
      </div>
    </div>

</div>
<br>

<script src="material_design/dependencias/jquery-1.10.2.min.js"></script>
<script src="material_design/dependencias/bootstrap.min.js"></script>
<script>
</script>
<script src="material_design/dist/js/ripples.min.js"></script>
<script src="material_design/dist/js/material.min.js"></script>
<script src="material_design/dependencias/snackbar.min.js"></script>



<script src="material_design/dependencias/jquery.nouislider.min.js"></script>

<script>
    //Função para ocultar o botão de gravar
    function visibilidade_cp() {
        if(document.getElementById('inputPassword').value == document.getElementById('inputPassword2').value && 
           document.getElementById('nomecompleto').value.length!=0 &&
           document.getElementById('nomeguerra').value.length!=0 &&
           document.getElementById('inputPassword').value.length!=0   &&
           document.getElementById('cpf').value.length!=0 &&
           document.getElementById('funcao').value.length!=0
          ){
            document.getElementById('gravar').style.visibility = 'visible';
            document.getElementById('msg').style.visibility = 'hidden';
        }
        else{
            document.getElementById('gravar').style.visibility = 'hidden';
            document.getElementById('msg').style.visibility = 'visible';
        }
        
    }
    function visibilidade() {
        if(document.getElementById('inputPassword').value == document.getElementById('inputPassword2').value && 
           document.getElementById('nomecompleto').value.length!=0 &&
           document.getElementById('nomeguerra').value.length!=0 &&
           document.getElementById('inputPassword').value.length!=0   &&
           document.getElementById('cpf').value.length!=0 &&
           document.getElementById('numero').value.length!=0
          ){
            document.getElementById('gravar').style.visibility = 'visible';
            document.getElementById('msg').style.visibility = 'hidden';
        }
        else{
            document.getElementById('gravar').style.visibility = 'hidden';
            document.getElementById('msg').style.visibility = 'visible';
        }
        
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
  //Função para deixar as letras maiúsculas
  function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
  }
  
//###############################################################
//FUNÇÃO PARA PASSAR PARA O PROXIMO CAMPO COM A TECLA "enter"
//nome do formulário 
nomeForm = "formulario"  
//função que gere o evento 
function TeclaPressionada( e ) {  
if ( window.event != null)     //IE4+  
tecla = window.event.keyCode;  
else if ( e != null )          //N4+ o W3C compatíveis  
tecla = e.which;  
else  
return;  
if (tecla == 13) {             //se pressionou enter  
if ( proximoCampo == "fin" ) { //fim da sequência, faz o submit  
alert("Envio do formulário.")  //eliminar este alert para uso normal  
return false                   //sustituir por return true para fazer o submit  
} else {                       //passa o foco para o campo seguinte 
eval("document." + nomeForm + "." + proximoCampo + ".focus()")  
return false  
}  
}  
}  
document.onkeydown = TeclaPressionada;  //faz com que a função TeclaPressionada seja executada no evento onkeydown 
if (document.captureEvents)             //netscape é especial: requer ativação da captura do evento  
document.captureEvents(Event.KEYDOWN)
//###############################################################  
</script>




</body>
</html>
