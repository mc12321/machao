<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/9
 * Time: 11:32
 */

namespace App\Components;


use App\Components\Utils;
use App\Models\AD;
use Illuminate\Support\Facades\Log;
use PhpParser\Comment;

class WechatManager
{

    /*
     * 是否包含敏感词
     *
     * By TerryQi
     *
     * 2018-08-25
     *
     * true无问题 false有敏感词
     */
    public static function msgSecCheck($app, $content)
    {
        $result = $app->content_security->checkText($content);
        Log::info(__METHOD__ . " " . "result:" . json_encode($result));
        if ($result['errcode'] != 0) {
            return false;
        } else {
            return true;
        }

    }
}