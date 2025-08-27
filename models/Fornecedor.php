<?php

class Fornecedor
{
    private $conn;

    function __construct($db)
    {
        $this->conn = $db;
    }

    public function listar(): array
    {
        $query = "SELECT * FROM fornecedores ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): ?array
    {
        $query = "SELECT * FROM fornecedores WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar(string $nome, string $email, string $telefone) {
        $resultNome = $this->buscarPorNome($nome);

        if ($resultNome) {
            return false; // Nome já cadastrado
        }

        $resultEmail = $this->buscarPorEmail($email);

        if ($resultEmail) {
            return false; // Email já cadastrado
        }

        $sql = "INSERT INTO fornecedores (nome, email, telefone) 
                VALUES (:nome, :email, :telefone)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        return $stmt->execute();
    }

    public function atualizar(int $id, string $nome, string $email, string $telefone) {
        $sql = "UPDATE fornecedores 
                   SET nome = :nome, email = :email, telefone = :telefone 
                 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        return $stmt->execute();
    }

    public function deletar(int $id): bool {
        $query = "DELETE FROM fornecedores WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarPorNome(string $nome): array
    {
        $query = "SELECT * FROM fornecedores WHERE nome LIKE :nome";
        $stmt = $this->conn->prepare($query);
        $likeNome = '%' . $nome . '%';
        $stmt->bindParam(':nome', $likeNome);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function buscarPorEmail(string $email): ?array
    {
        $query = "SELECT * FROM fornecedores WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}

