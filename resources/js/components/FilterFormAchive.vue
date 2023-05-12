<template>
  <form
    @submit="submit"
    action="#"
    class="form-horizontal"
    :class="{ card: filterType > 0 }"
  >
    <div class="card-body">
      <div class="input-group mb-2">
        <select class="form-control" v-model="filterType">
          <option value="" selected disabled hidden>FILTER</option>
          <option :value="1">Date Range</option>
        </select>
        <select
          class="form-control"
          ref="filterFormInput"
          required
          v-model="stepType"
          name="stepType"
          v-if="filterType > 0"
        >
          <option value="DAILY">DAILY</option>
          <option value="WEEKLY">WEEKLY</option>
          <option value="MONTHLY">MONTHLY</option>
          <option value="YEARLY">YEARLY</option>
        </select>
      </div>
      <!-- Date Range -->
      <div class="input-group" v-if="filterType == 1">
        <div class="form-group">
          <label for="">From</label>
          <input
            v-model="startDate"
            type="date"
            class="form-control"
            name="startDate"
            required
          />
        </div>
        <div class="form-group">
          <label for="">To</label>
          <input
            v-model="endDate"
            type="date"
            class="form-control"
            name="endDate"
            required
          />
        </div>
      </div>
      <!-- Reference Date -->
      <div class="input-group" v-if="filterType == 2">
        <div class="form-group">
          <label for="">Reference Date</label>
          <input
            v-model="endDate"
            type="date"
            class="form-control"
            name="endDate"
            required
          />
        </div>
        <div class="form-group">
          <label for="">Reference Count</label>
          <input
            type="number"
            name="noOfSteps"
            class="form-control"
            v-model="noOfSteps"
            required
          />
        </div>
      </div>

      <div class="d-flex justify-content-end" v-if="filterType > 0">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    baseurl: {
      required: true,
      type: String,
    },
  },
  data() {
    return {
      filterType: "",
      startDate: undefined,
      endDate: undefined,
      stepType: "DAILY",
      noOfSteps: 7,
    };
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    try {
      this.endDate = urlParams.get("endDate") || this.endDate;
      this.startDate = urlParams.get("startDate") || this.startDate;
      this.stepType = urlParams.get("stepType") || this.stepType;
      this.noOfSteps = urlParams.get("noOfSteps") || this.noOfSteps;
    } catch (e) {}
  },
  methods: {
    submit() {
      event.preventDefault();
      event.stopPropagation();

      let queryString = `?stepType=${this.stepType}&endDate=${this.endDate}`;

      if (this.filterType === 1) {
        queryString += `&startDate=${this.startDate}`;
      } else if (this.filterType === 2) {
        queryString += `&noOfSteps=${this.noOfSteps}`;
      } else {
        return;
      }

      let a = document.createElement("a");
      a.href = this.baseurl.replace(/\/+$/, "") + queryString;

      a.click();
    },
  },
};
</script>

<style scoped>
.input-group {
  gap: 0.5em;
}
</style>
