@extends('layouts.master')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">人員管理</a>
        </li>
        <li class="breadcrumb-item active">人員列表</li>
    </ol>

    {{--    <section class="py-3">--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-md-5"></div>--}}
    {{--            <div class="col-md-5">--}}
    {{--                <input type="text" class="form-control rounded-pill text-center" name="search" placeholder="Search">--}}
    {{--            </div>--}}
    {{--            <div class="col-md-2">--}}
    {{--                <a href="" class="btn btn-outline-secondary">Create <i class="fa fa-plus"></i></a>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
{{--<test-component></test-component>--}}

{{--<user-component></user-component>--}}
<member-component></member-component>




@stop
