<?php
// Inicia a sessão antes de qualquer saída para evitar "headers already sent"
session_start();
//Includes e teste de sessão
require_once "./inc/conf.php";
require_once "./inc/funcoes.php";

if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('Location: index.html');
    exit;
}
$logado = $_SESSION['login'];
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="./favicon.ico">  
  
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">


  <title>Arranchamento</title>
  
  <link rel="stylesheet" href="./material_design/dependencias/roboto.css" type="text/css">
  <link href="./material_design/dependencias/materialicons" rel="stylesheet">

  <link href="./material_design/dependencias/bootstrap.min.css" rel="stylesheet">

  <link href="material_design/dist/css/bootstrap-material-design.css" rel="stylesheet">
  <link href="material_design/dist/css/ripples.min.css" rel="stylesheet">


  <link href="./material_design/dependencias/snackbar.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    /* ==================================================
       ESTILOS PARA A PÁGINA DE ARRACHAMENTO
       ================================================== */

    body {
        background-color: #f5f5f5; /* Um fundo suave */
    }

    /* --- Cabeçalho do Painel --- */
    /* (Sugestão: refatorar o cabeçalho para não usar tabela) */
    .panel-heading .botaosair {
        margin-left: 8px;
        opacity: 0.7;
        transition: opacity 0.2s ease-in-out;
    }
    .panel-heading .botaosair:hover {
        opacity: 1;
    }

    /* --- Tabela de Cabeçalho das Refeições --- */
    .meal-header-table {
        border-top: 3px solid #333; /* Cor mais suave */
        line-height: 2;
        margin-bottom: 0; /* Remover margem inferior */
        width: 100%;
        line-height: 200%;
    }
    .meal-header-table th {
        vertical-align: middle;
        text-align: center;
    }
    .meal-header-table th:first-child {
        text-align: left;
        width: 50%;
    }

    /* --- Linha de Dia Individual --- */
    .day-row {
        width: 100%;
        line-height: 1.5; /* Mais moderno */
        border-top: 1px solid #ddd; /* Borda mais leve */
        padding: 16px 8px;
        display: flex;
        align-items: center;
        background-color: #fff;
        transition: background-color 0.2s;
    }
    .day-row:hover {
        background-color: #f9f9f9;
    }

    /* Coluna de Informações do Dia (50%) */
    .day-info {
        width: 50%;
        padding-right: 10px;
        font-size: 16px; /* Tamanho base */
    }
    .day-info .day-name {
        font-size: 1.25em; /* 20px */
        font-weight: bold;
    }
    .day-info .day-date {
        font-size: 1em; /* 16px */
        color: #555;
    }
    .day-info .day-messages {
        font-size: 0.75em; /* 12px */
        margin-top: 5px;
        line-height: 1.4;
    }
    .day-info .msg-bloqueio { color: #cb00ff; }
    .day-info .msg-expediente, 
    .day-info .msg-prazo { 
        color: #777; 
        display: block; /* Quebra de linha */
    }

    /* Coluna de Refeição (Checkbox) */
    .day-meal {
        width: 16.66%; /* 50% dividido por 3 */
        text-align: center;
        /* Centraliza o checkbox do Material Design */
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40px; /* Altura fixa para alinhar */
    }

    /* Estilo para refeições bloqueadas */
    .meal-locked .checkbox label {
        opacity: 0.3;
        filter: grayscale(100%); /* Efeito mais moderno */
        cursor: not-allowed;
    }

    /* --- Pop-up de Justificativa --- */
    .justificativa-popup {
        background-color: #522121;
        color: #fff;
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        /* Centralização moderna */
        transform: translate(-50%, -50%); 
        padding: 25px;
        z-index: 1050; /* Acima de tudo */
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        width: 90%;
        max-width: 500px; /* Limite de largura */
    }
    .justificativa-popup p {
        font-size: 1.2em;
        margin-top: 0;
        font-weight: 500;
    }
    .justificativa-popup .form-control {
        color: #000; /* Estilo já existente */
        background-color: #f0f0f0;
    }
    .justificativa-popup .justificativa-actions {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end; /* Alinha botões à direita */
        gap: 20px;
    }
    .justificativa-actions .btn-justificar,
    .justificativa-actions .btn-cancelar {
        cursor: pointer;
        font-weight: 500;
        font-size: 1.1em;
        padding: 8px 12px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    .justificativa-actions .btn-justificar {
        color: #fff;
        background-color: #00b300;
    }
    .justificativa-actions .btn-justificar:hover {
        background-color: #008000;
    }
    .justificativa-actions .btn-cancelar {
        color: #ffb3b3;
        background-color: transparent;
    }
    .justificativa-actions .btn-cancelar:hover {
        background-color: rgba(255,255,255,0.1);
    }

  </style>
  <?php
$dias_semana = array(
        'Sun' => 'Domingo', 
        'Mon' => 'Segunda-feira',
        'Tue' => 'Terça-feira',
        'Wed' => 'Quarta-feira',
        'Thu' => 'Quinta-feira',
        'Fri' => 'Sexta-feira',
        'Sat' => 'Sábado'
    );

// ==================================================
// FUNÇÃO 'dia' REFATORADA (USA CLASSES CSS)
// ==================================================
function dia($i,$dia,$semana,$cor,$lock_cafe,$lock_almoco,$lock_jantar,
             $checked_cafe,$checked_almoco,$checked_jantar,
             $msg_bloqueio,$bloq_msg_cafe,$bloq_msg_almoco,$bloq_msg_jantar,
			 $msg_expediente, $msg_prazo, $justicativa_de_sexta,$onclick_msg_alm_sex){
	
	// Define classes CSS em vez de estilos inline
	$cafe_class = $lock_cafe != "" ? "meal-locked" : "";
	$alm_class  = $lock_almoco != "" ? "meal-locked" : "";
	$jan_class  = $lock_jantar != "" ? "meal-locked" : "";
    
    // O HTML foi refatorado para usar DIVs e Classes CSS
	print("
    <div class=\"day-row\">
        <div class=\"day-info\">
            <span class=\"day-name\" style=\"color:$cor\">$semana</span><br>
            <span class=\"day-date\" style=\"color:$cor\">$dia</span><br>
            <div class=\"day-messages\">
                <span class=\"msg-bloqueio\">$msg_bloqueio $bloq_msg_cafe $bloq_msg_almoco $bloq_msg_jantar</span>
                <span class=\"msg-expediente\">$msg_expediente</span>
                <span class=\"msg-prazo\">$msg_prazo</span>
            </div>
        </div>
        
        <div class=\"day-meal $cafe_class\">
            <div class=\"checkbox\">
              <label> 
                <input type=\"checkbox\" value=\"None\" $lock_cafe $checked_cafe id=\"caf$i\" name=\"checkcaf$i\" >
              </label>
            </div>    
        </div>
        
        <div class=\"day-meal $alm_class\">
            <div class=\"checkbox\">
              <label>
                <input type=\"checkbox\" $onclick_msg_alm_sex value=\"None\" $lock_almoco $checked_almoco id=\"alm$i\" name=\"checkalm$i\">
              </label>
            </div>    
        </div>
        
        <div class=\"day-meal $jan_class\">
            <div class=\"checkbox\">
              <label>
                <input type=\"checkbox\" value=\"None\" $lock_jantar $checked_jantar id=\"jan$i\" name=\"checkjan$i\">
              </label>
            </div>    
        </div>
    </div>
    ");
    
    // Pop-up de justificativa também usa classes CSS
    // ID do input de texto corrigido para "alm_justificativa_texto$i"
    print("
        <div class=\"justificativa-popup form-group has-warning\" id=\"almoco_justificativa$i\">
            <p>Por favor, justifique o seu arranchamento para o almoço de Sexta-Feira</p>
            <label class=\"control-label\" for=\"alm_justificativa_texto$i\">Descreva de forma sucinta</label>
            <input class=\"form-control\" type=\"text\" value=\"$justicativa_de_sexta\" id=\"alm_justificativa_texto$i\" name=\"almoco_justificativa$i\">   
            <div class=\"justificativa-actions\">
                <span class=\"btn-cancelar\" onclick=\"sem_justificativa($i)\">Não me arranchar</span>
                <span class=\"btn-justificar\" onclick=\"verifica_just_preench('alm_justificativa_texto$i','almoco_justificativa$i','alm$i');\">Justificar</span>
            </div>
        </div>
    ");

    // Corrigido o popup de Jantar que estava com IDs duplicados
    // O texto "almoço de Sexta-Feira" parece ser um erro de digitação no original, mas foi mantido.
    print("
        <div class=\"justificativa-popup form-group has-warning\" id=\"jantar_justificativa$i\">
            <p>Por favor, justifique o seu arranchamento para o almoço de Sexta-Feira</p>
            <label class=\"control-label\" for=\"jan_justificativa_texto$i\">Descreva de forma sucinta</label>
            <input class=\"form-control\" type=\"text\" value=\"$justicativa_de_sexta\" id=\"jan_justificativa_texto$i\" name=\"jantar_justificativa$i\">   
            <div class=\"justificativa-actions\">
                <span class=\"btn-cancelar\" onclick=\"sem_justificativa_jantar($i)\">Não me arranchar</span>
                <span class=\"btn-justificar\" onclick=\"verifica_just_preench('jan_justificativa_texto$i','jantar_justificativa$i','jan$i');\">Justificar</span>
            </div>
        </div>
    ");
}
?> 

</head>
<body >

<?php

$seleciona = "select * from militares where cpf='$logado'";
$result = $conexao->query($seleciona);
$row = $result->fetch_object();
?>


<div class="container" id="container">

  <div class="panel panel-info" style="margin-top: -21px" >
    <div class="panel-heading">
		<table style="width:100%" >
		  <tr>
			<th >
			    <img src="./img/arranchamento_72x72.png" height="48">
				<font style="font-size:16px;margin-left:2px;position: relative;top: 7px"><b>Arranchar</font>			
			</th>
			<th style="text-align:right">
				 <a href="logout.php" title="Sair" class="botaosair"><img src="./img/sair.png" ></a>
				 <a href="editar_conta.php" title="Editar minha Conta" class="botaosair"><img src="./img/editar.png" ></a>
				 <?php //se é administrador mostra botão de retorno para a área administrativa
                    if($_SESSION['tipo_acesso']=='ADMINISTRADOR'){
                        print("
                            <a href=\"administrador.php\" title=\"Voltar\" class=\"botaosair\"><img src=\"./img/voltar.png\" ></a>
                        ");                
                    }
                ?>
			</th>
		  </tr>
		</table>
	  
    </div>
    <div class="panel-body">
        <form method="post" class="form-horizontal" style="color: black" action="arrancha.php" id="form_arrancha" name="form_arrancha">
            <center><h3 style="color:black"><b>
            <?php
            //Retorna a saudação: Bom dia, Boa tarde...
            echo bomdia().", "; echo "$row->posto"." "."$row->nomeguerra"; ?></b></h3></center><br>
			<?php echo "".hora();
            echo " - ".$_SESSION['tipo_acesso'];
            ?>
            
            <table class="meal-header-table">
                <tr>
                    <th><h4>Dias/Refeições</h4></th>    
                    <th><img src='./img/cafe.png'></th>    
                    <th><img src='./img/almoco.png'></th>   
                    <th><img src='./img/jantar.png'></th>
                </tr>
            </table>

            <?php
			  
              //Cria as linhas dos dias com as opções de café almoço e jantar
              //O valor máximo do FOR define a quantidade de dias mostrados na tela
              for($i=0;$i<=$nr_dias;$i++){
                $dia = date("d-m-Y",mktime(0,0,0,date("m"),date("d")+$i,date("Y")));
                $dia_sql = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+$i,date("Y")));
                $semana=$dias_semana[date("D",mktime(0,0,0,date("m"),date("d")+$i,date("Y")))];
				$msg_expediente=""; $msg_prazo="";
				$lock_cafe="";$lock_almoco="";$lock_jantar="";
				
                //Condicionais
                if($semana=="Sábado" or $semana=="Domingo") {
					$cor = "red";
					$msg_expediente = "Sem expediente";
					}
					else{
						$msg_expediente = "Expediente normal";
						$cor = "black";
					}
                
                //Carrega o arranchamento já efetuado anteriormente
                $arranch0  = "select * from arranchamento where cpf='$logado' and data = '$dia_sql' ";
                $result0 = $conexao->query($arranch0 );
                $row = $result0->fetch_object();
                if($result0->num_rows>0 ){ // Aqui checa no banco os dias arranchados e se sim define as variáveis para checked
                    if($row->cafe=='S') {$checked_cafe="checked";} else $checked_cafe='';
                    if($row->almoco=='S') {$checked_almoco="checked";} else $checked_almoco='';
                    if($row->jantar=='S') {$checked_jantar="checked";} else $checked_jantar='';
                    $justicativa_de_sexta = $row->justificativa_sexta;

                }
                else{ $checked_cafe=''; $checked_almoco=''; $checked_jantar='';$justicativa_de_sexta = ""; }
                

                
                
              
				//Bloqueio por horário Sábado
				if($semana=="Sábado"){
					$arranch  = "select * from limite_arranchamento where diasemana='sab' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de sexta";
					if($i==0){
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
						}
					if($i==1 and hora()>$row->horalimite){//Analise da sábado na sexta-feira						
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
					}
				}	
				
				//Bloqueio por horário Domingo
				if($semana=="Domingo"){
					$arranch  = "select * from limite_arranchamento where diasemana='dom' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de sexta";
					if($i>=0 AND $i<=1){
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
						}
					if($i==2 and hora()>$row->horalimite){//Analise da domingo na sexta-feira						
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
					}
				}				
				
				//Bloqueio por horário Segunda
				if($semana=="Segunda-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='seg' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de sexta";
					if($i>=0 AND $i<=2){
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
						}
					//função "hora()" está no arquivo "func.php"
					if($i==3 and hora()>$row->horalimite){//Analise da segunda-feira na sexta-feira						
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
					}
				}
				//Bloqueio por horário Terça
				if($semana=="Terça-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='ter' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de segunda";

					if($i==1 and hora()>$row->horalimite){//Analise da quarta-feira um dia antes - "$i==1" quer dizer que ele é o segundo dia a aparecer na tela
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
					}
				}				
				//Bloqueio por horário Quarta
				if($semana=="Quarta-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='qua' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de terça";

					if($i==1 and hora()>$row->horalimite){//Analise da quarta-feira um dia antes - "$i==1" quer dizer que ele é o segundo dia a aparecer na tela
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
					}
				}
				//Bloqueio por horário Quinta
				if($semana=="Quinta-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='qui' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de quarta";

					if($i==1 and hora()>$row->horalimite){//Analise da quinta-feira um dia antes				
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
					}
				}
				//Bloqueio por horário Sexta, também verifica se é necessário colocar a função em onclick
                $onclick_msg_alm_sex = "";
				if($semana=="Sexta-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='sex' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de quinta";
                    
                    if($_SESSION['tipo_acesso']!="ALUNO"){
                        // Removido 'tamanho_msg' pois o CSS cuida disso
                        $onclick_msg_alm_sex = "onclick=\"div_visivel('almoco_justificativa$i');reaplica_check('alm$i')\" ";   
                    }

					if($i==1 and hora()>$row->horalimite){//Analise da sexta-feira um dia antes				
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado";
                        $onclick_msg_alm_sex = "";
					}
				}
                  

                //Bloqueia arranchamento - Tabela "bloqueia_arranchamento"
                $arranch0  = "select * from bloqueia_arranchamento where databloqueio = '$dia_sql' ";
                $result0 = $conexao->query($arranch0 );
                $row = $result0->fetch_object();
                if($result0->num_rows>0 ){
                    $msg_bloqueio = $row->motivobloqueio.'<br>';
                    $msg_expediente="";$msg_prazo="";
                    if($row->bloqueiacafe=='S') {$lock_cafe="$lock";$bloq_msg_cafe='Sem Café, ';$checked_cafe='';}           	else {$lock_cafe="";$bloq_msg_cafe='Com Café, ';}
                    if($row->bloqueiaalmoco=='S') {$lock_almoco="$lock";$bloq_msg_almoco='Sem Almoço, ';$checked_almoco='';}   	else {$lock_almoco="";$bloq_msg_almoco='Com Almoço, ';}
                    if($row->bloqueiajantar=='S') {$lock_jantar="$lock";$bloq_msg_jantar='Sem Jantar';$checked_jantar='';}   	else {$lock_jantar="";$bloq_msg_jantar='Com Jantar';}
                } else {$msg_bloqueio='';$bloq_msg_cafe='';$bloq_msg_almoco='';$bloq_msg_jantar='';}
                  
                  
				//Bloqueia opções de Hoje independente de qualquer outra configuração
				if($i == 0){$semana = "Hoje";$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";$cor="black";} 
				
                //Chama a função que escreve a linha do dia
                dia($i,$dia,$semana,$cor,												//informações sobre dia, dia da semana e cor do texto
					$lock_cafe,$lock_almoco,$lock_jantar,								//variáveis que bloqueiam o checkbox
                    $checked_cafe,$checked_almoco,$checked_jantar,                      //itens marcados
                    $msg_bloqueio, $bloq_msg_cafe,$bloq_msg_almoco,$bloq_msg_jantar,    //Bloqueio arranchamento - Mensagens
					$msg_expediente, $msg_prazo, 
                    $justicativa_de_sexta,$onclick_msg_alm_sex					         //Mensagens sobre o dia e prazo de arranchamento
                    );
              }
              
            ?>
            
          <div class="modal-footer">
  <button type="submit" 
          style="background: url(./img/like_48x48.png);
                 border: 0; 
                 height: 48px; 
                 width: 48px;
                 cursor: pointer;
                 box-shadow: 0 2px 5px rgba(0,0,0,0.26);
                 border-radius: 50%;
                 z-index: 10;
                 
                 
                 position: fixed;  
                 left: 50%;
                 bottom: 15px;    
                 transform: translateX(-50%); 
                 ">
  </button>
</div>      
        </form>
        
    </div>
    
  </div>   
  
<br>

<script>
    function div_visivel(el) {
        var display = document.getElementById(el).style.display;

            if(display == "none") document.getElementById(el).style.display = 'block';
            else document.getElementById(el).style.display = 'none';
    }
    
    function sem_justificativa(i) {
        document.getElementById('almoco_justificativa'+i).style.display = 'none';
        document.getElementById('alm'+i).checked = false;
        document.getElementById('alm_justificativa_texto'+i).value = ""; // ID corrigido
    }      
    
    function sem_justificativa_jantar(i) {
        document.getElementById('jantar_justificativa'+i).style.display = 'none';
        document.getElementById('jan'+i).checked = false;
        document.getElementById('jan_justificativa_texto'+i).value = ""; // ID corrigido
    }  
    
   
    
    function tamanho_elemento(id_destino,id_base,porcentagem){
        var width = window.getComputedStyle(document.getElementById(id_base), null).getPropertyValue("width");
        width = width.replace("px","");
        document.getElementById(id_destino).style.width = (width*(porcentagem/100))+"px";
    }        
      

    function reaplica_check(elemento) {
        if(document.getElementById(elemento).checked != true)
            document.getElementById(elemento).checked = true;
        else
            document.getElementById(elemento).checked = false;
    }
    
    function verifica_just_preench(input_justificativa,quem_ocultar,quem_checar){
        if(document.getElementById(input_justificativa).value.length == 0)
        {
            alert('Você deve preencher a sua justificativa para poder se arranchar');
        }
        else {
            div_visivel(quem_ocultar);
            document.getElementById(quem_checar).checked = true;
        }
    }
</script>
<script src="material_design/dependencias/jquery-1.10.2.min.js"></script>
<script src="material_design/dependencias/bootstrap.min.js"></script>
<script src="material_design/dist/js/ripples.min.js"></script>
<script src="material_design/dist/js/material.min.js"></script>
<script src="material_design/dependencias/snackbar.min.js"></script>


<script src="material_design/dependencias/jquery.nouislider.min.js"></script>
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