<template>
  <div class="div">
    <h6 class="h6">Oxygen supply ({{ supplyIndex }} )</h6>
    <div class="row align-items-end mb-4">
      <div class="row col-10">
        <div class="form-group mb-0 col-md-6">
          <label class="form-label"
            >Size <span class="text-danger">*</span></label
          >
          <select class="form-control" name="size[]" required>
            <option value="" selected hidden></option>
            <option :value="size.id" v-for="size in sizes" :key="size.id">
              {{ size.size }}
            </option>
          </select>
        </div>
        <div class="form-group mb-0 col-md-6">
          <label class="form-label"
            >Number of cylinders <span class="text-danger">*</span></label
          >
          <input
            type="number"
            class="form-control"
            name="noOfCylinders[]"
            required
          />
        </div>
      </div>
      <div class="">
        <button
          class="btn btn-sm"
          :class="{
            'btn-danger': !defaultEntry,
            'btn-secondary': defaultEntry,
          }"
          @click.prevent="deleteEntry"
        >
          Delete Entry
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id", "supplyIndex", "sizes", "defaultEntry"],
  methods: {
    deleteEntry() {
      event.preventDefault();
      event.stopPropagation();
      if (this.defaultEntry) return;

      this.$emit("delete-entry", this.id);
      console.log("Emited");
    },
  },
};
</script>

<style scoped>
.btn-secondary {
  cursor: not-allowed;
}
</style>