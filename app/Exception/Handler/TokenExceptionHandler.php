<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/26 0026
 * Time: 11:22
 */

namespace App\Exception\Handler;


use App\Exception\TokenException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * TokenExceptionHandler 异常处理器
 * @package App\Exception\Handler
 */
class TokenExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof TokenException) {
            // 格式化输出
            $data = json_encode([
                'code'    => $throwable->getCode(),
                'message' => $throwable->getMessage(),
            ], JSON_UNESCAPED_UNICODE);

            return $response->withStatus(500)->withBody(new SwooleStream($data));
        }
        // 系统内部异常或者是不能暴露到外网的异常
        return $response->withStatus(500)->withBody('Server Error');
    }

    public function isValid(Throwable $throwable): bool
    {
        // TODO: Implement isValid() method.
        return true;
    }
}