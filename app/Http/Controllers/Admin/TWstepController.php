<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/9
 * Time: 11:32
 */

namespace App\Http\Controllers\Admin;

use App\Components\TWStepManager;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;

class TWstepController
{

    //删除图文详情
    public function delDetail(Request $request)
    {
        $data = $request->all();
        if (array_key_exists('id', $data)) {
            $id = $data['id'];
            if (is_numeric($id) !== true) {
                return ApiResponse::makeResponse(false, ApiResponse::$returnMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
            } else {
                $twStep = TWStepManager::getById($id);
                //查询如果文章详情大于一条时可以删除 等于一条时设置为空 不然点击编辑图为 tw表无对应值会报错
                $con_arr = array(
                    'f_id' => $twStep['f_id'],
                );
                $twSteps = TWStepManager::getListByCon($con_arr, false);
                if ($twSteps->count() > 1) {
                    $result = $twStep->delete();
                } else {
                    $twStep['img'] = null;
                    $twStep['text'] = null;
                    $twStep['video'] = null;
                    $result = $twStep->save();
                }
                if ($result) {
                    return ApiResponse::makeResponse(true, false, ApiResponse::SUCCESS_CODE);
                } else {
                    return ApiResponse::makeResponse(false, false, ApiResponse::INNER_ERROR);
                }
            }
        } else {
            return ApiResponse::makeResponse(false, false, ApiResponse::MISSING_PARAM);
        }
        return $return;
    }


}





