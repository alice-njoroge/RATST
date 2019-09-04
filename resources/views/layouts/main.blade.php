<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>@yield('title') | RATSQL</title>


    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @stack('styles')

</head>
<body>
<div id="app">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">RATSQL</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{route('parser')}}">Parser</a>
            <a class="p-2 text-dark" href="{{route('add-schema-step-1')}}">Key in data</a>
            <a class="p-2 text-dark" href="{{route('import')}}">Import from SQL dump </a>
            <a class="p-2 text-dark" href="{{route('import_from_excel')}}">Import from Excel</a>
        </nav>
    </div>

    @yield('top-content')
    <div class="{{isset($container_fluid) && $container_fluid == true ? 'container-fluid' : 'container'}}">
        @include('flash::message')
        @yield('main-content')
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <img class="mb-2" src="/docs/4.3/assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
                    <small class="d-block mb-3 text-muted">&copy; {{now()->format('Y')}}</small>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@stack('scripts')
</body>
</html>
