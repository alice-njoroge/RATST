<template>
    <div>
        <div class="card p-1">
            <div class="card-text">
                <p>Database:<b> {{database_name}}</b></p>
                <p><u><b>Tables</b></u></p>
                <p class="ml-1" v-for="item in tables"><b>{{item.table}}</b>
                    <br/>
                    <span class="ml-2" v-for="column in item.columns">{{column.field}} -  {{column.type}}
                <hr style="border-style: dotted;"/>

            </span></p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['database_name'],
        data() {
            return {
                tables: []
            }
        },
        created() {
            axios({
                'method': 'get',
                'url': '/databases/tables_fields/' + this.database_name
            })
                .then(res => this.tables = res.data)
                .catch(error => console.log(error));
        }
    }
</script>
