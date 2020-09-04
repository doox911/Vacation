<template>
  <v-app-bar app>
    <v-spacer />
    <template v-if="isLogged">
      <v-btn
        icon
        color="primary"
        title="Домой"
        @click="goHome"
      >
        <v-icon>home</v-icon>
      </v-btn>

      <v-btn
        icon
        color="success"
        title="Выход"
        @click="logout"
      >
        <v-icon>exit_to_app</v-icon>
      </v-btn>
    </template>
  </v-app-bar>
</template>

<script>
  export default {
    name: 'NavBar',
    data () {
      return {
      }
    },
    computed: {
      isLogged () {
        return this.$store.getters.isLogged
      }
    },
    methods: {
      goHome () {
        this.$router.push('/', () => {})
      },
      logout () {
        this.$store.dispatch('logout')
      }
    }
  }
</script>

<style scoped>
</style>
