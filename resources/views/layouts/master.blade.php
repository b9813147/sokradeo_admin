<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>後台管理 - 蘇格拉底</title>

    {{--<!-- Custom styles for this template-->--}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body id="page-top">
<div id="wrapper">
    {{--header--}}
    @include('layouts._header')

    {{--Sidebar --}}
    @include('layouts._sidebar')

    <div id="content-wrapper" class="pt-5">
        <div class="container-fluid pt-5">

            @yield('content')


        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        @include('layouts._footer')


    </div>
    <!-- /.content-wrapper -->
    <progress-component></progress-component>
</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
