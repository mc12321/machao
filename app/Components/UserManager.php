<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace App\Components;

use App\Models\GuanZhu;
use App\Models\User;
use App\Models\Vertify;


class UserManager
{

    /*
     * 根据id获取用户信息，带token
     *
     * By TerryQi
     *
     * 2017-09-28
     */
    public static function getByIdWithToken($id)
    {
        $user = User::where('id', '=', $id)->first();
        return $user;
    }

    /*
     * 根据id获取用户信息
     *
     * By TerryQi
     *
     * 2017-09-28
     */
    public static function getById($id)
    {
        $user = self::getByIdWithToken($id);


        if ($user) {
            $user->token = null;
        }
        return $user;
    }

    /*
     * 根据级别获取信息
     *
     * By TerryQi
     *
     * 2018-06-07
     *
     * 0:带粉丝数和关注数
     */
    public static function getInfoByLevel($info, $level)
    {
        //带粉丝数和关注数
        if (strpos($level, '0') !== false) {
            $con_arr = array(
                'fan_user_id' => $info->id,
            );
            $info->gz_num = GuanZhuManager::getListByCon($con_arr, false)->count();   //关注数
            $con_arr = array(
                'gz_user_id' => $info->id,
            );
            $info->fans_num = GuanZhuManager::getListByCon($con_arr, false)->count();   //粉丝数
        }

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
        $infos = new User();
        //相关条件
        if (array_key_exists('phonenum', $con_arr) && !Utils::isObjNull($con_arr['phonenum'])) {
            $infos = $infos->where('phonenum', '=', $con_arr['phonenum']);
        }
        if (array_key_exists('password', $con_arr) && !Utils::isObjNull($con_arr['password'])) {
            $infos = $infos->where('password', '=', $con_arr['password']);
        }
        if (array_key_exists('level', $con_arr) && !Utils::isObjNull($con_arr['level'])) {
            $infos = $infos->where('level', '=', $con_arr['level']);
        }
        if (array_key_exists('search_word', $con_arr) && !Utils::isObjNull($con_arr['search_word'])) {
            $keyword = $con_arr['search_word'];
            $infos = $infos->where(function ($query) use ($keyword) {
                $query->where('phonenum', 'like', "%{$keyword}%")
                    ->orwhere('nick_name', 'like', "%{$keyword}%")
                    ->orwhere('real_name', 'like', "%{$keyword}%");
            });
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
     * 根据条件获取关注列表
     *
     * By TerryQi
     *
     * 2018-06-06
     */
    public static function getListByid($con_arr, $is_paginate)
    {
        $infos = new GuanZhu();
        //相关条件
        if (array_key_exists('id', $con_arr) && !Utils::isObjNull($con_arr['id'])) {
            $infos = $infos->where('id', '=', $con_arr['id']);
        }
        if (array_key_exists('fan_user_id', $con_arr) && !Utils::isObjNull($con_arr['fan_user_id'])) {
            $infos = $infos->where('fan_user_id', '=', $con_arr['fan_user_id']);
        }
        if (array_key_exists('gz_user_id', $con_arr) && !Utils::isObjNull($con_arr['gz_user_id'])) {
            $infos = $infos->where('gz_user_id', '=', $con_arr['gz_user_id']);
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
     * 根据user_code和token校验合法性，全部插入、更新、删除类操作需要使用中间件
     *
     * By TerryQi
     *
     * 2017-09-14
     *
     * 返回值
     *
     */
    public static function ckeckToken($id, $token)
    {
        //根据id、token获取用户信息
        $count = User::where('id', '=', $id)->where('token', '=', $token)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }


    /*
     * 配置用户信息，用于更新用户信息和新建用户信息
     *
     * By TerryQi
     *
     * 2017-09-28
     *
     * PS：服务号和小程序输出的字段不一样
     */
    public static function setInfo($info, $data)
    {
        if (array_key_exists('nick_name', $data)) {
            $info->nick_name = array_get($data, 'nick_name');
        }
        if (array_key_exists('real_name', $data)) {
            $info->real_name = array_get($data, 'real_name');
        }
        if (array_key_exists('avatar', $data)) {
            $info->avatar = array_get($data, 'avatar');
        }
        if (array_key_exists('phonenum', $data)) {
            $info->phonenum = array_get($data, 'phonenum');
        }
        if (array_key_exists('gender', $data)) {
            $info->gender = array_get($data, 'gender');
        }
        if (array_key_exists('status', $data)) {
            $info->status = array_get($data, 'status');
        }
        if (array_key_exists('token', $data)) {
            $info->token = array_get($data, 'token');
        }
        if (array_key_exists('province', $data)) {
            $info->province = array_get($data, 'province');
        }
        if (array_key_exists('city', $data)) {
            $info->city = array_get($data, 'city');
        }
        if (array_key_exists('qm', $data)) {
            $info->qm = array_get($data, 'qm');
        }
        if (array_key_exists('level', $data)) {
            $info->level = array_get($data, 'level');
        }
        return $info;
    }

    // 生成guid
    /*
     * 生成uuid全部用户相同，uuid即为token
     *
     */
    public static function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));

            $uuid = substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12);
            return $uuid;
        }
    }


    /*
   * 生成验证码
   *
   * By TerryQi
   */
    public static function sendVertify($phonenum)
    {
        $vertify_code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);  //生成4位验证码
        $vertify = new Vertify();
        $vertify->phonenum = $phonenum;
        $vertify->code = $vertify_code;
        $vertify->save();
        /*
         * 预留，需要触发短信端口进行验证码下发
         */
        if ($vertify) {
            SMSManager::sendSMSVerification($phonenum, $vertify_code);
            return true;
        }
        return false;
    }

    /*
     * 校验验证码
     *
     * By TerryQi
     *
     * 2017-11-28
     */
    public static function judgeVertifyCode($phonenum, $vertify_code)
    {
        $vertify = Vertify::where('phonenum', '=', $phonenum)
            ->where('code', '=', $vertify_code)->where('status', '=', '0')->first();
        if ($vertify) {
            //验证码置为失效
            $vertify->status = '1';
            $vertify->save();
            return true;
        } else {
            return false;
        }
    }


}