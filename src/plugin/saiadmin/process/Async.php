<?php

/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace plugin\saiadmin\process;

use support\Container;
use support\exception\BusinessException;
use support\Log;
use Workerman\Connection\TcpConnection;

/**
 * Class Consumer
 * @package process
 */
class Async
{
    public function __construct()
    {

    }

    public function onWorkerStart(object $worker)
    {

    }

    public function onConnect(TcpConnection $connection)
    {

    }

    public function onMessage(TcpConnection $connection, $data)
    {
        try {
            //接受请求数据
            $data = json_decode($data, true);
            //验证参数
            if(!is_array($data)){
                throw new BusinessException('parameter exception', 404);
            }
            //验证类
            $class = $data['class'] ?? '';
            if ($class === '' || !class_exists($class)) {
                throw new BusinessException('class not found', 404);
            }
            //验证方法
            $method = $data['method'] ?? '';
            if (!method_exists($class, $method)) {
                throw new BusinessException('method not found',404);
            }
            //获取参数
            $args = $data['args'] ?? [];
            $class = Container::get($class);
            call_user_func_array([$class, $method], [...$args]);
            $json = ['code' => 200, 'msg' => 'success'];
        } catch (BusinessException $exception) {
            $json = ['code' => $exception->getCode(), 'msg' => $exception->getMessage()];
            Log::channel('async')->info(json_encode($json, JSON_UNESCAPED_UNICODE));
        } catch (\Throwable $exception) {
            $json = ['code' => 500, 'msg' => ['errMessage'=>$exception->getMessage(), 'errCode'=>$exception->getCode(), 'errFile'=>$exception->getFile(), 'errLine'=>$exception->getLine()]];
            Log::channel('async')->error(json_encode($json, JSON_UNESCAPED_UNICODE));
        }
        $connection->send(json_encode($json));

    }

    public function onClose(TcpConnection $connection)
    {

    }
}
