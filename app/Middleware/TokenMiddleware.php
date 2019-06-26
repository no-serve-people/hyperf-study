<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\TokenException;
use App\Service\TokenService;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;

class TokenMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var TokenService
     */
    protected $tokenService;

    /**
     * @var HttpResponse
     */
    protected $response;

    public function __construct(ContainerInterface $container, HttpResponse $response)
    {
        $this->container = $container;
        $this->response = $response;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $authorization = $request->getHeaders()["authorization"];

        $token = "";
        if (!empty($authorization[0])) {
            $token = substr($authorization[0], 7); // 截取"Bearer "
        }

        if (empty($token)) {
            throw new TokenException(-999, "token:为空或者不存在.");
        }

        $jwt = $this->tokenService->verification($token);

        // 判断返回值，确实token是否可用等
        try {

            json_decode($jwt);

        } catch (\Throwable $throwable) {

            throw new TokenException(-994, $throwable->getMessage());

        }
        return $handler->handle($request);
    }
}