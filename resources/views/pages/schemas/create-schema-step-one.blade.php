@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">Design your Database</h3>
        <p class="lead">Step One</p>
    </div>
@endsection
@section('main-content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Create Schema / step 1</h2>
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
                    <form novalidate method="post" action="{{route('store_database')}}">
                        @csrf
                        <div class="form-group">
                            <label for="nameInput">Name</label>
                            <input type="text" class="form-control" id="nameInput" name="name"
                                   placeholder="Enter name of the database" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="number_of_tables">Number Of Tables</label>
                            <input type="number" class="form-control" id="number_of_tables" min="1"
                                   value="{{old('number_of_tables')}}"
                                   name="number_of_tables" placeholder="Enter Number of Tables">
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
