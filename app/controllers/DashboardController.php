<?php
namespace app\controllers;

use app\core\Controller;
use app\repositories\DashboardRepository;

class DashboardController extends Controller
{
    public function index()
    {
        $this->autenticacaoRequired();
        $usuario = $this->usuarioLogado();
        $isAdmin = $this->isAdmin();
        $usuarioId = $isAdmin ? null : (int)$usuario['id'];

        $dashboardRepo = new DashboardRepository();

        $this->view('dashboard', [
            'usuario' => $usuario,
            'isAdmin' => $isAdmin,
            'metricas' => $dashboardRepo->getMetricas($usuarioId),
            'processosPorMes' => $dashboardRepo->getProcessosPorMes($usuarioId),
            'statusProcessos' => $dashboardRepo->getStatusProcessos($usuarioId),
            'processosRecentes' => $dashboardRepo->getProcessosRecentes($usuarioId)
        ]);
    }
}
