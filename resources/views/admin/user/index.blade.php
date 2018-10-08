@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span
                class="c-gray en">&gt;</span> 用户列表 <a class="btn btn-success radius r btn-refresh"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace(location.href);" title="刷新"
                                                      onclick="location.replace('{{URL::asset('admin/user/index')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form action="{{URL::asset('admin/user/index')}}" method="post" class="form-horizontal">
                {{csrf_field()}}
                <div class="Huiform text-r">
                    <input id="search_word" name="search_word" type="text" class="input-text" style="width:350px"
                           placeholder="根据用户名查询" value="{{$con_arr['search_word']?$con_arr['search_word']:''}}">
                    <button type="submit" class="btn btn-success" id="" name="">
                        <i class="Hui-iconfont">&#xe665;</i> 搜索
                    </button>
                </div>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="r">共有数据：<strong>{{$datas->total()}}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-bg table-sort mt-10">
            <thead>
            <tr>
                <th scope="col" colspan="9">内部管理员列表</th>
            </tr>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="40">ID</th>
                <th width="50">头像</th>
                <th width="100">昵称</th>
                <th width="100">省份</th>
                <th width="100">城市</th>
                <th width="130">加入时间</th>
                <th width="100">用户等级</th>
                <th width="50">状态</th>
                <th width="60">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    {{--<td><input type="checkbox" value="1" name=""></td>--}}
                    <td>{{$data->id}}</td>
                    <td>
                        <img src="{{ $data->avatar ? $data->avatar.'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="img-rect-30 radius-5">
                    </td>
                    <td>{{$data->nick_name}}</td>
                    <td>{{$data->province}}</td>
                    <td>{{$data->city}}</td>
                    <td>{{$data->created_at}}</td>
                    <td class="use_level">
                        @if($data->level=="0")
                            <span class="label label-secondary radius">普通用户</span>
                        @else
                            <span class="label label-success radius">系统管理员</span>
                        @endif
                    </td>
                    <td class="td-status">
                        @if($data->status=="1")
                            <span class="label label-success radius">已启用</span>
                        @else
                            <span class="label label-default radius">已禁用</span>
                        @endif
                    </td>
                    <td class="td-manage">
                        @if($data->status=="1")
                            <a style="text-decoration:none" onClick="stop(this,'{{$data->id}}')"
                               href="javascript:;"
                               title="停用">
                                {{--<i class="Hui-iconfont">&#xe631;</i>--}}
                                <i class="Hui-iconfont">&#xe631;</i>
                            </a>
                        @else
                            <a style="text-decoration:none" onClick="start(this,'{{$data->id}}')"
                               href="javascript:;"
                               title="启用">
                                {{--<i class="Hui-iconfont">&#xe615;</i>--}}
                                <i class="Hui-iconfont">&#xe615;</i>
                            </a>
                        @endif


                        <a class="use_level_class" title="查看用户详情" href="javascript:;"
                           onclick="detail('用户详情','{{URL::asset('/admin/user/detail')}}?id={{$data->id}}&&name={{$data->name}}')"
                           class="ml-5"
                           style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe667;</i>
                        </a>


                        @if($data->level=="0")
                            <a style="text-decoration:none" onClick="level_tj(this,'{{$data->id}}')"
                               href="javascript:;"
                               title="设置为系统管理员">
                                {{--<i class="Hui-iconfont">&#xe631;</i>--}}
                                <i class="Hui-iconfont">&#xe676;</i>
                            </a>
                        @else
                            <a style="text-decoration:none" onClick="level_pt(this,'{{$data->id}}')"
                               href="javascript:;"
                               title="设置为普通用户">
                                {{--<i class="Hui-iconfont">&#xe615;</i>--}}
                                <i class="Hui-iconfont">&#xe676;</i>
                            </a>
                        @endif


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-20">
            {{ $datas->appends($con_arr)->links() }}
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">


        /*管理员-停用*/
        function stop(obj, id) {
            consoledebug.log("stop id:" + id);
            layer.confirm('确认要停用吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    status: 0,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置管理员状态
                user_setStatus('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {

                    }
                })
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="start(this,' + id + ')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                $(obj).remove();
                layer.msg('已停用', {icon: 5, time: 1000});
            });
        }

        /*管理员-启用*/
        function start(obj, id) {
            layer.confirm('确认要启用吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    status: 1,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置管理员状态
                user_setStatus('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {

                    }
                })
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="stop(this,' + id + ')" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                $(obj).remove();
                layer.msg('已启用', {icon: 6, time: 1000});
            });
        }


        /*设置为系统管理员*/
        function level_tj(obj, id) {
            consoledebug.log("stop id:" + id);
            layer.confirm('是否确认设置为管理员？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    level: 1,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置用户等级
                user_setLevel('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {

                    }
                })
                $(obj).parents("tr").find(".use_level_class").after('<a onClick="level_pt(this,' + id + ')" href="javascript:;" title="普通用户" style="text-decoration:none"><i class="Hui-iconfont">&#xe676;</i></a>');
                $(obj).parents("tr").find(".use_level").html('<span class="label label-success radius">系统管理员</span>');
                $(obj).remove();
                layer.msg('已设置为系统管理员', {icon: 6, time: 1000});
            });
        }


        /*设置为普通用户*/
        function level_pt(obj, id) {
            layer.confirm('是否确认设置为管理员？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    level: 0,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置用户等级
                user_setLevel('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {

                    }
                })
                $(obj).parents("tr").find(".use_level_class").after('<a onClick="level_tj(this,' + id + ')" href="javascript:;" title="系统管理员" style="text-decoration:none"><i class="Hui-iconfont">&#xe676;</i></a>');
                $(obj).parents("tr").find(".use_level").html('<span class="label label-secondary radius">普通用户</span>');
                $(obj).remove();
                layer.msg('已设置为普通用户', {icon: 6, time: 1000});
            });
        }


        /*用户详细信息*/
        function detail(title, url) {
            consoledebug.log("show_optRecord url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
    </script>
@endsection