<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/9
 * Time: 11:32
 */

namespace App\Http\Controllers\Admin;

use App\Components\ArticleManager;
use App\Components\QNManager;
use App\Components\TWStepManager;
use App\Components\UserManager;
use App\Components\Utils;
use App\Components\RequestValidator;
use App\Http\Controllers\ApiResponse;
use App\Models\AD;
use App\Models\Article;
use App\Models\TWStep;
use Illuminate\Http\Request;

class ArticleController
{

    /*
      * 图文管理页
      *
      *
      *
      * 2018-4-9
      */
    public static function index(Request $request)
    {

        $articlemin = $request->session()->get('admin');
        $data = $request->all();
        $search_word = null;    //搜索条件

        $id = null;
        $user_id = null;
        $created_at = null;


        //如果翻页 有page  要改变传入的排序字段格式  防止view层 取不到排序值  使翻页取不到排序值
        if(array_key_exists('page', $data) && !Utils::isObjNull($data['page'])){
            //判断是否传入 orderby
            if(array_key_exists('orderby', $data) && !Utils::isObjNull($data['orderby'])) {
                $data['orderby'] = array_keys($data['orderby'])[0];
            }
        }


        $orderby = [];    //排序搜索种类

        if (array_key_exists('search_word', $data) && !Utils::isObjNull($data['search_word'])) {
            $search_word = $data['search_word'];
        }

        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $id = $data['id'];
        }

        if (array_key_exists('user_id', $data) && !Utils::isObjNull($data['user_id'])) {
            $user_id = $data['user_id'];
        }

        if (array_key_exists('created_at', $data) && !Utils::isObjNull($data['created_at'])) {
            $created_at = $data['created_at'];
        }

        if (array_key_exists('orderby', $data) && !Utils::isObjNull($data['orderby'])) {

            if ($data['orderby'] == "created_at") {
                $orderby = array(
                    'created_at' => 'desc'
                );
            }
            if ($data['orderby'] == "zan_num") {
                $orderby = array(
                    'zan_num' => 'desc'
                );
            }
            if ($data['orderby'] == "show_num") {
                $orderby = array(
                    'show_num' => 'desc'
                );
            }


        }
        $status_arr=array(0,1); //显示status状态为0 1的文章
        $con_arr = array(
            'status_arr' => $status_arr,
            'search_word' => $search_word,
            'id' => $id,
            'user_id' => $user_id,
            'created_at' => $created_at,
            'orderby' => $orderby
        );


        $articles = ArticleManager::getListByCon($con_arr, true);



        foreach ($articles as $article) {
            $article = ArticleManager::getInfoByLevel($article, '');
          //  $article->f_table = TWStepManager::getByFId($article['id']);   //获取对应 文章详情表f_id
        }


