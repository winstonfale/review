<style scoped>
.cursor {
  cursor: pointer;
}
</style>

<template>
  <div class="row justify-content-center">
    <div class="col-12" style="margin-bottom: 5px">
      <span class="float-right">
        <input type="date" v-model="from" @change="fetch(groupBy, siteId)" />
        <input type="date" v-model="to" @change="fetch(groupBy, siteId)" />
      </span>
    </div>

    <div class="col-12" style="margin-botton: 10px">
      <div class="row" style="margin-bottom:20px">
        <div class="col-3">
          <div class="card text-center">
            <div class="card-header">Clicks</div>
            <h1 style="padding: 30px">{{ data.clicks }}</h1>
          </div>
        </div>

        <div class="col-3">
          <div class="card text-center">
            <div class="card-header">Conversion</div>
            <h1 style="padding: 30px">{{ data.conversion }}</h1>
          </div>
        </div>

        <div class="col-3">
          <div class="card text-center">
            <div class="card-header">Revenue</div>
            <h1 style="padding: 30px">{{ data.earnings | amount }}</h1>
          </div>
        </div>

        <div class="col-3">
          <div class="card text-center">
            <div class="card-header">Cost</div>
            <h1 style="padding: 30px">{{ data.cost | amount }}</h1>
          </div>
        <button @click.prevent="goToCostPage()" style="border: 1px solid white; padding:10px; width:100%">Add Cost/Revenue</button>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Campaigns</div>

        <table class="table">
          <thead>
            <th width="40%" @click="reset(0)" class="cursor">Campaign</th>
            <th>Clicks</th>
            <th>Conversions</th>
            <th>Earnings</th>
          </thead>

          <tr
            v-for="(campaign, index) in data.campaigns"
            :key="campaign.name + index"
          >
            <td width="40%" class="cursor">{{ campaign.site_id | filterName }}</td>
            <td>{{ campaign.clicks }}</td>
            <td>{{ campaign.conversions }}</td>
            <td>{{ campaign.amount | amount }}</td>
          </tr>

          <tr v-show="(data.campaigns || {}).length === 0">
            <td colspan="3">No Data</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
var date = new Date();

export default {
  name: "Campaigns",

  data() {
    return {
      data: [],
      groupBy: "site_id",
      siteId: null,
      from: new Date(date.getFullYear(), date.getMonth(), 2).toISOString().slice(0, 10),
      to: new Date(new Date()).toISOString().slice(0, 10),
    };
  },

  computed: {},

  mounted() {
    this.fetch();
  },

  filters: {
    wordFilter(str) {
      return str
        .split("_")
        .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
        .join(" ");
    },
    amount(val) {
        if(!val) {
            return 0;
        }
      return val.toFixed(2);
    },

    filterName(val) {
      if (val === 1) {
        return "ShagToday";
      }
      if (val === 2) {
        return "HookupToday";
      }
      if (val === 3) {
        return "Shag2night";
      }
      if (val === 4) {
        return "HoneyNearby";
      }
      if (val === 5) {
        return "HookUp69";
      }

      if (val === 5) {
        return "WannaHookup";
      }

      if (val === 0) {
        return "No Record";
      }

      return val;
    },
  },

  methods: {
    fetch() {
      axios
        .post("/dashboard", {
          to: this.to,
          from: this.from,
        })
        .then((res) => [(this.data = res.data )])
        .catch((err) => {});
    },

    goToCostPage(){
       window.open("/costs","_self");

    }
  },
};
</script>
