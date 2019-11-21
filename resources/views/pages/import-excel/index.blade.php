@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">Import From Excel Sheet</h3>
    </div>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Import Excel Data</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form novalidate method="post" action="{{route('process_excel_file')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="provide_database">Database Name</label>
                            <input type="text" name="database" class="form-control" id="provide_database"
                                   placeholder="Provide Database Name">
                        </div>
                        <div class="form-group">
                            <label for="schema">Table Name</label>
                            <input type="text" name="schema_name" class="form-control" id="schema"
                                   placeholder="Enter Schema Name">
                        </div>
                        <div class="form-group">
                            <label for="excell_sheet">Upload the excel file</label>
                            <input name="excel_sheet" type="file" class="form-control-file" id="excell_sheet">
                        </div>
                        <button type="submit" class="btn btn-primary">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