        return view('admin.article.index', ['admin' => $articlemin, 'datas' => $articles, 'con_arr' => $con_arr]);
    }




    /*
     * 文章回收站
     *
     *
     *
     *
     */
    public static function recovery(Request $request)
    {

        $articlemin = $request->session()->get('admin');
        $data = $request->all();
        $search_word = null;    //搜索条件

        $id = null;
        $user_id = null;
        $created_at = null;



        //如果翻页 有page  要改变传入的排序字段格式  防止view层 取不到排序值  使翻页取不到排序值
        if(array_key_exists('page', $data) && !Utils::isObjNull($data['page'])){
            //判断是否传入 orderby
            if(array_key_exists('orderby', $data) && !Utils::isObjNull($data['orderby'])) {
                $data['orderby'] = array_keys($data['orderby'])[0];
            }
        }


        $orderby = [];    //排序搜索种类

        if (array_key_exists('search_word', $data) && !Utils::isObjNull($data['search_word'])) {
            $search_word = $data['search_word'];
        }

        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $id = $data['id'];
        }

        if (array_key_exists('user_id', $data) && !Utils::isObjNull($data['user_id'])) {
            $user_id = $data['user_id'];
        }

        if (array_key_exists('created_at', $data) && !Utils::isObjNull($data['created_at'])) {
            $created_at = $data['created_at'];
        }

        if (array_key_exists('orderby', $data) && !Utils::isObjNull($data['orderby'])) {

            if ($data['orderby'] == "created_at") {
                $orderby = array(
                    'created_at' => 'desc'
                );
            }
            if ($data['orderby'] == "zan_num") {
                $orderby = array(
                    'zan_num' => 'desc'
                );
            }
            if ($data['orderby'] == "show_num") {
                $orderby = array(
                    'show_num' => 'desc'
                );
            }
        }
        $status_arr=array(2); //显示status状态为2的文章
        $con_arr = array(
            'status_arr' => $status_arr,
            'search_word' => $search_word,
            'id' => $id,
            'user_id' => $user_id,
            'created_at' => $created_at,
            'orderby' => $orderby
        );


        $articles = ArticleManager::getListByCon($con_arr, true);

        foreach ($articles as $article) {
            $article = ArticleManager::getInfoByLevel($article, '');
         //   $article->f_table = TWStepManager::getByFId($article['id']);
        }


        return view('admin.article.recovery', ['admin' => $articlemin, 'datas' => $articles, 'con_arr' => $con_arr]);
    }







    /*
     *
     *
     * By mtt
     *
     * 2018-4-9
     */
    public function setStatus(Request $request, $id)
    {
        $data = $request->all();
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数轮播图id$id']);
        }
        $article = ArticleManager::getById($data['id']);
        $article = ArticleManager::setInfo($article, $data);
        $article->save();
        return ApiResponse::makeResponse(true, $article, ApiResponse::SUCCESS_CODE);
    }


    /*
     * 查看图文详情
     *
     *
     *
     * 2018-06-28
     */

    public function detail(Request $request)
    {
        $data = $request->all();
        $admin = $request->session()->get('admin');

        if (array_key_exists('f_id', $data) && array_key_exists('f_table', $data)) {
            //获取图文详情
            $con_arr = array(
                'f_id' => $data['f_id'],
                'f_table' => $data['f_table']
            );
            $twSteps = TWStepManager::getListByCon($con_arr, false);
            foreach ($twSteps as $twStep) {
                $twStep['text'] = str_replace('"', '”', $twStep['text']);
            }
            $data['twSteps'] = $twSteps;
            //生成七牛token
            $upload_token = QNManager::uploadToken();
            $param = array(
                'admin' => $admin,
                'data' => $data,
                'upload_token' => $upload_token
            );

            return view('admin.article.detail_xq', $param);
        } else {
            return ApiResponse::makeResponse(false, false, ApiResponse::MISSING_PARAM);
        }

    }


    /*
     * 更改图文详情
     *
     *
     *
     * 2018-06-28
     */
    public function detailPost(Request $request)
    {
        $data = $request->all();
        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $twStep = TWStepManager::getById($data['id']);
        } else {
            $twStep = new TWStep();
        }

        $twStep = TWStepManager::setInfo($twStep, $data);
        $result = $twStep->save();

        //dd($twStep);
        if ($result) {
            return ApiResponse::makeResponse(true, $twStep, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, "添加失败", ApiResponse::INNER_ERROR);
        }

    }


    /*
     * 获取文章信息
     *
     *
     *
     * 2018-07-5
     */
    public function info(Request $request)
    {
        $data = $request->all();


        $admin = $request->session()->get('admin');
        //合规校验
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        //获取文章信息


        $con_arr = array(
            'f_id' => $data['id'],
        );
        $wzs = TWStepManager::getListByCon($con_arr, false);
        $contribute = ArticleManager::getById($data['id']);

        return view('admin.article.info', ['admin' => $admin, 'data' => $contribute, 'wzs' => $wzs]);
    }


    //新建或编辑文章标题
    public function edit(Request $request)
    {
        $data = $request->all();
        $admin = $request->session()->get('admin');
        //文章信息
        $artcile = new Article();
        if (array_key_exists('id', $data)) {
            $artcile = ArticleManager::getById($data['id']);
            $artcile->user_id_show_flag = 0;    //show_flag 是否显示 作者项  0 代表不显示  1 代表显示
        } else {
            $artcile->user_id_show_flag = 1;
        }
        //获取推荐用户列表 用于新建系统文章选择作者
        $con_arr = array(
            'level' => '1',
        );
        $xt_users = UserManager::getListByCon($con_arr, false);

        //获取七牛上传的token
        $upload_token = QNManager::uploadToken();

        return view('admin.article.edit', ['admin' => $admin, 'data' => $artcile, 'upload_token' => $upload_token, 'xt_users' => $xt_users]);
    }


    //新建或编辑文章标题->post
    public function editPost(Request $request)
    {
        $data = $request->all();
        $wzStep = new Article();
        $result = null;

        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $wzStep = ArticleManager::getById($data['id']);
            $data['status'] = 0;    //新建 及编辑文章 设置为隐藏状态
            $wzStep = ArticleManager::setInfo($wzStep, $data);
            $result = $wzStep->save();
        } else {
            $data['status'] = 0;    //新建 及编辑文章 设置为隐藏状态
            $wzStep = ArticleManager::setInfo($wzStep, $data);
            $result = $wzStep->save();
            $tw = new TWStep();
            $tw['f_id'] = $wzStep['id'];
            $tw['f_table'] = 'article';
            $tw->save();
        }


        if ($result) {
            return ApiResponse::makeResponse(true, $wzStep, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, "添加失败", ApiResponse::INNER_ERROR);
        }
    }


    /*
     * 获取资讯的二维码
     *
     * By TerryQi
     *
     * 2018-03-29
     */
    public function ewm(Request $request)
    {
        $data = $request->all();
        $admin = $request->session()->get('admin');
//        dd($data);
        //合规校验
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $filename = 'zixun_' . $data['id'] . '.png';
        //判断文件是否存在
        if (file_exists(public_path('img/') . $filename)) {
//            dd("file exists");
        } else {
            $app = app('wechat.mini_program');
            $response = $app->app_code->get('pages/articleDetail/articleDetail?articleId=' . $data['id']);
            $response->saveAs(public_path('img'), 'zixun_' . $data['id'] . '.png');
        }
        return view('admin.article.ewm', ['admin' => $admin, 'filename' => $filename]);
    }


    /*
      * 删除文章
      *
      *
      *
      *
      */
    public function delDetailWz(Request $request)
    {
        $data = $request->all();
        //合规校验
        $requestValidationResult = RequestValidator::validator($data, [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }

        $contribute = ArticleManager::getById($data['id']);

        $contribute['status'] = 2;    //删除 设置文章status状态为2
        $contribute = ArticleManager::setInfo($contribute, $contribute);
        $result = $contribute->save();
        if ($result) {
            return ApiResponse::makeResponse(true, '删除成功', ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, '删除失败', ApiResponse::INNER_ERROR);
        }
    }


    /*
     * 恢复删除的文章
     *
     *
     *
     *
     */
    public function regain(Request $request)
    {
        $data = $request->all();
        //合规校验
        $requestValidationResult = RequestValidator::validator($data, [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }

        $contribute = ArticleManager::getById($data['id']);

        $contribute['status'] = 0;    //恢复 设置文章status状态为0
        $contribute = ArticleManager::setInfo($contribute, $contribute);
        $result = $contribute->save();
        if ($result) {
            return ApiResponse::makeResponse(true, '恢复成功', ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, '恢复失败', ApiResponse::INNER_ERROR);
        }
    }


}



