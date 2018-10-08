<?php
/**
 * 首页控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20 0020
 * Time: 20:15
 */

namespace App\Http\Controllers\Admin;

use App\Components\ShowPicManager;
use App\Components\QNManager;
use App\Components\Utils;
use App\Http\Controllers\ApiResponse;
use App\Models\ShowPic;
use Illuminate\Http\Request;



class ShowPicController
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();



        $search_word = null;    //搜索条件
        $admin = $request->session()->get('admin');
        //相关搜素条件
        $search_word = null;
        if (array_key_exists('search_word', $data) && !Utils::isObjNull($data['search_word'])) {
            $search_word = $data['search_word'];
        }
        $con_arr = array(
            'search_word' => $search_word,
        );
        $pics = ShowPicManager::getListByCon($con_arr, false);
//
//        dd($pics);
//
        return view('admin.showpic.index', ['datas' => $pics, 'con_arr' => $con_arr]);
    }


    /*
     *设置图片状态
     *
     *
     *
     * 2018-7-9
     */
    public function setStatus(Request $request, $id)
    {
        $data = $request->all();



        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数轮播图id$id']);
        }
        $artile = ShowPicManager::getById($data['id']);
        $artile = ShowPicManager::setInfo($artile, $data);
        $artile->save();

       // dd($artile);
        return ApiResponse::makeResponse(true, $artile, ApiResponse::SUCCESS_CODE);
    }


    /*
     *新建图片
     *
     *
     *
     * 2018-7-9
     */
    public function edit(Request $request)
    {
        $data = $request->all();

        $admin_b = new ShowPic();
        if (array_key_exists('id', $data)) {
            $admin_b = ShowPicManager::getById($data['id']);
        }
        $admin = $request->session()->get('admin');

        //只有根管理员有修改权限
        /*
         *   此处出现问题，找不到IndexController@error
         *   2018/04/20
         *
         * */
//        if (!($admin->role == '0')) {
//            return redirect()->action('/App/Http/Controllers/MBGL/Admin/IndexController@error', ['msg' => '合规校验失败，只有根级管理员有修改权限']);
//        }
        //生成七牛token
        $upload_token = QNManager::uploadToken();
//        dd($admin_b);
        return view('admin.showpic.edit', ['admin' => $admin, 'data' => $admin_b, 'upload_token' => $upload_token]);
    }




    /*
     * 添加、编辑图片
     *
     *
     *
     * 2018-7-9
     */
    public function editPost(Request $request)
    {
        $data = $request->all();

        $ad = new ShowPic();
        $return = null;
        //如果存在id就是编辑
        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $ad = ShowPicManager::getById($data['id']);
        }
        $ad -> admin =  $request->session()->get('admin')->name;
        $ad = ShowPicManager::setInfo($ad, $data);


        $result = $ad->save();
        if ($result) {
            return ApiResponse::makeResponse(true, "添加成功", ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, "添加失败", ApiResponse::INNER_ERROR);
        }
    }



}