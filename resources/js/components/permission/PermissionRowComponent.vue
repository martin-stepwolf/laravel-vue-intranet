  
<template>
  <tr>
    <td>{{user.name}}</td>
    <td class="text-center">{{user.pivot.created_at | date}}</td>
    <td class="col-action-2">
      <button v-on:click="Show_info()" class="btn btn-info btn-circle">
        <i class="fas fa-info-circle"/>
      </button>
      <button v-on:click="$emit('delete')" class="btn btn-danger btn-circle">
        <i class="far fa-trash-alt"/>
      </button>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["user"],
  methods: {
    Show_info() {
      const date = this.$options.filters.date;
      this.$root.InfoMessage(
        "More information.",
        "<strong>Name</strong>: " +
          this.user.name +
          "<br><strong>Email</strong>: " +
          this.user.email +
          "<br><strong>Department</strong>: " +
          this.user.department.name +
          "<br><strong>Created at</strong>: " +
          (this.user.pivot
            ? date(this.user.pivot.created_at)
            : this.$root.ShowDate())
      );
    },
  },
};
</script>