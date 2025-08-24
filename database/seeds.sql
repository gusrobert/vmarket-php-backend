
-- Seeds para tabela fornecedores
INSERT INTO fornecedores (nome, email, telefone) VALUES
('Fazenda Boa Esperança', 'fazendaboaesperanca@email.com', '11999990001'),
('Fazenda São João', 'fazendasaojoao@email.com', '11999990002'),
('Fazenda Central', 'fazendacentral@email.com', '11999990003');

-- Seeds para tabela produtos
INSERT INTO produtos (nome, descricao, quantidade, preco) VALUES
('Abacaxi', 'Descrição do produto 1', 10, 10.50),
('Banana', 'Descrição do produto 2', 20, 20.00),
('Laranja', 'Descrição do produto 3', 30, 30.99),
('Manga', 'Outro produto do fornecedor 1', 15, 15.00);

-- Seeds para tabela produtos_fornecedores
INSERT INTO produtos_fornecedores (produto_id, fornecedor_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1);
