<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/25
 * Time: 14:54
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Components\RequestValidator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiResponse;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{

    const ACCOUNT_CONFIG = 'wechat.official_account';

    /**
     * 处理微信的请求消息
     *
     * 消息包括
     *
     * @return string
     */
    public function serve()
    {
        Log::info(__METHOD__ . " " . 'request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
        $app = app(self::ACCOUNT_CONFIG);
        $app->server->push(function ($message) {
            $app = app(self::ACCOUNT_CONFIG);
            Log::info(__METHOD__ . " " . "server receive:" . json_encode($message));
            $user_openid = $message['FromUserName'];  //用户公众号openid
            Log::info(__METHOD__ . " " . 'user_openid:' . $user_openid);
            $wechat_user = $app->user->get($user_openid);        //通过用户openid获取信息
            Log::info(__METHOD__ . " " . 'wechat_user:' . json_encode($wechat_user));
            //补全基本信息
            $data = array(
                "avatar" => $wechat_user['headimgurl'],
                "nick_name" => $wechat_user['nickname'],
                "gender" => $wechat_user['sex'],
                "country" => $wechat_user['country'],
                "province" => $wechat_user['province'],
                "language" => $wechat_user['language'],
                "city" => $wechat_user['city'],
                "openid" => $wechat_user['openid'],
                "busi_name" => self::BUSI_NAME
            );

            //根据消息类型分别进行处理
            switch ($message['MsgType']) {
                case 'event':
                    //点击事件
                    if ($message['Event'] == 'CLICK') {
                        switch ($message['EventKey']) {

                        }
                    }
                    //关注事件
                    if ($message['Event'] == 'subscribe') {

                    }
                    //取消关注事件
                    if ($message['Event'] == 'unsubscribe') {

                    }
                    //扫描进入事件
                    if ($message['Event'] == 'SCAN') {

                    }
                    break;
                case 'text':        //文本消息
                    break;
                case 'image':

                    break;
                case 'voice':

                    break;
                case 'video':

                    break;
                case 'location':

                    break;
                case 'link':

                    break;
                // ... 其它消息
                default:
//                    return '';
                    break;
            }
        });
        $response = $app->server->serve();
        return $response;
    }
}