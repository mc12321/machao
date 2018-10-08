<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace App\Components;

use App\Models\Login;
use App\Models\User;

class LoginManager
{

    /*
     * 根据id获取信息
     *
     * By TerryQi
     *
     * 2018-06-13
     */
    public static function getById($id)
    {
        $info = Login::where('id', '=', $id)->first();
        return $info;
    }


    /*
    * 根据条件获取列表
     *
     * By TerryQi
     *
     * 2018-06-06
     */
    public static function getListByCon($con_arr, $is_paginate)
    {
        $infos = new Login();
        //相关条件
        if (array_key_exists('user_id', $con_arr) && !Utils::isObjNull($con_arr['user_id'])) {
            $infos = $infos->where('user_id', '=', $con_arr['user_id']);
        }
        if (array_key_exists('account_type', $con_arr) && !Utils::isObjNull($con_arr['account_type'])) {
            $infos = $infos->where('account_type', '=', $con_arr['account_type']);
        }
        if (array_key_exists('busi_name', $con_arr) && !Utils::isObjNull($con_arr['busi_name'])) {
            $infos = $infos->where('busi_name', '=', $con_arr['busi_name']);
        }
        if (array_key_exists('ve_value1', $con_arr) && !Utils::isObjNull($con_arr['ve_value1'])) {
            $infos = $infos->where('ve_value1', '=', $con_arr['ve_value1']);
        }
        if (array_key_exists('ve_value2', $con_arr) && !Utils::isObjNull($con_arr['ve_value2'])) {
            $infos = $infos->where('ve_value2', '=', $con_arr['ve_value2']);
        }
        $infos = $infos->orderby('id', 'desc');
        //配置规则
        if ($is_paginate) {
            $infos = $infos->paginate(Utils::PAGE_SIZE);
        } else {
            $infos = $infos->get();
        }
        return $infos;
    }

    /*
     * 配置登录信息
     *
     * By TerryQi
     *
     * 2017-09-28
     *
     */
    public static function setInfo($info, $data)
    {
        if (array_key_exists('user_id', $data)) {
            $info->user_id = array_get($data, 'user_id');
        }
        if (array_key_exists('account_type', $data)) {
            $info->account_type = array_get($data, 'account_type');
        }
        if (array_key_exists('busi_name', $data)) {
            $info->busi_name = array_get($data, 'busi_name');
        }
        if (array_key_exists('ve_value1', $data)) {
            $info->ve_value1 = array_get($data, 've_value1');
        }
        if (array_key_exists('ve_value2', $data)) {
            $info->ve_value2 = array_get($data, 've_value2');
        }
        return $info;
    }
}