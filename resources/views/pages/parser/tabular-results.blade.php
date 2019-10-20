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
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="sql" role="tabpanel" aria-labelledby="profile-tab">This will
                display the generated SQL
            </div>
        </div>
    </div>
</div>
