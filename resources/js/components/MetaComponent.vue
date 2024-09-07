<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Listado de Metas</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalMeta('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="m_anio_per">Año</option>
                            <option value="meta ">Meta</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarMeta(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarMeta(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Año</th>
                            <th class="column-title">Meta</th>
                            <th class="column-title">Descripción</th>
                            <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(meta,index) in arrayMeta" :key="meta.m_cod_meta" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="meta.m_anio_per"></td>
                            <td class=" " v-text="meta.meta"></td>
                            <td class=" " v-text="meta.descripcion"></td>
                            <td>
                            <button type="button" @click="abrirModalMeta('actualizar',meta)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarMeta(meta.m_cod_meta)" title='Eliminar' class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i></button>
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
              <div class="modal fade" :class="{'mostrar':modalMeta}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalMeta()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalmeta"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                  <div class="col-md-2" v-if="tipoAccionmeta==2">
                                    <label for="text-input">Codigo</label>
                                    <input type="text" v-model="meta.m_cod_meta " id="m_cod_meta " class="form-control" disabled>
                                    <span v-if="errors.m_cod_meta " class="error">{{errors.m_cod_meta [0]}}</span>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label for="text-input">Año</label>
                                    <input type="text" v-model="meta.m_anio_per" class="form-control">
                                    <span v-if="errors.m_anio_per" class="error">{{errors.m_anio_per[0]}}</span>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label for="text-input">Meta</label>
                                    <input type="text" v-model="meta.meta" class="form-control">
                                    <span v-if="errors.meta" class="error">{{errors.meta[0]}}</span>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label for="text-input">Descripción</label>
                                    <input type="text" v-model="meta.descripcion" class="form-control">
                                    <span v-if="errors.descripcion" class="error">{{errors.descripcion[0]}}</span>
                                  </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalMeta()">Cerrar</button>
                            <button type="button" v-if="tipoAccionmeta==1" class="btn btn-primary" @click="registrarMeta()">Guardar</button>
                            <button type="button" v-if="tipoAccionmeta==2" class="btn btn-primary" @click="actualizarMeta()">Actualizar</button>
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
                arrayMeta: [],
                criterio: 'm_anio_per',
                modalMeta: 0,
                meta:{
                    m_cod_meta:'',
                    m_anio_per:'',
                    meta:'',
                    descripcion:''
                },
                tituloModalmeta: '',
                tipoAccionmeta: 0,
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
            
        listarMeta(page,buscar,criterio){
                let me=this;
                var url= 'meta/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayMeta=respuesta.meta.data;
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
                me.listarMeta(page,buscar,criterio);

            },


        abrirModalMeta(accion,data=[]){
          switch(accion){
            case 'registrar':
            {
                this.modalMeta=1;
                this.tituloModalmeta='Nueva Meta';
                this.meta.m_cod_meta='';
                this.meta.m_anio_per='';
                this.meta.meta='';
                this.meta.descripcion='';
                this.tipoAccionmeta=1;
                break;
            }
            case 'actualizar':
            {
                this.modalMeta = 1;
                this.tituloModalmeta = "Editar Cargo";
                this.meta.m_cod_meta = data['m_cod_meta'];
                this.meta.m_anio_per = data['m_anio_per'];
                this.meta.meta = data['meta'];
                this.meta.descripcion = data['descripcion'];
                this.tipoAccionmeta = 2;
                break;
            }
          }
        },

        cerrarModalMeta(){
            this.modalMeta = 0;
            this.tituloModalmeta = '';
        },

        registrarMeta() {

            this.errors=[];

            var me = this;

            axios.post('meta/store', {
                'm_anio_per' : me.meta.m_anio_per,
                'meta' : me.meta.meta,
                'descripcion' : me.meta.descripcion,
            }).then(function (response) {
                me.cerrarModalMeta();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarMeta(1, '', 'm_anio_per');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarMeta() {

            this.errors=[];
        
            var me = this;

            axios.put('meta/update', {
                'm_cod_meta' : me.meta.m_cod_meta,
                'm_anio_per' : me.meta.m_anio_per,
                'meta' : me.meta.meta,
                'descripcion' : me.meta.descripcion,
            }).then(function (response) {
                me.cerrarModalMeta();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarMeta(1, '', 'm_anio_per');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarMeta(id){
            
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
                    axios.put('meta/destroy', {
                        'm_cod_meta': id
                    }).then(function (response) {
                        me.listarMeta(1, '', 'm_anio_per');
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
            this.listarMeta(1,this.buscar,this.criterio);
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
