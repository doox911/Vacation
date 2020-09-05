import axios from 'axios'

export default {
  actions: {
    async login({commit}, payload) {
      try {
        const sanctum = await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/api/login', payload);

        commit('setUser', response.data.user);
      } catch (e) {
        console.log('Authorization failed', `exception: ${e}`);
      }
    },

    async logout({commit}) {
      try {
        const user = JSON.parse(localStorage.getItem('user'));

        await axios.post(`/api/logout/${user.id}`);

        commit('clearUser');
      } catch (e) {
        console.log('Logout failed', `exception: ${e}`);
      }
    }
  },
  mutations: {
    setUser(state, user) {
      state.user = user
      localStorage.setItem('user', JSON.stringify(user))
      axios.defaults.headers.common.Authorization = `Bearer ${user.token}`
    },

    clearUser() {
      localStorage.removeItem('user')
      location.reload()
    }
  },
  state: {
    user: null
  },
  getters: {
    isLogged: state => !!state.user
  }
}
