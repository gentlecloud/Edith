<?php
namespace Edith\Admin\Exceptions;

use Edith\Admin\Support\Response;

class RuntimeException extends \Exception
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return Response::error($this->getMessage(), -101);
    }
}