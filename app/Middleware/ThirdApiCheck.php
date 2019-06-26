<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ThirdApiCheck implements MiddlewareInterface
{
    private $whiteList = ['127.0.0.1'];

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $param = $request->getServerParams();
//        var_dump($param);
        if (!in_array($param['remote_addr'], $this->whiteList)) {
            if (!isset($param['time']) || !isset($param['token']) || $param['token'] != md5('chachadian' . $param['time'])) {
                var_dump("hello");
            }
        }
        return $handler->handle($request);
    }
}
