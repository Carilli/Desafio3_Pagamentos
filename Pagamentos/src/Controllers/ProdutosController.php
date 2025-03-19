<?php

namespace Implyestudos\Pagamentos\Controllers;

use Implyestudos\Pagamentos\Models\Produtos;

class ProdutosController {
    private Produtos $produtosModel;
    private string $arquivoPreRegistro;

    public function __construct() {
        $this->arquivoPreRegistro = __DIR__ . '/../../data/preRegistro.json';
        $this->produtosModel = new Produtos();
    }


    private function salvarPreRegistro(array $produto): bool {
        try {
            $preRegistros = $this->lerPreRegistros();
            $preRegistros[] = $produto;
            file_put_contents($this->arquivoPreRegistro, json_encode($preRegistros, JSON_PRETTY_PRINT));
            return true;
        } catch (\Exception $e) {
            error_log("Erro ao salvar pré-registro: " . $e->getMessage());
            return false;
        }
    }

    
    private function lerPreRegistros(): array {
        if (file_exists($this->arquivoPreRegistro)) {
            $conteudo = file_get_contents($this->arquivoPreRegistro);
            return json_decode($conteudo, true) ?? [];
        }
        return [];
    }

    public function addProduto(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['produto']) || !is_array($data['produto'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Formato inválido. A chave "produto" deve ser um array.']);
            return;
        }

        $produto = $data['produto'];

        
        if (!$this->produtosModel->validarProduto($produto)) {
            http_response_code(400);
            echo json_encode(['error' => 'Produto inválido. Campos obrigatórios ausentes ou inválidos.']);
            return;
        }

        if ($this->salvarPreRegistro($produto)) {
            echo json_encode(['status' => 'success', 'message' => 'Produto salvo no pré-registro!']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao salvar produto no pré-registro.']);
        }
    }

}