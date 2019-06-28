import Vue  from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    url : {},
    path: {
      group       : '/storage/group/',
      groupChannel: '/storage/group_channel/',
      tba         : '/storage/tba/',
      user        : '/storage/user/',
      imgDefault  : '/storage/default.jpg',
    }
  },

  mutations: {},

  actions: {}
});
