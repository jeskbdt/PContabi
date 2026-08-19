<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" sizes="192x192" href="<?= URL_BASE ?>/assets/images/icon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= URL_BASE ?>/assets/images/icon-512.png">
    <link rel="shortcut icon" href="<?= URL_BASE ?>/favicon.ico">
    <link rel="apple-touch-icon" href="<?= URL_BASE ?>/assets/images/apple-touch-icon.png">
<title>Dashboard • Contabi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL_BASE_CSS ?>/style.css">
</head>
<body>
<?php require_once __DIR__ . '/partials/sidebar.php'; ?>
<div class="main-content">
    <div class="topbar">
        <div>
            <span class="page-title">Dashboard</span>
            <div class="text-muted small">Visão geral da carteira de propriedade industrial</div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted">Olá, <?= htmlspecialchars($usuario['nome']) ?></span>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-4"><div class="card metric-card"><div class="metric-icon bg-primary-subtle text-primary"><i class="bi bi-people"></i></div><div><div class="metric-value"><?= $metricas['clientes'] ?></div><div class="text-muted">Clientes</div></div></div></div>
        <div class="col-md-6 col-xl-4"><div class="card metric-card"><div class="metric-icon bg-success-subtle text-success"><i class="bi bi-award"></i></div><div><div class="metric-value"><?= $metricas['marcas'] ?></div><div class="text-muted">Marcas</div></div></div></div>
        <div class="col-md-6 col-xl-4"><div class="card metric-card"><div class="metric-icon bg-info-subtle text-info"><i class="bi bi-lightbulb"></i></div><div><div class="metric-value"><?= $metricas['patentes'] ?></div><div class="text-muted">Patentes</div></div></div></div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-7"><div class="card h-100"><div class="card-header bg-white"><strong>Processos cadastrados por mês</strong></div><div class="card-body"><canvas id="processosMes" height="110"></canvas></div></div></div>
        <div class="col-xl-5"><div class="card h-100"><div class="card-header bg-white"><strong>Distribuição por status</strong></div><div class="card-body"><canvas id="statusProcessos" height="170"></canvas></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-xl-12">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center"><strong>Processos recentes</strong><span class="badge text-bg-light"><?= $metricas['processos'] ?> processos</span></div>
                <div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>Tipo</th><th>Processo</th><th>Titular</th><th>Cliente</th><th>Status</th></tr></thead><tbody>
                <?php if (!$processosRecentes): ?><tr><td colspan="5" class="text-center text-muted py-4">Nenhum processo cadastrado.</td></tr><?php endif; ?>
                <?php foreach ($processosRecentes as $processo): ?><tr><td><span class="badge text-bg-light"><?= htmlspecialchars($processo['tipo']) ?></span></td><td><?= htmlspecialchars($processo['numero_processo']) ?></td><td><?= htmlspecialchars($processo['titulo']) ?></td><td><?= htmlspecialchars($processo['cliente']) ?></td><td><span class="badge bg-secondary"><?= htmlspecialchars($processo['status']) ?></span></td></tr><?php endforeach; ?>
                </tbody></table></div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
const meses = <?= json_encode(array_column($processosPorMes, 'mes'), JSON_UNESCAPED_UNICODE) ?>;
const totaisMes = <?= json_encode(array_map('intval', array_column($processosPorMes, 'total'))) ?>;
const statusLabels = <?= json_encode(array_column($statusProcessos, 'status'), JSON_UNESCAPED_UNICODE) ?>;
const statusTotais = <?= json_encode(array_map('intval', array_column($statusProcessos, 'total'))) ?>;
new Chart(document.getElementById('processosMes'), {type:'bar',data:{labels:meses.map(m=>{const [a,b]=m.split('-');return b+'/'+a}),datasets:[{label:'Processos',data:totaisMes,borderRadius:8}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});
new Chart(document.getElementById('statusProcessos'), {type:'doughnut',data:{labels:statusLabels,datasets:[{data:statusTotais}]},options:{responsive:true,plugins:{legend:{position:'bottom'}}}});
</script>
</body>
</html>
