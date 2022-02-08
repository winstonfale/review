<template>
   
        <div class="row justify-content-center">
            <div class="col-md-7">
                 <div class="card-header">
                     Website info
                 </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Unique key</th>
                            </thead>

                            <tr v-for="website in data" :key="website.id">
                                <td> {{ website.id }} </td>
                                <td> {{ website.name }} </td>
                                <td> <textarea readonly class="form-control" rows="3" :value="website.access_key" /></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  
</template>

<script>
    export default {
        name: 'Websites',

        data(){
            return {
                data: {},
            }
        },
 
        mounted() {
            this.init()
        },

        methods: {
            init(){
                axios.get(
                    '/websites/info')
                .then((res) => [
                    this.data = res.data  
                ])
            },
        }
    }
</script>
