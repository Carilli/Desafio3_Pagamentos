CREATE TABLE movimentacoes (
    id SERIAL PRIMARY KEY,
    id_movimentacao VARCHAR(50) UNIQUE NOT NULL,
    usuario_id INT NOT NULL,
    equipamento_id INT NOT NULL,
    data_hora TIMESTAMP NOT NULL,
    ultima_atualizacao TIMESTAMP NOT NULL
);