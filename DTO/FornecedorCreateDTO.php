<?php

class FornecedorCreateDTO
{
    public string $nome;
    public string $email;
    public string $telefone;

    public function __construct(string $nome, string $email, string $telefone)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
    }
}
