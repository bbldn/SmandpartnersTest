<template>
  <div>
    <b-list-group>
      <ItemComponent
          :key="comment.id"
          :on-edit="onEdit"
          :comment="comment"
          :on-delete="onDelete"
          v-for="comment in commentList"
      />
    </b-list-group>
  </div>
</template>

<script>
import CommentRepository from "@/domain/application/repository/CommentRepository";
import ItemComponent from "@/domain/components/MainComponent/ListComponent/ItemComponent";

export default {
  name: "ListComponent",
  components: {ItemComponent},
  props: {
    onChange: {
      required: true,
      type: Function,
    },
  },
  data() {
    return {
      commentList: [],
    };
  },
  async mounted() {
    this.commentList = await CommentRepository.getAll();
  },
  methods: {
    onEdit(comment) {
      this.onChange(comment);
    },
    onDelete(comment) {
      this.$bvModal.msgBoxConfirm('Вы уверены, что хотите удалить комментарий?').then(async () => {
        const result = await CommentRepository.removeById(comment.id);
        if (true === result) {
          this.commentList = this.commentList.filter((c) => c.id !== comment.id);
        }
      })
    },
    onAdd(comment) {
      let needAdd = true;
      const commentList = [...this.commentList];
      for (const [key, c] of Object.entries(commentList)) {
        if (c.id === comment.id) {
          commentList[key] = comment;
          needAdd = false;
          break;
        }
      }

      if (true === needAdd) {
        commentList.push(comment);
      }

      this.commentList = commentList;
    },
  }
}
</script>