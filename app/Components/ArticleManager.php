<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/9
 * Time: 11:32
 */

namespace App\Components;


use App\Components\Utils;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use EasyWeChat\Factory;

class ArticleManager
{

    /*
     * 根据id获取轮播图信息
     *
     * By mtt
     *
     * 2018-4-9
     */
    public static function getById($id)
    {

        $info = Article::where('id', $id)->first();

        return $info;
    }

    /*
     * 根据级别获取信息
     *
     * By TerryQi
     *
     * 2018-06-14
     *
     * 0:带图文信息
     *
     */
    public static function getInfoByLevel($info, $level)
    {
        // dd($info->user_id);
        $info->user = UserManager::getById($info->user_id);

        if (strpos($level, '0') !== false) {
            $con_arr = array(
                'f_id' => $info->id,
                'f_table' => 'article',
            );
            $info->twSteps = TWStepManager::getListByCon($con_arr, false);
        }

        return $info;
    }


    /*
     * 根据条件获取信息
     *
     * By mtt
     *
     * 2018-4-9
     */
    public static function getListByCon($con_arr, $is_paginate)
    {
        $infos = new Article();


        if (array_key_exists('id', $con_arr) && !Utils::isObjNull($con_arr['id'])) {
            $infos = $infos->where('id', '=', $con_arr['id']);
        }

        if (array_key_exists('user_id', $con_arr) && !Utils::isObjNull($con_arr['user_id'])) {
            $infos = $infos->where('user_id', '=', $con_arr['user_id']);
        }
        // status_arr需为数组格式
        if (array_key_exists('status_arr', $con_arr) && !Utils::isObjNull($con_arr['status_arr'])) {

            $infos = $infos->wherein('status', $con_arr['status_arr']);
        }


        if (array_key_exists('user_id', $con_arr) && !Utils::isObjNull($con_arr['user_id'])) {
            $infos = $infos->where('user_id', '=', $con_arr['user_id']);
        }

        if (array_key_exists('search_word', $con_arr) && !Utils::isObjNull($con_arr['search_word'])) {
            $infos = $infos->where('name', 'like', '%' . $con_arr['search_word'] . '%');
        }

        if (array_key_exists('wz_id', $con_arr) && !Utils::isObjNull($con_arr['wz_id'])) {
            $infos = $infos->where('id', '=', $con_arr['wz_id']);
        }

        if (array_key_exists('created_at', $con_arr) && !Utils::isObjNull($con_arr['created_at'])) {
            $infos = $infos->where('created_at', 'like', '%' . $con_arr['created_at'] . '%');
        }


        //排序设定
        if (!empty($con_arr['orderby'])) {

            $orderby_arr = $con_arr['orderby'];
            if (array_key_exists('zan_num', $orderby_arr) && !Utils::isObjNull($orderby_arr['zan_num'])) {
                $infos = $infos->orderby('zan_num', $orderby_arr['zan_num']);
            }
            if (array_key_exists('show_num', $orderby_arr) && !Utils::isObjNull($orderby_arr['show_num'])) {
                $infos = $infos->orderby('show_num', $orderby_arr['show_num']);
            }
            if (array_key_exists('created_at', $orderby_arr) && !Utils::isObjNull($orderby_arr['created_at'])) {
                $infos = $infos->orderby('created_at', $orderby_arr['created_at']);
            }
        } else {
            $infos = $infos->orderby('id', 'desc');
        }

        if ($is_paginate) {
            $infos = $infos->paginate(Utils::PAGE_SIZE);
        } else {
            $infos = $infos->get();
        }


        return $infos;
    }




    /*
     * 根据条件获取信息 根据状态
     *
     *
     *
     *
     */

    public static function getListByConByStatus($con_arr, $is_paginate)
    {
        $infos = new Article();


        if (array_key_exists('status', $con_arr) && !Utils::isObjNull($con_arr['status'])) {
            $infos = $infos->where('status', '=', $con_arr['status']);
        }


        $infos = $infos->orderby('id', 'desc');


        if ($is_paginate) {
            $infos = $infos->paginate(Utils::PAGE_SIZE);
        } else {
            $infos = $infos->get();
        }

     //   dd($infos->count());
        return $infos;
    }













