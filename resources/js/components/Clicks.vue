<template>
   
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Clicks
                        <div class="float-right">
                            <input type="date" v-model="filters.from" @change="init">
                             <input type="date" v-model="filters.to" @change="init">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-3" v-for="(overall,index) in overalls" :key="'overall'+index">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ index | wordFilter }}</h5>
                                        <p class="card-text">${{ overall | amount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        Note Legend: Clicks | Conversion
                        <table class="table">
                            <thead>
                                <th width="15%">Date</th>
                                <th>ShagToday</th>
                                <th>HookupToday</th>
                                <th>Site2Night</th>
                                <th>HoneyNearby</th>
                                <th>Total</th>
                            </thead>

                            <tr v-for="(clicks,index) in data.data" :key="index">
                               <td> {{ clicks.date }} </td>
                                <td> {{ clicks.shag_clicks }} | <strong>{{ clicks.shag_conversions }}</strong> | ${{ clicks.shag_earnings | amount }} </td>
                                <td> {{ clicks.hut_clicks }} | <strong>{{ clicks.hut_conversions }}</strong> | ${{ clicks.hut_earnings | amount }} </td>
                                <td> {{ clicks.site_2_night }} | <strong>{{ clicks.site_2_night_conversions }}</strong>  | ${{ clicks.site_2_night_earnings | amount }} </td>
                                <td> {{ clicks.honey_nearby }} | <strong>{{ clicks.honey_nearby_conversions }}</strong> | ${{ clicks.honey_nearby_earnings | amount }} </td>
                                <td> {{ clicks.clicks }} | <strong>{{ clicks.conversions }}</strong> | ${{ clicks.earnings | amount }} </td>
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
                selected: [],
                overalls:[]
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
            this.cards()
        },

        filters: {
            wordFilter(str) {
             return str
                .split('_')
                .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                .join(' ');    
            },
             amount(val) {
                return val.toFixed(2)
            }
        },

        methods: {
            cards(){
                axios.get(
                    '/overall')
                .then((res) => [
                    this.overalls = res.data
                ])
                .catch((err) => {

                })
                .then(() => {
                    this.init()
                })

            },

            init(){
                try {
                    window.history.replaceState('Dashboard', 'Dashboard', window.location.pathname + '?' +new URLSearchParams(this.filters).toString())
                } catch (e) { }
                axios.post(
                    '/clicks', {
                        to: this.filters.to,
                        from: this.filters.from
                     })
                .then((res) => [
                    this.data = res  
                ])
            },
        }
    }
</script>
