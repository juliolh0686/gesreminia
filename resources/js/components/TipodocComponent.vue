<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Tipo de Documento</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalTipodoc('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="td_documento">Tipo de Documento</option>
                            <option value="cod_tipo_documento ">Codigo de Documento</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarTipodoc(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarTipodoc(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Codigo</th>
                            <th class="column-title">Tipo de Documento</th>
                            <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(tipodoc,index) in arrayTipodoc" :key="tipodoc.cod_tipo_documento " class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="tipodoc.cod_tipo_documento "></td>
                            <td class=" " v-text="tipodoc.td_documento"></td>
                            <td>
                            <button type="button" @click="abrirModalTipodoc('actualizar',tipodoc)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarTipodoc(tipodoc.cod_tipo_documento)" title='Eliminar' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
              <div class="modal fade" :class="{'mostrar':modalTipodoc}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModaltipodoc()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModaltipodoc"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                     <div class="col-md-2">
                                        <label for="text-input">Codigo</label>
                                        <input type="text" v-model="tipodocumento.cod_tipo_documento" id="cod_tipo_documento" class="form-control">
                                        <span v-if="errors.cod_tipo_documento" class="error">{{errors.cod_tipo_documento[0]}}</span>
                                    </div>

                                    <div class="col-md-10">
                                        <label for="text-input">Tipo de Documento</label>
                                        <input type="text" v-model="tipodocumento.td_documento" class="form-control">
                                        <span v-if="errors.td_documento" class="error">{{errors.td_documento[0]}}</span>
                                    </div>
                                    
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModaltipodoc()">Cerrar</button>
                            <button type="button" v-if="tipoAcciontipodoc==1" class="btn btn-primary" @click="registrarTipodoc()">Guardar</button>
                            <button type="button" v-if="tipoAcciontipodoc==2" class="btn btn-primary" @click="actualizarTipodoc()">Actualizar</button>
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
                arrayTipodoc: [],
                criterio: 'td_documento',
                modalTipodoc: 0,
                tipodocumento:{
                    cod_tipo_documento:'',
                    td_documento:'',
                },
                tituloModaltipodoc: '',
                tipoAcciontipodoc: 0,
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
            
        listarTipodoc(page,buscar,criterio){
                let me=this;
                var url= 'tipodoc/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTipodoc=respuesta.tipodoc.data;
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
                me.listarTipodoc(page,buscar,criterio);

            },


        abrirModalTipodoc(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalTipodoc=1;
                    this.tituloModaltipodoc='Nuevo Tipo de Documento';
                    this.tipodocumento.cod_tipo_documento ='';
                    this.tipodocumento.td_documento='';
                    this.tipoAcciontipodoc=1;
                    document.getElementById("cod_tipo_documento").disabled = false;
                    break;
                }
                case 'actualizar':
                {
                    this.modalTipodoc = 1;
                    this.tituloModaltipodoc = "Editar Tipo de Documento";
                    this.tipodocumento.cod_tipo_documento = data['cod_tipo_documento'];
                    this.tipodocumento.td_documento = data['td_documento'];
                    document.getElementById("cod_tipo_documento").disabled = true;
                    this.tipoAcciontipodoc = 2;
                    break;
                }
            }
        
        },

        cerrarModaltipodoc(){
            this.modalTipodoc = 0;
            this.tituloModaltipodoc = '';
        },

        registrarTipodoc() {

            this.errors=[];

            var me = this;

            axios.post('tipodoc/store', {
                'cod_tipo_documento' : me.tipodocumento.cod_tipo_documento,
                'td_documento' : this.tipodocumento.td_documento,
            }).then(function (response) {
                me.cerrarModaltipodoc();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarTipodoc(1, '', 'td_documento');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarTipodoc() {

            this.errors=[];
        
            var me = this;

            axios.put('tipodoc/update', {
                'cod_tipo_documento': me.tipodocumento.cod_tipo_documento,
                'td_documento' : me.tipodocumento.td_documento,
            }).then(function (response) {
                me.cerrarModaltipodoc();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarTipodoc(1, '', 'td_documento');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarTipodoc(id){
            
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
                    axios.put('tipodoc/destroy', {
                        'cod_tipo_documento': id
                    }).then(function (response) {
                        me.listarTipodoc(1, '', 'td_documento');
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
            this.listarTipodoc(1,this.buscar,this.criterio);
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
