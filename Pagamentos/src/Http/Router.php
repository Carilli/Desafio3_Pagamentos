<?php

namespace Implyestudos\Pagamentos\Http;

use Implyestudos\Pagamentos\Controllers\MovimentacaoController;
use Implyestudos\Pagamentos\Controllers\PagamentosController;
use Implyestudos\Pagamentos\Controllers\ProdutosController;
use Implyestudos\Pagamentos\Common\DBConnection;
use Exception;
use PDO;

class Router {
    private MovimentacaoController $movimentacaoController;
    private PagamentosController $pagamentosController;
    private ProdutosController $produtosController;

    public function __construct() {
        $pdo = (new DBConnection())->getConnection();
        $this->movimentacaoController = new MovimentacaoController($pdo);
        $this->pagamentosController = new PagamentosController($pdo);
        $this->produtosController = new ProdutosController($pdo);
    }

    public function route(): void {
        header('Content-Type: application/json; charset=UTF-8');

        $route = isset($_GET['route']) ? trim(filter_var($_GET['route'], FILTER_SANITIZE_URL), '/') : '';
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            if ($method === 'POST') {
                $inputData = json_decode(file_get_contents('php://input'), true) ?? [];

                switch ($route) {
                    case 'AddProduto':
                        $this->produtosController->addProduto();
                        break;
                    case 'pagamentos/registrar':
                        $this->pagamentosController->handleRequest('registrar', $inputData);
                        break;
                    case 'pagamentos/processarPreRegistros':
                        $this->pagamentosController->handleRequest('processarPreRegistros');
                        break;
                    case 'movimentacoes/registrar':
                        $this->movimentacaoController->handleRequest('registrar');
                        break;
                    default:
                        $this->sendResponse(['error' => "Rota POST '$route' não encontrada"], 404);
                }
            } else {
                $this->sendResponse(['error' => "Método $method não permitido"], 405);
            }
        } catch (Exception $e) {
            $this->sendResponse(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
    }

    private function sendResponse(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}


/*
---- http://localhost:8000/?route=/AddProduto ----
{
    "produto": {
        "id_produto_venda": 1,
        "nome": "Notebook",
        "preco": 3500.00,
        "quantidade": 10,
        "movimentacao_id": 123,
        "valor": 3500.00,
        "status_item": "disponivel",
        "data_hora": "2023-10-01 12:00:00",
        "ultima_atualizacao": "2023-10-01 12:00:00"
    }
}

 ---- http://localhost:8000/?route=/pagamentos/registrar ----
{
    "id_produto_venda": 1,
    "forma_pagamento": "cartao_credito",
    "status": "aprovado",
    "data_hora": "2023-10-01 12:00:00",
    "ultima_atualizacao": "2023-10-01 12:00:00"
}
*/