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
            <h3> Joins </h3>
            <p>Join operation is essentially a cartesian product followed by a selection criterion. <br/>
                Join operation is denoted by ⋈.</p>

            <div class="card">
                <div class="card-header">
                    Types of JOIN:
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                            <li>
                                Inner Joins
                                <ul>
                                    <li>Theta join</li>
                                    <li>EQUI join</li>
                                    <li>Natural join</li>
                                </ul>
                            </li>
                            </ul>

                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>
                                    Outer join
                                    <ul>
                                        <li>Left Outer Join</li>
                                        <li>Right Outer Join</li>
                                        <li>Full Outer Join</li>
                                    </ul>
                                </li>
                            </ul>

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
@endsection
