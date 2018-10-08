@extends('admin.layouts.app')

@section('content')
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-testing-edit">
            {{csrf_field()}}
            <div class="row cl hidden">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>f_id：</label>
                <div class="formControls col-xs-8 col-sm-8">
                    <input id="f_id" name="f_id" type="text" class="input-text" readonly
                           value="{{ isset($data['f_id']) ? $data['f_id'] : '' }}" placeholder="f_id">
                </div>
            </div>
            <div class="row cl hidden">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>f_table：</label>
                <div class="formControls col-xs-8 col-sm-8">
                    <input id="f_table" name="f_table" type="text" class="input-text" readonly
                           value="{{ isset($data['f_table']) ? $data['f_table'] : '' }}" placeholder="f_table">
                </div>
            </div>
            <div id="graphic_black">
                <div class="row cl" id="container">
                    <div class="formControls col-xs-6 col-sm-6" id="peration-area">
                        <div id="prefix_graphic_content"></div>
                        <div id="configuration"></div>
                    </div>
                    <div class="formControls col-xs-1 col-sm-1"></div>
                    <div class="formControls col-xs-4 col-sm-4 padding-top-10 ">
                        <div class="teltphone_header"></div>
                        <div id="prefix_graphic_show_content" class="graphic_show"></div>
                        <div class="teltphone_footer"></div>
                    </div>
                    <div class="formControls col-xs-1 col-sm-1"></div>
                </div>
            </div>
        </form>
    </div>

    {{-- 商品详情 --}}
    <script id="prefix_graphic_content_template" type="text/x-dot-template">
        <div id="graphic_content_detail" class="formControls col-xs-12 col-sm-12">

            @{{? it.text && it.img }}
            <textarea id="prefix_text_detail_@{{=it.index}}" wrap="\n" class="textarea" style="resize:vertical;"
                      placeholder="请填写内容" dragonfly="true" nullmsg="内容不能为空！">@{{=it.text}}</textarea>
            <img src="@{{=it.img}}"/>
            @{{?? it.text }}
            <textarea id="prefix_text_detail_@{{=it.index}}" wrap="\n" class="textarea" style="resize:vertical;"
                      placeholder="请填写内容" dragonfly="true" nullmsg="内容不能为空！">@{{=it.text}}</textarea>
            @{{?? it.img }}
            <img src="@{{=it.img}}"/>
            @{{?? it.video }}
            <video src="@{{=it.video}}" controls="controls">
                您的浏览器不支持 video 标签。
            </video>
            @{{? }}
            @{{? it.text }}
            <a href="javascript:" onclick="sortUp(@{{=it.index}},@{{=it.id}})" title="上移">
                <div class="formControls col-xs-3 col-sm-3">
                    <div class="graphic_icon_btn">
                        <img src="{{URL::asset('img/up.png')}}" style="width:18px;height:18px;margin-bottom:3px;"/>
                    </div>
                </div>
            </a>
            <a href="javascript:" onclick="delDetailList(@{{=it.index}},@{{=it.id}})" title="删除">
                <div class="formControls col-xs-3 col-sm-3">
                    <div class="graphic_icon_btn">
                        <img src="{{URL::asset('img/del.png')}}" style="width:18px;height:18px;margin-bottom:3px;"/>
                    </div>
                </div>
            </a>
            <a href="javascript:" onclick="updateTextDetial(@{{=it.index}},@{{=it.id}})" title="提交编辑">
                <div class="formControls col-xs-3 col-sm-3">
                    <div class="graphic_icon_btn">
                        <img src="{{URL::asset('img/edit.png')}}" style="width:18px;height:18px;margin-bottom:3px;"/>
                    </div>
                </div>
            </a>
            <a href="javascript:" onclick="sortDown(@{{=it.index}},@{{=it.id}})" title="下移">
                <div class="formControls col-xs-3 col-sm-3">
                    <div class="graphic_icon_btn">
                        <img src="{{URL::asset('img/down.png')}}" style="width:18px;height:18px;margin-bottom:3px;"/>
                    </div>
                </div>
            </a>
            @{{?? }}
            <a href="javascript:" onclick="sortUp(@{{=it.index}},@{{=it.id}})" title="上移">
                <div class="formControls col-xs-4 col-sm-4">
                    <div class="graphic_icon_btn">
                        <img src="{{URL::asset('img/up.png')}}" style="width:18px;height:18px;margin-bottom:3px;"/>
                    </div>
                </div>
            </a>
            <a href="javascript:" onclick="delDetailList(@{{=it.index}},@{{=it.id}})" title="删除">
                <div class="formControls col-xs-4 col-sm-4">
                    <div class="graphic_icon_btn">
                        <img src="{{URL::asset('img/del.png')}}" style="width:18px;height:18px;margin-bottom:3px;"/>
                    </div>
                </div>
            </a>
            <a href="javascript:" onclick="sortDown(@{{=it.index}},@{{=it.id}})" title="下移">
                <div class="formControls col-xs-4 col-sm-4">
                    <div class="graphic_icon_btn">
                        <img src="{{URL::asset('img/down.png')}}" style="width:18px;height:18px;margin-bottom:3px;"/>
                    </div>
                </div>
            </a>
            @{{? }}
        </div>
    </script>
    <script id="prefix_graphic_show_content_template" type="text/x-dot-template">
        @{{? it.text && it.img }}
        <div>@{{=it.text}}</div>
        <img src="@{{=it.img}}"/>
        @{{?? it.text }}
        <div>@{{=it.text}}</div>
        @{{?? it.img }}
        <img src="@{{=it.img}}"/>
        @{{?? it.video }}
        <video src="@{{=it.video}}" controls="controls">
            您的浏览器不支持 video 标签。
        </video>
        @{{? }}
    </script>
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('/js/graphicEditing/graphicEditing.js') }}"></script>
    <script type="text/javascript">

        //对详情进行编辑的操作
        //配置图文编辑器content
        var config_graphic = {
            'f_id': '{{$data['f_id']}}',  //需要编辑的父级id【必填】
            'f_table': '{{$data['f_table']}}',  //需要编辑的表识别符【必填】
            'number': 3,   //显示的功能数目
            'text': true,  //是否显示文本编辑
            'image': true,  //是否显示图片上传
            'video': true,  //是否显示视频上传
            'edit_id': 'prefix_graphic_content',    //编辑模块的id【必填】
            'edit_template': 'prefix_graphic_content_template',    //编辑模块的DOT模板id【必填】
            'show_id': 'prefix_graphic_show_content',    //展示模块的id【必填】
            'show_template': 'prefix_graphic_show_content_template',    //展示模块的DOT模板id【必填】
            'content': '{{$data['twSteps']}}',  //内容详情
            'prefix': 'prefix_',  //前缀（最好与常用标签区分开，用于其他模块时，方便一键替换）
        }
        //初始化
        initializationOfGraphicEditing(config_graphic)

        //确认添加文本操作
        function submitDetailText(f_id, f_table) {
            var add_text = $('#' + config_graphic['prefix'] + 'add_text').val()
            if (add_text == '') {
                layer.msg('添加失败，内容不能为空', {icon: 2, time: 2000});
            }
            else {
                var detail = {};
                detail['f_id'] = f_id;
                detail['f_table'] = f_table;
                detail['text'] = transformationRow(add_text);
                detail['seq'] = jsonObj.length;
                addDetailList(detail, function (ret) {
                    // console.log('addDetailList text ret is : '+JSON.stringify(ret))
                    if (ret.result == true) {
                        //重新展示
                        $('#' + config_graphic['prefix'] + 'add_text').val('')
                        jsonObj.push(ret.ret);
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.message, {icon: 2, time: 1000})
                    }
                })
            }
        }
        //确认添加图片操作
        function submitDetailImage(f_id, f_table) {
            var add_image = $('#' + config_graphic['prefix'] + 'add_image').val();
            if (add_image == '') {
                layer.msg('添加失败，请上传图片', {icon: 2, time: 2000});
            }
            else {
                var detail = {};
                detail['f_id'] = f_id;
                detail['f_table'] = f_table;
                detail['img'] = add_image;
                detail['seq'] = jsonObj.length;
                addDetailList(detail, function (ret) {
                    if (ret.result == true) {
                        //重新展示
                        $('#' + config_graphic['prefix'] + 'add_image').val('')
                        $('#' + config_graphic['prefix'] + 'imagePrv_image').attr('src', '{{ URL::asset('/img/add_image.png') }}')
                        $('#' + config_graphic['prefix'] + 'image_percent').css('width', '0%');
                        jsonObj.push(ret.ret);
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.message, {icon: 2, time: 1000})
                    }
                })
            }
        }
        //确认添加视频操作
        function submitDetailVideo(f_id, f_table) {
            var add_video = $('#' + config_graphic['prefix'] + 'add_video').val();
            if (add_video == '') {
                layer.msg('添加失败，请上传视频', {icon: 2, time: 2000});
            }
            else {
                var detail = {};
                detail['f_id'] = f_id;
                detail['f_table'] = f_table;
                detail['video'] = add_video;
                detail['seq'] = jsonObj.length;
                addDetailList(detail, function (ret) {
                    if (ret.result == true) {
                        //重新展示
                        $('#' + config_graphic['prefix'] + 'add_video').val('')
                        $('#videoPrv').attr('src', '')
                        $('#videoPrv').hide()
                        $('#imagePrv_video').show()
                        $('#' + config_graphic['prefix'] + 'video_percent').css('width', '0%');
                        jsonObj.push(ret.ret);
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.message, {icon: 2, time: 1000})
                    }
                })
            }
        }
        //删除这条数据
        function delDetailList(index, id) {
            layer.confirm('确认要删除这条数据吗？', function (index) {
                //进行后台删除
                var param = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
                delDetail('{{URL::asset('')}}', param, function (ret) {
                    if (ret.result == true) {
                        layer.msg(ret.message, {icon: 1, time: 1000});
                        // console.log('sortDown index is : ' + JSON.stringify((jsonObj[index])))
                        for (var i = 0; i < jsonObj.length; i++) {
                            if (id == jsonObj[i]['id']) {
                                jsonObj.splice(i, 1);//从下标为i的元素开始，连续删除1个元素
                            }
                        }
                        //重新展示
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.message, {icon: 2, time: 1000})
                    }
                })
            });
        }
        //提交后台编辑数据
        function editDetailList(param) {
            param['_token'] = "{{ csrf_token() }}"
            editDetail('{{URL::asset('')}}', param, function (ret) {
                console.log("editDetail ret is ： "+JSON.stringify(ret))
                if (ret.result == true) {
                    return ret.result;
                } else {
                    layer.msg(ret.message, {icon: 2, time: 1000})
                    return ret.result;
                }
            })
        }
        //提交后台添加数据
        function addDetailList(param, callBack) {
            param['_token'] = "{{ csrf_token() }}"
            editDetail('{{URL::asset('')}}', param, callBack)
        }


        $(function () {
            //获取七牛token
            initQNUploader();
        });
        //初始化七牛上传模块
        function initQNUploader() {
            var uploader_image = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式，依次退化
                browse_button: config_graphic['prefix'] + 'imagePrv_image',         // 上传选择的点选按钮，必需
                container: 'container',//上传按钮的上级元素ID
                // 在初始化时，uptoken，uptoken_url，uptoken_func三个参数中必须有一个被设置
                // 切如果提供了多个，其优先级为uptoken > uptoken_url > uptoken_func
                // 其中uptoken是直接提供上传凭证，uptoken_url是提供了获取上传凭证的地址，如果需要定制获取uptoken的过程则可以设置uptoken_func
                uptoken: "{{$upload_token}}", // uptoken是上传凭证，由其他程序生成
                // uptoken_url: '/uptoken',         // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
                // uptoken_func: function(file){    // 在需要获取uptoken时，该方法会被调用
                //    // do something
                //    return uptoken;
                // },
                get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
                // downtoken_url: '/downtoken',
                // Ajax请求downToken的Url，私有空间时使用，JS-SDK将向该地址POST文件的key和domain，服务端返回的JSON必须包含url字段，url值为该文件的下载地址
                unique_names: true,              // 默认false，key为文件名。若开启该选项，JS-SDK会为每个文件自动生成key（文件名）
                // save_key: true,                  // 默认false。若在服务端生成uptoken的上传策略中指定了sava_key，则开启，SDK在前端将不对key进行任何处理
                domain: 'http://twst.isart.me/',     // bucket域名，下载资源时用到，必需
                max_file_size: '100mb',             // 最大文件体积限制
                flash_swf_url: 'path/of/plupload/Moxie.swf',  //引入flash，相对路径
                max_retries: 3,                     // 上传失败最大重试次数
                dragdrop: true,                     // 开启可拖曳上传
                drop_element: 'container',          // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
                chunk_size: '4mb',                  // 分块上传时，每块的体积
                auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
                //x_vars : {
                //    查看自定义变量
                //    'time' : function(up,file) {
                //        var time = (new Date()).getTime();
                // do something with 'time'
                //        return time;
                //    },
                //    'size' : function(up,file) {
                //        var size = file.size;
                // do something with 'size'
                //        return size;
                //    }
                //},
                init: {
                    'FilesAdded': function (up, files) {
                        plupload.each(files, function (file) {
                            // 文件添加进队列后，处理相关的事情
//                                            alert(alert(JSON.stringify(file)));
                        });
                    },
                    'BeforeUpload': function (up, file) {
                        // 每个文件上传前，处理相关的事情
//                        console.log("BeforeUpload up:" + up + " file:" + JSON.stringify(file));
                    },
                    'UploadProgress': function (up, file) {
                        // 每个文件上传时，处理相关的事情
                        $('#' + config_graphic['prefix'] + 'image_percent').css('width', file.percent + '%');
                        $('#' + config_graphic['prefix'] + 'image_percent').css('float', 'left');
                        // console.log("UploadProgress up:" + up + " file:" + JSON.stringify(file));
                    },
                    'FileUploaded': function (up, file, info) {
                        // 每个文件上传成功后，处理相关的事情
                        // 其中info是文件上传成功后，服务端返回的json，形式如：
                        // {
                        //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                        //    "key": "gogopher.jpg"
                        //  }
                        // console.log(JSON.stringify(info));
                        var domain = up.getOption('domain');
                        var res = JSON.parse(info);
                        //获取上传成功后的文件的Url
                        var sourceLink = domain + res.key;
                        $('#' + config_graphic['prefix'] + 'imagePrv_image').attr('src', sourceLink);
                        $('#' + config_graphic['prefix'] + 'add_image').val(sourceLink)
                        // console.log($("#pickfiles").attr('src'));
                    },
                    'Error': function (up, err, errTip) {
                        //上传出错时，处理相关的事情
                        // console.log(err + errTip);
                    },
                    'UploadComplete': function () {
                        //队列文件处理完毕后，处理相关的事情
                    },
                    'Key': function (up, file) {
                        // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                        // 该配置必须要在unique_names: false，save_key: false时才生效

                        var key = "";
                        // do something with key here
                        return key
                    }
                }
            });
            var uploader_video = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式，依次退化
                browse_button: config_graphic['prefix'] + 'imagePrv_video',         // 上传选择的点选按钮，必需
                container: 'container',//上传按钮的上级元素ID
                // 在初始化时，uptoken，uptoken_url，uptoken_func三个参数中必须有一个被设置
                // 切如果提供了多个，其优先级为uptoken > uptoken_url > uptoken_func
                // 其中uptoken是直接提供上传凭证，uptoken_url是提供了获取上传凭证的地址，如果需要定制获取uptoken的过程则可以设置uptoken_func
                uptoken: "{{$upload_token}}", // uptoken是上传凭证，由其他程序生成
                // uptoken_url: '/uptoken',         // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
                // uptoken_func: function(file){    // 在需要获取uptoken时，该方法会被调用
                //    // do something
                //    return uptoken;
                // },
                get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
                // downtoken_url: '/downtoken',
                // Ajax请求downToken的Url，私有空间时使用，JS-SDK将向该地址POST文件的key和domain，服务端返回的JSON必须包含url字段，url值为该文件的下载地址
                unique_names: true,              // 默认false，key为文件名。若开启该选项，JS-SDK会为每个文件自动生成key（文件名）
                // save_key: true,                  // 默认false。若在服务端生成uptoken的上传策略中指定了sava_key，则开启，SDK在前端将不对key进行任何处理
                domain: 'http://twst.isart.me/',     // bucket域名，下载资源时用到，必需
                max_file_size: '100mb',             // 最大文件体积限制
                flash_swf_url: 'path/of/plupload/Moxie.swf',  //引入flash，相对路径
                max_retries: 3,                     // 上传失败最大重试次数
                dragdrop: true,                     // 开启可拖曳上传
                drop_element: 'container',          // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
                chunk_size: '4mb',                  // 分块上传时，每块的体积
                auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
                //x_vars : {
                //    查看自定义变量
                //    'time' : function(up,file) {
                //        var time = (new Date()).getTime();
                // do something with 'time'
                //        return time;
                //    },
                //    'size' : function(up,file) {
                //        var size = file.size;
                // do something with 'size'
                //        return size;
                //    }
                //},
                init: {
                    'FilesAdded': function (up, files) {
                        plupload.each(files, function (file) {
                            // 文件添加进队列后，处理相关的事情
//                                            alert(alert(JSON.stringify(file)));
                        });
                    },
                    'BeforeUpload': function (up, file) {
                        // 每个文件上传前，处理相关的事情
//                        console.log("BeforeUpload up:" + up + " file:" + JSON.stringify(file));
                    },
                    'UploadProgress': function (up, file) {
                        // 每个文件上传时，处理相关的事情
                        $('#' + config_graphic['prefix'] + 'video_percent').css('width', file.percent + '%');
                        $('#' + config_graphic['prefix'] + 'video_percent').css('float', 'left');
                        // console.log("UploadProgress up:" + up + " file:" + JSON.stringify(file));
                    },
                    'FileUploaded': function (up, file, info) {
                        // 每个文件上传成功后，处理相关的事情
                        // 其中info是文件上传成功后，服务端返回的json，形式如：
                        // {
                        //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                        //    "key": "gogopher.jpg"
                        //  }
                        // console.log(JSON.stringify(info));
                        var domain = up.getOption('domain');
                        var res = JSON.parse(info);
                        //获取上传成功后的文件的Url
                        var sourceLink = domain + res.key;
                        $('#' + config_graphic['prefix'] + 'imagePrv_video').hide();
                        $('#' + config_graphic['prefix'] + 'videoPrv').show()
                        $('#' + config_graphic['prefix'] + 'videoPrv').attr('src', sourceLink);
                        $('#' + config_graphic['prefix'] + 'add_video').val(sourceLink)
                        // console.log($("#pickfiles").attr('src'));
                    },
                    'Error': function (up, err, errTip) {
                        //上传出错时，处理相关的事情
                        // console.log(err + errTip);
                    },
                    'UploadComplete': function () {
                        //队列文件处理完毕后，处理相关的事情
                    },
                    'Key': function (up, file) {
                        // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                        // 该配置必须要在unique_names: false，save_key: false时才生效

                        var key = "";
                        // do something with key here
                        return key
                    }
                }
            });
        }
    </script>
@endsection