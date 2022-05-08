<template>
  <b-container>
    <b-card title="Заголовок поста">
      <b-card-text>
        <TextComponent/>
      </b-card-text>

      <b-card-text>
        <FormComponent :onAdd="onAdd" ref="formNode"/>
      </b-card-text>

      <b-card-text>
        <ListComponent :onChange="onChange" ref="listNode"/>
      </b-card-text>
    </b-card>
  </b-container>
</template>

<script>
import FormComponent from "@/domain/components/MainComponent/FormComponent";
import TextComponent from "@/domain/components/MainComponent/TextComponent";
import ListComponent from "@/domain/components/MainComponent/ListComponent";

export default {
  name: "MainComponent",
  components: {FormComponent, ListComponent, TextComponent},
  methods: {
    onAdd(comment) {
      this.$refs.listNode.onAdd(comment);
    },
    onChange(comment) {
      this.$refs.formNode.onChange(comment);
    }
  }
}
</script>