<?php

require_once __DIR__ . '/../models/Fornecedor.php';

class FornecedoresController {
	private Fornecedor $fornecedor;

    public function __construct($conn) {
        $this->fornecedor = new Fornecedor($conn);
    }

    public function listarFornecedores() {
        return $this->fornecedor->listar();
    }

    public function cadastrarFornecedor(FornecedorCreateDTO $dto): bool
    {
        return $this->fornecedor->cadastrar(
            $dto->nome,
            $dto->email,
            $dto->telefone
        );
    }

    public function deletarFornecedor(int $id): bool
    {
        return $this->fornecedor->deletar($id);
    }

    public function buscarPorNome(string $nome): array
    {
        return $this->fornecedor->buscarPorNome($nome);
    }

    public function buscarPorId(int $id): ?array
    {
        return $this->fornecedor->buscarPorId($id);
    }

    public function atualizarFornecedor(int $id, string $nome, string $email, string $telefone): bool
    {
        return $this->fornecedor->atualizar($id, $nome, $email, $telefone);
    }
}
