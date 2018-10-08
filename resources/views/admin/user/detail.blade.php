@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户详细信息 <span
                class="c-gray en">&gt;</span> 用户详情 <a class="btn btn-success radius r btn-refresh"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace(location.href);" title="刷新"
                                                      onclick="location.replace('{{URL::asset('admin/user/detail')}}?id={{$data->id}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        <div class="panel panel-primary mt-20">
            <div class="panel-header">用户详细信息</div>
            <div class="panel-body">

                <table class="table table-border table-bordered radius">
                    <tbody>
                    <tr>
                        <td rowspan="6" style="text-align: center;width: 380px;">
                            <img src="{{ $data->avatar ? $data->avatar : URL::asset('/img/default_headicon.png')}}"
                                 style="width: 220px;height: 220px;">
                        </td>
                        <td>姓名</td>
                        <td>{{isset($data->real_name)?$data->real_name:'--'}}</td>
                        <td>昵称</td>
                        <td>{{isset($data->nick_name)?$data->nick_name:'--'}}</td>
                        <td>联系电话</td>
                        <td class="c-primary">{{isset($data->phonenum)?$data->phonenum:'--'}}</td>
                    </tr>
                    <tr>
                        <td>ID</td>
                        <td>{{isset($data->id)?$data->id:'--'}}</td>
                        <td>性别</td>
                        <td>
                            @if($data->gender=='0')
                                保密
                            @endif
                            @if($data->gender=='1')
                                男
                            @endif
                            @if($data->gender=='2')
                                女
                            @endif
                        </td>
                        <td>注册时间</td>
                        <td>{{$data->created_at}}</td>
                    </tr>
                    <tr>
                        <td>状态</td>
                        <td>{{$data->status=='0'?'失效':'生效'}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>省份</td>
                        <td>{{isset($data->province)?$data->province:'--'}}</td>
                        <td>城市</td>
                        <td>{{isset($data->city)?$data->city:'--'}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="panel panel-primary mt-20">
            <div class="panel-header">作品列表</div>
            <div class="panel-body">
                {{--记录列表--}}
                <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
                    <thead>
                    <tr>
                        <th scope="col" colspan="10">记录列表</th>
                    </tr>
                    <tr class="text-c">
                        <th width="40">文章ID</th>
                        <th width="50">文章封面</th>
                        <th width="80">文章标题</th>
                        <th width="80">文章说明</th>
                        <th width="80">展示数</th>
                        <th width="80">评论数</th>
                        <th width="40">点赞数</th>
                        <th width="40">收藏数</th>
                        <th width="40">转发数</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($zps as $zp)
                        <tr class="text-c">
                            <td>{{$zp->id}}</td>
                            <td>
                                <img src="{{$zp->img ? $zp->img  : URL::asset('/img/default_headicon.png')}}"
                                     class="img-rect-30 radius-5">
                            </td>
                            {{--<td style="color: #0a6ebd">{{$zp->name? $zp->name:'--'}}</td>--}}

                            <td>
                            <a title="文章详情"
                               onclick="creatIframe_info('{{URL::asset('admin/article/info')}}?id={{$zp->id}}','文章详情')"

                               {{--onclick="creatIframe('{{URL::asset('admin/article/edit')}}?id={{$data->id}}','编辑标题-{{$data->title}}')"--}}

                               {{--onclick="showinfo('文章详情','{{URL::asset('/admin/article/info')}}?id={{$zp->id}}')"--}}
                               style="color: #0a6ebd;">
                                {{$zp->name? $zp->name:'--'}}
                            </a>
                            </td>



                            <td>{{$zp->desc ? $zp->desc:'--'}}</td>
                            <td>{{$zp->show_num? $zp->show_num:'--'}}</td>
                            <td>{{$zp->comm_num? $zp->comm_num:'--'}}</td>
                            <td>{{$zp->zan_num? $zp->zan_num:'--'}}</td>
                            <td>{{$zp->coll_num? $zp->coll_num:'--'}}</td>
                            <td>{{$zp->trans_num? $zp->trans_num:'--'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="panel panel-primary mt-20">
            <div class="panel-header">关注列表</div>
            <div class="panel-body">
                {{--记录列表--}}
                <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
                    <thead>
                    <tr>
                        <th scope="col" colspan="10">记录列表</th>
                    </tr>
                    <tr class="text-c">
                        <th width="40">ID</th>
                        <th width="50">头像</th>
                        <th width="80">昵称</th>
                        <th width="80">姓名</th>
                        <th width="80">电话</th>
                        <th width="80">关注时间</th>
                        <th width="40">编辑</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($fans as $fan)
                        <tr id="{{$fan->fan_name->id}}" class="text-c">
                            <td>{{$fan->id}}</td>
                            <td>
                                <img src="{{$fan->fan_name->avatar ? $fan->fan_name->avatar  : URL::asset('/img/default_headicon.png')}}"
                                     class="img-rect-30 radius-5">
                            </td>
                            <td>{{$fan->fan_name->nick_name ? $fan->fan_name->nick_name:'--'}}</td>
                            <td>{{$fan->fan_name->real_name ? $fan->fan_name->real_name:'--'}}</td>
                            <td>{{$fan->fan_name->phonenum ? $fan->fan_name->phonenum:'--'}}</td>
                            <td>{{$fan->created_at}}</td>
                            <td class="td-manage">
                                <a style="text-decoration:none" onClick="cancel('{{$fan->fan_name->id}}','{{$data->id}}',1)"
                                   href="javascript:;"
                                   title="取消关注">
                                    {{--<i class="Hui-iconfont">&#xe631;</i>--}}
                                    <i class="Hui-iconfont">&#xe631;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="panel panel-primary mt-20">
            <div class="panel-header">粉丝列表</div>
            <div class="panel-body">
                {{--记录列表--}}
                <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
                    <thead>
                    <tr>
                        <th scope="col" colspan="10">记录列表</th>
                    </tr>
                    <tr class="text-c">
                        <th width="40">ID</th>
                        <th width="50">头像</th>
                        <th width="80">昵称</th>
                        <th width="80">姓名</th>
                        <th width="80">电话</th>
                        <th width="80">关注时间</th>
                        <th width="40">编辑</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gzs as $gz)
                        <tr id="{{$gz->gz_name->id}}" class="text-c">
                            <td>{{$gz->id}}</td>
                            <td>
                                <img src="{{$gz->gz_name->avatar ? $gz->gz_name->avatar : URL::asset('/img/default_headicon.png')}}"
                                     class="img-rect-30 radius-5">
                            </td>
                            <td>{{$gz->gz_name->nick_name ? $gz->gz_name->nick_name:'--'}}</td>
                            <td>{{$gz->gz_name->real_name ? $gz->gz_name->real_name:'--'}}</td>
                            <td>{{$gz->gz_name->phonenum ? $gz->gz_name->phonenum:'--'}}</td>
                            <td>{{$gz->created_at}}</td>
                            <td class="td-manage">
                                <a style="text-decoration:none" onClick="cancel('{{$gz->gz_name->id}}','{{$data->id}}',2)"
                                   href="javascript:;"
                                   title="取消关注">
                                    {{--<i class="Hui-iconfont">&#xe631;</i>--}}
                                    <i class="Hui-iconfont">&#xe631;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">


        $(function () {

        });


        /*取消关注*/
        function cancel(id,userid,type) {
            consoledebug.log("cancel id:" + id);
            layer.confirm('确认要取消吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param;
                if (type == 1) {
                    param = {
                        user_id:userid,
                        gz_user_id:id,
                        opt: 0,
                        _token: "{{ csrf_token() }}"
                    }
                } else {
                    param = {
                        user_id:id,
                        gz_user_id:userid,
                        opt: 0,
                        _token: "{{ csrf_token() }}"
                    }
                }
                //从后台设置管理员状态
                guanZhu_setGuanZhu('{{URL::asset('')}}', param, function (ret) {
                    if (ret.result == true) {
                        $("#" + id).remove();
                        layer.msg('已取消', {icon: 5, time: 1000});
                    }
                })
            });
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


    </script>
@endsection