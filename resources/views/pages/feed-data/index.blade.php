@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">Feed Data</h3>
    </div>
@endsection
@section('main-content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Feed data to {{$schema->name}}</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form novalidate method="post" action="{{route('process-step-2')}}">
                <input type="hidden" name="schema_id" value="{{$schema->id}}">
                @csrf
                <feed-data :attributes="{{$schema->attributes}}"></feed-data>
                <button type="submit" class="btn btn-outline-primary">submit</button>
            </form>
        </div>
    </div>
@endsection
