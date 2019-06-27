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

namespace App\Controller;

use App\Model\User;
use App\Service\TokenService;
use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\TokenMiddleware;

/**
 * Class IndexController
 *
 * @\Hyperf\HttpServer\Annotation\Controller(prefix="t")
 * @package App\Controller
 */
class TestController extends Controller
{

    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    /**
     * @Inject()
     * @var TokenService
     */
    private $tokenService;


    /**
     * @GetMapping("index")
     */
    public function index()
    {
        return ["test" => 'index'];
    }


    /**
     * @GetMapping("info")
     */
    public function getInfo()
    {
        return $this->userService->getInfoById(1);
    }

    /**
     * @GetMapping("reg")
     * @return bool
     */
    public function reg()
    {
        return $this->userService->register() ? "注册成功" : "注册失败";
    }

    /**
     * @GetMapping("encode")
     */
    public function encode()
    {
        $c_token = $this->tokenService->authorizations($this->request);
        return $this->response->json([
            "token" => $c_token
        ]);
    }

    /**
     * @GetMapping("decode")
     * @Middlewares({
     *  @Middleware(TokenMiddleware::class)
     * })
     */
    public function jwt()
    {
        $headers = $this->request->getHeaders();
        return $this->response->json([
            "code"    => 200,
            "headers" => $headers
        ]);
    }

    /**
     * @GetMapping("dbTest")
     */
    public function dbTest()
    {
        $data = User::query()->where('id', 1)->first();
        return json_encode($data);
    }
}
