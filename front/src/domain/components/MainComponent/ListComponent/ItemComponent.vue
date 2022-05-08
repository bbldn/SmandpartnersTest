<template>
  <b-list-group-item class="d-flex align-items-center">
    <b-container>
      <CommentComponent
          :on-edit="onEdit"
          :comment="comment"
          :on-delete="onDelete"
      />
      <AuthorComponent :comment="comment"/>
    </b-container>
  </b-list-group-item>
</template>

<script>
import CommentComponent from "@/domain/components/MainComponent/ListComponent/ItemComponent/CommentComponent";
import AuthorComponent from "@/domain/components/MainComponent/ListComponent/ItemComponent/AuthorComponent";

export default {
  name: "ItemComponent",
  components: {AuthorComponent, CommentComponent},
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