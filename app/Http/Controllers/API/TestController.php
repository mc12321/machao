<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/9
 * Time: 13:29
 */

namespace App\Http\Controllers\API;


use App\Components\GuanZhuManager;
use App\Components\ArticleManager;
use App\Components\RequestValidator;
use App\Components\ADManager;
use App\Components\UserManager;
use App\Components\Utils;
use App\Components\WechatManager;
use App\Components\ZanManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\GuanZhu;
use App\Models\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

    public function test(Request $request)
    {
        $data = $request->all();

        $requestValidationResult = RequestValidator::validator($request->all(), [
            'test' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }

        $test = $data['test'];

        return ApiResponse::makeResponse(true, $test, ApiResponse::SUCCESS_CODE);

    }


}





