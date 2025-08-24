<?php

class Produto
{
	private $conn;

	function __construct($db)
	{
		$this->conn = $db;
	}

	public function listar(): array
	{
		$query = "SELECT p.*, GROUP_CONCAT(f.nome SEPARATOR ', ') AS fornecedores_nomes
				FROM produtos p
				JOIN produtos_fornecedores pf ON pf.produto_id = p.id
				JOIN fornecedores f ON pf.fornecedor_id = f.id
				GROUP BY p.id
				ORDER BY p.id ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function buscarPorId(int $id): ?array
	{
		$query = "SELECT p.*, GROUP_CONCAT(f.id SEPARATOR ', ') AS fornecedores_id
				  FROM produtos p
				  JOIN produtos_fornecedores pf ON pf.produto_id = p.id
				  JOIN fornecedores f ON pf.fornecedor_id = f.id
				  WHERE p.id = :id
				  GROUP BY p.id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			$row['fornecedores_id'] = isset($row['fornecedores_id']) && $row['fornecedores_id'] !== null
				? explode(',', $row['fornecedores_id'])
				: [];
        	return $row;
		}
		return null;
    }

	public function cadastrar(
		string $nome, 
		?string $descricao,
		int $quantidade,
		float $preco
	): ?int {
		$query = "INSERT INTO produtos (nome, descricao, quantidade, preco) 
				  VALUES (:nome, :descricao, :quantidade, :preco)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':descricao', $descricao);
		$stmt->bindParam(':quantidade', $quantidade);
		$stmt->bindParam(':preco', $preco);

		if ($stmt->execute()) {
			return $this->conn->lastInsertId();
		}
		return null;
	}

	public function atualizar(
		int $id,
		string $nome,
		?string $descricao,
		float $preco
	): bool {
		$query = "
			UPDATE produtos 
			SET nome = :nome, 
				descricao = :descricao, 
				preco = :preco
			WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':descricao', $descricao);
		$stmt->bindParam(':preco', $preco);
		return $stmt->execute();
	}

	public function deletar(int $id): bool {
		$query = "DELETE FROM produtos WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);
		return $stmt->execute();
	}

	public function buscarPorNomeOuFornecedor(string $nome, int $fornecedor_id): array
	{
		$query = "SELECT p.*, GROUP_CONCAT(DISTINCT f2.nome SEPARATOR ', ') AS fornecedores_nomes
			FROM produtos p
			JOIN produtos_fornecedores pf1 ON pf1.produto_id = p.id
			JOIN fornecedores f1 ON pf1.fornecedor_id = f1.id
			JOIN produtos_fornecedores pf2 ON pf2.produto_id = p.id
			JOIN fornecedores f2 ON pf2.fornecedor_id = f2.id
			WHERE 1=1";
		if (!empty($nome)) {
			$query .= " AND p.nome LIKE :nome";
		}
		if ($fornecedor_id > 0) {
			$query .= " AND f1.id = :fornecedor_id";
		}
		$query .= " GROUP BY p.id
				ORDER BY p.id ASC";

		$stmt = $this->conn->prepare($query);
		if (!empty($nome)) {
			$likeNome = '%' . $nome . '%';
			$stmt->bindParam(':nome', $likeNome);
		}
		if ($fornecedor_id > 0) {
			$stmt->bindParam(':fornecedor_id', $fornecedor_id);
		}
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

