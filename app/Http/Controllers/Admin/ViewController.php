<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/25
 * Time: 14:54
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Components\RequestValidator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiResponse;
use Illuminate\Support\Facades\Log;

class ViewController extends Controller
{

    public function index(Request $request)
    {
//        $data = $request->all();
//
       $session_val = session('wechat.oauth_user'); // 拿到授权用户资料
dd($session_val);
        Log::info(__METHOD__ . " " . 'session_val:' . json_encode($session_val));
        $param = [
            'session_val' => $session_val,
        ];
        return view('admin.show.index',$param);

    }
}