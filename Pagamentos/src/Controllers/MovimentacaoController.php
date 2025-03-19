<?php

namespace Implyestudos\Pagamentos\Controllers;

use Implyestudos\Pagamentos\Models\Movimentacao;
use PDO;

class MovimentacaoController {
    private Movimentacao $movimentacaoModel;

    public function __construct(PDO $pdo) {
        $this->movimentacaoModel = new Movimentacao($pdo);
    }

    public function registrarMovimentacoes(): void {
        $data = json_decode(file_get_contents('php://input'), true);

        
    }

    public function handleRequest(string $action): void {
        switch ($action) {
            case 'registrar':
                $this->registrarMovimentacoes();
                break;
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Ação inválida.']);
        }
    }
}