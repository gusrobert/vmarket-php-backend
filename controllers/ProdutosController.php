<?php

require_once __DIR__ . '/../dto/ProdutoCreateDTO.php';
require_once __DIR__ . '/../dto/ProdutoUpdateDTO.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/ProdutosFornecedores.php';

class ProdutosController 
{
	private Produto $produto;

    public function __construct() 
    {
		global $conn;
        $this->produto = new Produto($conn);
    }

    public function listarProdutos() 
    {
        return $this->produto->listar();
    }

    public function buscarProdutoPorNomeOuFornecedor(?string $nome, ?int $fornecedor_id): array
    {
        return $this->produto->buscarPorNomeOuFornecedor($nome, $fornecedor_id);
    }

    public function cadastrarProduto(ProdutoCreateDTO $data): bool 
    {
        $idProduto = $this->produto->cadastrar(
            $data->nome,
            $data->descricao,
            $data->quantidade,
            $data->preco
        );

        if ($idProduto) {
            $produtosFornecedores = new ProdutosFornecedores($GLOBALS['conn']);
            foreach ($data->fornecedores_id as $fornecedor_id) {
                $produtosFornecedores->cadastrarProdutoFornecedor($idProduto, $fornecedor_id);
            }
            return true;
        }
        return false;
    }

    public function deletarProduto(int $id): bool
    {
        return $this->produto->deletar($id);
    }

    public function atualizarProduto(ProdutoUpdateDTO $data): bool 
    {
        $produtosFornecedores = new ProdutosFornecedores($GLOBALS['conn']);
        $produtosFornecedores->deletarPorProdutoId($data->id);

        foreach ($data->fornecedores_id as $fornecedor_id) {
            $produtosFornecedores->cadastrarProdutoFornecedor($data->id, $fornecedor_id);
        }

        return $this->produto->atualizar(
            $data->id,
            $data->nome,
            $data->descricao,
            $data->quantidade,
            $data->preco
        );
    }

    public function buscarProdutoPorId(int $id): ?array 
    {
        return $this->produto->buscarPorId($id);
    }
}
