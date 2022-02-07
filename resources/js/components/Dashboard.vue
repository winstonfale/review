<template>
   
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Comments and Reviews


                        <div class="float-right">

                          <select v-model="filters.website_id" @change.prevent="init">
                                <option value="1">Shagtoday</option>
                                <option value="2">HookUpToday</option>
                                <option value="3">BeeDate</option>
                                <option value="4">OhCupid</option>
                                <option value="0">All Sites</option>
                            </select>


                            <select v-model="filters.status" @change.prevent="init">
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                                <option value="2">Rejected</option>
                                <option value="all">All Reviews</option>
                            </select>

                            
                            <select v-model="filters.order_by" @change.prevent="init">
                                <option value="asc">Date posted</option>
                                <option value="desc">Latest</option>
                            </select>
                        </div>

                    </div>
                    <div class="card-body">

         

                        <table class="table">

                            <thead>
                                <th width="15%">Website & Name</th>
                                <th>Comment</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>

                            <tr v-for="(review,index) in data.data" :key="index">
                                <td>
                                    <strong>
                                        {{ review.website_url }}
                                    </strong>
                                    <br>
                                    {{ review.name }}
                                </td>
                                <td>
                                    <strong>  {{ review.feedback }} </strong> <br>
                                    {{ review.comment }}
                                </td>
                                <td>{{ review.rating }}</td>
                                <td>{{ review.created_at }}</td>
                                <td>
                                    <button :disabled="review.status === 1" class="btn btn-sm btn-success" @click.prevent="approve(review.id, index)">Approve</button>
                                    <button :disabled="review.status === 2" style="margin-top:3px" class="btn btn-sm btn-danger" @click.prevent="reject(review.id, index)">Reject</button>
                                </td>
                            </tr>

                        </table>

                        <div class="text-center" >
                            <nav v-show="data.total > 0 ">
                                <ul class="pagination">
                                    <li @click.prevent="changePage(page)" class="page-item" v-for="page in data.last_page" :key="'k'+page" :disabled="page === filters.page"><a class="page-link" href="#"> {{ page }} </a></li>
                                </ul>
                            </nav>

                            <p v-show="!(data.total > 0)">No results</p>
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
                    website_id: 0,
                    order_by: 'asc',
                    status: 0,
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
