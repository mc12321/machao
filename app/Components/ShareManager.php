<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/6/26
 * Time: 10:40
 */

namespace App\Components;


use App\Components\DateTool;
use App\Components\Utils;
use Illuminate\Support\Facades\Log;

class ShareManager
{
    /*
     * 生成投稿二维码
     * By mtt
     * 2018-6-26
     */
    public static function createQRCode($contribute_id, $event_id)
    {
        $filename = 'contribute_' . $contribute_id . '.jpg';
        //判断文件是否存在
        if (true == false) {        //临时码取消逻辑
//            dd("file exists");
        } else {
            $app = app('wechat.mini_program');
            //生成二维码

            $response = $app->app_code->getUnlimit($contribute_id . 'a' . $event_id, [
                'width' => 280,
                'page' => 'pages/draftDetails/draftDetails',

            ]);
//            dd($response);
            //将拼好信息保存成图片
            $response->saveAs(public_path('img'), 'contribute_' . $contribute_id . '.jpg');
        }
        return $filename;
    }

    /*
     * 创建分享图片
     * By mtt
     * 2018-6-26
     */
    public static function createShareTP($contribute_id, $event_id, $user_id)
    {
        $filename = 'contribute_' . $contribute_id . '_ShareTP.jpg';
        //判断文件是否存在
        if (true == false) {
            Log::info($filename . " file exists");
        } else {
            //二维码图片名称
            $contribute_share_code_filename = self::eventEwm($event_id);
            //创建底图
            $path_1 = public_path('img/share/event_base.jpg');
            $image_1 = imagecreatefromjpeg($path_1);
            //创建二维码图
            $path_2 = public_path('img/') . $contribute_share_code_filename;
            //    dd($path_2);
            $image_2 = imagecreatefromjpeg($path_2);

            //创建投稿标题图片
            //获取投稿信息
            $contribute = ArticleManager::getById($contribute_id);
//            dd($contribute);
            $contribute_title = $contribute['title'];
//            dd($contribute['title']);
            //判断标题长度
            $contribute_title_length = mb_strlen($contribute_title, "utf-8");
            if ($contribute_title_length > 12) {
                $contribute_title = mb_substr($contribute_title, 0, 8, 'utf-8') . "...";
            }

            //创建一个投稿标题的图片
            $im_3 = imagecreate(1008, 100);
            $background_color_3 = ImageColorAllocate($im_3, 255, 255, 255);
            $col = imagecolorallocate($im_3, 0, 0, 0);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $come = iconv('UTF-8', 'UTF-8', $contribute_title);
//            dd(mb_detect_encoding($come));
            imagettftext($im_3, 30, 0, 5, 30, $col, $font, $come);
            imagejpeg($im_3, 'img/' . $contribute_title . '.jpg');
//            imagedestroy($im_3);
//            dd($contribute_title);
            $path_3 = public_path('img/') . $contribute_title . '.jpg';
//            dd($path_3);
            $image_3 = imagecreatefromjpeg($path_3);

            //用户头像
            $path_4 = public_path('img/share/avatar.jpg');
            $image_4 = self::yuanjiao($path_4);
            //昵称
            $path_5 = public_path('img/share/name_time.jpg');
            $image_5 = imagecreatefromjpeg($path_5);
            //时间
            $path_6 = public_path('img/share/name_time.jpg');
            $image_6 = imagecreatefromjpeg($path_6);


            //创建文章创建 时间图片
            $im_6 = imagecreate(300, 120);
            $background_color_3 = ImageColorAllocate($im_6, 255, 255, 255);
            $col = imagecolorallocate($im_6, 161, 161, 161);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $come = iconv('UTF-8', 'UTF-8', DateTool::format('Y-m-d', $contribute->created_at));
            imagettftext($im_6, 22, 0, 5, 30, $col, $font, $come);
//            imagepng($im,"images/circle.png")
            imagejpeg($im_6, 'img/' . DateTool::format('Y-m-d', $contribute->created_at) . '.jpg');
            imagedestroy($im_6);
            $path_6 = public_path('img/') . DateTool::format('Y-m-d', $contribute->created_at) . '.jpg';
            $image_6 = imagecreatefromjpeg($path_6);

            //获取文章作者名称
            $user_zz = UserManager::getById($contribute['user_id']);
            $zz_name = '暂未设置称昵';
            if ($user_zz) {
                $zz_name = $user_zz['nick_name'];
            }
            $im_12 = imagecreate(250, 120);
            $background_color_3 = ImageColorAllocate($im_12, 255, 255, 255);
            $col = imagecolorallocate($im_12, 161, 161, 161);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $come = iconv('UTF-8', 'UTF-8','作者：'. $zz_name);
            imagettftext($im_12, 22, 0, 5, 30, $col, $font, $come);
            imagejpeg($im_12, 'img/' . $zz_name . '_zz.jpg');
            imagedestroy($im_12);
            $path_12 = public_path('img/') . $zz_name . '_zz.jpg';
            $image_12 = imagecreatefromjpeg($path_12);


            //获取用户信息
            if ($user_id) {

                $user = UserManager::getById($user_id);
                //用户头像
                $path_4 = $user->avatar;
//                self::GrabImage($path_4, $user->nick."png");
//                $image_4 = imagecreatefromjpeg($path_4);
                if ($path_4 == null) {    //如果没有用户头像设置默认头像
                    $path_4 = 'https://dekuaiwen.isart.me/img/448728677088756580.png';
                }
                $image_4 = self::yuanjiao($path_4);

                //创建一个当前用户昵称的图片
                $im_5 = imagecreate(500, 200);
                $background_color_3 = ImageColorAllocate($im_5, 255, 255, 255);
                $col = imagecolorallocate($im_5, 161, 161, 161);
                $font = public_path('docs/css/fonts/msyh.ttf');
                $come = iconv('UTF-8', 'UTF-8', $user->nick_name . '   正在阅读这篇文章');
                imagettftext($im_5, 20, 0, 5, 30, $col, $font, $come);
                imagejpeg($im_5, 'img/' . $user->nick_name . '.jpg');
                imagedestroy($im_5);
                $path_5 = public_path('img/') . $user->nick_name . '.jpg';
                $image_5 = imagecreatefromjpeg($path_5);


            }
            //获取投稿详情信息
            $con_arr_tw_info = array(
                'wz_id' => $contribute_id,
            );
            $contributeTwInfos = ArticleManager::getListByCon($con_arr_tw_info, false);


            // 标题及封面图片
            $contributeTwInfo_text = '暂无标题';

            $contributeTwInfo_desc = '此文章值得阅读';

            $contributeTwInfo_img_arr = [];
            foreach ($contributeTwInfos as $contributeTwInfo) {
                if (!Utils::isObjNull($contributeTwInfo->name)) {
                    $contributeTwInfo_text = $contributeTwInfo->name;
                }
                if (!Utils::isObjNull($contributeTwInfo->img)) {
                    array_push($contributeTwInfo_img_arr, $contributeTwInfo->img);
                }

                if (!Utils::isObjNull($contributeTwInfo->desc)) {
                  //  $contributeTwInfo_desc = $contributeTwInfo->desc;
                    $contributeTwInfo_desc = '此文章值得阅读';
                }

            }
            //    dd($contributeTwInfo_text);
//            $contributeTwInfo_img = $contributeTwInfos->first();
//            dd($contributeTwInfo_img_arr[0]);
            $contributeTwInfo_img = $contributeTwInfo_img_arr[0];

            //投稿详情文字
            //创建一个投稿详情文字的图片
            $im_7 = imagecreate(1008, 130);
            $background_color_3 = ImageColorAllocate($im_7, 255, 255, 255);
            $col = imagecolorallocate($im_7, 0, 0, 0);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $contributeTwInfo_text = str_replace("<br/>", " ", $contributeTwInfo_text);
            $contribute_text_length = mb_strlen($contributeTwInfo_text, "utf-8");
            if ($contribute_text_length != '0') {
                $contributeTwInfo_text = self::autowrap(35, 0, $font, $contributeTwInfo_text, 1000); // 自动换行处理

                // 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
            }
            $come = iconv('UTF-8', 'UTF-8', $contributeTwInfo_text);
            //设置字体大小
            imagettftext($im_7, 35, 0, 5, 55, $col, $font, $come);
//            imagepng($im,"images/circle.png")
            imagejpeg($im_7, 'img/' . mb_substr($contributeTwInfo_text, 0, 8, 'utf-8') . '.jpg');
            imagedestroy($im_7);
            $path_7 = public_path('img/') . mb_substr($contributeTwInfo_text, 0, 8, 'utf-8') . '.jpg';
            $image_7 = imagecreatefromjpeg($path_7);


            //投稿详情文字
            //创建一个投稿详情文字的图片
            $im_9 = imagecreate(1008, 100);
            $background_color_3 = ImageColorAllocate($im_9, 255, 255, 255);
            $col = imagecolorallocate($im_9, 104, 104, 104);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $contributeTwInfo_text = str_replace("<br/>", " ", $contributeTwInfo_desc);
            $contribute_text_length = mb_strlen($contributeTwInfo_desc, "utf-8");
            if ($contribute_text_length != '0') {
                $contributeTwInfo_text = self::autowrap(40, 0, $font, $contributeTwInfo_desc, 1000); // 自动换行处理

                // 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
            }
            $come = iconv('UTF-8', 'UTF-8', $contributeTwInfo_desc);
            //设置字体大小
            imagettftext($im_9, 27, 0, 5, 55, $col, $font, $come);
            imagejpeg($im_9, 'img/' . mb_substr($contributeTwInfo_desc, 0, 8, 'utf-8') . '.jpg');
            imagedestroy($im_9);
            $path_9 = public_path('img/') . mb_substr($contributeTwInfo_desc, 0, 8, 'utf-8') . '.jpg';
            $image_9 = imagecreatefromjpeg($path_9);


            //创建一个自定义图片
            $im_10 = imagecreate(504, 100);
            $background_color_3 = ImageColorAllocate($im_10, 255, 255, 255);
            $col = imagecolorallocate($im_10, 0, 0, 0);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $contributeTwInfo_text = str_replace("<br/>", " ", '长按扫码');
            $contribute_text_length = mb_strlen('长按扫码', "utf-8");
            if ($contribute_text_length != '0') {
                $contributeTwInfo_text = self::autowrap(40, 0, $font, '长按扫码', 1000); // 自动换行处理
            }
            $come = iconv('UTF-8', 'UTF-8', '长按扫码');
            //设置字体大小
            imagettftext($im_10, 30, 0, 5, 55, $col, $font, $come);
            imagejpeg($im_10, 'img/' . mb_substr('长按扫码', 0, 8, 'utf-8') . '.jpg');
            imagedestroy($im_10);
            $path_10 = public_path('img/') . mb_substr('长按扫码', 0, 8, 'utf-8') . '.jpg';
            $image_10 = imagecreatefromjpeg($path_10);


            //创建一个自定义图片2
            $im_11 = imagecreate(604, 100);
            $background_color_3 = ImageColorAllocate($im_11, 255, 255, 255);
            $col = imagecolorallocate($im_11, 0, 0, 0);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $contributeTwInfo_text = str_replace("<br/>", " ", '进入            阅读全文');
            $contribute_text_length = mb_strlen('进入            阅读全文', "utf-8");
            if ($contribute_text_length != '0') {
                $contributeTwInfo_text = self::autowrap(40, 0, $font, '进入            阅读全文', 1000); // 自动换行处理
            }
            $come = iconv('UTF-8', 'UTF-8', '进入            阅读全文');
            //设置字体大小
            imagettftext($im_11, 30, 0, 5, 55, $col, $font, $come);
            imagejpeg($im_11, 'img/' . mb_substr('进入快文阅读全文', 0, 8, 'utf-8') . '.jpg');
            imagedestroy($im_11);
            $path_11 = public_path('img/') . mb_substr('进入快文阅读全文', 0, 8, 'utf-8') . '.jpg';
            $image_11 = imagecreatefromjpeg($path_11);



            //创建一个自定义图片  快文
            $im_13 = imagecreate(100, 100);
            $background_color_3 = ImageColorAllocate($im_13, 255, 255, 255);
            $col = imagecolorallocate($im_13, 251, 2, 0);
            $font = public_path('docs/css/fonts/msyh.ttf');
            $contributeTwInfo_text = str_replace("<br/>", " ", '快文');
            $contribute_text_length = mb_strlen('快文', "utf-8");
            if ($contribute_text_length != '0') {
                $contributeTwInfo_text = self::autowrap(40, 0, $font, '快文', 1000); // 自动换行处理
            }
            $come = iconv('UTF-8', 'UTF-8', '快文');
            //设置字体大小
            imagettftext($im_13, 30, 0, 5, 55, $col, $font, $come);
            imagejpeg($im_13, 'img/' . mb_substr('快文', 0, 8, 'utf-8') . '.jpg');
            imagedestroy($im_13);
            $path_13 = public_path('img/') . mb_substr('快文', 0, 8, 'utf-8') . '.jpg';
            $image_13 = imagecreatefromjpeg($path_13);



            //创建一个投稿详情图片的图片
            //投稿第一张图片
            $path_8 = null;
            if (Utils::isObjNull($contributeTwInfo_img)) {
                $path_8 = public_path('img/share/base_map.jpg') . '?imageView2/1/w/400/h/300/interlace/1/q/75';
            } else {
                $path_8 = $contributeTwInfo_img . '?imageView2/1/w/400/h/400/interlace/1/q/75';
            }
            //判断投稿图片格式
//            $ext = pathinfo($path_8);
            $ext = strrchr($path_8, '.');
//            dd($ext);
            $image_8 = null;
            switch ($ext) {
                case '.jpg?imageView2/1/w/400/h/400/interlace/1/q/75':
                    $image_8 = imagecreatefromjpeg($path_8);
                    break;
                case '.png?imageView2/1/w/400/h/400/interlace/1/q/75':
                    $image_8 = imagecreatefrompng($path_8);
                    break;
            }
//            $image_8 = imagecreatefromjpeg($path_8);

            //二维码
            list($width, $height) = getimagesize($path_2);
            $ewm_width = 280;
            $ewm_height = 280;
            $image_2_resize = imagecreatetruecolor($ewm_width, $ewm_height);
            imagecopyresized($image_2_resize, $image_2, 0, 0, 0, 0, $ewm_width, $ewm_height, $width, $height);

            //投稿标题
            list($width, $height) = getimagesize($path_3);
            $tg_width = 1008;
            $tg_height = 100;
            $image_3_resize = imagecreatetruecolor($tg_width, $tg_height);
            imagecopyresized($image_3_resize, $image_3, 0, 0, 0, 0, $tg_width, $tg_height, $width, $height);

            //用户头像信息
            list($width, $height) = getimagesize($path_4);
            $tx_width = 100;
            $tx_height = 100;
            //添加背景色，给图片image_4
            $bg = imagecolorallocate($image_4, 255, 255, 255);
            imagefill($image_4, 0, 0, $bg);
            $image_4_resize = imagecreatetruecolor($tx_width, $tx_height);
//            dd($image_4_resize);
            imagecopyresized($image_4_resize, $image_4, 0, 0, 0, 0, $tx_width, $tx_height, $width, $height);
            ImageColorTransparent($image_4, 255);

            //用户昵称
            list($width, $height) = getimagesize($path_5);
            $nickname_width = 500;
            $nickname_height = 250;
            $image_5_resize = imagecreatetruecolor($nickname_width, $nickname_height);
            imagecopyresized($image_5_resize, $image_5, 0, 0, 0, 0, $nickname_width, $nickname_height, $width, $height);

            //文章时间
            list($width, $height) = getimagesize($path_6);
            $time_width = 300;
            $time_height = 150;
            $image_6_resize = imagecreatetruecolor($time_width, $time_height);
            imagecopyresized($image_6_resize, $image_6, 0, 0, 0, 0, $time_width, $time_height, $width, $height);


            //文章 作者名称
            list($width, $height) = getimagesize($path_12);
            $details_width = 300;
            $details_height = 150;
            $image_12_resize = imagecreatetruecolor($details_width, $details_height);
            imagecopyresized($image_12_resize, $image_12, 0, 0, 0, 0, $details_width, $details_height, $width, $height);



            //投稿详情文字
            list($width, $height) = getimagesize($path_7);
            $detailsWZ_width = 1008;
            $detailsWZ_height = 130;
            $image_7_resize = imagecreatetruecolor($detailsWZ_width, $detailsWZ_height);
            imagecopyresized($image_7_resize, $image_7, 0, 0, 0, 0, $detailsWZ_width, $detailsWZ_height, $width, $height);

            //投稿详情图片
            list($width, $height) = getimagesize($path_8);
            $detailsTP_width = 1008;
            $detailsTP_height = 800;
            $image_8_resize = imagecreatetruecolor($detailsTP_width, $detailsTP_height);
            imagecopyresized($image_8_resize, $image_8, 0, 0, 0, 0, $detailsTP_width, $detailsTP_height, $width, $height);


            //投稿详情文字
            list($width, $height) = getimagesize($path_9);
            $detailsWZ_width = 1008;
            $detailsWZ_height = 100;
            $image_9_resize = imagecreatetruecolor($detailsWZ_width, $detailsWZ_height);
            imagecopyresized($image_9_resize, $image_9, 0, 0, 0, 0, $detailsWZ_width, $detailsWZ_height, $width, $height);


            //自定义文字
            list($width, $height) = getimagesize($path_10);
            $detailsWZ_width = 504;
            $detailsWZ_height = 100;
            $image_10_resize = imagecreatetruecolor($detailsWZ_width, $detailsWZ_height);
            imagecopyresized($image_10_resize, $image_10, 0, 0, 0, 0, $detailsWZ_width, $detailsWZ_height, $width, $height);


            //自定义文字2
            list($width, $height) = getimagesize($path_11);
            $detailsWZ_width = 604;
            $detailsWZ_height = 100;
            $image_11_resize = imagecreatetruecolor($detailsWZ_width, $detailsWZ_height);
            imagecopyresized($image_11_resize, $image_11, 0, 0, 0, 0, $detailsWZ_width, $detailsWZ_height, $width, $height);





            //自定义文字 快文
            list($width, $height) = getimagesize($path_13);
            $detailsWZ_width = 100;
            $detailsWZ_height = 100;
            $image_13_resize = imagecreatetruecolor($detailsWZ_width, $detailsWZ_height);
            imagecopyresized($image_13_resize, $image_13, 0, 0, 0, 0, $detailsWZ_width, $detailsWZ_height, $width, $height);


            //新建一个真彩色图片，imagesx取$image_1的取得图像宽度，imagesy取$image_1的取得图像高度
            //底图
            $image_9 = imageCreatetruecolor(imagesx($image_1), imagesy($image_1));
            //为图像分配颜色
            $color = imagecolorallocate($image_9, 255, 255, 255);
            // 区域填充
            imagefill($image_9, 0, 0, $color);
            // 将某个颜色定义为透明色
            imageColorTransparent($image_9, $color);
            //重采样拷贝部分图像并调整大小
            imagecopyresampled($image_9, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));

            //拷贝并合并图像二维码部分
            imagecopymerge($image_9, $image_2_resize, 700, 1150, 0, 0, imagesx($image_2_resize), imagesy($image_2_resize), 100);

            //拷贝并合并图像投稿标题部分
            imagecopymerge($image_9, $image_3_resize, 10, 0, 0, 0, imagesx($image_3_resize), imagesy($image_3_resize), 100);

            //拷贝并合并图像用户头像部分
            imagecopymerge($image_9, $image_4_resize, 20, 1105, 0, 0, imagesx($image_4_resize), imagesy($image_4_resize), 100);

            //拷贝并合并图像用户昵称部分
            imagecopymerge($image_9, $image_5_resize, 160, 1125, 0, 0, imagesx($image_5_resize), imagesy($image_5_resize), 100);


            //作者姓名
            imagecopymerge($image_9, $image_12_resize, 20, 955, 0, 0, imagesx($image_12_resize), imagesy($image_12_resize), 100);

            //拷贝并合并图像用户时间部分
            imagecopymerge($image_9, $image_6_resize, 270, 955, 0, 0, imagesx($image_6_resize), imagesy($image_6_resize), 100);



            //拷贝并合并投稿详情文字部分
            imagecopymerge($image_9, $image_7_resize, 20, 820, 0, 0, imagesx($image_7_resize), imagesy($image_7_resize), 100);

            //拷贝并合并投稿详情图片部分
            imagecopymerge($image_9, $image_8_resize, 0, 0, 0, 0, imagesx($image_8_resize), imagesy($image_8_resize), 100);


            //文章desc
            imagecopymerge($image_9, $image_9_resize, 20, 995, 0, 0, imagesx($image_9_resize), imagesy($image_9_resize), 100);

            //自定义文字
            imagecopymerge($image_9, $image_10_resize, 20, 1250, 0, 0, imagesx($image_10_resize), imagesy($image_10_resize), 100);


            //自定义文字2
            imagecopymerge($image_9, $image_11_resize, 20, 1350, 0, 0, imagesx($image_11_resize), imagesy($image_11_resize), 100);


            //自定义文字  快文
            imagecopymerge($image_9, $image_13_resize, 130, 1350, 0, 0, imagesx($image_13_resize), imagesy($image_13_resize), 100);



            //输出图片
            imagejpeg($image_9, public_path('img/') . $filename);
        }
        return $filename;
    }


    /*
     * 文字换行
     */
    public static function autowrap($fontsize, $angle, $fontface, $string, $width)
    {
        // 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
        $content = "";
        // 将字符串拆分成一个个单字 保存到数组 letter 中
        for ($i = 0; $i < mb_strlen($string); $i++) {
            $letter[] = mb_substr($string, $i, 1);
        }
        foreach ($letter as $l) {
            $teststr = $content . " " . $l;
            $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
            // 判断拼接后的字符串是否超过预设的宽度
            if (($testbox[2] > $width) && ($content !== "")) {
                $content .= "\n";
            }
            $content .= $l;
        }
        return $content;
    }


    /*
    * 将图片切成圆角
    */
    public static function yuanjiao($imgpath)
    {
        //获取图片格式
        $imgpath_gsh = getimagesize($imgpath);
        $src_img = null;
     //   dd($imgpath_gsh);
        switch ($imgpath_gsh['mime']) {
            case 'image/jpeg':
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 'image/png':
                $src_img = imagecreatefrompng($imgpath);
                break;
        }
        $wh = getimagesize($imgpath);
//        dd($wh);
        $w = $wh[0];
        $h = $wh[1];
        $w = min($w, $h);
        $h = $w;
        $img = imagecreatetruecolor($w, $h);
//        dd($img);
//        imagepng(imagecreatefromstring(file_get_contents($img), $img.".png"));
//        dd($img);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 248, 248, 248, 248);
        imagefill($img, 0, 0, $bg);
        $r = $w / 2; //圆半径
        $y_x = $r; //圆心X坐标
        $y_y = $r; //圆心Y坐标
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
            }
        }
