CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    id_produto VARCHAR(50) UNIQUE NOT NULL,
    id_movimentacao VARCHAR(50) REFERENCES movimentacoes(id_movimentacao) ON DELETE CASCADE,
    valor NUMERIC(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL,
    data_hora TIMESTAMP NOT NULL,
    ultima_atualizacao TIMESTAMP NOT NULL
);