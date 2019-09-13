@extends('layouts.main')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <a href="{{route('learn-more')}}">Introduction </a>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                σ Selection
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Π Projection
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                ∪ Union
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                - Set Difference
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                ∩ Intersection
                            </a>
                        </li>
                    </ul>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            ρ Rename
                        </a>
                    </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Last quarter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Social engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Year-end sale
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-8 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">

                @yield('content')


            </main>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>
@endpush
