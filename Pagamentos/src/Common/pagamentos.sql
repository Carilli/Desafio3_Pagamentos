CREATE TABLE pagamentos (
    id SERIAL PRIMARY KEY,
    id_pagamento VARCHAR(50) UNIQUE NOT NULL,
    id_movimentacao VARCHAR(50) REFERENCES movimentacoes(id_movimentacao) ON DELETE CASCADE,
    valor NUMERIC(10,2) NOT NULL,
    forma_pagamento VARCHAR(20) NOT NULL,
    status VARCHAR(20) NOT NULL,
    data_hora TIMESTAMP NOT NULL,
    ultima_atualizacao TIMESTAMP NOT NULL
);