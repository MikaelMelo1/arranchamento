<?php
require_once "./inc/conf.php"; 
require_once "./inc/funcoes.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.html");
    exit;
}

$sql = "SELECT * FROM cardapio ORDER BY data ASC, FIELD(refeicao, 'cafe', 'almoco', 'jantar')";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cardápio</title>
  <link rel="icon" href="./favicon.ico">
  <link rel="stylesheet" href="./material_design/dependencias/bootstrap.min.css">
  <style>
    body { background: #f5f5f5; padding: 24px 12px; font-family: Arial, sans-serif; }
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    .page-title { margin: 0; font-size: 20px; }
    @media (min-width: 576px) { .page-title { font-size: 24px; } }
    .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .card-body { padding: 12px; }
    @media (min-width: 576px) { .card-body { padding: 20px; } }
    .table thead th { background: #2b7cff; color: #fff; border-color: #2b7cff; }
    .table tbody td { vertical-align: middle; }
    .table-responsive { border-radius: 10px; overflow: hidden; }
    /* Mobile stacked table */
    @media (max-width: 575.98px) {
      .table-stacked thead { display: none; }
      .table-stacked tbody tr { display: block; border: 1px solid #e9ecef; border-radius: 10px; padding: 10px 12px; margin-bottom: 12px; background: #fff; }
      .table-stacked tbody td { display: flex; align-items: center; padding: 8px 0; border: 0; word-break: break-word; white-space: normal; }
      .table-stacked tbody td::before { content: attr(data-label); flex: 0 0 110px; font-weight: 600; color: #6c757d; margin-right: 8px; }
      .table-stacked tbody td.td-desc { display: block; }
      .table-stacked tbody td.td-desc::before { display: block; margin: 0 0 6px 0; }
    }
    .badge-date { display: inline-block; background: #eef4ff; color: #2b7cff; border: 1px solid #d6e4ff; padding: 6px 10px; border-radius: 999px; font-weight: 600; }
  </style>
</head>
<body>

<div class="container">
  <div class="page-header">
    <h2 class="page-title">Cardápio da Semana</h2>
    <a href="./arranchamento_form.php" class="btn btn-outline-secondary btn-sm">← Voltar</a>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive" aria-live="polite">
        <table class="table table-striped table-hover mb-0 table-stacked">
          <thead>
            <tr>
              <th>Data</th>
              <th>Refeição</th>
              <th>Descrição</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0) { ?>
              <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                  <td data-label="Data"><span class="badge-date"><?php echo date('d/m/Y', strtotime($row['data'])); ?></span></td>
                  <td data-label="Refeição"><?php echo ucfirst($row['refeicao']); ?></td>
                  <td data-label="Descrição" class="td-desc"><?php echo nl2br(htmlspecialchars($row['descricao'])); ?></td>
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="3" class="text-center" style="padding: 20px;">Nenhum item de cardápio encontrado.</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>
