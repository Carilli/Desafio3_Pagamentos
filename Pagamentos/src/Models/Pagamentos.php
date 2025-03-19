<?php

namespace Implyestudos\Pagamentos\Models;

class Pagamentos {
    private string $arquivoPreRegistro;

    public function __construct() {
        $this->arquivoPreRegistro = __DIR__ . '/../data/preRegistro.json'; 
    }

    public function salvarPreRegistro(array $dadosPagamento): bool {
        try {
            $preRegistros = $this->lerPreRegistros();
            $preRegistros[] = $dadosPagamento;
            file_put_contents($this->arquivoPreRegistro, json_encode($preRegistros, JSON_PRETTY_PRINT));
            return true;
        } catch (\Exception $e) {
            error_log("Erro ao salvar pré-registro: " . $e->getMessage());
            return false;
        }
    }

    public function lerPreRegistros(): array {
        if (file_exists($this->arquivoPreRegistro)) {
            $conteudo = file_get_contents($this->arquivoPreRegistro);
            return json_decode($conteudo, true) ?? [];
        }
        return [];
    }

    public function validarPagamento(array $pagamento): bool {
        return isset(
            $pagamento['id_pagamento'],
            $pagamento['valor'],
            $pagamento['forma_pagamento'],
            $pagamento['status'],
            $pagamento['data_hora'],
            $pagamento['ultima_atualizacao']
        );
    }
}