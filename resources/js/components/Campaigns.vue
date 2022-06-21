<style scoped>
.cursor {
    cursor: pointer;
}
</style>

<template>
   
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header ">Campaigns 

                       <div class="float-right">
                            <input type="date" v-model="from" @change="fetch(groupBy,siteId)">
                             <input type="date" v-model="to" @change="fetch(groupBy,siteId)">
                        </div>
                    
                    <br>
                    <small> {{ _breadCrumbs }}</small>
                    </div>

                        <table class="table">
                            <thead>
                                <th width="40%" @click="reset(0)" class="cursor">Campaign Name (Reset)</th>
                                <th>Clicks</th>
                                <th>Conversions</th>
                            </thead>

                            <tr style="background:lightgreen" v-for="(campaign,index) in containers" :key="campaign.name + index + '1'">
                               <td width="40%" class="cursor" @click="insertToContainer(campaign, false)"> {{ getBreadCrumbs(campaign.tag) }} {{ campaign.name | filterName }} </td>
                               <td> {{ campaign.clicks }} </td>
                               <td> {{ campaign.conversions }} </td>
                            </tr>

                            <tr v-for="(campaign,index) in campaigns" :key="campaign.name + index">
                               <td width="40%" class="cursor" @click="insertToContainer(campaign)"> {{ getBreadCrumbs(campaign.tag) }} {{ campaign.name | filterName }} </td>
                               <td> {{ campaign.clicks }} </td>
                               <td> {{ campaign.conversions }} </td>
                            </tr>

                            <tr v-show="campaigns.length === 0">
                                <td colspan="3">No Data</td>
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
                campaigns: [],
                containers: [],
                s1: '',
                s2: '',
                s3: '',
                s4: '',
                s5: '',
                groupBy: 'site_id',
                siteId: null,
                from: new Date(new Date().setDate(new Date().getDate() - 7)).toISOString().slice(0, 10),
                to: new Date(new Date).toISOString().slice(0, 10)
            }
        },

        computed: {
            _breadCrumbs(){
                let str =  this.$options.filters.filterName(this.siteId)

                if(!this.s1) {
                    return str;
                }

                str = str + ' > ' +this.s1

                 if(!this.s2) {
                    return str;
                }

                   str = str + ' > ' +this.s2

                 if(!this.s3) {
                    return str;
                }

                   str = str + ' > ' +this.s3

                 if(!this.s4) {
                    return str;
                }

                   str = str + ' > ' +this.s4

                 if(!this.s5) {
                    return str;
                }

                return str = str + ' > ' +this.s5

            }
        },
 
        mounted() {
            this.fetch()
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
            },

            filterName(val){
                if(val === 1) {
                    return 'ShagToday'
                }
                if(val === 2) {
                    return 'HookupToday'
                }
                if(val === 3) {
                    return 'Shag2night'
                }
                if(val === 4) {
                    return 'HoneyNearby'
                }
                if(val === 5) {
                    return 'HookUp69'
                }

                if(val === 5) {
                    return 'WannaHookup'
                }

                if(val === 0) {
                    return 'organic'
                }

                return val;
            }
        },

        methods: {
            fetch(groupBy = 'site_id', siteId = null){
                axios.post(
                    '/campaigns', {
                        s1: this.s1,
                        s2: this.s2,
                        s3: this.s3,
                        s4: this.s4,
                        s5: this.s5,
                        groupBy: groupBy,
                        siteId: siteId,
                        to: this.to,
                        from: this.from
                    })
                .then((res) => [
                    this.campaigns = res.data
                ])
                .catch((err) => {

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

            insertToContainer(campaign, pushToContainer= true) 
            {
                console.log(campaign)
                if(campaign.tag === 's5' ||  campaign.clicks === 0 ||  campaign.name === 'organic') {
                    return;
                }

                if(campaign.tag === 'site_id') {
                    this.groupBy = 's1'
                    this.siteId = campaign.name
                    this.s1 = '';
                    this.s2 = '';
                    this.s3 = '';
                    this.s4 = '';
                    this.s5 = '';
                    this.containers = this.containers.filter(item => !(item.tag === 's1' || item.tag === 's2' || item.tag === 's3' || item.tag === 's4' || item.tag === 's5'));
                }

                if(campaign.tag === 's1') {
                    this.s1 = campaign.name
                    this.groupBy = 's2'
                    this.s2 = '';
                    this.s3 = '';
                    this.s4 = '';
                    this.s5 = '';
                    this.containers = this.containers.filter(item => !(item.tag === 's2' || item.tag === 's3' || item.tag === 's4' || item.tag === 's5'));

                }

                if(campaign.tag === 's2') {
                    this.s2 = campaign.name
                    this.groupBy = 's3'
                    this.s3 = '';
                    this.s4 = '';
                    this.s5 = '';
                    this.containers = this.containers.filter(item => !(item.tag === 's3' || item.tag === 's4' || item.tag === 's5'));

                }

                if(campaign.tag === 's3') {
                    this.s3 = campaign.name
                    this.groupBy = 's4'
                    this.s4 = '';
                    this.s5 = '';
                    this.containers = this.containers.filter(item => !(item.tag === 's4' || item.tag === 's5'));

                }

                if(campaign.tag === 's4') {
                    this.s4 = campaign.name
                    this.groupBy = 's5'
                    this.s5 = '';
                    this.containers = this.containers.filter(item => !(item.tag === 's5'));

                }

                if(pushToContainer) {
                    this.containers.push(campaign)
                }
                this.fetch(this.groupBy, this.siteId)
            },

            getBreadCrumbs(tag){

                if(tag === 'site_id') {
                    return ''
                }

                if(tag === 's1') {
                     return '↳'
                }

                if(tag === 's2') {
                   return '\xa0\xa0 ↳'
                }

                if(tag === 's3') {
                     return '\xa0\xa0\xa0\xa0 ↳'
                }

                if(tag === 's4') {
                     return '\xa0\xa0\xa0\xa0\xa0\xa0 ↳'
                }

                return '\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0 ↳'

            },

            reset(level) {

                this.campaigns = [];
                this.containers = [];
                this.s1 = '';
                this.s2 = '';
                this.s3 = '';
                this.s4 = '';
                this.s5 = '';
                this.groupBy = 'site_id';
                this.siteId = null;
                this.fetch()
            }
        }
    }
</script>
