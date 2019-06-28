@extends('layouts.master')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">群組管理</a>
        </li>
        <li class="breadcrumb-item active">人員列表</li>
    </ol>

    <group-member-component></group-member-component>
@stop
