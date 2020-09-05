<template>
  <div class="home asasa">
    <span
      @click="help"
    >
help
    </span>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: 'Home',
    methods: {
      help() {
        console.log(this.$store.getters.isLogged)
      }
    },
  }
</script>
