@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 图文管理 <span
                class="c-gray en">&gt;</span> 图文列表 <a class="btn btn-success radius r btn-refresh"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace('{{URL::asset('/admin/showpic/index')}}');"
                                                      title="刷新"
                                                      onclick="location.replace('{{URL::asset('/admin/showpic/index')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form action="{{URL::asset('/admin/showpic/index')}}" method="get" class="form-horizontal">
                {{csrf_field()}}
                <div class="Huiform text-r">
                    <input id="search_word" name="search_word" type="text" class="input-text" style="width:250px"
                           placeholder="根据管理员查询，支持模糊查询" value="{{$con_arr['search_word']}}">
                    <button type="submit" class="btn btn-success" id="" name="">
                        <i class="Hui-iconfont">&#xe665;</i> 搜索
                    </button>
                </div>
            </form>
        </div>

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                 <a href="javascript:;" onclick="add('添加图片','{{URL::asset('/admin/showpic/edit')}}')"
                    class="btn btn-primary radius">
                     <i class="Hui-iconfont">&#xe600;</i>添加图片
                 </a>
            </span>
            {{--<span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span>--}}
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
                    <th width="50">记录</th>
                    <th width="50">状态</th>
                    <th width="100">创建时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr class="text-c">
                        {{--<td><input type="checkbox" value="1" name=""></td>--}}
                        <td>{{$data->id}}</td>
                        <td><img src="{{ $data->img.'?imageView2/1/w/100/h/60/interlace/1/q/75|imageslim'}}" style="width: 80px;height: 60px;"></td>
                        <td class="c-primary" title="详情" href="javascript:;">
                            {{$data->admin}}</td>
                        <td class="td-status">
                            @if($data->status=="1")
                                <span class="label label-success radius">显示</span>
                            @else
                                <span class="label label-default radius">隐藏</span>
                            @endif
                        </td>
                        <td>{{$data->created_at}}</td>
                        <td class="td-manage">
                            @if($data->status=="1")
                                <a style="text-decoration:none" onClick="stop(this,'{{$data->id}}')"
                                   href="javascript:;"
                                   title="隐藏">
                                    <i class="Hui-iconfont">&#xe631;</i>
                                </a>
                            @else
                                <a style="text-decoration:none" onClick="start(this,'{{$data->id}}')"
                                   href="javascript:;"
                                   title="显示">
                                    <i class="Hui-iconfont">&#xe615;</i>
                                </a>
                            @endif
                            <a title="编辑" href="javascript:;"
                               onclick="detail('编辑图片','{{URL::asset('admin/showpic/edit')}}?id={{$data->id}}')"
                               class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-20">
                {{--{{ $datas->links() }}--}}       {{-- 分页插件--}}
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



        /*添加图片*/
        function add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }


        $(function () {

        });



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
                showpic_setStatus('{{URL::asset('')}}', param, function (ret) {
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
                showpic_setStatus('{{URL::asset('')}}', param, function (ret) {
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

    </script>
@endsection