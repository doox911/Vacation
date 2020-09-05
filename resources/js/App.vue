<template>
  <v-app>
    <v-navigation-drawer
      v-if="isLogged"
      v-model="drawer"
      app
      clipped
    >
      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.text"
          :to="{ name: item.link }"
          link
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>
              {{ item.text }}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      clipped-left
      dense
    >
      <v-app-bar-nav-icon
        v-if="isLogged"
        @click.stop="drawer = !drawer"
      />
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
  export default {
    name: 'App',
    data() {
      return {
        drawer: true,
        items: [
          { icon: 'mdi-calendar-text', text: 'Управлени отпуском', link: 'Vacation' },
        ],
      }
    },
    mounted() {
      this.$store.commit('updateUserInStore');
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
    },
  }
</script>
