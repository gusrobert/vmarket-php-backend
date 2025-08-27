<?php

class ProdutosFornecedores
{
    private $conn;

    function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrarProdutoFornecedor(int $produto_id, int $fornecedor_id): bool {
        $queryFornecedoresProduto = "INSERT INTO produtos_fornecedores (produto_id, fornecedor_id) VALUES (:produto_id, :fornecedor_id)";
        $stmtFornecedoresProduto = $this->conn->prepare($queryFornecedoresProduto);
        $stmtFornecedoresProduto->bindParam(':produto_id', $produto_id);
        $stmtFornecedoresProduto->bindParam(':fornecedor_id', $fornecedor_id);
        return $stmtFornecedoresProduto->execute();
    }

    public function deletarPorProdutoId(int $produto_id): bool {
        $query = "DELETE FROM produtos_fornecedores WHERE produto_id = :produto_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':produto_id', $produto_id);
        return $stmt->execute();
    }
}
