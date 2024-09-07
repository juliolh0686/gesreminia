<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Roles</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalRol('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarRoles(1,buscar)" class="form-control">
                    </div>
                    <button type="submit" @click="listarRoles(1,buscar)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Nombres</th>
                            <th class="column-title">Permisos</th>
                            <th class="column-title no-link last" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(role,index) in arrayRoles" :key="role.id" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="role.name"></td>
                            <td>
                              <multiselect 
                                v-model="role.permissions"
                                placeholder="Agregar un Rol"
                                label="name"
                                track-by="id"
                                :hide-selected="true"
                                :searchable="false"
                                :showLabels="false"
                                :options="arrayPermissions"
                                :multiple="true"
                                :taggable="true"
                                @tag="addTag"
                                @input="updatePermissions(role.id,role.permissions)"
                                >
                            </multiselect>
                            </td>
                            <td>
                            <button type="button" @click="abrirModalRol('actualizar',role)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarRol(role.id)" title='Eliminar' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
              <div class="modal fade" :class="{'mostrar':modalRoles}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalRol()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalRol"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="col-md-2">
                                        <label for="text-input">ID</label>
                                        <input type="text" v-model="rol.id" id="id" class="form-control" readonly>
                                    </div>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <label for="text-input">Nombre del Rol</label>
                                        <input type="text" v-model="rol.name" class="form-control">
                                    </div>
                                    
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalRol()">Cerrar</button>
                            <button type="button" v-if="tipoAccionsexo==1" class="btn btn-primary" @click="registrarRol()">Guardar</button>
                            <button type="button" v-if="tipoAccionsexo==2" class="btn btn-primary" @click="actualizarRol()">Actualizar</button>
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
                arrayRoles: [],
                arrayPermissions: [],
                modalRoles: 0,
                rol:{
                    id:'',
                    name:'',
                },
                tituloModalRol: '',
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
            
            
        listarRoles(page,buscar){
                let me=this;
                let url= 'roles?page='+page+'&buscar='+buscar;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayRoles=respuesta.roles.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

        listPermissions(){
            let me=this;
            var url= 'permission/listPermissions';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayPermissions=respuesta.permission;
            })
            .catch(function (error) {
                console.log(error);
            });

        },


        updatePermissions(id, permissions=[]) {

          let valores=[];

          permissions.forEach(valor=> {
          	valores.push(valor.name)
          })
        
            axios.put('permissions/update', {
							id:id,
							permissions: valores
						}).then(function (response) {
            }).catch(function (error) {
                console.log(error);
            });
        },

        abrirModalRol(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalRoles=1;
                    this.tituloModalRol='Nuevo Rol';
                    this.rol.id ='';
                    this.rol.name ='';
                    this.tipoAccionsexo=1;
                    break;
                }
                case 'actualizar':
                {
                    this.modalRoles = 1;
                    this.tituloModalsexo = "Editar Rol";
                    this.rol.id = data['id'];
                    this.rol.name = data['name'];
                    this.tipoAccionsexo = 2;
                    break;
                }
            }
        
        },

        cerrarModalRol(){
            this.modalRoles = 0;
            this.tituloModalRol = '';
        },

        registrarRol() {

            this.errors=[];

            var me = this;

            axios.post('role/store', {
                'name' : me.rol.name,
            }).then(function (response) {
                me.cerrarModalRol();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarRoles(1, '');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarRol() {

            this.errors=[];
        
            var me = this;

            axios.put('role/update', {
               'id' : me.rol.id,
                'name' : me.rol.name,
            }).then(function (response) {
                me.cerrarModalRol();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarRoles(1, '');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        eliminarRol(id){
            
            let me=this;

            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, elimínalo!',
                cancelButtonText: '¡No, cancelar!',
                }).then((result) => {
                if (result.value) {
                    axios.put('role/destroy', {
                        'id': id
                    }).then(function (response) {
                        me.listarRoles(1, '');
                         Swal.fire(
                            '¡Eliminado!',
                            'Registro Eliminado.',
                            'success'
                            )
                    }).catch(function (error) {
                        console.log(error);
                    });
                   
                }
                })
        },

        cambiarPagina(page,buscar,criterio){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarRoles(page,buscar,criterio);

            },

        },
        mounted() {
            this.listarRoles(1,this.buscar,this.criterio);
            this.listPermissions();
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
