<?php

namespace Implyestudos\Pagamentos\Models;

use PDO;
use PDOException;

class Produtos {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function validarProduto(array $produto): bool {
        $camposObrigatorios = ['id_produto_venda', 'nome', 'preco', 'quantidade'];

        foreach ($camposObrigatorios as $campo) {
            if (!isset($produto[$campo])) {
                return false;
            }
        }

        return true;
    }

    public function salvarProduto(array $produto): bool {
    
        $parametros = [
            ':id_produto_venda' => $produto['id_produto_venda'],
            ':movimentacao_id' => $produto['movimentacao_id'],
            ':valor' => $produto['valor'],
            ':status_item' => $produto['status_item'],
            ':data_hora' => $produto['data_hora'],
            ':ultima_atualizacao' => $produto['ultima_atualizacao']
        ];
    
        try {
            $stmt = $this->pdo->prepare("INSERT INTO produtos_venda (id_produto_venda, movimentacao_id, valor, status_item, data_hora, ultima_atualizacao) VALUES (:id_produto_venda, :movimentacao_id, :valor, :status_item, :data_hora, :ultima_atualizacao)");
            $stmt->execute($parametros);
            return true;
        } catch (PDOException $e) {
            error_log("Erro ao salvar produto: " . $e->getMessage());
            return false;
        }
    }
    
    public function buscarProdutoPorId(int $id_produto_venda): ?array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM produtos_venda WHERE id_produto_venda = :id_produto_venda
            ");
            $stmt->execute(['id_produto_venda' => $id_produto_venda]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar produto: " . $e->getMessage());
            return null;
        }
    }
}