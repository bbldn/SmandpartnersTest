<template>
  <b-row class="w-100">
    <b-col class="avatar-wrapper">
      <b-avatar class="avatar"/>
    </b-col>
    <b-col class="author">{{ comment.author }} <i>{{ moment(comment.createdAt).format('D MMM') }}</i></b-col>
  </b-row>
</template>

<script>
import moment from "moment";

export default {
  name: "AuthorComponent",
  props: {
    comment: {
      required: true,
    },
  },
  methods: {
    moment: function () {
      return moment();
    },
  },
}
</script>

<style scoped>

.author {
  align-items: center;
}

.avatar-wrapper {
  margin: unset;
  padding: unset;

  width: 35px;
  flex-grow: 0;
  flex-basis: auto;
}

.avatar-wrapper .avatar {
  color: white;
  width: 30px;
  height: 30px;
  background-color: #7A7A7A;
}

</style>