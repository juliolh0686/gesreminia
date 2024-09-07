<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Parametros</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalParametros('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="pm_nombre_abrev">Abreviatura</option>
                            <option value="pm_nombre">Nombre</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarParametros(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarParametros(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Parametro</th>
                            <th class="column-title">Abreviatura</th>
                            <th class="column-title">Monto Fijo</th>
                            <th class="column-title">porcentaje</th>
                            <th class="column-title">Descripción</th>
                            <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(parametro,index) in arrayParametros" :key="parametro.pm_id" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="parametro.pm_nombre"></td>
                            <td class=" " v-text="parametro.pm_nombre_abrev"></td>
                            <td class=" " v-text="parametro.pm_monto"></td>
                            <td class=" " v-text="parametro.pm_porcentaje"></td>
                            <td class=" " v-text="parametro.pm_descripcion"></td>
                            <td>
                            <button type="button" @click="abrirModalParametros('actualizar',parametro)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarParametro(parametro.pm_id)" title='Eliminar' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
              <div class="modal fade" :class="{'mostrar':modalParametros}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalparametros()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalparametro"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                     <div class="col-md-4">
                                        <label for="text-input">Parametro</label>
                                        <input type="text" v-model="parametros.pm_nombre" class="form-control">
                                        <span v-if="errors.pm_nombre" class="error">{{errors.pm_nombre[0]}}</span>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="text-input">Abreviatura</label>
                                        <input type="text" v-model="parametros.pm_nombre_abrev" class="form-control">
                                        <span v-if="errors.pm_nombre_abrev" class="error">{{errors.pm_nombre_abrev[0]}}</span>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="text-input">Monto</label>
                                        <input type="text" v-model="parametros.pm_monto" class="form-control">
                                        <span v-if="errors.pm_monto" class="error">{{errors.pm_monto[0]}}</span>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="text-input">Porcentaje</label>
                                        <input type="text" v-model="parametros.pm_porcentaje" class="form-control">
                                        <span v-if="errors.pm_porcentaje" class="error">{{errors.pm_porcentaje[0]}}</span>
                                    </div>
                                    
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="text-input">Descripción</label>
                                        <input type="text" v-model="parametros.pm_descripcion" class="form-control">
                                        <span v-if="errors.pm_descripcion" class="error">{{errors.pm_descripcion[0]}}</span>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalparametros()">Cerrar</button>
                            <button type="button" v-if="tipoAccionparametro==1" class="btn btn-primary" @click="registrarParametro()">Guardar</button>
                            <button type="button" v-if="tipoAccionparametro==2" class="btn btn-primary" @click="actualizarParametro()">Actualizar</button>
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
                arrayParametros: [],
                criterio: 'pm_nombre_abrev',
                modalParametros: 0,
                parametros:{
                    pm_id:'',
                    pm_nombre:'',
                    pm_nombre_abrev:'',
                    pm_monto:'',
                    pm_porcentaje:'',
                    pm_descripcion:'',
                },
                tituloModalparametro: '',
                tipoAccionparametro: 0,
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
            
        listarParametros(page,buscar,criterio){
                let me=this;
                var url= 'parametros/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayParametros=respuesta.parametros.data;
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
                me.listarParametros(page,buscar,criterio);

            },


        abrirModalParametros(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalParametros=1;
                    this.tituloModalparametro='Nuevo Parametro';
                    this.parametros.pm_nombre='';
                    this.parametros.pm_nombre_abrev='';
                    this.parametros.pm_monto='';
                    this.parametros.pm_porcentaje='';
                    this.parametros.pm_descripcion='';
                    this.tipoAccionparametro=1;
                    break;
                }
                case 'actualizar':
                {
                    this.modalParametros = 1;
                    this.tituloModalparametro = "Editar Parametro";
                    this.parametros.pm_id = data['pm_id'];
                    this.parametros.pm_nombre = data['pm_nombre'];
                    this.parametros.pm_nombre_abrev = data['pm_nombre_abrev'];
                    this.parametros.pm_monto = data['pm_monto'];
                    this.parametros.pm_porcentaje = data['pm_porcentaje'];
                    this.parametros.pm_descripcion = data['pm_descripcion'];
                    this.tipoAccionparametro = 2;
                    break;
                }
            }
        
        },

        cerrarModalparametros(){
            this.modalParametros = 0;
            this.tituloModalparametro = '';
        },

        registrarParametro() {

            this.errors=[];

            var me = this;

            axios.post('parametros/store', {
                'pm_nombre' : me.parametros.pm_nombre,
                'pm_nombre_abrev' : this.parametros.pm_nombre_abrev,
                'pm_monto' : this.parametros.pm_monto,
                'pm_porcentaje' : this.parametros.pm_porcentaje,
                'pm_descripcion' : this.parametros.pm_descripcion,
            }).then(function (response) {
                me.cerrarModalparametros();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarParametros(1, '', 'pm_nombre_abrev');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarParametro() {

            this.errors=[];
        
            var me = this;

            axios.put('parametros/update', {
                'pm_id': me.parametros.pm_id,
                'pm_nombre' : me.parametros.pm_nombre,
                'pm_nombre_abrev' : this.parametros.pm_nombre_abrev,
                'pm_monto' : this.parametros.pm_monto,
                'pm_porcentaje' : this.parametros.pm_porcentaje,
                'pm_descripcion' : this.parametros.pm_descripcion,
            }).then(function (response) {
                me.cerrarModalparametros();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarParametros(1, '', 'pm_nombre_abrev');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarParametro(id){
            
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
                    axios.put('parametros/destroy', {
                        'pm_id': id
                    }).then(function (response) {
                        me.listarParametros(1, '', 'pm_nombre_abrev');
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
            this.listarParametros(1,this.buscar,this.criterio);
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
