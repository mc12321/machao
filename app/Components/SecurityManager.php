<?php
namespace App\Components;


use EasyWeChat\Factory;


class SecurityManager
{

    /*
     * 执行文字内容审核
     *
     *
     *
     *
     */
    public static function auditContent($twSteps_text_arr,$config)
    {
        // time_sleep_until(time()+1);    //延时执行

        $app = Factory::miniProgram($config);
        $result = $app->content_security->checkText($twSteps_text_arr);

        return $result;
    }

    /*
     * 执行审核图片
     *
     *
     *
     *图片路径必须为绝对路径
     */
    public static function auditImg($img,$con_arr)
    {


        $config = [
            'app_id' => array_get($con_arr, 'app_id'),
            'secret' => array_get($con_arr, 'secret'),

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];

        $app = Factory::miniProgram($config);

        $result = $app->content_security->checkImage($img);

        return $result;
    }
}

