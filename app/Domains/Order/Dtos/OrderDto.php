<?php

namespace App\Domains\Order\Dtos;

class OrderDto
{
    public string $corporate_name;
    public string $cnpj;
    public string $email;

    /**
     * Construtor do DTO.
     */
    public function __construct(string $corporate_name, string $cnpj, string $email)
    {
        $this->corporate_name = $corporate_name;
        $this->cnpj = $cnpj;
        $this->email = $email;
    }

    /**
     * Cria uma instância do DTO a partir de um array (exemplo: dados da requisição).
     */
    public static function fromArray(array $data): self
    {
        return new self(
            corporate_name: $data['corporate_name'] ?? '',
            cnpj: $data['cnpj'] ?? '',
            email: $data['email'] ?? ''
        );
    }
}
