<?php

namespace App\JsonRpc;

use Hyperf\RpcClient\AbstractServiceClient;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="CaculatorService", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="consul")
 */
class CaculatorService extends AbstractServiceClient implements CaculatorServiceInterface
{
    /**
     * 定义对应服务提供者的服务名称
     * @var string
     */
    protected $serviceName = 'CaculatorService';

    /**
     * 定义对应服务提供者的服务协议
     * @var string
     */
    protected $protocol = 'jsonrpc-http';

    // 实现一个加法方法，这里简单的认为参数都是 int 类型
    public function caculate(int $a, int $b): int
    {
        // 这里是服务方法的具体实现
        return $a + $b;
    }

    public function add(int $a, int $b): int
    {
        return $this->__request(__FUNCTION__, compact('a', 'b'));
    }
}