<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Regimen de Pension</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalRegpen('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="rp_regimen_pension">Regimen Pensionario</option>
                            <option value="cod_regimen_pension ">Codigo Regimen</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarRegpen(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarRegpen(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Codigo</th>
                            <th class="column-title">Regimen Pensionario</th>
                            <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(regpen,index) in arrayRegpen" :key="regpen.cod_regimen_pension " class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="regpen.cod_regimen_pension"></td>
                            <td class=" " v-text="regpen.rp_regimen_pension"></td>
                            <td>
                            <button type="button" @click="abrirModalRegpen('actualizar',regpen)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarRegpen(regpen.cod_regimen_pension)" title='Eliminar' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
              <div class="modal fade" :class="{'mostrar':modalRegpen}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalRegpen()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalregpen"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                     <div class="col-md-2">
                                        <label for="text-input">Codigo</label>
                                        <input type="text" v-model="regpen.cod_regimen_pension" id="cod_regimen_pension" class="form-control">
                                        <span v-if="errors.cod_regimen_pension" class="error">{{errors.cod_regimen_pension[0]}}</span>
                                    </div>

                                    <div class="col-md-10">
                                        <label for="text-input">Tipo de Documento</label>
                                        <input type="text" v-model="regpen.rp_regimen_pension" class="form-control">
                                        <span v-if="errors.rp_regimen_pension" class="error">{{errors.rp_regimen_pension[0]}}</span>
                                    </div>
                                    
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalRegpen()">Cerrar</button>
                            <button type="button" v-if="tipoAccionregpen==1" class="btn btn-primary" @click="registrarRegpen()">Guardar</button>
                            <button type="button" v-if="tipoAccionregpen==2" class="btn btn-primary" @click="actualizarRegpen()">Actualizar</button>
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
                arrayRegpen: [],
                criterio: 'rp_regimen_pension',
                modalRegpen: 0,
                regpen:{
                    cod_regimen_pension:'',
                    rp_regimen_pension:'',
                },
                tituloModalregpen: '',
                tipoAccionregpen: 0,
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
            
        listarRegpen(page,buscar,criterio){
                let me=this;
                var url= 'regimenpension/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayRegpen=respuesta.regimenpension.data;
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
                me.listarRegpen(page,buscar,criterio);

            },


        abrirModalRegpen(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalRegpen=1;
                    this.tituloModalregpen='Nuevo Regimen de pensiones';
                    this.regpen.cod_regimen_pension  ='';
                    this.regpen.rp_regimen_pension='';
                    this.tipoAccionregpen=1;
                    document.getElementById("cod_regimen_pension").disabled = false;
                    break;
                }
                case 'actualizar':
                {
                    this.modalRegpen = 1;
                    this.tituloModalregpen = "Editar Regimen de pensiones";
                    this.regpen.cod_regimen_pension  = data['cod_regimen_pension'];
                    this.regpen.rp_regimen_pension = data['rp_regimen_pension'];
                    document.getElementById("cod_regimen_pension").disabled = true;
                    this.tipoAccionregpen = 2;
                    break;
                }
            }
        
        },

        cerrarModalRegpen(){
            this.modalRegpen = 0;
            this.tituloModalregpen = '';
        },

        //--Registrar Regimen Pensionario--

        registrarRegpen() {

            this.errors=[];

            var me = this;

            axios.post('regimenpension/store', {
                'cod_regimen_pension' : me.regpen.cod_regimen_pension,
                'rp_regimen_pension' : me.regpen.rp_regimen_pension,
            }).then(function (response) {
                me.cerrarModalRegpen();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarRegpen(1, '', 'rp_regimen_pension');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        //--Fin Registrar Regimen Pensionario--

        //--Fin Actualizar Regimen Pensionario--

        actualizarRegpen() {

            this.errors=[];
        
            var me = this;

            axios.put('regimenpension/update', {
                'cod_regimen_pension' : me.regpen.cod_regimen_pension,
                'rp_regimen_pension' : me.regpen.rp_regimen_pension,
            }).then(function (response) {
                me.cerrarModalRegpen();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarRegpen(1, '', 'rp_regimen_pension');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarRegpen(id){
            
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
                    axios.put('regimenpension/destroy', {
                        'cod_regimen_pension': id
                    }).then(function (response) {
                        me.listarRegpen(1, '', 'td_documento');
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
            this.listarRegpen(1,this.buscar,this.criterio);
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
