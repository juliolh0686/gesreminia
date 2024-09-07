<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Usuarios</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Nombres y Apellidos</th>
                            <th class="column-title">Usuario</th>
                            <th class="column-title">Correo Electrónico</th>
                            <th class="column-title">Roles</th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(user,index) in arrayUsers" :key="user.id" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="user.name"></td>
                            <td class=" " v-text="user.username"></td>
                            <td class=" " v-text="user.email"></td>
                            <td>
                              <multiselect 
                                v-model="user.roles"
                                placeholder="Agregar un Rol"
                                label="name"
                                track-by="id"
                                :hide-selected="true"
                                :searchable="false"
                                :showLabels="false"
                                :options="arrayroles"
                                :multiple="true"
                                :taggable="true"
                                @tag="addTag"
                                @input="updateRoles(user.id,user.roles)"
                                >
                            </multiselect>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                      <nav>
                          <ul class="pagination">
                              <li class="page-item" v-if="pagination.current_page>1">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Anterior</a>
                              </li>
                               <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page">1</a>
                              </li>
                               <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Siguiente</a>
                              </li>
                          </ul>
                      </nav>
                    </div>

			<!--Inicio del modal agregar/actualizar planilla-->
              <div class="modal fade" :class="{'mostrar':modalSexo}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalSexo()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalsexo"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                     <div class="col-md-2">
                                        <label for="text-input">Codigo</label>
                                        <input type="text" v-model="sexo.cod_sexo" id="cod_sexo" class="form-control">
                                        <span v-if="errors.cod_sexo" class="error">{{errors.cod_sexo[0]}}</span>
                                    </div>

                                    <div class="col-md-10">
                                        <label for="text-input">Sexo</label>
                                        <input type="text" v-model="sexo.s_sexo" class="form-control">
                                        <span v-if="errors.s_sexo" class="error">{{errors.s_sexo[0]}}</span>
                                    </div>
                                    
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalSexo()">Cerrar</button>
                            <button type="button" v-if="tipoAccionsexo==1" class="btn btn-primary" @click="registrarSexo()">Guardar</button>
                            <button type="button" v-if="tipoAccionsexo==2" class="btn btn-primary" @click="actualizarSexo()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
						
                  </div>

                </div>

                </div>
                </div>
            
          </div>
        </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect';

    export default {
        data(){
            return {
                arrayUsers: [],
                arrayroles: [],
                criterio: 'name',
                modalSexo: 0,
                sexo:{
                    name:'',
                    username:'',
                },
                tituloModalsexo: '',
                tipoAccionsexo: 0,
                buscar: '',
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                errors:[],
                offset: 3,
            }

        },
        components: { Multiselect },
        computed:{
            isActived:function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
                return [];
                }

                var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }

                var to = from + (this.offset*2);
                if(to >= this.pagination.last_page){
                    to=this.pagination.last_page;
                }

                var pagesArray=[];
                while(from <=to){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;

            }
        },

        methods: {

        addTag (newTag) {
          const tag = {
            name: newTag,
            code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
          }
          this.options.push(tag)
          this.value.push(tag)
        },
            
            
        listarUsers(page,buscar,criterio){
                let me=this;
                var url= 'user?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayUsers=respuesta.user.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

        listarroles(){
            let me=this;
            var url= 'role/userrole';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayroles=respuesta.roles;
            })
            .catch(function (error) {
                console.log(error);
            });

        },

        updateRoles(id, roles=[]) {

          let valores=[];

          roles.forEach(valor=> {
          	valores.push(valor.name)
          })
        
            axios.put('roles/update', {
							id:id,
							roles: valores
						}).then(function (response) {
            }).catch(function (error) {
                console.log(error);
            });
        },

        cambiarPagina(page,buscar,criterio){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarUsers(page,buscar,criterio);

            },

        },
        mounted() {
            this.listarUsers(1,this.buscar,this.criterio);
            this.listarroles();
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

 <style>

        .modal-content{
          width: 100% !important;
          position: absolute !important;
        }

        .mostrar{
          display:list-item !important;
          opacity: 1 !important;
          background-color: #3c29297a !important;
        }

        .div-error{
          display:flex;
          justify-content: center;
        }

        .text-error{
          color: red !important;
          font-weight: bold;
        }

</style>
