@extends('layouts.main')
@section('main-content')
    <main role="main" class="">
        <div class="card">
            <div class="card-header">
                <h2>About</h2>
            </div>
            <div class="card-body">
                <article class="row single-post mt-5 no-gutters">
                    <div>
                        <div class="image-wrapper float-left pr-3">
                            <img src="{{asset('images/alice.jpg')}}" class="rounded"
                                 alt="Cinque Terre" width="210" height="236">
                        </div>
                        <div class="single-post-content-wrapper p-3">

                            <p><b>Name:</b> Alice Njoroge</p>
                            <p><b>University:</b> Dedan Kimathi University</p>
                            <p><b>Course:</b> Bsc. Computer Science </p>
                            <p><b>Skills:</b> Laravel and Vue Js</p>
                            <p><b>Project Supervisor:</b> Mr. Kagiri</p>


                            <br><br>
                             This software is a DLO and a Parser that translates Relational Algebra to equivalent and
                            valid SQL queries. It is meant to ease the learning curve of foundational concepts to Database students.
                            <br>Many Thanks to My supervisor Mr. Kagiri, without him this would be
                            completely impossible!!

                        </div>
                    </div>
                </article>
            </div>
        </div>
    </main>
@endsection
