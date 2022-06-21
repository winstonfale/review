<style scoped>
.cursor {
    cursor: pointer;
}
</style>

<template>
   
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header ">Costs from

                       <div class="">
                         <form @submit.prevent="addCost">
                            <input type="date" v-model="from" required>
                            to
                            <input type="date" v-model="to" required>
                            <input type="number" v-model="cost" required placeholder="Amount">
                            <button type="submit" >Add Cost Record</button>
                        </form>
                        </div>
                    </div>

                        <table class="table">
                            <thead>
                                <th>Date</th>
                                <th>Cost</th>
                                <th></th>
                            </thead>
                               <tr v-for="(cost,index) in data.data" :key="'cost' + index">
                                <td>{{ cost.from }} - {{ cost.to }}</td>
                                <td>{{ cost.cost }}</td>
                                 <td><button class="btn btn-danger" @click.prevent="deleteRecord(cost.id)">Delete</button></td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
  
</template>

<script>
    export default {
        name: 'Campaigns',

        data(){
            return {
                data: [],
                cost: '',
                from: new Date(new Date().setDate(new Date().getDate() - 7)).toISOString().slice(0, 10),
                to: new Date(new Date).toISOString().slice(0, 10)
            }
        },
        
        mounted() {
            this.fetch()
        },

        methods: {
            fetch(){
                axios.post(
                    '/costs', {
                        to: this.to,
                        from: this.from
                    })
                .then((res) => [
                    this.data = res.data
                ])
                .catch((err) => {

                })
            },

            addCost(){
                 axios.post(
                    '/cost/store', {
                        to: this.to,
                        from: this.from,
                        cost: this.cost
                     })
                .then(() => {
                    alert('Success')
                    this.cost = ''
                    this.fetch()
                })
                 .catch(() => {
                    alert('Error')
                })
            },

            deleteRecord(id){
                if (confirm("Confirm delete?! This action cannot be undone") == false) {
                    return
                } 

                axios.post(
                    '/cost/'+id+'/delete'
                ).then(() => {
                    this.fetch()
                })
                 .catch(() => {
                    alert('Error')
                })
            
            }
        }
    }
</script>
