<style scoped>
.cursor {
  cursor: pointer;
}

.gray-div{
    background: lightgray;
    border-right: 1px solid darkgray;
    padding: 30px;
}

.no-padding {
    padding-right: 0 !important;
    padding-left: 0 !important;
}

</style>

<template>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-6 text-center gray-div">
          <h2>Revenue</h2>
        <h1>${{ earnings.total }}</h1>

        </div>

        <div class="col-6 text-center gray-div">
          <h2>Cost</h2>
          <h1>${{ costs.total }}</h1>

        </div>
      </div>
    </div>
    <div class="col-md-6 no-padding">
      <div class="card">
        <div class="card-header">
          <div class="text-center">
            <h4>Revenue</h4>
            <hr />
          </div>
          <div class="">
            <select>
                <option> All Brands </option>
            </select>
          </div>
        </div>

        <table class="table">
          <thead>
            <th>Date</th>
            <th>Cost</th>
            <th></th>
          </thead>
          <tr v-for="(earning, index) in earnings.list" :key="'cost' + index">
            <td>{{ earning.from }} - {{ cost.to }}</td>
            <td>{{ earning.cost }}</td>
            <td>
              <button
                class="btn btn-danger"
                disabled
              >
                Delete
              </button>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-6 no-padding">
      <div class="card">
        <div class="card-header">
          <div class="text-center">
            <h4>Cost</h4>
            <hr />
          </div>
          <div class="">
            <form @submit.prevent="addCost">
              <input type="date" v-model="from" required />
              to
              <input type="date" v-model="to" required />
              <input
                type="number"
                v-model="cost"
                required
                placeholder="Amount"
              />
              <button type="submit">Add Cost Record</button>
            </form>
          </div>
        </div>

        <table class="table">
          <thead>
            <th>Date</th>
            <th>Cost</th>
            <th></th>
          </thead>
          <tr v-for="(cost, index) in costs.list" :key="'cost' + index">
            <td>{{ cost.from }} - {{ cost.to }}</td>
            <td>${{ cost.cost }}</td>
            <td>
              <button
                class="btn btn-danger"
                @click.prevent="deleteRecord(cost.id)"
              >
                Delete
              </button>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Campaigns",

  data() {
    return {
      costs: [],
      earnings: [],
      cost: "",
      from: new Date(new Date().setDate(new Date().getDate() - 7))
        .toISOString()
        .slice(0, 10),
      to: new Date(new Date()).toISOString().slice(0, 10),
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      axios
        .post("/costs", {
          to: this.to,
          from: this.from,
        })
        .then((res) => {
            this.costs = res.data.costs
             this.earnings = res.data.earnings

        })
        .catch((err) => {});
    },

    addCost() {
      axios
        .post("/cost/store", {
          to: this.to,
          from: this.from,
          cost: this.cost,
        })
        .then(() => {
          alert("Success");
          this.cost = "";
          this.fetch();
        })
        .catch(() => {
          alert("Error");
        });
    },

    deleteRecord(id) {
      if (confirm("Confirm delete?! This action cannot be undone") == false) {
        return;
      }
      axios
        .post("/cost/" + id + "/delete")
        .then(() => {
          this.fetch();
        })
        .catch(() => {
          alert("Error");
        });
    },
  },
};
</script>
