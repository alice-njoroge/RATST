@extends('layouts.main')

@section('title', 'Create Schema')
@section('top-content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3 class="display-4">Design your schema</h3>
        <p class="lead">Step Two</p>
    </div>
@endsection
@section('main-content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Add Attributes for schema {{$schema->name}}/ step 1</h2>
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
                    @foreach(range(1, $schema->number_of_attributes) as  $i)
                        <tr>
                            <th>
                                <input type="text" class="form-control" name="attributes[{{$i}}][name]" value="{{old('attributes.'.$i.'.name')}}">
                            </th>
                            <td>
                                <select class="form-control" name="attributes[{{$i}}][type]">
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
                            <td><input type="number" class="form-control" name="attributes[{{$i}}][size]">
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input ml-3" name="attributes[{{$i}}][null]">
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input ml-3" name="attributes[{{$i}}][index]">
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input ml-3"
                                       name="attributes[{{$i}}][primary_key]">
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
