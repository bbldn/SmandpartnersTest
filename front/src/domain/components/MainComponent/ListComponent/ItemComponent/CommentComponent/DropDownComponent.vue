<template>
  <div @mouseover="onOver" @mouseleave="onLeave">
    <b-dropdown
        ref="dropdown"
        variant="link"
        :no-caret="true"
        toggle-class="text-decoration-none"
    >
      <template #button-content>
        <button class="btn dropdown-toggle"></button>
      </template>
      <b-dropdown-item @click="onEditProxy">Редактировать</b-dropdown-item>
      <b-dropdown-item @click="onDeleteProxy">Удалить</b-dropdown-item>
    </b-dropdown>
  </div>
</template>

<script>
export default {
  name: "DropDownComponent",
  props: {
    comment: {
      required: true,
    },
    onEdit: {
      required: true,
      type: Function,
    },
    onDelete: {
      required: true,
      type: Function,
    },
  },
  methods: {
    onOver() {
      this.$refs.dropdown.visible = true;
    },
    onLeave() {
      this.$refs.dropdown.visible = false;
    },
    onEditProxy() {
      this.$props.onEdit(this.$props.comment);
    },
    onDeleteProxy() {
      this.$props.onDelete(this.$props.comment);
    },
  }
}
</script>