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
            <h3> Cartesian product </h3>
            <p>
                An intersection is defined by the symbol  X<br/>
            <p>This type of operation is helpful to merge columns from two relations. Generally, a Cartesian product is never a meaningful operation when it performs alone.
                However, it becomes meaningful when it is followed by other operations.</p>

            </p> <br/>


            <h4>Syntax</h4>
            <td style="width: 100%; text-align: center;">
                <strong><span class="font-size-12"> A X B</span></strong>
            </td>
            <br>
            <ul>
                <li>where A and B are relations</li>
                <li> It Defines a relation consisting of a set
                    of all tuples that are in both A and B. However,
                    A and B must be union-compatible.</li>
            </ul>

            <h4>Example</h4>
            <td style="width: 100%; text-align: center;">
                <strong><span style="font-size: 12pt;">σ<sub>&lt;column 2 = '1'&gt;</sub>(A X B)</span></strong>
            </td>
            <ul>
                <li>Output-- The above example shows all rows from relation A and B whose column 2 has value 1
                </li>
            </ul>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{asset('images/cross-join.png')}}" width="350" height="150" alt="" style="padding-bottom:0.5em;" >
                        </div>

                    </div>

                </div>
            </div>

            <br/>  <br/>


        </div>
        <h4><u> Note</u></h4>
        <ul>
            <li>A and B must be the same number of attributes.</li>
            <li>Attribute domains need to be compatible.</li>
            <li> A and B must be union-compatible.</li>
        </ul>

    </div>
    </div>
@endsection
