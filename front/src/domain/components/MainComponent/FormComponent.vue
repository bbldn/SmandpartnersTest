<template>
  <div>
    <b-form @reset="onReset" @submit="onSubmit">
      <b-form-group>
        <b-form-input
            required="required"
            @focus="onShowButtons"
            v-model="form.comment"
            placeholder="Написать комментарий"
        ></b-form-input>
      </b-form-group>

      <div v-if="showButtons" class="button-wrapper">
        <b-button type="submit" variant="primary" class="save-button" :disabled="form.comment.length < 1">СОХРАНИТЬ
        </b-button>
        <b-button type="reset" variant="outline-primary" class="cancel-button">ОТМЕНА</b-button>
      </div>
    </b-form>
  </div>
</template>

<script>
import CommentRepository from "@/domain/application/repository/CommentRepository";

export default {
  name: "FormComponent",
  props: {
    onAdd: {
      required: true,
      type: Function,
    },
  },
  data: function () {
    return {
      showButtons: false,
      form: {
        comment: '',
      },
    };
  },
  methods: {
    onChange(comment) {
      this.showButtons = true;
      this.form = {...comment};
    },
    onShowButtons() {
      this.showButtons = true;
    },
    onReset() {
      this.form.comment = '';
      this.showButtons = false;
    },
    async onSubmit(e) {
      e.preventDefault();

      const result = await CommentRepository.createOrUpdate(this.form);
      if (null !== result) {
        this.onAdd(result);
        this.onReset();
      }
    }
  }
}
</script>

<style scoped>

.button-wrapper {
  padding-top: 10px;
}

.button-wrapper button:first-child {
  margin-right: 5px;
}

.cancel-button {
  color: black;
  border: 1px solid black;
}

.cancel-button:hover {
  color: white;
  background-color: black;
  border: 1px solid white;
}

.save-button.disabled {
  color: white;
  border: 1px solid #D6D6D6;
  background-color: #D6D6D6;
}

</style>