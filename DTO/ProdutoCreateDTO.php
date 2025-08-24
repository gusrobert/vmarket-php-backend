<?php

class ProdutoCreateDTO {
    public string $nome;
    public ?string $descricao;
    public int $quantidade;
    public float $preco;
    public array $fornecedores_id;

    public function __construct(string $nome, ?string $descricao, int $quantidade, float $preco, array $fornecedores_id) {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
        $this->fornecedores_id = $fornecedores_id;
    }
}
