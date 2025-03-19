<?php

namespace Implyestudos\Pagamentos\Models;

use PDO;
use PDOException;

class Movimentacao {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function salvarMovimentacao(array $movimentacao): bool {
       
    }
}