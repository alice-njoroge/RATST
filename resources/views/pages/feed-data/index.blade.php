@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">{{$schema}} Tables</h3>
    </div>
@endsection
@section('main-content')
    @php
        $key = "Tables_in_" . $schema;
    @endphp
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Table</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tables as $table)
                    <tr>
                        <td>{{$table->$key}}</td>
                        <td>
                            <a href="{{route('feed.data_view',[$schema, $table->$key])}}"
                               class="btn btn-success btn-sm">Feed
                                Data</a>
                            <a href="#" class="btn btn-info btn-sm">Update Table</a>
                            <a href="#" class="btn btn-danger btn-sm">Remove Table</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
