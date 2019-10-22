@extends('layouts.main')

@section('title', 'Schemas')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h6 class="display-4">Custom Designs Available</h6>
        <p class="lead">Click the create button below to design your database</p>
    </div>
@endsection
@section('main-content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">databases</h2>
            <a href="{{route('create_database')}}" class="btn btn-sm btn-outline-success float-right mb-2">
                Design Database</a>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($databases as $database)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$database->name}}</td>
                        <td>
                            <a href="{{route('feed.index', $database->name)}}"
                               class="btn btn-outline-success btn-sm mr-1" title="Select a table">view tables</a>
                            <a href="#" class="btn btn-outline-info btn-sm mr-1">update</a>
                            <a href="{{route('remove_database',$database->name)}}"
                               class="btn btn-outline-danger btn-sm mr-1">remove</a>
                        </td>
                    </tr>
                @endforeach
                @if($databases->isEmpty())
                    <tr>
                        <td colspan="3">There are no database at this time. Create one by clicking on the create
                            database
                            button on top
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
