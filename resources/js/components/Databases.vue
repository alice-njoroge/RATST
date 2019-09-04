<template>
    <div>
        <p v-for="item in database_list"><a :href="'/parser/' + item.database">{{item.database}}</a></p>
    </div>
</template>
// functionality to fetch data from inside otherwise use props
<script>
    export default {
        name: 'Databases',
        data() {
            return {
                database_list: []
            }
        },
        // http client axios to access urls
        created() {
            axios({
                'method': 'get',
                'url': '/databases'
            })
                // asynchronuous processing working on promises to return data
                .then(res => this.database_list = res.data) // funtion takes the response as an argument and returns in in the internal variable database_list
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>
