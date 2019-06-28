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

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

abstract class Controller
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $container->get(RequestInterface::class);
        $this->response = $container->get(ResponseInterface::class);
    }

    /**
     * 接口返回公共方法
     * @param int $status 返回成功1 失败 0
     * @param array $data 接口返回数据
     * @param int $page 分页
     * @param int $totalPage 每页数据
     * @param int $totalNum 总数据
     * @param string $msg 提示信息
     * @param int $code http状态码
     * @return mixed
     */
    public function jsonReturn($status = 0, $data = [], $page = -1, $totalPage = -1, $totalNum = -1, $msg = '', $code = 200)
    {
        $return['status'] = $status;
        if (!empty($msg)) {
            $return['msg'] = $msg;
        }
        if ($page != -1) {
            $return['data']['page'] = $page;
        }
        if ($totalPage != -1) {
            $return['data']['totalPage'] = $totalPage;
        }
        if ($totalNum != -1) {
            $return['data']['totalNum'] = $totalNum;
        }
        $return['data']['data'] = $data;
        return $this->response->json($return);
    }
}
