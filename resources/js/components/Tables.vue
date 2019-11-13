<template>
    <div>
        <div class="card p-1">
            <div class="card-text">
                <p>Database:<b> {{database_name}}</b></p>
                <p><u><b>Tables</b></u></p>
                <p class="ml-1" v-for="item in tables"><b class="cursor table-selection">{{item.table}}</b><a
                    @click.prevent="view_data(item.table,database_name)" href="#!" class="float-right">view data</a>
                    <br/>
                    <span class="ml-2 cursor table-selection" v-for="column in item.columns">{{column.field}}-  {{column.type}}<hr
                        style="border-style: dotted;"/>

                    </span></p>
            </div>
        </div>
        <div class="modal fade" id="displayDataModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" v-bind:style="styleObject" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Sample data for {{current_table_name}}
                            table in {{current_database_name}} database</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col" v-for="column in columns">{{column.Field}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="row in data">
                                <th v-for="data_item in row">{{data_item}}</th>
                            </tr>
                            </tbody>
                        </table>
                        <p v-if="this.data.length === 10" class="text-center"><b>...............</b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    // props are used to pass down state to child components.
    export default {
        props: ['database_name'],
        data() {
            return {
                tables: [],
                error: null,
                current_table_name: '',
                current_database_name: '',
                columns: [],
                data: [],
                styleObject: {
                    'max-width': '1200px'
                }
            }
        },
        created() {
            axios({
                'method': 'get',
                'url': '/databases/tables_fields/' + this.database_name
            })
                .then(res => this.tables = res.data)
                .catch(error => {
                    if (error.response.status === 400) {
                        this.error = error.response.data.message
                    }
                });
        },
        methods: {
            view_data: function (table_name, database_name) {
                $('#displayDataModal').modal('show');
                this.current_table_name = table_name;
                this.current_database_name = database_name;
                axios({ //http client for making ajax requests
                    method: 'post',
                    url: '/show-sample-data',
                    data: {
                        database_name: database_name,
                        table_name: table_name
                    }
                })
                    .then(response => {
                        this.columns = response.data.columns;
                        this.data = response.data.data;
                        if (this.columns.length <= 5) {
                            this.styleObject["max-width"] = '700px'
                        } else {
                            this.styleObject["max-width"] = '1200px'
                        }
                    })
                    .catch(error => {
                        return console.log(error.response.data)
                    })
            }
        }
    }
</script>
<style scoped>
    .cursor {
        cursor: pointer;
    }
</style>
