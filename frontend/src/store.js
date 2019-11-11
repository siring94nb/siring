import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: true,
  state: {
    user_id: '',
    phone: ''
  },
  mutations: {
    login(state, data) {
      state.user_id = data.id;
      state.phone = data.phone;
      sessionStorage.setItem('user_id', data.id);
      sessionStorage.setItem('phone', data.phone);
    },
    logout(state, data) {
      state.user_id = '';
      state.phone = '';
      sessionStorage.clear();
    }

  },
  actions: {

  }
})
