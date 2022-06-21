<style scoped>
.cursor {
    cursor: pointer;
}
</style>

<template>
   
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header cursor" @click="reset(0)">Campaigns
                    </div>

                        <table class="table">
                            <thead>
                                <th width="15%">Campaign Name</th>
                                <th>Clicks</th>
                                <th>Conversions</th>
                            </thead>

                            <tr v-for="(campaign,index) in containers" :key="campaign.name + index + '1'">
                               <td width="40%" class="cursor"> {{ getBreadCrumbs(campaign.tag) }} {{ campaign.name | filterName }} </td>
                               <td> {{ campaign.clicks }} </td>
                               <td> {{ campaign.conversions }} </td>
                            </tr>

                            <tr v-for="(campaign,index) in campaigns" :key="campaign.name + index">
                               <td width="40%" class="cursor" @click="insertToContainer(campaign)"> {{ getBreadCrumbs(campaign.tag) }} {{ campaign.name | filterName }} </td>
                               <td> {{ campaign.clicks }} </td>
                               <td> {{ campaign.conversions }} </td>
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
                siteId: null
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
                    return 'Site2night'
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

            insertToContainer(campaign) 
            {
                if(campaign.tag === 's5' ||  campaign.clicks === 0 ||  campaign.name === 'organic') {
                    return;
                }

                if(campaign.tag === 'site_id') {
                    this.groupBy = 's1'
                    this.siteId = campaign.name
                }

                if(campaign.tag === 's1') {
                    this.s1 = campaign.name
                    this.groupBy = 's2'
                }

                if(campaign.tag === 's2') {
                    this.s2 = campaign.name
                    this.groupBy = 's3'
                }

                if(campaign.tag === 's3') {
                    this.s3 = campaign.name
                    this.groupBy = 's4'
                }

                if(campaign.tag === 's4') {
                     this.s4 = campaign.name
                    this.groupBy = 's5'
                }

                this.containers.push(campaign)
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
                   return '\xa0 ↳'
                }

                if(tag === 's3') {
                     return '\xa0\xa0 ↳'
                }

                if(tag === 's4') {
                     return '\xa0\xa0\xa0↳'
                }

                return '\xa0\xa0\xa0\xa0↳'

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
