<?php
namespace Gentle\Edith\Exceptions;

use Gentle\Edith\Support\Response;

class RendererException extends \Exception
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return Response::error($this->getMessage(), $this->getCode() ?: -5000);
    }
}