var config_graphic_using = {
    'f_id': '',  //需要编辑的父级id【必填】
    'f_table': '',  //需要编辑的表识别符【必填】
    'number': 3,   //显示的功能数目
    'text': true,  //是否显示文本编辑
    'image': true,  //是否显示图片上传
    'video': true,  //是否显示视频上传
    'edit_id': '',    //编辑模块的id【必填】
    'edit_template': '',    //编辑模块的DOT模板id【必填】
    'show_id': '',    //展示模块的id【必填】
    'show_template': '',    //展示模块的DOT模板id【必填】
    'content': '',  //内容详情
    'prefix': '',  //前缀
};
var jsonObj;
function initializationOfGraphicEditing(data) {
     console.log("config_graphic_using is1 : "+JSON.stringify(config_graphic_using))
    assignmentConfig(data)
    var str = data['content']
    var jsonStr = str.replace(/&quot;/ig, '"')
  // var jsonStr = transformationRow(jsonStr)

    jsonObj = JSON.parse(jsonStr)

    console.log("一次"+JSON.stringify(jsonObj))

    //内容详情页
    LoadDetailsHtml(jsonObj)
    //配置功能
    if (config_graphic_using['number'] > 0) {
        var module = ''
        if (config_graphic_using['number'] == 1) {
            if (config_graphic_using['text']) {
                module = 'text'
            }
            else if (config_graphic_using['image']) {
                module = 'image'
            }
            else if (config_graphic_using['video']) {
                module = 'video'
            }
        }
        else if (config_graphic_using['number'] == 2) {
            if (!config_graphic_using['text']) {
                module = 'text'
            }
            else if (!config_graphic_using['image']) {
                module = 'image'
            }
            else if (!config_graphic_using['video']) {
                module = 'video'
            }
        }

        config_graphic_usingurationFunctional(config_graphic_using['number'], module)
    }
}
//赋值配置
function assignmentConfig(data) {
    if (!data['f_id']) {
        $('#graphic_black').html('<div style="text-align:center">缺少参数，请传入f_id</div>')
    }
    else if (!data['f_table']) {
        $('#graphic_black').html('<div style="text-align:center">缺少参数，请传入f_table</div>')
    }
    else if (!data['edit_id']) {
        $('#graphic_black').html('<div style="text-align:center">缺少参数，请传入编辑模块的id</div>')
    }
    else if (!data['edit_template']) {
        $('#graphic_black').html('<div style="text-align:center">缺少参数，请传入编辑模块的DOT模板id</div>')
    }
    else if (!data['show_id']) {
        $('#graphic_black').html('<div style="text-align:center">缺少参数，请传入展示模块的id</div>')
    }
    else if (!data['show_template']) {
        $('#graphic_black').html('<div style="text-align:center">缺少参数，请传入展示模块的DOT模板id</div>')
    }
    else {
        for (var key in data) {
            config_graphic_using[key] = data[key]
            // console.log("config_graphic_using['"+key+"'] is : "+JSON.stringify(config_graphic_using[key]))
        }
        console.log("config_graphic_using is : " + JSON.stringify(config_graphic_using))
    }
}
//功能显示
/*
 * number：模块的个数，用于计算栅格
 * module：如果是全都显示，传入空值；如果显示2个，传入的值为隐藏模块的名称；如果只显示一个，传入的值为显示模块的名称
 */
