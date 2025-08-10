<?php
namespace Edith\Admin\Providers;

use Edith\Admin\Components\Displays\Text;
use Edith\Admin\Components\Pages\ResultPage;
use Edith\Admin\Support\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        $handler = $this->app->make(ExceptionHandler::class);
        $handler->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson() && $request->isMethod('get')) {
                return Response::failed(
                    $e->getMessage(),
                    (new ResultPage())
                        ->status(404)
                        ->title('404')
                        ->errMessage('接口不存在或未找到，请联系管理员。')
                        ->subTitle('Sorry, the page you visited does not exist.'),
                    -1,
                    $e->getHeaders(),
                    404
                );
            }
        });

        $handler->renderable(function (HttpException $e, Request $request) {
            $status = $e->getStatusCode();
            if ($request->expectsJson() && $request->isMethod('get') && !in_array($status, [401, 404])) {
                $message = match ($status) {
                    403 => '禁止访问',
                    500 => '服务器内部错误',
                    default => $e->getMessage() ?: 'HTTP 异常',
                };
                return Response::failed(
                    $e->getMessage(),
                    (new ResultPage())
                        ->status($status)
                        ->title($status)
                        ->subTitle($message . '，请稍后重试或联系管理员')
                        ->errMessage($e->getMessage())
                        ->body((new Text($e->getTraceAsString()))),
                    -2,
                    $e->getHeaders(),
                    $status
                );
            }
        });

        $handler->renderable(function (AuthorizationException $e, Request $request) {
            if ($request->isMethod('get') && $request->expectsJson()) {
                return Response::failed(
                    $e->getMessage(),
                    (new ResultPage())
                        ->status(403)
                        ->title(403)
                        ->subTitle('无权限访问')
                        ->errMessage($e->getMessage()),
                    -3,
                    [],
                    403
                );
            }
        });

        $handler->renderable(function (ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'code' => 422,
                    'message' => '参数校验失败',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        $handler->renderable(function (\Throwable $e, Request $request) {
            if ($request->isMethod('get') && !($e instanceof HttpException) && $request->expectsJson()) {
                return Response::failed(
                    $e->getMessage(),
                    (new ResultPage())
                        ->status(500)
                        ->title(500)
                        ->subTitle('服务器内部错误，请稍后重试或联系管理员')
                        ->errMessage($e->getMessage())
                        ->body((new Text($e->getTraceAsString()))),
                    -3,
                    []
                );
            }
        });
    }
}