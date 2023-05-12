<template>
  <div>
    <form action="" @submit="submit">
      <div
        id="reportrange"
        style="
          background: #fff;
          cursor: pointer;
          padding: 5px 10px;
          border: 1px solid #ccc;
          width: 100%;
        "
      >
        <i class="fa fa-calendar"></i>&nbsp; <span></span>
        <i class="fa fa-caret-down"></i>
      </div>
      <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-sm btn-primary" v-if="startDate && endDate">
          Apply Filter
        </button>
      </div>
    </form>
  </div>
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
      startDate: undefined,
      endDate: undefined,
    };
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);

    let start = urlParams.get("startDate")
      ? moment(urlParams.get("startDate"))
      : moment().subtract(29, "days");
    let end = urlParams.get("endDate")
      ? moment(urlParams.get("endDate"))
      : moment();

    $("#reportrange").daterangepicker(
      {
        startDate: start,
        endDate: end,
        ranges: {
          Today: [moment(), moment()],
          Yesterday: [
            moment().subtract(1, "days"),
            moment().subtract(1, "days"),
          ],
          "Last 7 Days": [moment().subtract(6, "days"), moment()],
          "Last 30 Days": [moment().subtract(29, "days"), moment()],
          "This Month": [moment().startOf("month"), moment().endOf("month")],
          "Last Month": [
            moment().subtract(1, "month").startOf("month"),
            moment().subtract(1, "month").endOf("month"),
          ],
        },
      },
      this.callback
    );

    this.callback(start, end);

    // $("#reportrange").data("daterangepicker").setStartDate("03/01/2014");
    // $("#reportrange").data("daterangepicker").setEndDate("03/31/2014");
  },

  methods: {
    callback(startDate, endDate) {
      this.startDate = startDate.format("YYYY-MM-DD");
      this.endDate = endDate.format("YYYY-MM-DD");
      $("#reportrange span").html(
        startDate.format("MMMM D, YYYY") +
          " - " +
          endDate.format("MMMM D, YYYY")
      );
    },
    submit() {
      event.preventDefault();
      event.stopPropagation();

      let queryString = `?startDate=${this.startDate}&endDate=${this.endDate}`;
      let a = document.createElement("a");
      a.href = this.baseurl.replace(/\/+$/, "") + queryString;
      a.click();
    },
  },
};
</script>