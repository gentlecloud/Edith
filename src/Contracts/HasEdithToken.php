<?php
namespace Edith\Admin\Contracts;

interface HasEdithToken
{

    /**
     * Create User Access Token
     * @return string
     */
    public function createToken(): string;
}
