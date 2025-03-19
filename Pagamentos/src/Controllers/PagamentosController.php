<?php

namespace Implyestudos\Pagamentos\Controllers;

use Implyestudos\Pagamentos\Models\Pagamentos;
use Implyestudos\Pagamentos\Models\Movimentacao;
use Implyestudos\Pagamentos\Models\Produtos;
use PDO;

class PagamentosController {
    private Pagamentos $pagamentosModel;
    private Movimentacao $movimentacaoModel;
    private Produtos $produtosModel;

    private function __construct(PDO $pdo) {
        $this->pagamentosModel = new Pagamentos();
        $this->movimentacaoModel = new Movimentacao($pdo);
        $this->produtosModel = new Produtos(__DIR__ . '/../data/preRegistro.json');
    }

    private function registrarPagamento(array $dados): array {
        if (!isset($dados['id_produto_venda'])) {
            return ["status" => "error", "message" => "ID do produto não fornecido."];
        }

        $produto = $this->produtosModel->buscarProdutoPorId($dados['id_produto_venda']);
        if (!$produto) {
            return ["status" => "error", "message" => "Produto não encontrado."];
        }

        $dados['id_pagamento'] = $produto['id_produto_venda'];
        $dados['valor'] = $produto['valor'];

        if (!$this->pagamentosModel->validarPagamento($dados)) {
            return ["status" => "error", "message" => "Dados do pagamento inválidos."];
        }

        if ($this->pagamentosModel->salvarPreRegistro($dados)) {
            return ["status" => "success", "message" => "Pagamento salvo no pré-registro!"];
        }

        return ["status" => "error", "message" => "Erro ao salvar pagamento."];
    }

    private function processarPreRegistros(): array {
        $preRegistros = $this->pagamentosModel->lerPreRegistros();

        if (empty($preRegistros)) {
            return ["status" => "error", "message" => "Nenhum pré-registro encontrado."];
        }

        $resultados = [];
        foreach ($preRegistros as $pagamento) {
            if ($pagamento['status'] === 'pago' || $pagamento['status'] === 'aprovado') {
                $movimentacao = [
                    'id_movimentacao' => uniqid(),
                    'id_usuario' => 1,
                    'id_equipamento' => 1,
                    'data_hora' => date('Y-m-d H:i:s'),
                    'ultima_atualizacao' => date('Y-m-d H:i:s'),
                    'pagamentos' => [$pagamento],
                    'produtos' => []
                ];

                $resultado = $this->movimentacaoModel->salvarMovimentacao($movimentacao);
                $resultados[] = $resultado;
            }
        }

        return [
            "status" => "success",
            "message" => "Pré-registros processados.",
            "resultados" => $resultados
        ];
    }

    public function handleRequest(string $action, array $data = []): void {
        $response = match ($action) {
            'registrar' => $this->registrarPagamento($data),
            'processarPreRegistros' => $this->processarPreRegistros(),
            default => ["status" => "error", "message" => "Ação não encontrada"]
        };

        echo json_encode($response);
    }
}