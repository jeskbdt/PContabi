<?php
namespace app\controllers;

use app\core\Controller;
use app\repositories\ClienteRepository;

class ClienteController extends Controller
{
    private ClienteRepository $repository;

    public function __construct()
    {
        $this->repository = new ClienteRepository();
    }

    public function index()
    {
        $this->autenticacaoRequired();
        $usuarioId = $this->isAdmin() ? null : (int)$this->usuarioLogado()['id'];
        $data['clientes'] = $this->repository->getClientes($usuarioId);
        $data['csrf_token'] = $this->csrfToken();
        $this->view('clientes/cliente_list', $data);
    }

    public function cadastrar()
    {
        $this->autenticacaoRequired();
        $data['csrf_token'] = $this->csrfToken();
        $this->view('clientes/cliente_create', $data);
    }

    public function salvar()
    {
        $this->autenticacaoRequired();
        $this->validarCsrf();
        $usuario = $this->usuarioLogado();
        $data = $this->dadosFormulario();
        $data['usuario_id'] = (int)$usuario['id'];
        $this->repository->saveCliente($data);
        $this->redirect(URL_BASE . '/clientes');
    }

    public function editar()
    {
        $this->autenticacaoRequired();
        $usuarioId = $this->isAdmin() ? null : (int)$this->usuarioLogado()['id'];
        $data['cliente'] = $this->repository->getClienteById((int)($_GET['id'] ?? 0), $usuarioId);
        if (!$data['cliente']) {
            $this->negarAcesso();
        }
        $data['csrf_token'] = $this->csrfToken();
        $this->view('clientes/cliente_edit', $data);
    }

    public function atualizar()
    {
        $this->autenticacaoRequired();
        $this->validarCsrf();
        $usuarioId = $this->isAdmin() ? null : (int)$this->usuarioLogado()['id'];
        $data = $this->dadosFormulario();
        $data['id'] = (int)($_POST['id'] ?? 0);
        if (!$this->repository->getClienteById($data['id'], $usuarioId)) {
            $this->negarAcesso();
        }
        $this->repository->updateCliente($data, $usuarioId);
        $this->redirect(URL_BASE . '/clientes');
    }

    public function excluir()
    {
        $this->autenticacaoRequired();
        $this->validarCsrf();
        $usuarioId = $this->isAdmin() ? null : (int)$this->usuarioLogado()['id'];
        $id = (int)($_POST['id'] ?? 0);
        if (!$this->repository->getClienteById($id, $usuarioId)) {
            $this->negarAcesso();
        }
        $this->repository->deleteCliente($id, $usuarioId);
        $this->redirect(URL_BASE . '/clientes');
    }

    private function dadosFormulario(): array
    {
        return [
            'nome' => trim($_POST['nome'] ?? ''),
            'tipo_pessoa' => $_POST['tipo_pessoa'] ?? 'PJ',
            'cpf_cnpj' => trim($_POST['cpf_cnpj'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'telefone' => trim($_POST['telefone'] ?? ''),
            'endereco' => trim($_POST['endereco'] ?? ''),
            'observacoes' => trim($_POST['observacoes'] ?? '')
        ];
    }
}
