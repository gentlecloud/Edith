<?php
namespace Gentle\Edith\Contracts;

interface HasEdithToken
{

    /**
     * Create User Access Token
     * @return string
     */
    public function createToken(): string;
}
