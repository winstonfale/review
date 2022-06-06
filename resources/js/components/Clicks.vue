<template>
   
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Comments and Reviews
                        <div class="float-right">
                          <!-- <select v-model="filters.website_id" @change.prevent="init">
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
                                <option value="asc">Sort by Oldest</option>
                                <option value="desc">Sort by Latest</option>
                            </select> -->

                            <input type="date" v-model="filters.from" @change="init">

                             <input type="date" v-model="filters.to" @change="init">

                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-2 offset-8">
                                <button class="btn btn-sm btn-success form-control" @click.prevent="approveSelected">Approve Selected</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-sm btn-success form-control" @click.prevent="approveAll">Approve All</button>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <th width="15%">Date</th>
                                <th>Clicks</th>
                                <th>Conversion</th>
                            </thead>

                            <tr v-for="(clicks,index) in data.data" :key="index">

                                <td> {{ clicks.date }} </td>
                                <td> {{ clicks.clicks }} </td>
                               <td> {{ clicks.conversions }} </td>
                              
                            </tr>

                        </table>

                        <div class="text-center" >
                            <nav v-show="data.total > 0 ">
                                <ul class="pagination">
                                    <li @click.prevent="changePage(page)" class="page-item" v-for="page in data.last_page" :key="'k'+page" :disabled="page === filters.page"><a class="page-link" href="#"> {{ page }} </a></li>
                                </ul>
                            </nav>
                            <p v-show="!(data.total > 0)">No results  </p>
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
                    from: new Date(new Date().setDate(new Date().getDate() - 7)).toISOString().slice(0, 10),
                    to: new Date(new Date).toISOString().slice(0, 10)

                },
                selected: []
            }
        },

        created(){
          let uri = window.location.search.substring(1); 
          let params = new URLSearchParams(uri);

          let obj = this.filters;
          Object.keys(obj).forEach((key) => {
              if(params.get(key)) {
                  this.filters[key] = params.get(key)
              }
          });
        },
 
        mounted() {
            this.init()
        },

        methods: {
            init(){
                try {
                    window.history.replaceState('Dashboard', 'Dashboard', window.location.pathname + '?' +new URLSearchParams(this.filters).toString())
                } catch (e) { }

                console.log(this.filters.to)

                axios.post(
                    '/clicks', {
                        to: this.filters.to,
                        from: this.filters.from
                     })
                .then((res) => [
                    this.data = res.data  
                ])
            },
        }
    }
</script>
