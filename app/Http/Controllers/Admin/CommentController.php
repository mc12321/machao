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
use App\Components\QNManager;
use App\Components\UserManager;
use App\Components\Utils;
use App\Http\Controllers\ApiResponse;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Libs\ServerUtils;
use App\Components\RequestValidator;
use Illuminate\Support\Facades\Redirect;


class CommentController
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();
 //       dd($data);
        $admin = $request->session()->get('admin');
        //相关搜素条件
        $id = null;
        $fan_user_id = null;
        $gz_user_id = null;
        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $id = $data['id'];
        }
        if (array_key_exists('fan_user_id', $data) && !Utils::isObjNull($data['fan_user_id'])) {
            $fan_user_id = $data['fan_user_id'];
        }
        if (array_key_exists('gz_user_id', $data) && !Utils::isObjNull($data['gz_user_id'])) {
            $gz_user_id = $data['gz_user_id'];
        }

        $con_arr = array(
            'id' => $id,
            'gz_user_id' => $gz_user_id,
            'fan_user_id' => $fan_user_id,
        );
        $users = UserManager::getListByid($con_arr, true);
        foreach ($users as $user) {
            $user = UserManager::getInfoByLevel($user, '0');
        }
        return view('admin.guanzhu.index', ['datas' => $users, 'con_arr' => $con_arr]);
    }


    //设置管理员状态
    public function setStatus(Request $request, $id)
    {
        $data = $request->all();
//        dd($data);
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\MBGL\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数管理员id$id']);
        }
        $user = UserManager::getByIdWithToken($id);
        $user->status = $data['status'];
        $user->save();
        return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
    }


}