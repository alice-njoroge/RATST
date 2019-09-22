@extends('layouts.help')

@section('content')
    <div class="card">
        <br class="card-body">
        <div class="ml-3 mr-3">
            <h3> Selection </h3>
            <p>
                Selection Operator (σ) is a unary operator in relational algebra that performs a selection
                operation.</br>
                It selects those rows or tuples from the relation that satisfies the selection condition.
            </p> </br>


            <h4>Syntax</h4>
            <td style="width: 100%; text-align: center;">
                <strong><span style="font-size: 12pt;">σ<sub>&lt;selection_condition&gt;</sub>(R)</span></strong>
            </td>
            <br>
            where R represents the name of the relation
            </br>  </br>

            <h4><u> Examples</u></h4>
            <ul>
                <li>Select tuples from a relation “Books” where subject is “database”</li>
                <ul>
                    <li>σsubject = “database” (Books)</li>
                </ul>
                <li>Select tuples from a relation “Books” where subject is “database” and price is “450”</li>
                <ul>
                    <li>σsubject = “database” ∧ price = “450” (Books)</li>
                </ul>
                <li>Select tuples from a relation “Books” where subject is “database” and price is “450” or have a
                    publication year after 2010
                    <ul><li>σsubject = “database” ∧ price = “450” ∨ year >”2010″ (Books)</li></ul>
                </li>
            </ul>


        </div>
    </div>
    </div>
@endsection
