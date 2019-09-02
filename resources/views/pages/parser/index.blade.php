@extends('layouts.main')

@section('title', 'Parser')
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
    <div class="row">
        <div class="col-md-3">

        </div>
    </div>
@endsection
