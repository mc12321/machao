<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2018-3-19
 * Time: 10:30
 */

namespace App\Components;


use App\Models\ShowPic;
use App\Models\Zan;
use Qiniu\Auth;

class ShowPicManager
{

    /*
     * 根据id获取信息
     *
     *
     *
     * 2018-7-9
     */
    public static function getById($id)
    {
        $info = ShowPic::where('id', '=', $id)->first();
        return $info;
    }




    /*
     * 根据条件获取列表
     *
     *
     *
     * 2018-07-09
     */
    public static function getListByCon($con_arr, $is_paginate)
    {
        $infos = new ShowPic();
        //相关条件
        if (array_key_exists('search_word', $con_arr) && !Utils::isObjNull($con_arr['search_word'])) {
        $keyword = $con_arr['search_word'];
        $infos = $infos->where(function ($query) use ($keyword) {
            $query->where('admin', 'like', "%{$keyword}%");
        });
    }
        if (array_key_exists('status', $con_arr) && !Utils::isObjNull($con_arr['status'])) {
            $infos = $infos->where('status', '=', $con_arr['status']);
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
     * 设置管理员信息，用于编辑
     *
     *
     *
     * 2018-3-19
     */
    public static function setInfo($info, $data)
    {
        if (array_key_exists('admin', $data)) {
            $info->admin = array_get($data, 'admin');
        }
        if (array_key_exists('img', $data)) {
            $info->img = array_get($data, 'img');
        }
        if (array_key_exists('status', $data)) {
            $info->status = array_get($data, 'status');
        }
        return $info;
    }

}