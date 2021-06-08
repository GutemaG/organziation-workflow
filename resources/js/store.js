import Vue from 'vue';

import Vuex from 'vuex';
Vue.use(Vuex);
const axios = require("axios").default;

export default new Vuex.Store({
	state:{
		users: [],
	},
	getters: {
		users: (state) => state.users,
		
	},

	actions: {
		 async fetchUsers({ commit }){
			console.log("Fetching User.....");
	      try {
	        let response = await axios.get("api/users");
	        commit("setUsers", response.data)

	      } catch (error) {
	        console.log(error);
	      }
			}
	},

	mutations:{
		setUsers(state, data){
			state.users = data.users;
		}
	}
});

