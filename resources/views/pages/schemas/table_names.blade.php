@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">Design your Database</h3>
        <p class="lead">Step Two</p>
    </div>
@endsection
@section('main-content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Provide table names for database {{session()->get('database_name')}} /
                step 2</h2>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form novalidate method="post" action="{{route('process_create_tables')}}">
                        @csrf
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Table Name</th>
                                <th scope="col">No. of Columns</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(range(1, $no_tables) as $i)
                                <tr>
                                    <th>
                                        <input type="text" class="form-control" name="tables[{{$i}}][name]"
                                               value="{{old('tables.'.$i.'.name')}}">
                                    </th>
                                    <td><input type="number" class="form-control"
                                               name="tables[{{$i}}][number_of_fields]"
                                               value="{{old('tables.'.$i.'.number_of_fields')}}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-outline-primary">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
