<template>
  <form
    method="POST"
    :action="submitUrl"
    class="form __oxygen-request-status-form"
  >
    <input type="hidden" name="_token" :value="csrftoken" />
    <input hidden type="text" ref="formInput" name="id" :value="id" />
    <input hidden type="text" ref="formInput" name="status" v-model="status" />
    <div class="__badge-container">
      <span
        class="badge __badge"
        :class="{ active: status == st }"
        v-for="(st, index) in statuses"
        :key="index"
        @click="changeStatus(st)"
        >{{ st }}</span
      >
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      status: "",
    };
  },
  props: {
    submitUrl: {
      required: true,
    },
    id: {
      required: true,
    },
    csrftoken: {
      required: true,
    },
    statuses: {
      required: true,
    },
    initstatus: {},
  },
  mounted() {
    this.status = this.initstatus;
  },
  methods: {
    changeStatus(st) {
      this.status = st;
    },
  },
};
</script>

<style  lang="scss">
.__oxygen-request-status-form {
  .__badge-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.3rem;
    justify-content: center;
    .__badge {
      border: 1.5px solid #6c757d;
      cursor: pointer;
      margin: 0;
    }

    .__badge.active {
      color: white;
      background: #3d7e23;
      border-color: white;
    }
  }
}
</style>