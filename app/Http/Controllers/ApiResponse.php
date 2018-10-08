<?php
/**
 * File_Name:ApiResponse.php
 * Author: leek
 * Date: 2017/8/23
 * Time: 14:37
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class ApiResponse
{
    //未知错误
    const UNKNOW_ERROR = 999;
    //缺少参数
    const MISSING_PARAM = 901;
    //逻辑错误
    const INNER_ERROR = 902;

    //成功
    const SUCCESS_CODE = 200;

    //缺少token
    const TOKEN_LOST = 101;
    //token校验失败
    const TOKEN_ERROR = 102;
    //用户编码丢失
    const USER_ID_LOST = 103;
    //注册失败
    const REGISTER_FAILED = 104;
    //未找到用户
    const NO_USER = 105;
    //验证码验证失败
    const VERTIFY_ERROR = 106;
    //手机号重复
    const PHONENUM_DUP = 107;
    const PHONENUM_ALREAD_REGISTED = 108; //手机号已经注册过

    //统一下单失败
    const UITIFY_ORDER_FAILED = 110;


    //微信小程序发布内容审核不通过
    const XCX_AUDIT_CODE = 601;

    //工程师加盟相关错误
    const ALREADY_BEEN_ENGINEER = 301;        //现已经为工程师
    const MISSING_BASEINFO = 302;        //缺少基本信息
    const MISSING_EXPERIENCE = 303;       //缺少工作经历
    const MISSING_ANSWER = 304;     //还未答题
    const ALREADY_APPLYING = 305;     //正在申请中


    //映射错误信息
    public static $errorMassage = [
        self::UNKNOW_ERROR => '未知错误',
        self::MISSING_PARAM => '缺少参数',
        self::TOKEN_LOST => '缺少token',
        self::TOKEN_ERROR => 'token校验失败',
        self::USER_ID_LOST => '缺少用户编码',
        self::NO_USER => '未找到用户',
        self::UITIFY_ORDER_FAILED => '统一下单失败',
        self::REGISTER_FAILED => '注册失败',
        self::INNER_ERROR => '内部错误',
        self::PHONENUM_ALREAD_REGISTED => '手机号已经注册',
        //工程师加盟相关错误
        self::ALREADY_BEEN_ENGINEER => '已经为工程师',
        self::MISSING_BASEINFO => '需填写基本信息',
        self::MISSING_EXPERIENCE => '需填写工作经历',
        self::MISSING_ANSWER => '加盟需要参加考试',
        self::ALREADY_APPLYING => '已经申请，请耐心等待',
    ];

    //格式化返回
    public static function makeResponse($result, $ret, $code, $mapping_function = null, $params = [])
    {
        $rsp = [];
        $rsp['code'] = $code;

        if ($result === true) {
            $rsp['result'] = true;
            $rsp['ret'] = $ret;
        } else {
            $rsp['result'] = false;
            if ($ret) {
                $rsp['message'] = $ret;
            } else {
                if (array_key_exists($code, self::$errorMassage)) {
                    $rsp['message'] = self::$errorMassage[$code];
                } else {
                    $rsp['message'] = 'undefind error code';
                }
            }
        }
        Log::info(__METHOD__ . " response:" . response()->json($rsp));
        return response()->json($rsp);
    }
}