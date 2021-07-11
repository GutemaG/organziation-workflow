import Vue from 'vue'

import EditModal from './user/EditModal.vue'
import AddUserModal from './user/AddUserModal.vue'
import Home from './Home.vue'
import AddBureauModal from './bureau/AddBureauModal.vue'
import EditBureauModal from './bureau/EditBureauModal.vue'
import AddBuildingModal from './building/AddBuildingModal.vue'
import EditBuildingModal from './building/EditBuildingModal.vue'
import BaseInput from './Base/BaseInput.vue'

/*j
Vue.component('edit-user-modal', require('./components/user/EditModal.vue').default);
Vue.component('add-user-modal', require('./components/user/AddUserModal.vue').default);
Vue.component('home', require('./components/Home.vue').default);
Vue.component('add-bureau-modal', require('./components/bureau/AddBureauModal.vue').default);
Vue.component('edit-bureau-modal', require('./components/bureau/EditBureauModal.vue').default);
Vue.component('add-building-modal', require('./components/building/AddBuildingModal.vue').default);
Vue.component('edit-building-modal', require('./components/building/EditBuildingModal.vue').default);
Vue.component('base-input', require('./components/Base/BaseInput.vue').default);
*/

export default Vue.component({
    'edit-user-modal':EditModal,
    'add-user-modal':AddUserModal,
    'home': Home,
    'add-bureau-modal':AddBureauModal,
    'edit-bureau-modal':EditBureauModal,
    'edit-building-modal':EditBuildingModal,
    'add-building-modal':AddBuildingModal,
    BaseInput
});