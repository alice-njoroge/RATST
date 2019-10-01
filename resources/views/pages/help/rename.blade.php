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
            <h3> Rename </h3>
            <p>
                Rename is a unary operation used for renaming attributes of a relation.</br>
                The operation is denoted with small Greek letter rho ρ.

            </p> </br>


            <h4>Syntax</h4>
            <td style="width: 100%; text-align: center;">
                <strong><span style="font-size: 12pt;">ρ <sub>&lt;(a/b)&gt;</sub>(R)</span></strong>
            </td>
            <br>
           <ul>
               <li>where R represents the name of the relation</li>
               <li>This will rename attribute ‘b’ of relation by ‘a’.</li>
           </ul>
            </br>  </br>

            <h4><u> Examples</u></h4>
            <ul>
                <li>Consider a relation "Employees" with an attribute "Name" the
                    invocation of ρ will rename the attribute Name to EmployeeName </li>

                <ul>
                    see the command:
                    <li>ρ EmployeeName/name (Employees)</li>
                </ul>



        </div>
    </div>
    </div>
@endsection
