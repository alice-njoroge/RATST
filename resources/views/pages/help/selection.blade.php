@extends('layouts.help')

@section('content')
    <div class="card">
        <br class="card-body">
        <div class="ml-3 mr-3">
            <h3> What is Relational Algebra </h3>
            <p>
                Relational algebra is a procedural query language, which takes instances of relations as input
                and yields instances of relations as output. It uses operators to perform queries. An operator
                can be either unary or binary. They accept relations as their input and yield relations as their
                output. Relational algebra is performed recursively on a relation and intermediate results are
                also considered relations.
            </p> </br>


            <h4>Unary Relational Operations</h4>
            <ul>
                <li>SELECT (σ)</li>
                <li>PROJECT ( π)</li>
                <li>RENAME (ρ)</li>
            </ul>
            </br>

            <h4> Binary Relational Operations</h4>
            <ul>
                <li>JOIN</li>
                <li>DIVISION</li>
            </ul>

            <h4>Relational Algebra Operations From Set Theory</h4>
            <ul>
                <li>UNION (υ)</li>
                <li>INTERSECTION ( ∩)</li>
                <li>DIFFERENCE (-)</li>
                <li>CARTESIAN PRODUCT ( x )</li>

            </ul>

        </div>
    </div>
    </div>
@endsection
