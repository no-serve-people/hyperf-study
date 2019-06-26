<?php

namespace App\Listener;

use App\Event\UserRegistered;
use App\Model\User;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener()
 * Class UserRegisteredListener
 * @package App\Listener
 */
class UserRegisteredListener implements ListenerInterface
{
    public function listen(): array
    {
        // 返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            UserRegistered::class,
        ];
    }

    /**
     * @param UserRegistered $event
     */
    public function process(object $event)
    {
        // 事件触发后该监听器要执行的代码写在这里，比如该示例下的发送用户注册成功短信
        if ($event instanceof UserRegistered) {
            var_dump($event->user->toArray()); // 对象转数组
        }
    }
}