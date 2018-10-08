<?php
/**
 * 首页控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20 0020
 * Time: 20:15
 */

namespace App\Http\Controllers\Admin;

use App\Components\AdminManager;
use App\Components\GuanZhuManager;

use App\Components\ArticleManager;
use App\Components\UserManager;
use App\Components\Utils;
use App\Http\Controllers\ApiResponse;
use App\Models\Admin;
use App\Models\GuanZhu;
use Illuminate\Http\Request;
use App\Libs\ServerUtils;
use App\Components\RequestValidator;
use Illuminate\Support\Facades\Redirect;


class GuanZhuController
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();

        $admin = $request->session()->get('admin');
        //相关搜素条件
        $con_arr = array();
        $guanzhus = GuanZhuManager::getListByCon($con_arr, true);
        foreach ($guanzhus as $guanzhu) {
            $guanzhu = GuanZhuManager::getInfoByLevel($guanzhu, '01');
        }


        return view('admin.guanzhu.index', ['datas' => $guanzhus, 'con_arr' => $con_arr]);
    }

    /*
     * 关注/取消关注接口
     *
     * By TerryQi
     *
     * 218-06-21
     *
     * opt: 0代表取消关注 1:代表关注
     */
    public function setGuanZhu(Request $request)
    {
        $data = $request->all();



        $requestValidationResult = RequestValidator::validator($request->all(), [
            'opt' => 'required',
            'user_id' => 'required',
            'gz_user_id' => 'required'
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }

        $opt = $data['opt'];
        //取消关注
        if ($opt == '0') {
            $con_arr = array(
                'fan_user_id' => $data['user_id'],
                'gz_user_id' => $data['gz_user_id']
            );
            $guanZhus = GuanZhuManager::getListByCon($con_arr, false);
            foreach ($guanZhus as $guanZhu) {
                $guanZhu->delete();
            }


            //文章id 是否从文章详情进行关注
            if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
                //更改关注数
                $article = ArticleManager::getById($data['id']);
                if ($article->gz_num > 0) {
                    $article->gz_num = $article->gz_num - 1;
                    $article->save();
                }
            }


            return ApiResponse::makeResponse(true, "取消关注成功", ApiResponse::SUCCESS_CODE);
        }
        //进行关注
        if ($opt == "1") {
            $con_arr = array(
                'fan_user_id' => $data['user_id'],
                'gz_user_id' => $data['gz_user_id']
            );
            $guanZhus = GuanZhuManager::getListByCon($con_arr, false);
            if ($guanZhus->count() == 0) {
                $guanZhu = new GuanZhu();
                $guanZhu = GuanZhuManager::setInfo($guanZhu, $con_arr);
                $guanZhu->save();

                //文章id 是否从文章详情进行关注
                if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
                    //更改关注数
                    $article = ArticleManager::getById($data['id']);
                    $article->gz_num = $article->gz_num + 1;
                    $article->save();
                }
            }



            return ApiResponse::makeResponse(true, "关注成功", ApiResponse::SUCCESS_CODE);
        }
    }
}