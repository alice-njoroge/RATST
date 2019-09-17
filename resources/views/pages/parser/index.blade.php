@extends('layouts.main')

@section('title', 'Parser')
@push('styles')
    <style type="text/css" media="screen">
        #editor {
            height: 400px;
            width: auto;
        }
    </style>
@endpush
@section('main-content')
    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dataset">
        Choose Dataset
    </button>

    <div class="modal fade" id="dataset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Choose Dataset Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Use Auto Generated Data</h4>
                            <databases></databases>
                        </div>
                        <div class="col-md-6">
                            <h4>Or ...</h4>
                            <p><a href="" class="btn btn-outline-secondary">Key in Data</a></p>
                            <p><a href="" class="btn btn-outline-secondary">Import from Excel</a></p>
                            <p><a href="" class="btn btn-outline-secondary">Import from MYSQL dump</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <div class="col-md-3">
            <tables database_name="{{$database}}"></tables>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 0.25rem">
                    <div class="card-text">
                        |<span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">Π </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">σ </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">ρ </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">X </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">U </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">- </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">∩ </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">⋈ </span>|
                        <span style="cursor: pointer;padding: 0 10px 0 10px" class="symbol">θ </span>|
                    </div>
                </div>
            </div>
            <br>
            <div id="editor">σ field = "filter" Π field (schema)</div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4>Help</h4>
                    <hr/>
                    <b>Projection, Π</b>
                    <p>A projection is a unary operation written as {\displaystyle \Pi _{a_{1},\ldots ,a_{n}}(R)}
                        \Pi_{a_1, \ldots,a_n}( R ) where {\displaystyle a_{1},\ldots ,a_{n}} a_1,\ldots,a_n is a set of
                        attribute names. The result of such projection is defined as the set that is obtained when all
                        tuples in R are restricted to the set {\displaystyle \{a_{1},\ldots ,a_{n}\}} \{a_{1},\ldots
                        ,a_{n}\}.

                        Note: when implemented in SQL standard the "default projection" returns a multiset instead of a
                        set, and the Π projection is obtained by the addition of the DISTINCT keyword to eliminate
                        duplicate data.</p>
                    <a href="{{route('learn-more')}}" class="btn btn-outline-primary float-right">Read More </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{{--    import the ace library--}}
    <script src="{{asset('ace-builds-master/src-min-noconflict/ace.js')}}" type="text/javascript"
            charset="utf-8"></script>
    <script>
        // configure the library
        var editor = ace.edit("editor");
        editor.setOptions({
            autoScrollEditorIntoView: true,
            copyWithEmptySelection: true,
        });
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/text");

        $(window).ready(function () {
            $(".symbol").on('click', function () {
                var text = $(this).text();
                var editor_text = editor.getValue();
                if (editor_text.includes('σ field = "filter" Π field (schema)')) {
                    editor.setValue(text);
                } else {
                    editor.setValue(editor_text + text)
                }
            });

            setTimeout(function () {
                $(".table-selection").on('click', function () {
                    var text = $(this).text();
                    if (text.includes('-')) {
                        var remove_after = text.indexOf('-');
                        var final_text = text.substring(0, remove_after);
                    } else {
                        var final_text = text;
                    }
                    var editor_text = editor.getValue();
                    if (editor_text.includes('σ field = "filter" Π field (schema)')) {
                        editor.setValue(final_text);
                    } else {
                        editor.setValue(editor_text + final_text)
                    }
                });
            }, 1000);
        });
    </script>
@endpush
