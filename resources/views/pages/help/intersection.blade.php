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
            <h3> Intersection </h3>
            <p>
                An intersection is defined by the symbol ∩<br/>

            </p> <br/>


            <h4>Syntax</h4>
            <td style="width: 100%; text-align: center;">
                <strong><span class="font-size-12"> A ∩ B</span></strong>
            </td>
            <br>
            <ul>
                <li>where A and B are relations</li>
                <li> It Defines a relation consisting of a set
                    of all tuples that are in both A and B. However, A and B must be union-compatible.</li>
            </ul>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{asset('images/100518_0535_RelationalA4.png')}}" width="500" height="150" alt="" style="padding-bottom:0.5em;" >
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
