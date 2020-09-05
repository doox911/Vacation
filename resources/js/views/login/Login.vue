<template>
  <v-row
    align="center"
    justify="center"
  >
    <v-col
      cols="12"
      sm="8"
      md="4"
    >
      <v-card class="elevation-12">
        <v-toolbar
          color="primary"
          dark
          flat
        >
          <v-toolbar-title>Авторизация</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-form>
            <v-text-field
              label="Email"
              v-model="email"
              prepend-icon="mdi-account"
              type="text"
            ></v-text-field>

            <v-text-field
              v-model="password"
              label="Пароль"
              prepend-icon="mdi-lock"
              type="password"
            ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            @click="login"
          >
            Вход
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
  export default {
    data () {
      return {
        email: '',
        password: ''
      };
    },
    computed: {
      isLogged () {
        return this.$store.getters.isLogged;
      },
    },
    methods: {
      async login () {
        await this.$store.dispatch('login', {
          email: this.email,
          password: this.password,
        });

        if (this.isLogged) {
          await this.$router.push({ name: 'Home' });
        }
      }
    }
  }
</script>
