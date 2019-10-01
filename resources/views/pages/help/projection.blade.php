@extends('layouts.help')
@push('styles')
    <style>
       .font-size-12{
           font-size:1.2em;

       }
    </style>
    @endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                        <div class="ml-3 mr-3">
                            <h3> Projection </h3>
                            <p>
                                Projection is a unary operation written as(Π).</br>
                                It projects column(s) that satisfy a given predicate
                            </p> </br>


                            <h4>Syntax</h4>
                            <td style="width: 100%; text-align: center;">
                                <strong><span style="font-size: 12pt;">∏<sub>&lt;A1, A2,...., An&gt;</sub>(R)</span></strong>
                            </td>
                            <br>
                            <ul>
                                <li>where R represents the name of the relation</li>
                                <li> A1, A2 , An are attribute names of relation R.</li>
                            </ul>
                            Duplicate rows are automatically eliminated, as a relation is a set.

                            </br>  </br>

                            <h4><u> Examples</u></h4>
                            <ul>
                                <li>Select and project columns named as subject and author from the relation Books.
                                <ul>
                                    <li><pre class="result notranslate"><span class="font-size-12">∏<sub>subject, author</sub> (Books)</span>
</pre></li>
                                </ul> </li>
                                <li>Select and project columns named as ID and name from the relation Students.
                                    <ul>
                                        <li><pre class="result notranslate"><span class="font-size-12">∏<sub>ID, name</sub> (Students)</span>
</pre></li>
                                    </ul> </li>
                                <li>Select and project columns named as age and name from the relation Students.
                                    <ul>
                                        <li><pre class="result notranslate"><span class="font-size-12">∏<sub>name, age</sub> (Students)</span>
</pre></li>
                                    </ul> </li>

                            </ul>
                            <h4><u> Notes</u></h4>
                            <ul>
                                <li>There is only one difference between projection operator of relational algebra and SELECT operation of SQL</li>
                                <li>Projection operator does not allow duplicates while SELECT operation allows duplicates.</li>
                                 <li>To avoid duplicates in SQL, we use “distinct” keyword and write SELECT distinct</li>
                                <li>Thus, projection operator of relational algebra is equivalent to SELECT operation of SQL.</li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

    </div>
    @endsection
