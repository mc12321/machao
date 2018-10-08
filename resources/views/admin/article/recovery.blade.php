@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 文章回收站 <span
                class="c-gray en">&gt;</span> 图文列表 <a class="btn btn-success radius r btn-refresh"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace('{{URL::asset('/admin/article/recovery')}}');"
                                                      title="刷新"
                                                      onclick="location.replace('{{URL::asset('/admin/article/recovery')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form action="{{URL::asset('/admin/article/recovery')}}" method="get" class="form-horizontal">
                {{csrf_field()}}
                <div class="Huiform text-r">

                    <span>文章id</span>
                    <input id="id" name="id" type="text" class="input-text" style="width:100px"
                           placeholder="文章id" value="{{$con_arr['id']}}">

                    <span class="ml-10">作者id</span>
                    <input id="user_id" name="user_id" type="text" class="input-text" style="width:100px"
                           placeholder="对应用户id" value="{{$con_arr['user_id']}}">

                    <span class="ml-10">按时间搜索</span>
                    <input id="created_at" name="created_at" type="text" class="input-text" style="width:100px"
                           placeholder="按时间搜索" value="{{$con_arr['created_at']}}">

                    <span class="ml-10">文章标题</span>
                    <input id="search_word" name="search_word" type="text" class="input-text" style="width:200px"
                           placeholder="根据图文标题搜索" value="{{$con_arr['search_word']}}">
                    <span class="select-box" style="width:150px">
                        <select class="select" name="orderby" id="orderby" size="1">
                            @foreach(\App\Components\Utils::user_search_val as $key=>$value)
                                <option value="{{$key}}" {{array_key_exists($key,$con_arr['orderby'])?'selected':''}}>{{$value}}</option>
                            @endforeach
                        </select>
                    </span>

                    <button type="submit" class="btn btn-success" id="" name="">
                        <i class="Hui-iconfont">&#xe665;</i> 搜索
                    </button>
                </div>
            </form>
        </div>

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
            <a href="javascript:;" onclick="add('添加图文','{{URL::asset('/admin/article/edit')}}')"
               class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加文章
            </a>
            </span>
            <span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span>
        </div>

        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-sort">
                <thead>
                <tr>
                    <th scope="col" colspan="8">图文列表</th>
                </tr>
                <tr class="text-c">
                    {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                    <th width="40">ID</th>
                    <th width="100">图片</th>
                    <th width="150">标题</th>
                    <th width="50">作者</th>
                    <th width="50">状态</th>
                    <th width="100">创建时间</th>
                    <th width="40">相关信息</th>
                    <th width="40">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr class="text-c">
                        {{--<td><input type="checkbox" value="1" name=""></td>--}}
                        <td>{{$data->id}}</td>
                        <td><img src="{{ $data->img.'?imageView2/1/w/100/h/60/interlace/1/q/75|imageslim'}}"/></td>
                        <td class="c-primary" title="详情" href="javascript:;"
                            onclick="show_info(' ','{{URL::asset('/admin/article/info')}}?id={{$data->id}})',{{$data->id}})">
                            {{$data->name}}</td>
                        <td>
                            {{$data->user->nick_name}}
                        </td>
                        <td class="td-status">
                            <span class="label label-default radius">删除</span>
                        </td>
                        <td>{{$data->created_at}}</td>
                        {{--<td>{{$data->f_table->f_table}}</td>--}}
                        <td>
                            <span class="label label-success radius">点赞数:{{$data->zan_num?$data->zan_num:'0'}}</span><br/>
                            <span class="label label-success radius" style="background-color: #694cff">展示数:{{$data->show_num?$data->show_num:'0'}}</span><br/>
                        </td>

                        <td class="td-manage">
                            {{--@if($data->status=="1")--}}
                                {{--<a style="text-decoration:none" onClick="stop(this,'{{$data->id}}')"--}}
                                   {{--href="javascript:;"--}}
                                   {{--title="隐藏">--}}
                                    {{--<i class="Hui-iconfont">&#xe631;</i>--}}
                                {{--</a>--}}
                            {{--@else--}}
                                {{--<a style="text-decoration:none" onClick="start(this,'{{$data->id}}')"--}}
                                   {{--href="javascript:;"--}}
                                   {{--title="显示">--}}
                                    {{--<i class="Hui-iconfont">&#xe615;</i>--}}
                                {{--</a>--}}
                            {{--@endif--}}
                            {{--<a title="图文编辑" href="javascript:;"--}}
                            {{--onclick="creatIframe('{{URL::asset('/admin/article/detail')}}?f_id={{$data->id}}&&f_table=article','图文编辑')"       --}}{{-- f_table=article 代表tw表里的文章 f_table={{$data->f_table->f_table}}--}}
                             {{--class="ml-5" style="text-decoration:none">--}}
                                {{--<i class="Hui-iconfont">&#xe613;</i>--}}
                            {{--</a>--}}
                            {{--<a title="编辑图文" href="javascript:;"--}}
                               {{--onclick="showinfo('编辑图文','{{URL::asset('/admin/article/edit')}}?id={{$data->id}})')"--}}
                               {{--class="ml-5"--}}
                               {{--style="text-decoration:none">--}}
                                {{--<i class="Hui-iconfont">&#xe6df;</i>--}}
                            {{--</a>--}}

                            {{--<a title="文章二维码" href="javascript:;"--}}
                               {{--onclick="zixun_show_ewm('{{$data->title}}小程序码','{{URL::asset('/admin/article/ewm')}}?id={{$data->id}}',{{$data->id}})"--}}
                               {{--class="ml-5"--}}
                               {{--style="text-decoration:none">--}}
                                {{--<i class="icon iconfont icon-erweima"></i>--}}
                            {{--</a>--}}
                                <a title="文章恢复" href="javascript:;"
                                   onclick="wz_regain(this,'{{$data->id}}')"
                                   class="ml-5"
                                   style="text-decoration:none;color: #00a0e9">
                                   文章恢复
                                </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-20">
                {{ $datas->appends($con_arr)->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">


        /*编辑信息*/
        function detail(title, url) {
            consoledebug.log("show_optRecord url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }


        /*文章信息*/
        function showinfo(title, url) {
            consoledebug.log("show_optRecord url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }


        $(function () {

        });

        /*
         参数解释：
         title	标题
         url		请求的url
         id		需要操作的数据id
         w		弹出层宽度（缺省调默认值）
         h		弹出层高度（缺省调默认值）
         */
        /*图文-增加*/
        function add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }


        /*图文-编辑*/
        function edit(title, url, id) {
            console.log("edit url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            console.log(index);
            layer.full(index);
        }

        /*图文-隐藏*/
        function stop(obj, id) {
            console.log("stop id:" + id);
            layer.confirm('确认要隐藏吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    status: 0,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置图文状态
                article_setStatus('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {
                        layer.msg('成功隐藏', {icon: 1, time: 1000});
                    }
                })
//                <i class="Hui-iconfont">&#xe631;</i>
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="start(this,' + id + ')" href="javascript:;" title="显示" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">隐藏</span>');
                $(obj).remove();
                layer.msg('已隐藏', {icon: 5, time: 1000});
            });
        }

        /*图文-显示*/
        function start(obj, id) {
            layer.confirm('确认要显示吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    status: 1,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置图文状态
                article_setStatus('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {
                        layer.msg('成功显示', {icon: 1, time: 1000});
                    }
                })
//                <i class="Hui-iconfont">&#xe615;</i>
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="stop(this,' + id + ')" href="javascript:;" title="隐藏" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">显示</span>');
                $(obj).remove();
                layer.msg('已显示', {icon: 6, time: 1000});
            });
        }


        /*
         *
         * 展示资讯二维码
         *
         * By TerryQi
         *
         * 2018-03-29
         */
        function zixun_show_ewm(title, url) {
            console.log("url:" + url);
            var index = layer.open({
                type: 2,
                area: ['520px', '520px'],
                fixed: false,
                maxmin: true,
                title: title,
                content: url
            });
        }

        /*
         *
         * 展示文章详情
         *
         *
         *
         *
         */
        function show_info(title, url, id) {
            console.log("show_info url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*文章-恢复*/
        function wz_regain(obj, id) {
            layer.confirm('确定要恢复此文章吗？', function (index) {
                //进行后台恢复
                var param = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }

                article_regain('{{URL::asset('')}}', param, function (ret) {
                    if (ret.result == true) {
                        $(obj).parents("tr").remove();
                        layer.msg('已恢复', {icon: 1, time: 1000});
 //                       window.location.reload();
//                        setTimeout(function () {
//                            var index = parent.layer.getFrameIndex(window.name);
//                            parent.$('.btn-refresh').click();
//                            parent.layer.close(index);
//                        }, 500)
                    } else {
                        layer.msg('恢复失败', {icon: 2, time: 1000})
                    }
                })
            });
        }
    </script>
@endsection