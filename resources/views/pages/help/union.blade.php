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
            <h3> Union </h3>
            <p>
                It performs binary union between two given relations<br/>
                The operation is denoted ∪ from set theory and represents a collection of all elements in a set.

            </p> <br/>


            <h4>Syntax</h4>
            <td style="width: 100%; text-align: center;">
                <strong><span class="font-size-12"> <sub>r ∪ s = { t | t ∈ r or t ∈ s}</sub></span></strong>
            </td>
            <br>
            <ul>
                <li>where R represents the name of the relation</li>
                <li>This will rename attribute ‘b’ of relation by ‘a’.</li>
            </ul>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{asset('images/union.png')}}" width="200" height="150" alt="" style="padding-bottom:0.5em;" >Union of two sets
                        </div>
                        <div class="col-md-6">
                            <img src="{{asset('images/Venn_0111_1111.svg')}}" width="150" height="150" alt="" style="padding-bottom:0.5em;" >union of three sets

                        </div>
                    </div>

                </div>
            </div>

            <br/>  <br/>

            <h4><u> Examples</u></h4>
            <ul>
                <li> The set A union set B would be expressed as: </li>

                <ul>

                    <li>A ∪ B</li>
                </ul>
                <ul><li> The results are all attributes in tables A or in B, eliminating duplicate tuples</li></ul>

        </div>
        <h4><u> Note</u></h4>
        <ul>
            <li>A and B must be the same number of attributes.</li>
            <li>Attribute domains need to be compatible.</li>
            <li> Duplicate tuples should be automatically removed.</li>
        </ul>

         </div>
    </div>
@endsection