    /*
     * 配置信息
     *
     * By TerryQi
     *
     * 2018-06-11
     */
    public static function setInfo($info, $data)
    {
        if (array_key_exists('user_id', $data)) {
            $info->user_id = array_get($data, 'user_id');
        }
        if (array_key_exists('name', $data)) {
            $info->name = array_get($data, 'name');
        }
        if (array_key_exists('desc', $data)) {
            $info->desc = array_get($data, 'desc');
        }
        if (array_key_exists('img', $data)) {
            $info->img = array_get($data, 'img');
        }
        if (array_key_exists('show_num', $data)) {
            $info->show_num = array_get($data, 'show_num');
        }
        if (array_key_exists('comm_num', $data)) {
            $info->comm_num = array_get($data, 'comm_num');
        }
        if (array_key_exists('zan_num', $data)) {
            $info->zan_num = array_get($data, 'zan_num');
        }
        if (array_key_exists('coll_num', $data)) {
            $info->coll_num = array_get($data, 'coll_num');
        }
        if (array_key_exists('trans_num', $data)) {
            $info->trans_num = array_get($data, 'trans_num');
        }
        if (array_key_exists('seq', $data)) {
            $info->seq = array_get($data, 'seq');
        }
        if (array_key_exists('status', $data)) {
            $info->status = array_get($data, 'status');
        }
        if (array_key_exists('article_type_id', $data)) {
            $info->article_type_id = array_get($data, 'article_type_id');
        }
        if (array_key_exists('pri_flag', $data)) {
            $info->pri_flag = array_get($data, 'pri_flag');
        }
        if (array_key_exists('allow_comm_flag', $data)) {
            $info->allow_comm_flag = array_get($data, 'allow_comm_flag');
        }
        if (array_key_exists('content', $data)) {
            $info->content = array_get($data, 'content');
        }
        if (array_key_exists('ori_flag', $data)) {
            $info->ori_flag = array_get($data, 'ori_flag');
        }
        if (array_key_exists('apply_recomm_flag', $data)) {
            $info->apply_recomm_flag = array_get($data, 'apply_recomm_flag');
        }
        if (array_key_exists('recomm_flag', $data)) {
            $info->recomm_flag = array_get($data, 'recomm_flag');
        }
        return $info;
    }


    //添加展示数
    public static function addShowNum($id)
    {
        $info = self::getById($id);
        $info->show_num = $info->show_num + 1;
        $info->save();
    }


    /*
     * 增加转发次数
     *
     * By TerryQi
     *
     * 2018-06-25
     *
     */
    public static function addTransNum($id)
    {
        $info = self::getById($id);
        $info->trans_num = $info->trans_num + 1;
        $info->save();
    }


    /*
     * 增加点赞次数
     *
     * By TerryQi
     *
     * 2018-06-25
     *
     */
    public static function addZanNum($id)
    {
        $info = self::getById($id);
        $info->zan_num = $info->zan_num + 1;
        $info->save();
    }

    /*
     * 减少点赞次数
     *
     * By TerryQi
     *
     * 2018-06-25
     *
     */
    public static function minusZanNum($id)
    {
        $info = self::getById($id);
        if ($info->zan_num > 0) {
            $info->zan_num = $info->zan_num - 1;
        }
        $info->save();
    }

    /*
     * 随机获取N条数据
     *
     * By TerryQi
     *
     * 2018-06-25
     */
    public static function getRandList($con_arr)
    {
        $infos = new Article();
        if (array_key_exists('status', $con_arr) && !Utils::isObjNull($con_arr['status'])) {
            $infos = $infos->where('status', '=', $con_arr['status']);
        }
        $infos = $infos->orderBy(DB::raw('RAND()'))
            ->take($con_arr['num'])
            ->get();

        return $infos;
    }


    /*
     * 设置用户是否点赞作品和关注作者
     *
     * By TerryQi
     *
     * 2018-06-25
     */
    public static function setRelOfUserAndArtile($user_id, $article)
    {
        //是否有关注关系
        $article->user->gz_flag = GuanZhuManager::isAGuanZhuB($user_id, $article->user_id);
        //是否已经赞过
        $con_arr = array(
            'user_id' => $user_id,
            'f_id' => $article->id,
            'f_table' => 'article'
        );
        if (ZanManager::getListByCon($con_arr, false)->count() > 0) {
            $article->zan_flag = true;
        } else {
            $article->zan_flag = false;
        }
    }


}