
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

window.Vue = require('vue');

///import Multiselect from 'vue-multiselect';
// register globally
//Vue.component('multiselect', Multiselect);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('escritorio', require('./components/Escritorio.vue').default);
Vue.component('personal', require('./components/Personal.vue').default);
Vue.component('contratos', require('./components/Contratos.vue').default);
Vue.component('planilla', require('./components/Planilla.vue').default);
Vue.component('aporcomprim-component', require('./components/AporcomprimComponent.vue').default);
Vue.component('declaracion', require('./components/Declaracion.vue').default);
Vue.component('boletas', require('./components/Boletas.vue').default);
Vue.component('compriafp', require('./components/Compriafp.vue').default);
Vue.component('operaciones', require('./components/Operacionesmasivas.vue').default);
Vue.component('compromiso', require('./components/Compromiso.vue').default);
Vue.component('mcpp', require('./components/Mcpp.vue').default);
Vue.component('generarplanilla', require('./components/GenerarPlanilla.vue').default);
Vue.component('importinastar', require('./components/ImportInastar.vue').default);
Vue.component('uejecutora-component', require('./components/UejecutoraComponent.vue').default);
Vue.component('parametros-component', require('./components/ParametrosComponent.vue').default);
Vue.component('tipodoc-component', require('./components/TipodocComponent.vue').default);
Vue.component('sexo-component', require('./components/SexoComponent.vue').default);
Vue.component('estadocivil-component', require('./components/EstadocivilComponent.vue').default);
Vue.component('depart-component', require('./components/DepartComponent.vue').default);
Vue.component('provincia-component', require('./components/ProvinciaComponent.vue').default);
Vue.component('distrito-component', require('./components/DistritoComponent.vue').default);
Vue.component('regpension-component', require('./components/RegpensionComponent.vue').default);
Vue.component('users-component', require('./components/users.vue').default);
Vue.component('modpermissions-component', require('./components/Permissions.vue').default);
Vue.component('roles-component', require('./components/Roles.vue').default);
Vue.component('cargo-component', require('./components/CargoComponent.vue').default);
Vue.component('adminpen-component', require('./components/AdminpenComponent.vue').default);
Vue.component('banco-component', require('./components/BancoComponent.vue').default);
Vue.component('reglaboral-component', require('./components/ReglaboralComponent.vue').default);
Vue.component('area-component', require('./components/AreaComponent.vue').default);
Vue.component('meta-component', require('./components/MetaComponent.vue').default);

const app = new Vue({
    el: '#app',
    data : {
        menu:0
    }
});
