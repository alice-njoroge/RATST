@extends('layouts.main')

@section('title', 'Schemas')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h6 class="display-4">Import from SQL dump </h6>
        <p class="lead">Click the green button below to upload your schema</p>
    </div>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center"> Import from SQL</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form enctype="multipart/form-data" novalidate action="{{route('upload')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="provide_database">Database Name</label>
                            <input type="text" name="database" class="form-control" id="provide_database" placeholder="Provide Database Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">choose file from my computer </label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="sql_file">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
