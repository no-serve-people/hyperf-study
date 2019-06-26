<?php

namespace App\Service;

use App\Exception\TokenException;
use Firebase\JWT\JWT;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class TokenService
{
    public function authorizations(RequestInterface $request)
    {
        $key = config('server.jwt-setting.key','xpnaYVqVVDwFfy8A'); //key
        $time = time(); //当前时间
        //公用信息
        $token = [
            'iss'  => 'xxx.com', //签发者 可选
            'iat'  => $time, //签发时间
            'data' => [ //自定义信息，不要定义敏感信息
                'userid' => 1,
            ]
        ];
        $access_token = $token;
        $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
        $access_token['exp'] = $time + 7200; //access_token过期时间,这里设置2个小时
        $refresh_token = $token;
        $refresh_token['scopes'] = 'role_refresh'; //token标识，刷新access_token
        $refresh_token['exp'] = $time + (86400 * 30); //refresh_token过期时间,这里设置30天
        $jsonList = [
            'access_token'  => JWT::encode($access_token, $key),
            'refresh_token' => JWT::encode($refresh_token, $key),
            'token_type'    => 'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
        ];
        return json_encode($jsonList); //返回给客户端token信息
    }

    public function verification($jwt)
    {
        $key = config('server.jwt-setting.key','xpnaYVqVVDwFfy8A'); //key要和签发的时候一样
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($jwt, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            return json_encode($arr);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            throw new TokenException(-998, $e->getMessage());
        } catch (\Firebase\JWT\BeforeValidException $e) {       // 签名在某个时间点之后才能用
            throw new TokenException(-997, $e->getMessage());
        } catch (\Firebase\JWT\ExpiredException $e) {           // token过期
            throw new TokenException(-996, $e->getMessage());
        } catch (\Throwable $e) {                               //其他错误
            throw new TokenException(-995, $e->getMessage());
        }
        //Firebase定义了多个 throw new，我们可以捕获多个catch来定义问题，catch加入自己的业务，比如token过期可以用当前Token刷新一个新Token
    }
}