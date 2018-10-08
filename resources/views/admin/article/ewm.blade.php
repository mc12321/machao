@extends('admin.layouts.app')

@section('content')

    <div class="page-container">
        <div style="text-align: center;">
            <img src="{{URL::asset('/img/'.$filename)}}">
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $(function () {

        });

    </script>
@endsection