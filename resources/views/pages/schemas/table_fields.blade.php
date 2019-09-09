@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">Design your Database</h3>
        <p class="lead">Step Three</p>
    </div>
@endsection
@section('main-content')
    @php
        $current_table_index = (int) session()->get('current_table');
        $table = session()->get('tables')[$current_table_index];
        $table_name = $table['name'];
        $table_columns = $table['number_of_fields'];
    @endphp
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Add fields for table {{$table_name}}/ step 3</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form novalidate method="post" action="{{route('process_create_fields')}}">
                @csrf
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Size</th>
                        <th scope="col">Nullable?</th>
                        <th scope="col">Index?</th>
                        <th scope="col">Primary Key?</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(range(1, $table_columns) as  $i)
                        <tr>
                            <th>
                                <input type="text" class="form-control" name="fields[{{$i}}][name]"
                                       value="{{old('fields.'.$i.'.name')}}">
                            </th>
                            <td>
                                <select class="form-control" name="fields[{{$i}}][type]">
                                    <option value="int">int</option>
                                    <option value="float">float</option>
                                    <option value="date">date</option>
                                    <option value="datetime">datetime</option>
                                    <option value="timestamp">timestamp</option>
                                    <option value="char">char</option>
                                    <option value="varchar">varchar</option>
                                    <option value="text">text</option>
                                </select>
                            </td>
                            <td><input type="number" class="form-control" name="fields[{{$i}}][size]">
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input ml-3" name="fields[{{$i}}][null]">
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input ml-3" name="fields[{{$i}}][index]">
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input ml-3"
                                       name="fields[{{$i}}][primary_key]">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-outline-primary">submit</button>
            </form>
        </div>
    </div>
@endsection
