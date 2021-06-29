import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

import userModule from './user';
import bureauModule from './bureau';
import buildingModule from './building';

export default new Vuex.Store({
    modules: {
     user: userModule,
     bureau: bureauModule,
     building: buildingModule,
    }
});
