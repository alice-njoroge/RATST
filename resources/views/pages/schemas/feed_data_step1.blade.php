@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">Design your Database</h3>
        <p class="lead">Step Four</p>
    </div>
@endsection
@section('main-content')
    @php
        $current_table_to_feed_data = (int) session()->get('current_table_to_feed_data');
        $table = session()->get('tables')[$current_table_to_feed_data];
        $table_name = $table['name'];
        $table_columns = $table['number_of_fields'];
    @endphp
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Add data to table {{$table_name}}</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form novalidate method="post" action="{{route('process_feed_table_data')}}">
                @csrf
                <div class="form-group">
                    <label for="rows">No. of data to feed</label>
                    <input type="email" id="rows" class="form-control" name="no_of_rows" aria-describedby="emailHelp"
                           placeholder="Enter number">
                    <small class="form-text text-muted">How many rows of data to feed?</small>
                </div>
                <button type="submit" class="btn btn-outline-primary">submit</button>
            </form>
        </div>
    </div>
@endsection
