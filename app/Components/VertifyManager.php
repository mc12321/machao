<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace App\Components;


use App\Models\Vertify;


class VertifyManager
{



    /*
     * 根据条件信息
     *
     *
     *
     * 2018-7-10
     */


    public static function getListByCon($con_arr, $is_paginate)
    {
        $infos = new Vertify();
        //相关条件
        if (array_key_exists('phonenum', $con_arr) && !Utils::isObjNull($con_arr['phonenum'])) {
            $infos = $infos->where('phonenum', '=', $con_arr['phonenum']);
            if (array_key_exists('code', $con_arr) && !Utils::isObjNull($con_arr['code'])) {
                $infos = $infos->where('code', '=', $con_arr['code']);
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


    }
}