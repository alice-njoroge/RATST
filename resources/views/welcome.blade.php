@extends('layouts.main')

@section('title', 'Schemas')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h6 class="display-4">Available Designs </h6>
        <p class="lead">Click the green button below to design your schema</p>
    </div>
@endsection
@section('main-content')
    @php
        $key = "Tables_in_" . env('DB_DATABASE');
    @endphp
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Schemas</h2>
            <a href="{{route('add-schema-step-1')}}" class="btn btn-sm btn-outline-success float-right mb-2">Add
                Schema</a>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($schemas as $schema)
                    <tr>
                        @if($schema->$key != 'migrations' && $schema->$key != 'users' && $schema->$key != 'password_resets')
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$schema->$key}}</td>
                            <td>
                                <a href="{{route('feed-data', $schema->$key)}}"
                                   class="btn btn-outline-success btn-sm mr-1">feed
                                    data</a>
                                <a href="#" class="btn btn-outline-info btn-sm mr-1">update</a>
                                <a href="{{route('remove-schema', $schema->$key)}}"
                                   class="btn btn-outline-danger btn-sm mr-1">remove</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                @if(empty($schema))
                    <tr>
                        <td colspan="3">There are no schemas at this time. Create one by clicking on the create schema
                            button on top
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
