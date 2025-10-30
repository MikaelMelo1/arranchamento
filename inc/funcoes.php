<?php
function bomdia(){
	date_default_timezone_set('America/Sao_Paulo');
    $date = date('H:i:s');
    
	if($date>="00:00:00" and $date<"11:59:59"){return "Bom dia";}
	if($date>="12:00:00" and $date<"17:59:59"){return "Boa tarde";}
	else return "Boa noite";	
}

function hora(){
	$timestamp = mktime(date("H")-3, date("i"), date("s"), date("m"), date("d"), date("Y"));
	return gmdate("H:i:s", $timestamp);
}
function icone_adm($url,$caminho_ico,$texto){
    print("
    <div style=\"float: left;width:102px;height:150px;margin-left:0px;margin-right:0px;margin-bottom:0px;\"><center>
    <a href=\"$url\"><img width=\"72px\" src=\"$caminho_ico\"><br>
    <div style=\"margin-top:10px;color:white;\">$texto</div></a>
    </center></div>
    ");
}

?>