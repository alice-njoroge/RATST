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
        $current_table_to_feed_data_index = (int) session()->get('current_table_to_feed_data');
        $table = session()->get('tables')[$current_table_to_feed_data_index];
        $table_name = $table['name'];
        $fields = $table['fields'];
        $no_of_rows = $table['no_of_rows'];

        // define the function that checks the data type of a field
        // given the type
        function field_data_type($type)
        {
            if ($type == 'float' || $type == 'int') {
                return 'number';
            }
            return 'text';
        }

        // given the field associative array check if the field is required if it does not have the null key
        function field_required($field_associative_array)
            {
                if (array_key_exists('null', $field_associative_array)) {
                    return '';
                }
                    return 'required';
            }

        // check the size of the field
        function field_size($field_associative_array)
            {
                if ($field_associative_array['type'] == 'varchar' || $field_associative_array['type'] == 'char')
                    {
                        return $field_associative_array['size'];
                    }
                return '';
            }
    @endphp
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center">Feed data for table {{$table_name}}/ step 4</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{route('process_create_fields')}}">
                @csrf
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($fields as $field)
                            <th scope="col">{{$field['name']}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(range(1, $no_of_rows) as  $i)
                        <tr>
                            @foreach($fields as $field)
                                <td><input type="{{field_data_type($field['type'])}}" class="form-control"
                                           name="data[{{$i}}][{{$field['name']}}]"
                                           maxlength="{{field_size($field)}}" {{field_required($field)}}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <input type="submit" name="submit" value="submit and feed the next table"
                       class="btn btn-outline-primary"/>
                <input type="submit" name="submit" value="submit and feed more data" class="btn btn-outline-primary"/>

            </form>
        </div>
    </div>
@endsection
