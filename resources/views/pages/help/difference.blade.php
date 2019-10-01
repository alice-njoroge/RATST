@extends('layouts.help')
@push('styles')
    <style>
        .font-size-12{
            font-size:1.2em;

        }
    </style>
@endpush

@section('content')
    <div class="card">
        <br class="card-body">
        <div class="ml-3 mr-3">
            <h3> Set Difference </h3>
            <p>
                The operation is denoted with the symbol (-).</br>


            </p> </br>


            <h4>Syntax</h4>
            <td style="width: 100%; text-align: center;">
                <strong><span style="font-size: 12pt;">A-B</span></strong>
            </td>
            <br>
            <ul>
                <li>where A and B are relations.</li>
                <li>The result is is a relation which includes all tuples that are in A but not in B.</li>
            </ul>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{asset('images/download (1).jpeg')}}" width="500" height="150" alt="" style="padding-bottom:0.5em;" >
                        </div>

                    </div>

                </div>
            </div>


            <h4><u> Note</u></h4>
            <ul>
                <li>The attribute name of A has to match with the attribute name in B.</li>
                <li> The two-operand relations A and B should be either compatible or Union compatible.</li>
                <li> The result should be a defined relation consisting of the tuples that are in relation A, but not in B </li>
            </ul>
        </div>
    </div>
    </div>
@endsection
