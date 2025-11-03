<?php
require_once "./inc/conf.php";
require_once "./inc/funcoes.php";
session_start();

// Somente ADMINISTRADOR
if (!isset($_SESSION['login']) || !isset($_SESSION['tipo_acesso']) || $_SESSION['tipo_acesso'] !== 'ADMINISTRADOR') {
  header('Location: index.html');
  exit;
}

// Inserção de múltiplas linhas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data']) && is_array($_POST['data'])) {
  $datas = $_POST['data'];
  $refeicoes = $_POST['refeicao'] ?? [];
  $descricoes = $_POST['descricao'] ?? [];

  $stmt = $conexao->prepare("INSERT INTO cardapio (data, refeicao, descricao) VALUES (?, ?, ?)");
  if ($stmt) {
    foreach ($datas as $i => $data) {
      $d = trim($data ?? '');
      $r = trim($refeicoes[$i] ?? '');
      $desc = trim($descricoes[$i] ?? '');
      if ($d !== '' && $r !== '' && $desc !== '') {
        $stmt->bind_param('sss', $d, $r, $desc);
        $stmt->execute();
      }
    }
    $stmt->close();
  }
  header('Location: inserir_cardapio.php?ok=1');
  exit;
}

// Exclusão
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  if ($id > 0) {
    $stmt = $conexao->prepare("DELETE FROM cardapio WHERE id = ?");
    if ($stmt) {
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $stmt->close();
    }
  }
  header('Location: inserir_cardapio.php?removed=1');
  exit;
}

// Buscar itens existentes
$sql = "SELECT id, data, refeicao, descricao FROM cardapio ORDER BY data ASC, FIELD(refeicao, 'cafe','almoco','jantar')";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inserir Cardápio</title>
  <link rel="icon" href="./favicon.ico">
  <link rel="stylesheet" href="./material_design/dependencias/bootstrap.min.css">
  <style>
    body { background: #f5f5f5; padding: 24px 12px; font-family: Arial, sans-serif; }
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    .page-title { margin: 0; font-size: 20px; }
    @media (min-width: 576px) { .page-title { font-size: 24px; } }
    .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 16px; }
    .card-body { padding: 12px; }
    @media (min-width: 576px) { .card-body { padding: 20px; } }
    .form-grid { display: grid; grid-template-columns: 1fr; gap: 12px; }
    @media (min-width: 576px) { .form-grid { grid-template-columns: 160px 160px 1fr auto; align-items: end; } }
    .row-item { display: contents; }
    .btn-icon { display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
    .table thead th { background: #2b7cff; color: #fff; border-color: #2b7cff; }
    .table-responsive { border-radius: 10px; overflow: hidden; }
    @media (max-width: 575.98px) {
      .table-stacked thead { display: none; }
      .table-stacked tbody tr { display: block; border: 1px solid #e9ecef; border-radius: 10px; padding: 10px 12px; margin-bottom: 12px; background: #fff; }
      .table-stacked tbody td { display: flex; align-items: center; padding: 8px 0; border: 0; word-break: break-word; white-space: normal; }
      .table-stacked tbody td::before { content: attr(data-label); flex: 0 0 110px; font-weight: 600; color: #6c757d; margin-right: 8px; }
      .table-stacked tbody td.td-desc { display: block; }
      .table-stacked tbody td.td-desc::before { display: block; margin: 0 0 6px 0; }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="page-header">
    <h2 class="page-title">Inserir Cardápio</h2>
    <div>
      <a href="./cardapio.php" class="btn btn-outline-secondary btn-sm">Ver Cardápio</a>
      <a href="./administrador.php" class="btn btn-outline-primary btn-sm">Admin</a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form method="post" id="formCardapio">
        <div id="rows" class="form-grid">
          <div class="row-item">
            <div>
              <label class="form-label">Data</label>
              <input type="date" name="data[]" class="form-control" required>
            </div>
            <div>
              <label class="form-label">Refeição</label>
              <select name="refeicao[]" class="form-control" required>
                <option value="cafe">Café</option>
                <option value="almoco">Almoço</option>
                <option value="jantar">Jantar</option>
              </select>
            </div>
            <div>
              <label class="form-label">Descrição</label>
              <textarea name="descricao[]" class="form-control" rows="2" placeholder="Ex.: Arroz, feijão, frango grelhado e salada" required></textarea>
            </div>
            <div>
              <button type="button" class="btn btn-outline-danger btn-icon" onclick="removerLinha(this)">Remover</button>
            </div>
          </div>
        </div>

        <div style="margin-top:12px; display:flex; gap:8px; flex-wrap:wrap;">
          <button type="button" class="btn btn-outline-secondary btn-icon" onclick="adicionarLinha()">Adicionar linha</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 style="margin:0 0 12px 0;">Itens já cadastrados</h5>
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 table-stacked">
          <thead>
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Refeição</th>
              <th>Descrição</th>
              <th style="width: 80px;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0) { ?>
              <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                  <td data-label="ID"><?php echo (int)$row['id']; ?></td>
                  <td data-label="Data"><?php echo date('d/m/Y', strtotime($row['data'])); ?></td>
                  <td data-label="Refeição"><?php echo ucfirst($row['refeicao']); ?></td>
                  <td data-label="Descrição" class="td-desc"><?php echo nl2br(htmlspecialchars($row['descricao'])); ?></td>
                  <td data-label="Ações">
                    <a class="btn btn-outline-danger btn-sm" href="?delete=<?php echo (int)$row['id']; ?>" onclick="return confirm('Excluir este item?');">Excluir</a>
                  </td>
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="5" class="text-center" style="padding: 20px;">Nenhum item cadastrado.</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
  function adicionarLinha() {
    var rows = document.getElementById('rows');
    var div = document.createElement('div');
    div.className = 'row-item';
    div.innerHTML = `
      <div>
        <label class="form-label">Data</label>
        <input type="date" name="data[]" class="form-control" required>
      </div>
      <div>
        <label class="form-label">Refeição</label>
        <select name="refeicao[]" class="form-control" required>
          <option value="cafe">Café</option>
          <option value="almoco">Almoço</option>
          <option value="jantar">Jantar</option>
        </select>
      </div>
      <div>
        <label class="form-label">Descrição</label>
        <textarea name="descricao[]" class="form-control" rows="2" placeholder="Ex.: Arroz, feijão, frango grelhado e salada" required></textarea>
      </div>
      <div>
        <button type="button" class="btn btn-outline-danger btn-icon" onclick="removerLinha(this)">Remover</button>
      </div>
    `;
    rows.appendChild(div);
  }
  function removerLinha(btn) {
    var item = btn.closest('.row-item');
    if (!item) return;
    var rows = document.getElementById('rows');
    // sempre deixa pelo menos 1 linha
    if (rows.querySelectorAll('.row-item').length > 1) {
      item.remove();
    } else {
      item.querySelectorAll('input,select,textarea').forEach(function(el){ el.value=''; });
    }
  }
</script>

</body>
</html>