//        imagefill($img, 0, 0, $bg);
//        dd($img);
        return $img;
    }

    /*
     * 创建活动二维码
     *
     * by mtt
     *
     * 2018-7-15
     */
    public static function eventEwm($event_id)
    {

        $filename = 'event_' . $event_id . '.jpg';
        //判断文件是否存在
        if (file_exists(public_path('img/') . $filename)) {
//            dd("file exists");

        } else {
            $app = app('wechat.mini_program');



            $response = $app->app_code->get('pages/articleDetail/articleDetail?articleId=' . $event_id, [
                'width' => 280
            ]);


            $response->saveAs(public_path('img'), 'event_' . $event_id . '.jpg');

        }
        return $filename;

    }

    /*
     * 创建活动图片
     *
     * By mtt
     *
     * 2018-7-15
     */
    public static function
    createShareEventTP($event_id)
    {
        $filename = 'event' . $event_id . '_EventShareTP.jpg';
        //判断文件是否存在
        if (true == false) {
            Log::info($filename . " file exists");
        } else {
            //二维码图片名称
            $event_share_code_filename = self::eventEwm($event_id);


//            dd($event_share_code_filename);

            //创建底图
            $path_1 = public_path('img/event_base.png');
            $image_1 = imagecreatefrompng($path_1);
            //创建二维码图
            $path_2 = public_path('img/') . $event_share_code_filename;
            //   dd($path_2);
            $image_2 = imagecreatefromjpeg($path_2);

            //查询活动信息

            $event = ArticleManager::getById($event_id);

            //获取活动标题图片
            $event_title = $event->name;
            $im_3 = imagecreate(1008, 100);
            $background_color_3 = ImageColorAllocate($im_3, 255, 255, 255);
            $col = imagecolorallocate($im_3, 0, 0, 0);
            $font = public_path('docs/css/fonts/msyh.ttf');
//            dd($font);
            $come = iconv('UTF-8', 'UTF-8', $event_title);
//            dd($come);
//            dd(mb_detect_encoding($come));
            imagettftext($im_3, 30, 0, 0, 60, $col, $font, $come);
            imagejpeg($im_3, 'img/' . $event_title . '.jpg');
//            imagedestroy($im_3);
//            dd($contribute_title);
            $path_3 = public_path('img/') . $event_title . '.jpg';
            //    dd($path_3);
            $image_3 = imagecreatefromjpeg($path_3);


//            //获取活动时间
//            $event_time = $event->status;
//
//            $im_time = imagecreate(50, 100);
//            $col = imagecolorallocate($im_time, 0, 0, 0);
//            $font = public_path('docs/css/fonts/msyh.ttf');
//         //   dd($col);
//            $come = iconv('UTF-8', 'UTF-8', $event_time);
////            dd($come);
////            dd(mb_detect_encoding($come));
//            imagettftext($im_time, 10, 0, 0, 30, $col, $font, $come);
//            imagejpeg($im_time, 'img/' . $event_time . '.jpg');
////            imagedestroy($im_3);
//            $path_time = public_path('img/') . $event_time . '.jpg';
////            dd($path_time);
//            $image_time = imagecreatefromjpeg($path_time);


            //获取活动封皮
            $event_img = $event->img;
            $path_4 = $event_img . '?imageView2/1/w/400/h/400/interlace/1/q/75';
//            dd($path_8);
            //判断投稿图片格式
//            $ext = pathinfo($path_8);
            $ext = strrchr($path_4, '.');
//            dd($ext);
            $image_4 = null;
            switch ($ext) {
                case '.jpg?imageView2/1/w/400/h/400/interlace/1/q/75':
                    $image_4 = imagecreatefromjpeg($path_4);
                    break;
                case '.png?imageView2/1/w/400/h/400/interlace/1/q/75':
                    $image_4 = imagecreatefrompng($path_4);
                    break;
            }

            //二维码
            list($width, $height) = getimagesize($path_2);
            $ewm_width = 280;
            $ewm_height = 280;
            $image_2_resize = imagecreatetruecolor($ewm_width, $ewm_height);
            imagecopyresized($image_2_resize, $image_2, 0, 0, 0, 0, $ewm_width, $ewm_height, $width, $height);

            //活动标题
            $img3_size = getimagesize($path_3);//获取标题大小
            list($width, $height) = getimagesize($path_3);
            $name_width = 1008;
            $name_height = 100;
            $image_3_resize = imagecreatetruecolor($name_width, $name_height);
            imagecopyresized($image_3_resize, $image_3, 0, 0, 0, 0, $name_width, $name_height, $width, $height);

//            //活动时间
//            $img_time_size=getimagesize($path_time);//获取时间大小
//            list($width, $height) = getimagesize($path_time);
//            $name_width = 500;
//            $name_height = 50;
//            $image_time_resize = imagecreatetruecolor($name_width, $name_height);
//            imagecopyresized($image_time_resize, $image_time, 0, 0, 0, 0, $name_width, $name_height, $width, $height);


            //活动图片
            list($width, $height) = getimagesize($path_4);
            $eventTP_width = 1132;
            $eventTP_height = 760;
            $image_4_resize = imagecreatetruecolor($eventTP_width, $eventTP_height);
            imagecopyresized($image_4_resize, $image_4, 0, 0, 0, 0, $eventTP_width, $eventTP_height, $width, $height);

            //获取底图真实大小
            $img1_size = getimagesize($path_1);

            //新建一个真彩色图片，imagesx取$image_1的取得图像宽度，imagesy取$image_1的取得图像高度
            //底图
            $image_9 = imageCreatetruecolor(imagesx($image_1), imagesy($image_1));
            //为图像分配颜色
            $color = imagecolorallocate($image_9, 255, 255, 255);
            // 区域填充
            imagefill($image_9, 0, 0, $color);
            // 将某个颜色定义为透明色
            imageColorTransparent($image_9, $color);
            //重采样拷贝部分图像并调整大小
            imagecopyresampled($image_9, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));

            //拷贝并合并图像二维码部分
            imagecopymerge($image_9, $image_2_resize, 426, 1000, 0, 0, imagesx($image_2_resize), imagesy($image_2_resize), 100);

            //拷贝并合并活动标题部分-40
            imagecopymerge($image_9, $image_3_resize, $img1_size[0] - $img3_size[0], 850, 0, 0, imagesx($image_3_resize), imagesy($image_3_resize), 100);

//            //拷贝并合并活动时间部分-40
//            imagecopymerge($image_9, $image_time_resize, $img1_size[0]-$img_time_size[0]-$img3_size[0], 850, 0, 0, imagesx($image_time_resize), imagesy($image_time_resize), 100);


            //拷贝并合并活动图片部分
            imagecopymerge($image_9, $image_4_resize, 0, 0, 0, 0, imagesx($image_4_resize), imagesy($image_4_resize), 100);

            //输出图片
            imagejpeg($image_9, public_path('img/') . $filename);
        }

        return $filename;
    }

    public static function get_lt_rounder_corner($radius)
    {
        $img = imagecreatetruecolor($radius, $radius);    // 创建一个正方形的图像
        $bgcolor = imagecolorallocate($img, 223, 0, 0);     // 图像的背景
        $fgcolor = imagecolorallocate($img, 0, 0, 0);
        imagefill($img, 0, 0, $bgcolor);
        // $radius,$radius：以图像的右下角开始画弧
        // $radius*2, $radius*2：已宽度、高度画弧
        // 180, 270：指定了角度的起始和结束点
        // fgcolor：指定颜色
        imagefilledarc($img, $radius, $radius, $radius * 2, $radius * 2, 180, 270, $fgcolor, IMG_ARC_PIE);
        // 将弧角图片的颜色设置为透明
        imagecolortransparent($img, $fgcolor);
        // 变换角度
        // $img	= imagerotate($img, 90, 0);
        // $img	= imagerotate($img, 180, 0);
        // $img	= imagerotate($img, 270, 0);
        // header('Content-Type: image/png');
        // imagepng($img);
        return $img;
    }


    /*
     * 分享小程序图片
     *
     * By mtt
     *
     * 2018-7-15
     */
    public static function
    createShareEventTPXCX()
    {
        $filename = 'eventerweima_EventShareTP.jpg';
        //判断文件是否存在
        if (true == false) {
            Log::info($filename . " file exists");
        } else {


            //创建底图
            $path_1 = public_path('img/event_base.png');
            $image_1 = imagecreatefrompng($path_1);


            //创建二维码图
            $path_2 = public_path('img/761825178710302223.jpg');
            $image_2 = imagecreatefromjpeg($path_2);

            //查询活动信息

            //     $event = UserManager::getById($event_id);

            //获取活动标题图片
            $event_title = '';
            $im_3 = imagecreate(1008, 100);
            $background_color_3 = ImageColorAllocate($im_3, 255, 255, 255);
            $col = imagecolorallocate($im_3, 0, 0, 0);
            $font = public_path('docs/css/fonts/msyh.ttf');
//            dd($font);
            $come = iconv('UTF-8', 'UTF-8', $event_title);
//            dd(mb_detect_encoding($come));
            imagettftext($im_3, 30, 0, 0, 60, $col, $font, $come);
            imagejpeg($im_3, 'img/' . $event_title . '.jpg');
//            imagedestroy($im_3);
//            dd($contribute_title);
            $path_3 = public_path('img/') . $event_title . '.jpg';
//            dd($path_3);
            $image_3 = imagecreatefromjpeg($path_3);
            //获取活动标题图片的


            //上半部分图片
            $path_4 = public_path('img/761825178710302223.jpg');
//            dd($path_8);
            //判断投稿图片格式
//            $ext = pathinfo($path_8);
            $ext = strrchr($path_4, '.');
            //     dd($ext);
            $image_4 = null;
            switch ($ext) {
                case '.jpg':
                    $image_4 = imagecreatefromjpeg($path_4);

                    break;
                case '.png':
                    $image_4 = imagecreatefrompng($path_4);
                    break;
            }

            //二维码
            list($width, $height) = getimagesize($path_2);
            $ewm_width = 320;
            $ewm_height = 320;
            $image_2_resize = imagecreatetruecolor($ewm_width, $ewm_height);
            imagecopyresized($image_2_resize, $image_2, 0, 0, 0, 0, $ewm_width, $ewm_height, $width, $height);

            //活动标题
            $img3_size = getimagesize($path_3);//获取标题大小
            list($width, $height) = getimagesize($path_3);
            $name_width = 1008;
            $name_height = 100;
            $image_3_resize = imagecreatetruecolor($name_width, $name_height);
            imagecopyresized($image_3_resize, $image_3, 0, 0, 0, 0, $name_width, $name_height, $width, $height);

            //活动图片
            //   dd($path_4);
            list($width, $height) = getimagesize($path_4);
            $eventTP_width = 700;
            $eventTP_height = 700;
            $image_4_resize = imagecreatetruecolor($eventTP_width, $eventTP_height);
            imagecopyresized($image_4_resize, $image_4, 0, 0, 0, 0, $eventTP_width, $eventTP_height, $width, $height);

            //获取底图真实大小
            $img1_size = getimagesize($path_1);

            //新建一个真彩色图片，imagesx取$image_1的取得图像宽度，imagesy取$image_1的取得图像高度
            //底图
            $image_9 = imageCreatetruecolor(imagesx($image_1), imagesy($image_1));
            //为图像分配颜色
            $color = imagecolorallocate($image_9, 255, 255, 255);
            // 区域填充
            imagefill($image_9, 0, 0, $color);
            // 将某个颜色定义为透明色
            imageColorTransparent($image_9, $color);
            //重采样拷贝部分图像并调整大小
            imagecopyresampled($image_9, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));

            //拷贝并合并图像二维码部分
            imagecopymerge($image_9, $image_2_resize, 426, 1000, 0, 0, imagesx($image_2_resize), imagesy($image_2_resize), 100);

            //拷贝并合并活动标题部分-40
            imagecopymerge($image_9, $image_3_resize, $img1_size[0] - $img3_size[0], 850, 0, 0, imagesx($image_3_resize), imagesy($image_3_resize), 100);

            //拷贝并合并活动图片部分
            imagecopymerge($image_9, $image_4_resize, 216, 40, 0, 0, imagesx($image_4_resize), imagesy($image_4_resize), 100);

            //输出图片
            imagejpeg($image_9, public_path('img/') . $filename);
        }

        return $filename;
    }


}