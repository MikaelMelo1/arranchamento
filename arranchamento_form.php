<!DOCTYPE html>
<html>
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
  <style>
    body {
      background: #f5f5f5;
      font-family: 'Roboto', Arial, sans-serif;
    }
    .main-card {
      margin: 40px auto;
      max-width: 740px;
      box-shadow: 0 8px 32px rgba(30,30,60,0.10);
      background: #fff;
      border-radius: 18px;
      padding: 0 0 18px 0;
    }
    .panel-heading {
      background: #e3f2fd!important;
      border-radius: 18px 18px 0 0;
      padding: 12px 24px;
      margin-bottom: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .panel-heading .painel-title {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.6rem;
      font-weight: 600;
      color: #2196F3;
      margin: 0;
    }
    .panel-heading .painel-actions a {
      margin-left: 12px;
      opacity: .7;
      transition: opacity .12s;
    }
    .panel-heading .painel-actions a:hover {
      opacity: 1;
    }
    .painel-title img {
      height: 42px;
    }
    .dias-table th, .dias-table td {
      vertical-align: middle !important;
      text-align: center !important;
      border: none !important;
      font-size: 1rem;
      padding: 3px 2px;
    }
    .dias-table th:first-child {
      text-align: right;
      color: #424242;
      font-weight: bold;
    }
    .dias-table {
      background: #fff;
      width: 100%;
      margin-bottom: 7px;
    }
    .ref-icon {
      width: 26px;
      height: 26px;
      object-fit: contain;
      filter: drop-shadow(0 2px 2px rgba(0,0,0,.10));
    }
    .saudacao {
      font-size: 1.2rem;
      margin: 8px auto 0 auto;
      color: #2196F3;
      font-weight: bold;
      background: #e3f2fd;
      display: inline-block;
      padding: 5px 26px;
      border-radius: 13px;
      box-shadow: 0 1px 5px rgba(40,100,250,0.08);
    }
    .panel-body {
      padding: 22px 16px 2px 16px;
      border-radius: 0 0 18px 18px;
      background: #ffffff;
    }
    .modal-footer {
      display: flex;justify-content: flex-end;background: none !important;border:none !important;box-shadow:none;
    }
    .like-btn{
      background: url(./img/like_48x48.png) no-repeat center center/contain;
      border:0;height:48px;width:48px;box-shadow:none;
      margin-left:auto;margin-right:auto;
    }
    .dias-table tr:not(:first-child) th {
      font-weight: normal;
    }
    @media (max-width: 600px) {
      .main-card {max-width:98vw;}
      .panel-heading {padding:7px 7px;}
      .panel-body {padding:7px 2px 2px 2px;}
      .saudacao {padding:5px 2vw;}
      .like-btn {height: 38px;width: 38px;}
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

function dia($i,$dia,$semana,$cor,$lock_cafe,$lock_almoco,$lock_jantar,
             $checked_cafe,$checked_almoco,$checked_jantar,
             $msg_bloqueio,$bloq_msg_cafe,$bloq_msg_almoco,$bloq_msg_jantar,
			 $msg_expediente, $msg_prazo, $justicativa_de_sexta,$onclick_msg_alm_sex){
	
	//Configuração de como aparecem as cores dos ítens bloqueados
	if($lock_cafe!=""){$cafecor="style=\"opacity: 0.2;filter: invert(100%);\"";} else {$cafecor="";}
	if($lock_almoco!=""){$almcor="style=\"opacity: 0.2;filter: invert(100%);\"";} else {$almcor="";}
	if($lock_jantar!=""){$jancor="style=\"opacity: 0.2;filter: invert(100%);\"";} else {$jancor="";}
    
	print("<br>
		  
		<table style=\"width:100%;line-height: 200%; border-top: 3px solid rgb(40,40,40);\">
		  <tr>
			<th style=\"width:50%\"><font style=\"font-size:20px;color:$cor\">$semana</font><br>
										  <font style=\"color:$cor\">$dia</font><br>
										  <font style=\"color:#cb00ff;font-size:11px\">$msg_bloqueio $bloq_msg_cafe $bloq_msg_almoco $bloq_msg_jantar</font>
										  <font style=\"color:black;font-size:11px\">$msg_expediente</font>
										  <font style=\"color:black;font-size:11px\">$msg_prazo</font>
										  </th>    
			<th><!--CHECKBOX CAFÉ-->
				<div class=\"checkbox\" >
				  <label $cafecor> 
					<input type=\"checkbox\" value=\"None\" $lock_cafe $checked_cafe id=\"caf$i\" name=\"checkcaf$i\" >
				  </label>
				</div>    
			</th>
			
			<th><!--CHECKBOX ALMOÇO-->
				<div class=\"checkbox\" >
				  <label $almcor>
					<input type=\"checkbox\" $onclick_msg_alm_sex value=\"None\" $lock_almoco $checked_almoco id=\"alm$i\" name=\"checkalm$i\">
				  </label>
				</div>    
			</th>
			
			<th><!--CHECKBOX JANTAR-->
				<div class=\"checkbox\" >
				  <label $jancor>
					<input type=\"checkbox\" value=\"None\" $lock_jantar $checked_jantar id=\"jan$i\" name=\"checkjan$i\">
				  </label>
				</div>    
			</th>
			
		  </tr>
		</table>
    ");
    
    //Input para Justificativa do almoço de sexta-feira

        print("
            <div class=\"form-group has-warning\" id=\"almoco_justificativa$i\" style=\"background-color:#522121;display:none;position:fixed;top:2%;padding:15px;z-index:10\"><br>
                <p>Por favor, justifique o seu arranchamento para o almoço de Sexta-Feira</p>
                <label class=\"control-label\" for=\"inputWarning\">Descreva de forma sucinta</label>
                <input class=\"form-control\" type=\"text\" value=\"$justicativa_de_sexta\" id=\"justificativa_texto$i\" name=\"almoco_justificativa$i\" style=\"color:black\">   
                <font onclick=\"verifica_just_preench('justificativa_texto$i','almoco_justificativa$i','alm$i');\" style=\"margin-right:30px;cursor:pointer;color:#00ff00;font-weight: 500;\">Justificar</font>
                <font onclick=\"sem_justificativa($i)\" style=\"margin-right:30px;cursor:pointer;color:#ffb3b3;font-weight: 500;\">Não me arranchar</font>
            </div>
        ");

 print("
            <div class=\"form-group has-warning\" id=\"jantar_justificativa$i\" style=\"background-color:#522121;display:none;position:fixed;top:2%;padding:15px;z-index:10\"><br>
                <p>Por favor, justifique o seu arranchamento para o almoço de Sexta-Feira</p>
                <label class=\"control-label\" for=\"inputWarning\">Descreva de forma sucinta</label>
                <input class=\"form-control\" type=\"text\" value=\"$justicativa_de_sexta\" id=\"justificativa_texto$i\" name=\"jantar_justificativa$i\" style=\"color:black\">   
                <font onclick=\"verifica_just_preench('justificativa_texto$i','jantar_justificativa$i','jan$i');\" style=\"margin-right:30px;cursor:pointer;color:#00ff00;font-weight: 500;\">Justificar</font>
                <font onclick=\"sem_justificativa($i)\" style=\"margin-right:30px;cursor:pointer;color:#ffb3b3;font-weight: 500;\">Não me arranchar</font>
            </div>
        ");


    
}
?> 

</head>
<body >

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

  <!-- Form Arranchamento ================================================== -->  
  <div class="panel panel-info main-card">
    <div class="panel-heading">
      <div class="painel-title">
        <img src="./img/arranchamento_72x72.png" alt="Arranchamento Logo">
        Arranchar
      </div>
      <div class="painel-actions">
         <a href="logout.php" title="Sair"><img src="./img/sair.png" height="28"></a>
         <a href="editar_conta.php" title="Editar minha Conta"><img src="./img/editar.png" height="28"></a>
         <?php if($_SESSION['tipo_acesso']=='ADMINISTRADOR'){ print('<a href="administrador.php" title="Voltar"><img src="./img/voltar.png" height="28"></a>'); } ?>
      </div>
    </div>
    <div class="panel-body">
      <span class="saudacao">
        <?php echo bomdia().", ".$row->posto." ".$row->nomeguerra; ?>
      </span>
      <span style="margin-left:8px;font-size:.9rem;color:#888;"> <?php echo hora()." - ".$_SESSION['tipo_acesso']; ?> </span>
      <hr style="margin:10px 0 16px 0;">
      <table class="dias-table">
        <tr>
          <th style="width:50%;text-align:right"><h4 style="margin:0;font-size:1.10rem;font-weight:700;color:#1976D2">Dias/Refeições</h4></th>    
          <th><img class="ref-icon" src='./img/cafe.png' title="Café da manhã"></th>    
          <th><img class="ref-icon" src='./img/almoco.png' title="Almoço"></th>   
          <th><img class="ref-icon" src='./img/jantar.png' title="Jantar"></th>
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
					$msg_expediente = "Sem expediente<br>";
					}
					else{
						$msg_expediente = "Expediente normal<br>";
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
					$msg_prazo = "Prazo: Até $row->horalimite de sexta<br>";
					if($i==0){
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
						}
					if($i==1 and hora()>$row->horalimite){//Analise da sábado na sexta-feira						
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
					}
				}	
				
				//Bloqueio por horário Domingo
				if($semana=="Domingo"){
					$arranch  = "select * from limite_arranchamento where diasemana='dom' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de sexta<br>";
					if($i>=0 AND $i<=1){
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
						}
					if($i==2 and hora()>$row->horalimite){//Analise da domingo na sexta-feira						
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
					}
				}				
				
				//Bloqueio por horário Segunda
				if($semana=="Segunda-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='seg' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de sexta<br>";
					if($i>=0 AND $i<=2){
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
						}
					//função "hora()" está no arquivo "func.php"
					if($i==3 and hora()>$row->horalimite){//Analise da segunda-feira na sexta-feira						
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
					}
				}
				//Bloqueio por horário Terça
				if($semana=="Terça-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='ter' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de segunda<br>";

					if($i==1 and hora()>$row->horalimite){//Analise da quarta-feira um dia antes - "$i==1" quer dizer que ele é o segundo dia a aparecer na tela
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
					}
				}				
				//Bloqueio por horário Quarta
				if($semana=="Quarta-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='qua' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de terça<br>";

					if($i==1 and hora()>$row->horalimite){//Analise da quarta-feira um dia antes - "$i==1" quer dizer que ele é o segundo dia a aparecer na tela
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
					}
				}
				//Bloqueio por horário Quinta
				if($semana=="Quinta-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='qui' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de quarta<br>";

					if($i==1 and hora()>$row->horalimite){//Analise da quinta-feira um dia antes				
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
					}
				}
				//Bloqueio por horário Sexta, também verifica se é necessário colocar a função em onclick
                $onclick_msg_alm_sex = "";
				if($semana=="Sexta-feira"){
					$arranch  = "select * from limite_arranchamento where diasemana='sex' ";
					$result = $conexao->query($arranch );
					$row = $result->fetch_object();
					$msg_prazo = "Prazo: Até $row->horalimite de quinta<br>";
                    
                    if($_SESSION['tipo_acesso']!="ALUNO"){
                        $onclick_msg_alm_sex = "onclick=\"div_visivel('almoco_justificativa$i');tamanho_msg('almoco_justificativa$i');reaplica_check('alm$i')\" ";   
                    }

					if($i==1 and hora()>$row->horalimite){//Analise da sexta-feira um dia antes				
						$lock_cafe="$lock";$lock_almoco="$lock";$lock_jantar="$lock";
						$msg_prazo = "Prazo: Encerrado<br>";
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
                    if($row->bloqueiajantar=='S') {$lock_jantar="$lock";$bloq_msg_jantar='Sem Jantar<br>';$checked_jantar='';}   	else {$lock_jantar="";$bloq_msg_jantar='Com Jantar<br>';}
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
              <button type="submit" class="like-btn"></button>
            </div>          
        </form>
    </div>
  </div>   
  
<br>

<!--Função para mostrar ou ocultar uma DIV-->
<script>
    function div_visivel(el) {
        var display = document.getElementById(el).style.display;

            if(display == "none") document.getElementById(el).style.display = 'block';
            else document.getElementById(el).style.display = 'none';
    }
    
    function sem_justificativa(i) {
        document.getElementById('almoco_justificativa'+i).style.display = 'none';
        document.getElementById('alm'+i).checked = false;
        document.getElementById('justificativa_texto'+i).value = "";

    }      
    
    <!--Função para determinar o tamanho da DIV da justificativa de Sexta. Pega o tamanho do container-->
    function tamanho_msg(id_nome){
        var width = window.getComputedStyle(document.getElementById("container"), null).getPropertyValue("width");
        document.getElementById(id_nome).style.width = width;
    }
    
    <!--Função para determinar o tamanho de um elemento-->
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
