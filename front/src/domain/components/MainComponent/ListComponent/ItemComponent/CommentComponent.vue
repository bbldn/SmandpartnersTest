<template>
  <b-row class="w-100">
    <b-col cols="12" class="wrapper">
      <span>{{ comment.comment }}</span>
      <DropDownComponent
          class="drop-down-component"

          :on-edit="onEdit"
          :comment="comment"
          :on-delete="onDelete"
      />
    </b-col>
  </b-row>
</template>

<script>
import DropDownComponent from "@/domain/components/MainComponent/ListComponent/ItemComponent/CommentComponent/DropDownComponent";

export default {
  name: "CommentComponent",
  components: {DropDownComponent},
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
}
</script>

<style scoped>

.drop-down-component {
  display: inline-block;
}

.wrapper {
  padding: 0;
}

</style>