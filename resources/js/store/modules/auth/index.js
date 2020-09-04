import axios from 'axios'

export default {
  actions: {
    async login ({ commit }, payload) {
      const response = await axios.get('/sanctum/csrf-cookie');
      const login = await axios.post('/login', payload);

      commit('setUser', response.data)
    },

    logout ({ commit }) {
      commit('clearUser')
    }
  },
  mutations: {
    setUser (state, user) {
      state.user = user
      localStorage.setItem('user', JSON.stringify(user))
      axios.defaults.headers.common.Authorization = `Bearer ${user.token}`
    },

    clearUser () {
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
