<template>
  <div>
    <div class="m-3"></div>
    <oxygen-supplies-input
      :supplyIndex="1"
      :sizes="sizes"
      :defaultEntry="true"
    />
    <oxygen-supplies-input
      :supplyIndex="i + 2"
      :id="supId"
      :sizes="sizes"
      :defaultEntry="false"
      v-for="(supId, i) in addedSupplies"
      :key="supId"
      @delete-entry="deleteEntry($event)"
    />
    <div class="div mb-5">
      <button class="btn btn-info btn-sm" @click.prevent="addSupply">
        Add Supply
      </button>
    </div>
  </div>
</template>

<script>
import OxygenSuppliesInput from "./OxygenSuppliesInput.vue";

export default {
  components: {
    OxygenSuppliesInput,
  },
  props: {
    sizes: { required: true },
  },
  data() {
    return {
      addedSupplies: [],
    };
  },
  methods: {
    addSupply() {
      event.preventDefault();
      event.stopPropagation();

      let id = 7;
      while (true) {
        id = Math.random();
        if (!this.addedSupplies.some((el) => el == id)) break;
      }

      this.addedSupplies.push(id);
    },
    deleteEntry(id) {
      const index = this.addedSupplies.findIndex((el) => el == id);
      this.addedSupplies.splice(index, 1);
    },
  },
};
</script>

<style>
</style>