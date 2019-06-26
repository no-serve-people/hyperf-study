<?php

namespace App\Service;

use App\Event\UserRegistered;
use App\Model\User;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;

class UserService
{

    /**
     * @Inject()
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function register()
    {
        // 我们假设存在 User 这个实体
        $user = new User();
//        $user->id = 2;
        $user->name = "张三";
        $user->gender = "男";
        $result = $user->save();
        // 完成账号注册的逻辑
        // 这里 dispatch(object $event) 会逐个运行监听该事件的监听器
        $this->eventDispatcher->dispatch(new UserRegistered($user));
        return $result;
    }

    public function getInfoById(int $id): array
    {
        return ['name' => '张三', 'age' => 22];
    }
}