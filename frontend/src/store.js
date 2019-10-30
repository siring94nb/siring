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
    setUserId(state, id) {
      state.user_id = id;
      sessionStorage.user_id = id;
    },
    setPhone(state, phone){
      state.phone = phone;
      sessionStorage.phone = phone;
    }
  },
  actions: {

  }
})
