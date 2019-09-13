@extends('layouts.help')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4> What is Relational Algebra </h4>
            <p>
                Relational algebra is a procedural query language, which takes instances of relations as input
                and yields instances of relations as output. It uses operators to perform queries. An operator
                can be either unary or binary. They accept relations as their input and yield relations as their
                output. Relational algebra is performed recursively on a relation and intermediate results are
                also considered relations.
            </p>
        </div>
    </div>
    @endsection
