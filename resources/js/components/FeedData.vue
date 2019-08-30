<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" v-for="attribute in attributes">{{attribute.name}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="data in input_data">
                <td v-for="attribute in data[0]">
                    <input
                        v-if="attribute.type ==='int' || attribute.type === 'float'"
                        type="number" class="form-control" name="" v-model="attribute.name">
                    <input v-else type="text" class="form-control" name="" v-model="attribute.name">

                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "FeedData",
        props: ['attributes'],
        data() {
            return {
                input_data: []
            }
        },
        mounted() {
            for (let attribute of this.attributes) {
                this.input_data.push([
                    {
                        'id': attribute.id,
                        'name': attribute.name,
                        'type': attribute.type
                    }
                ])
            }
        },
        methods: {}
    }
</script>

<style scoped>

</style>
