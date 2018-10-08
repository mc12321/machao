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
use App\Components\ArticleManager;
use App\Components\GuanZhuManager;
use App\Components\UserManager;
use App\Components\Utils;
use App\Http\Controllers\ApiResponse;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Libs\ServerUtils;
use App\Components\RequestValidator;
use Illuminate\Support\Facades\Redirect;


class UserController
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $admin = $request->session()->get('admin');
        //相关搜素条件
        $search_word = null;
        if (array_key_exists('search_word', $data) && !Utils::isObjNull($data['search_word'])) {
            $search_word = $data['search_word'];
        }
        $con_arr = array(
            'search_word' => $search_word,
        );
        $users = UserManager::getListByCon($con_arr, true);
        foreach ($users as $user) {
            $user = UserManager::getInfoByLevel($user, '0');
        }
        return view('admin.user.index', ['datas' => $users, 'con_arr' => $con_arr]);
    }


    //设置管理员状态
    public function setStatus(Request $request, $id)
    {
        $data = $request->all();
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\MBGL\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数管理员id$id']);
        }
        $user = UserManager::getByIdWithToken($id);
        $user->status = $data['status'];
        $user->save();
        return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
    }


    //设置管理员状态
    public function setLevel(Request $request, $id)
    {
        $data = $request->all();
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\MBGL\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数管理员id$id']);
        }
        $user = UserManager::getByIdWithToken($id);
        $user->level = $data['level'];
        $user->save();
        return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
    }


   //用户详情
    public function detail(Request $request)
    {
        $data = $request->all();

        $admin = $request->session()->get('admin');
        //合规校验
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return redirect()->action('\App\Http\Controllers\SJDL\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数' . $requestValidationResult]);
        }
        //用户信息
        $user = UserManager::getById($data['id']);
        $user = UserManager::getInfoByLevel($user, '0');

        //获取作品
        $zp_arr = array(
            'user_id' => $data['id']
        );
        $zps = ArticleManager::getListByCon($zp_arr, false);

        //获取关注
        $fan_arr = array(
            'fan_user_id' => $data['id']
        );
        $fans = GuanZhuManager::getListByCon($fan_arr, false);
        foreach ($fans as $fan) {
            $fan -> fan_name = UserManager::getById($fan['gz_user_id']);
        }

        //获取粉丝列表
        $gz_arr = array(
            'gz_user_id' => $data['id']
        );
        $gzs = GuanZhuManager::getListByCon($gz_arr, false);
        foreach ($gzs as $gz) {
            $gz -> gz_name = UserManager::getById($gz['fan_user_id']);
        }

        return view('admin.user.detail', ['admin' => $admin, 'data' => $user
            , 'fans' => $fans, 'gzs' => $gzs, 'zps' => $zps]);
    }




}