<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Listado de Cargos</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalCargo('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="c_nomcar">Cargo</option>
                            <option value="cod_cargo ">Codigo Cargo</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarCargo(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarCargo(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Cargo</th>
                            <th class="column-title">Cargo Abreviado</th>
                            <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(cargo,index) in arrayCargo" :key="cargo.cod_cargo" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="cargo.c_nomcar"></td>
                            <td class=" " v-text="cargo.c_abrev_cargo"></td>
                            <td>
                            <button type="button" @click="abrirModalCargo('actualizar',cargo)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarCargo(cargo.cod_cargo)" title='Eliminar' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
              <div class="modal fade" :class="{'mostrar':modalCargo}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalCargo()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalcargo"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                  <div class="col-md-2" v-if="tipoAccioncargo==2">
                                    <label for="text-input">Codigo</label>
                                    <input type="text" v-model="cargo.cod_cargo" id="cod_cargo" class="form-control" disabled>
                                    <span v-if="errors.cod_cargo" class="error">{{errors.cod_cargo[0]}}</span>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label for="text-input">Cargo</label>
                                    <input type="text" v-model="cargo.c_nomcar" class="form-control">
                                    <span v-if="errors.c_nomcar" class="error">{{errors.c_nomcar[0]}}</span>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label for="text-input">Cargo Abreviado</label>
                                    <input type="text" v-model="cargo.c_abrev_cargo" class="form-control">
                                    <span v-if="errors.c_abrev_cargo" class="error">{{errors.c_abrev_cargo[0]}}</span>
                                  </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalCargo()">Cerrar</button>
                            <button type="button" v-if="tipoAccioncargo==1" class="btn btn-primary" @click="registrarCargo()">Guardar</button>
                            <button type="button" v-if="tipoAccioncargo==2" class="btn btn-primary" @click="actualizarCargo()">Actualizar</button>
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

    export default {
        data(){
            return {
                arrayCargo: [],
                criterio: 'c_nomcar',
                modalCargo: 0,
                cargo:{
                    cod_cargo:'',
                    c_nomcar:'',
                    c_abrev_cargo:''
                },
                tituloModalcargo: '',
                tipoAccioncargo: 0,
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
            
        listarCargo(page,buscar,criterio){
                let me=this;
                var url= 'cargo/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCargo=respuesta.cargo.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

        cambiarPagina(page,buscar,criterio){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarCargo(page,buscar,criterio);

            },


        abrirModalCargo(accion,data=[]){
          switch(accion){
            case 'registrar':
            {
                this.modalCargo=1;
                this.tituloModalcargo='Nuevo Cargo';
                this.cargo.cod_cargo='';
                this.cargo.c_nomcar='';
                this.cargo.c_abrev_cargo='';
                this.tipoAccioncargo=1;
                break;
            }
            case 'actualizar':
            {
                this.modalCargo = 1;
                this.tituloModalcargo = "Editar Cargo";
                this.cargo.cod_cargo = data['cod_cargo'];
                this.cargo.c_nomcar = data['c_nomcar'];
                this.cargo.c_abrev_cargo = data['c_abrev_cargo'];
                this.tipoAccioncargo = 2;
                break;
            }
          }
        },

        cerrarModalCargo(){
            this.modalCargo = 0;
            this.tituloModalCargo = '';
        },

        registrarCargo() {

            this.errors=[];

            var me = this;

            axios.post('cargo/store', {
                'c_nomcar' : me.cargo.c_nomcar,
                'c_abrev_cargo' : me.cargo.c_abrev_cargo,
            }).then(function (response) {
                me.cerrarModalCargo();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarCargo(1, '', 'c_nomcar');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarCargo() {

            this.errors=[];
        
            var me = this;

            axios.put('cargo/update', {
                'cod_cargo' : me.cargo.cod_cargo,
                'c_nomcar' : me.cargo.c_nomcar,
                'c_abrev_cargo' : me.cargo.c_abrev_cargo,
            }).then(function (response) {
                me.cerrarModalCargo();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarCargo(1, '', 'c_nomcar');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarCargo(id){
            
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
                    axios.put('cargo/destroy', {
                        'cod_cargo': id
                    }).then(function (response) {
                        me.listarCargo(1, '', 's_sexo');
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
        }

        },
        mounted() {
            this.listarCargo(1,this.buscar,this.criterio);
        }
    }
</script>

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
