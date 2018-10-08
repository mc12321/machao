@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 文章详情 <span
                class="c-gray en">&gt;</span> 文章详情 <a class="btn btn-success radius r btn-refresh"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace(location.href);" title="刷新"
                                                      onclick="location.replace('{{URL::asset('/admin/article/info')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        <div class="panel panel-primary mt-20">
            <div class="panel-header">详细信息</div>
            <div class="panel-body">

                <table class="table table-border table-bordered radius">
                    <tbody>
                    <tr>
                        <td>标题</td>
                        <td>{{isset($data->name)?$data->name:'--'}}</td>

                        <td>点赞数</td>
                        <td>{{isset($data->zan_num)?$data->zan_num:'--'}}</td>
                        <td>展示数</td>
                        <td>{{isset($data->show_num)?$data->show_num:'--'}}</td>
                        <td>评论数</td>
                        <td>{{isset($data->comment_num)?$data->comment_num:'--'}}</td>
                    </tr>
                    <tr>
                        <td>文章说明
                        </td>
                        <td>{{isset($data->desc)?$data->desc:'--'}}</td>
                        <td>转发数</td>
                        <td>{{isset($data->trans_num)?$data->trans_num:'--'}}</td>
                        <td>收藏数</td>
                        <td>{{isset($data->coll_num)?$data->coll_num:'--'}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>


                <div class="panel panel-primary mt-20 text-c" style="width: 33rem;text-align: center" id="p">
                    @foreach($wzs as $wz)
                        <tr class="text-c">
                            <td colspan="4" style="">
                                @if(isset($wz->img))
                                    <img style="text-align: center;"
                                         src="{{ $wz->img .'?imageView2/1/w/500/h/200/interlace/1/q/75|imageslim'}}"
                                         class="radius-5"/><br/>
                                @endif
                                    @if(isset($wz->text))
                                        {{str_replace('<br/>','',$wz->text)}}
                                    @endif
                                @if(isset($wz->video))
                                    <video src="{{ $wz->video}}" class="radius-5" style="width: 8rem;"></video>
                                    <br/>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </div>

                <div>
                    @if (isset($data->content))
                        {!! $data->content !!}
                    @endif
                </div>


            </div>
        </div>



    </div>
@endsection

@section('script')


    <script type="text/javascript">


        $(function () {

        });


    </script>
@endsection