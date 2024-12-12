<?php

namespace App\Domains\Client\Dtos;

class ClientDto
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
     * Create a ClientDto instance from an array.
     *
     * @param array $data Input data array containing 'corporate_name', 'cnpj', and 'email'.
     * @return self A new instance of ClientDto.
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
