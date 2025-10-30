<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
// Este arquivo já cria a conexão $conexao segura
require_once "../inc/conf.php"; 
?>
<title>Sistema de Arranchamento / 13º GAC</title>
<link rel="stylesheet" type="text/css" href="./stylesrelatorio.css">

<?php
//$turma = $_GET["turma"];
$data = $_POST["calendario_data"];
$select_filtro = $_POST["optionsRadios"];//Post vindo do arquivo index.php, com configurações de select
//echo $select_filtro;
    

?>
</head>

<body>

<button onclick="history.back();"></button>

<a class="titulo"><img src="../img/13gac.gif" width="50px"><br><strong><?php echo "13º Grupo de Artilharia de Campanha"; ?></strong></a><br>
<a>Relatório de Arranchamento</a>
<br>

<?php
if($select_filtro=='arranchamento.hierarquia<=6') $titulo = "Oficiais";
if($select_filtro=="arranchamento.hierarquia>=8 and arranchamento.hierarquia<=11 and militares.tipo_acesso<>'ALUNO'") $titulo = "Sub Ten e Sgt";
if($select_filtro=="arranchamento.hierarquia>=12 and arranchamento.hierarquia<=13 and militares.tipo_acesso<>'ALUNO'") $titulo = "Cabos e Soldados";
if($select_filtro=="militares.turma='OUTRAS' and militares.tipo_acesso='ALUNO'") $titulo = "Outras";
?>

<h3><?php echo $titulo;?></h3>
<h1>Dia: <?php echo $data;?></h1>

<?php

$data_sql = date('Y-m-d', strtotime($data));//converte Data para o formato do banco de dados

//Calcula número de arranchados para o café
$arranch0 = "select * from arranchamento, militares where $select_filtro and data='$data_sql' and cafe='S' and arranchamento.cpf=militares.cpf ";
$result0 = $conexao->query($arranch0);
$totalcaf = $result0->num_rows;

?>

<?php
//Calcula nmero de arranchados para o almoço
$arranch0 = "select * from arranchamento, militares where $select_filtro and data='$data_sql' and almoco='S' and arranchamento.cpf=militares.cpf ";
$result0 = $conexao->query($arranch0);
$totalaml = $result0->num_rows;
?>

<?php
//Calcula nmero de arranchados para o jantar
$arranch0 = "select * from arranchamento, militares where $select_filtro and data='$data_sql' and jantar='S' and arranchamento.cpf=militares.cpf ";
$result0 = $conexao->query($arranch0);
$totaljan = $result0->num_rows;
?>


<a class="titulo" style="font-size:28px"></a><br>
<table style="width:100%;color:black;border: 1px solid black;font-size:14px;padding:4px">
  <tr>
    <th width="16%">Café: <?php echo $totalcaf ?> </th>
    <th width="16%">Almoço: <?php echo $totalaml ?> </th>
    <th width="16%">Jantar: <?php echo $totaljan ?> </th>
  </tr>
  <tr>
  
    <td style="border: 1px solid black;text-align:left;vertical-align:top;padding:10px">
    <?php
  $arranch0 = "select * from arranchamento, militares where $select_filtro and data='$data_sql' and cafe='S' and arranchamento.cpf=militares.cpf ORDER BY arranchamento.hierarquia, militares.nomeguerra ASC";
  $query = $conexao->query($arranch0);
  while ($dados = $query->fetch_object()) {
      echo '<div class=\'datapeq\'>'.'<img src=\'../img/box_select.png\' width=\'16px\'> '.' '.$dados->posto.' '.$dados->nomeguerra.'</div>'.'<br>';
  }
    ?>
    </td>
    
    <td style="border: 1px solid black;text-align:left;vertical-align:top;padding:10px">
    <?php
  $arranch0 = "select * from arranchamento, militares where $select_filtro and data='$data_sql' and almoco='S' and arranchamento.cpf=militares.cpf ORDER BY arranchamento.hierarquia, militares.nomeguerra ASC";
  $query = $conexao->query($arranch0);
        while ($dados = $query->fetch_object()) {
      echo '<div class=\'datapeq\'>'.'<img src=\'../img/box_select.png\' width=\'16px\'> '.' '.$dados->posto.' '.$dados->nomeguerra.'</div>'.'<br>';
  }
    ?>
    
    </td>
    
    <td style="border: 1px solid black;text-align:left;vertical-align:top;padding:10px">
    <?php
  $arranch0 = "select * from arranchamento, militares where $select_filtro and data='$data_sql' and jantar='S' and arranchamento.cpf=militares.cpf ORDER BY arranchamento.hierarquia, militares.nomeguerra ASC";
  $query = $conexao->query($arranch0);
  while ($dados = $query->fetch_object()) {
      echo '<div class=\'datapeq\'>'.'<img src=\'../img/box_select.png\' width=\'16px\'> '.' '.$dados->posto.' '.$dados->nomeguerra.'</div>'.'<br>';
  }
    ?>
    
    </td>
    
  </tr>
</table>

</body>
</html>