function config_graphic_usingurationFunctional(number, module) {
    var str = '';
    var col = 12 / number;
    if (number == 1) {
        if (module == 'text') {
            str = str + '<a href="javascript:" onclick="addDetailText()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_text">添加文本</div>'
                + '</a>'

                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_text" >'
                + '<textarea name="" id="' + config_graphic_using['prefix'] + 'add_text" wrap="\\n" class="textarea" style="resize:vertical;" placeholder="请填写内容" dragonfly="true" nullmsg="内容不能为空！"></textarea>'
                + '<a href="javascript:" onclick="submitDetailText(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
        }
        else if (module == 'image') {
            str = str + '<a href="javascript:" onclick="addDetailImage()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_image">添加图片</div>'
                + '</a>'

                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_image" style="text-align: center;" >'
                + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_image" src="../../img/add_image.png" style="cursor:pointer;" />'
                + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'image_percent"></span></div>'
                + '<input id="' + config_graphic_using['prefix'] + 'add_image" type="hidden" />'
                + '<a href="javascript:" onclick="submitDetailImage(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
        }
        else if (module = 'video') {
            str = str + '<a href="javascript:" onclick="addDetailVideo()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_video">添加视频</div>'
                + '</a>'

                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_video" style="text-align: center;" >'
                + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_video" src="../../img/add_video.png" style="cursor:pointer;" />'
                + '<video src="" id="' + config_graphic_using['prefix'] + 'videoPrv" controls="controls" hidden>'
                + '您的浏览器不支持 video 标签。'
                + '</video>'
                + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'video_percent"></span></div>'
                + '<input id="' + config_graphic_using['prefix'] + 'add_video" type="hidden" />'
                + '<a href="javascript:" onclick="submitDetailVideo(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
        }
    }
    else if (number == 2) {
        if (module == 'text') {
            str = str + '<a href="javascript:" onclick="addDetailImage()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_image">添加图片</div>'
                + '</a>'
                + '<a href="javascript:" onclick="addDetailVideo()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_video">添加视频</div>'
                + '</a>'

                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_image" style="text-align: center;" >'
                + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_image" src="../../img/add_image.png" style="cursor:pointer;" />'
                + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'image_percent"></span></div>'
                + '<input id="' + config_graphic_using['prefix'] + 'add_image" type="hidden" />'
                + '<a href="javascript:" onclick="submitDetailImage(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_video" style="text-align: center;" hidden >'
                + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_video" src="../../img/add_video.png" style="cursor:pointer;" />'
                + '<video src="" id="' + config_graphic_using['prefix'] + 'videoPrv" controls="controls" hidden>'
                + '您的浏览器不支持 video 标签。'
                + '</video>'
                + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'video_percent"></span></div>'
                + '<input id="' + config_graphic_using['prefix'] + 'add_video" type="hidden" />'
                + '<a href="javascript:" onclick="submitDetailVideo(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
        }
        else if (module == 'image') {
            str = str + '<a href="javascript:" onclick="addDetailText()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_text">添加文本</div>'
                + '</a>'
                + '<a href="javascript:" onclick="addDetailVideo()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_video">添加视频</div>'
                + '</a>'

                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_text" >'
                + '<textarea name="" id="' + config_graphic_using['prefix'] + 'add_text" wrap="\\n" class="textarea" style="resize:vertical;" placeholder="请填写内容" dragonfly="true" nullmsg="内容不能为空！"></textarea>'
                + '<a href="javascript:" onclick="submitDetailText(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_video" style="text-align: center;" hidden >'
                + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_video" src="../../img/add_video.png" style="cursor:pointer;" />'
                + '<video src="" id="' + config_graphic_using['prefix'] + 'videoPrv" controls="controls" hidden>'
                + '您的浏览器不支持 video 标签。'
                + '</video>'
                + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'video_percent"></span></div>'
                + '<input id="' + config_graphic_using['prefix'] + 'add_video" type="hidden" />'
                + '<a href="javascript:" onclick="submitDetailVideo(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
        }
        else if (module = 'video') {
            str = str + '<a href="javascript:" onclick="addDetailText()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_text">添加文本</div>'
                + '</a>'
                + '<a href="javascript:" onclick="addDetailImage()">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_image">添加图片</div>'
                + '</a>'

                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_text" >'
                + '<textarea name="" id="' + config_graphic_using['prefix'] + 'add_text" wrap="\\n" class="textarea" style="resize:vertical;" placeholder="请填写内容" dragonfly="true" nullmsg="内容不能为空！"></textarea>'
                + '<a href="javascript:" onclick="submitDetailText(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
                + '<div id="' + config_graphic_using['prefix'] + 'add_detail_image" style="text-align: center;" hidden >'
                + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_image" src="../../img/add_image.png" style="cursor:pointer;" />'
                + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'image_percent"></span></div>'
                + '<input id="' + config_graphic_using['prefix'] + 'add_image" type="hidden" />'
                + '<a href="javascript:" onclick="submitDetailImage(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
                + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
                + '</a>'
                + '</div>'
        }
    }
    else if (number == 3) {
        str = str + '<a href="javascript:" onclick="addDetailText()">'
            + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_text">添加文本</div>'
            + '</a>'
            + '<a href="javascript:" onclick="addDetailImage()">'
            + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_image">添加图片</div>'
            + '</a>'
            + '<a href="javascript:" onclick="addDetailVideo()">'
            + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-' + col + ' col-sm-' + col + ' detail_add_video">添加视频</div>'
            + '</a>'

            + '<div id="' + config_graphic_using['prefix'] + 'add_detail_text" >'
            + '<textarea name="" id="' + config_graphic_using['prefix'] + 'add_text" wrap="\\n" class="textarea" style="resize:vertical;" placeholder="请填写内容" dragonfly="true" nullmsg="内容不能为空！"></textarea>'
            + '<a href="javascript:" onclick="submitDetailText(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
            + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
            + '</a>'
            + '</div>'
            + '<div id="' + config_graphic_using['prefix'] + 'add_detail_image" style="text-align: center;" hidden >'
            + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_image" src="../../img/add_image.png" style="cursor:pointer;" />'
            + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'image_percent"></span></div>'
            + '<input id="' + config_graphic_using['prefix'] + 'add_image" type="hidden" />'
            + '<a href="javascript:" onclick="submitDetailImage(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
            + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
            + '</a>'
            + '</div>'
            + '<div id="' + config_graphic_using['prefix'] + 'add_detail_video" style="text-align: center;" hidden >'
            + '<img id="' + config_graphic_using['prefix'] + 'imagePrv_video" src="../../img/add_video.png" style="cursor:pointer;" />'
            + '<video src="" id="' + config_graphic_using['prefix'] + 'videoPrv" controls="controls" hidden>'
            + '您的浏览器不支持 video 标签。'
            + '</video>'
            + '<div class="progress-bar"><span class="sr-only" id="' + config_graphic_using['prefix'] + 'video_percent"></span></div>'
            + '<input id="' + config_graphic_using['prefix'] + 'add_video" type="hidden" />'
            + '<a href="javascript:" onclick="submitDetailVideo(' + config_graphic_using['f_id'] + ',\'' + config_graphic_using['f_table'] + '\')">'
            + '<div id="' + config_graphic_using['prefix'] + 'graphic_content" class="formControls col-xs-12 col-sm-4 col-md-offset-4  detail_add_button">确认添加</div>'
            + '</a>'
            + '</div>'
    }
    $('#configuration').html(str)
}
// 内容详情页编辑
function LoadDetailsHtml(data) {
    var data_text = data    //data_text：用于文本编辑器中解决换行问题的过度变量
    console.log("data is : "+JSON.stringify(data))
    for (var i = 0; i < data.length; i++) {
        data[i]['index'] = i
        // console.log('LoadDetailsHtml data['+i+'] is : ' + JSON.stringify((data[i])))
        if (data[i]['text']) {
            console.log("二次 : "+JSON.stringify(data_text[i]))
            data_text[i]['text'] = reverseRow(data[i]['text']);
            //编辑
            var interText = doT.template($("#" + config_graphic_using['edit_template']).text())
            $("#" + config_graphic_using['edit_id']).append(interText(data_text[i]))
            data_text[i]['text'] = transformationRow(data_text[i]['text']);
            //展示
            var interText = doT.template($("#" + config_graphic_using['show_template']).text())
            $("#" + config_graphic_using['show_id']).append(interText(data_text[i]))
        }
        else {
            console.log("三次 : "+JSON.stringify(data[i]))
            //编辑
            var interText = doT.template($("#" + config_graphic_using['edit_template']).text())
            $("#" + config_graphic_using['edit_id']).append(interText(data[i]))
            //展示
            var interText = doT.template($("#" + config_graphic_using['show_template']).text())
            $("#" + config_graphic_using['show_id']).append(interText(data[i]))
        }
    }
}
//点击排序-上升
function sortUp(index, id) {
    console.log('上升传入index : ' + JSON.stringify(index))
   console.log('上升传入 : ' + JSON.stringify((jsonObj[index])))
    //判断如果不是最上面的内容，执行向上操作
    if (index != 0) {
        //再交换jsonObj中的位置
        var pack = jsonObj[index - 1]
        jsonObj[index - 1] = jsonObj[index]
        jsonObj[index] = pack
        for (var i = 0; i < jsonObj.length; i++) {
            jsonObj[i]['seq'] = i
        }
        for (var i = 0; i < jsonObj.length; i++) {
            editDetailList(jsonObj[i])
        }
        //重新展示
        refresh(jsonObj)
    }
}
//点击排序-下降
function sortDown(index) {
    console.log("下降是否传入index : "+JSON.stringify(index))
    console.log("下降是否传入index2 : "+index)
    console.log('下降是否传入: ' + JSON.stringify((jsonObj[index])))
    // console.log('sortDown index is : ' + JSON.stringify((jsonObj[index])))
    //判断如果不是最上面的内容，执行向上操作
    if (index != jsonObj.length - 1) {
        //再交换jsonObj中的位置
        var pack = jsonObj[index + 1]
        jsonObj[index + 1] = jsonObj[index]
        jsonObj[index + 1]['seq'] = index + 1
        jsonObj[index] = pack
        jsonObj[index]['seq'] = index
        for (var i = 0; i < jsonObj.length; i++) {
            jsonObj[i]['seq'] = i
        }
        for (var i = 0; i < jsonObj.length; i++) {
            editDetailList(jsonObj[i])
        }
        //重新展示
        refresh(jsonObj)
    }
}
//提交修改后的文本
function updateTextDetial(index) {
    var content = $('#' + config_graphic_using['prefix'] + 'text_detail_' + index).val();
    content = transformationRow(content)
    jsonObj[index]['text'] = content;
    for (var i = 0; i < jsonObj.length; i++) {



        editDetailList(jsonObj[i])
    }
    //重新展示
    refresh(jsonObj)
}
//显示添加文本
function addDetailText() {
    $('#' + config_graphic_using['prefix'] + 'add_detail_text').show();
    $('#' + config_graphic_using['prefix'] + 'add_detail_image').hide();
    $('#' + config_graphic_using['prefix'] + 'add_detail_video').hide();
}
//显示添加图片
function addDetailImage() {
    $('#' + config_graphic_using['prefix'] + 'add_detail_text').hide();
    $('#' + config_graphic_using['prefix'] + 'add_detail_image').show();
    $('#' + config_graphic_using['prefix'] + 'add_detail_video').hide();
}
//显示添加视频
function addDetailVideo() {
    $('#' + config_graphic_using['prefix'] + 'add_detail_text').hide();
    $('#' + config_graphic_using['prefix'] + 'add_detail_image').hide();
    $('#' + config_graphic_using['prefix'] + 'add_detail_video').show();
}
//刷新页面
function refresh(jsonObj) {
    $("#" + config_graphic_using['edit_id']).html('')
    $("#" + config_graphic_using['show_id']).html('')
    LoadDetailsHtml(jsonObj)
}

//textarea换行转换成html标签
function transformationRow(str) {
    str = str.replace(/\r\n/g, '<br/>'); //IE9、FF、chrome
    str = str.replace(/\n/g, '<br/>'); //IE7-8
    return str;
}
//html标签转换成textarea识别标签
function reverseRow(str) {
    str = str.replace(/&lt;br\/&gt;/g, "\n"); //IE7-8
    str = str.replace(/<br\/>/g, '\n'); //IE7-8
    // console.log('reverseRow str : '+JSON.stringify(str))
    return str;
}

