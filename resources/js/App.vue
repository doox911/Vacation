<template>
  <v-app>
    <nav-bar/>
    <v-main>
      <!-- Provides the application the proper gutter -->
      <v-container fluid>

        <!-- If using vue-router -->
        <router-view />
      </v-container>
    </v-main>

    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app>
</template>

<script>
  import NavBar from './components/NavBar';

  export default {
    name: 'App',
    components: {
      NavBar
    },
  }
</script>
