<template>
    <div>
        <p v-for="item in database_list"><a href="#">{{item.database}}</a></p>
    </div>
</template>
<script>
    export default {
        name: 'Databases',
        data() {
            return {
                database_list: []
            }
        },
        created() {
            axios({
                'method': 'get',
                'url': '/databases'
            })
                .then(res => this.database_list = res.data)
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>
