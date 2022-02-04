<template>
   
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Comments and Reviews</div>
                    <div class="card-body">

         

                        <table class="table">

                            <thead>
                                <th>Website</th>
                                <th>Name</th>
                                <th>Comment</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>

                            <tr v-for="(review,index) in data.data" :key="index">
                                <td>{{ review.website_url }}</td>
                                  <td>{{ review.name }}</td>
                                <td>{{ review.comment }}</td>
                                <td>{{ review.rating }}</td>
                                <td>{{ review.created_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" @click.prevent="approve(review.id, index)">Approve</button>
                                    <button style="margin-top:3px" class="btn btn-sm btn-danger" @click.prevent="reject(review.id, index)">Reject</button>
                                </td>
                            </tr>

                        </table>

                        <div class="text-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li @click.prevent="changePage(page)" class="page-item" v-for="page in data.last_page" :key="'k'+page" :disabled="page === filters.page"><a class="page-link" href="#"> {{ page }} </a></li>
                                </ul>
                            </nav>
                        </div>

                       
                    </div>
                </div>
            </div>
        </div>
  
</template>

<script>
    export default {
        name: 'Dashboard',

        data(){
            return {
                data: {},
                filters: {
                    page: 1,
                    website_id: 0
                }
            }
        },
 
        mounted() {
            this.init()
        },

        methods: {
            init(){
                axios.get(
                    '/reviews', {
                        params: this.filters
                     })
                .then((res) => [
                    this.data = res.data  
                ])
            },

             approve(id,index){
                axios.post(
                    '/review/'+id+'/approve')
                .then((res) => [
                    this.data.data.splice(index,1)
                ])
            },

             reject(id,index){
                axios.post(
                    '/review/'+id+'/reject')
                .then((res) => [
                    this.data.data.splice(index,1)
                ])
            },

            changePage(page) {
                if(page === this.filters.page) {
                    return;
                }

                this.filters.page = page;
                this.init()
            }
        }
    }
</script>
