<template>
  <div>
    <b-form @reset="onReset" @submit="onSubmit">
      <b-form-group :invalid-feedback="form.comment.error" :state="form.comment.error.length > 0 ? false : undefined">
        <b-form-input
            required="required"
            @focus="onShowButtons"
            v-model="form.comment.value"
            placeholder="Написать комментарий"
            :state="form.comment.error.length > 0 ? false : undefined"
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
import FormHelper from "@/domain/application/helper/formHelper";

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
      form: FormHelper.createForm(),
    };
  },
  methods: {
    onShowButtons() {
      this.showButtons = true;
    },
    onChange(comment) {
      this.showButtons = true;
      this.form = FormHelper.createFormByComment(comment);
    },
    onReset() {
      this.showButtons = false;
      this.form = FormHelper.createForm();
    },
    onLoadErrors(exception) {
      if (!exception.exception) {
        this.$bvModal.msgBoxOk('Произошла неизвестная ошибка');

        return;
      }

      if ('RestException' === exception.exception) {
        this.$bvModal.msgBoxOk(exception.message ?? 'Произошла неизвестная ошибка');

        return;
      }

      if ('ValidateException' === exception.exception) {
        try {
          FormHelper.loadErrorsToForm(this.form, exception.errors);
        } catch (message) {
          this.$bvModal.msgBoxOk(message ?? 'Произошла неизвестная ошибка');
        }
      }
    },
    async onSubmit(e) {
      e.preventDefault();

      const mutation = FormHelper.formToMutation(this.form);

      let result = null;
      try {
        result = await CommentRepository.createOrUpdate(mutation);
      } catch (exception) {
        this.onLoadErrors(exception);
      }

      if (null !== result) {
        this.onReset();
        this.onAdd(result);
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