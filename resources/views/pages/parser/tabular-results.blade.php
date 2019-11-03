<div class="card mt-2">
    <h4 class="card-header text-center">
        Results
    </h4>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="relational-tab" data-toggle="tab" href="#relational"
                   role="tab" aria-controls="relational" aria-selected="true">Relational Output</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="sql-tab" data-toggle="tab" href="#sql" role="tab"
                   aria-controls="sql" aria-selected="false">Sql Output</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="relational" role="tabpanel"
                 aria-labelledby="home-tab">
                <div class="mt-3">
                    @if(sizeof($database_results) > 0)
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                @foreach($database_results[0] as $key => $value)
                                    <th scope="col">{{$key}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($database_results as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        <td>{{$value}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="sql" role="tabpanel" aria-labelledby="profile-tab">The SQL output will be:
                <p><code>{{$sql_output}}</code></p>
            </div>
        </div>
    </div>
</div>
