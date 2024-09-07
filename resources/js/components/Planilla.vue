<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Gestión de Planilla</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalplanilla('planilla','registrar')" class="btn btn-danger float-right">
                            <i class="fas fa-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="pll_periodo">Periodo</option>
                            <option value="pll_detalle">Detalle de Planilla</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarPlanilla(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarPlanilla(1,buscar,criterio)" class="btn btn-primary"><i class="fab fa-sistrix"></i>&nbsp;Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Tipo de Planilla</th>
                            <th class="column-title">Clase Planilla</th>
                            <th class="column-title">Periodo</th>
                            <th class="column-title">Detalle</th>
                            <th class="column-title">Monto Bruto</th>
                            <th class="column-title">Descuentos</th>
                            <th class="column-title">Monto Liquido</th>
                            <th class="column-title">Aportes</th>
                            <th class="column-title">Estado</th>
                            <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(planilla,index) in arrayPlanilla" :key="planilla.cod_planilla" class="even pointer">
                            <td class=" " v-text="index+1"></td>
                            <td class=" " v-text="planilla.tpll_tipo_planilla"></td>
                            <td class=" " v-text="planilla.cpll_clase_planilla"></td>
                            <td class=" " v-text="planilla.pll_periodo"></td>
                            <td class=" " v-text="planilla.pll_detalle"></td>
                            <td class=" " v-text="planilla.pll_bruto"></td>
                            <td class=" " v-text="planilla.pll_desc"></td>
                            <td class=" " v-text="planilla.pll_liquido"></td>
                            <td class=" " v-text="planilla.pll_aport"></td>
                            <td class=" " width="10px">
                                <div v-if="planilla.plles_estado=='APERTURADO'">
                                    <span class="label label-success">APERTURADO</span>
                                </div>
                                <div v-if="planilla.plles_estado=='PROCESADO'">
                                    <span class="label label-warning">PROCESADO</span>
                                </div>
                                <div v-if="planilla.plles_estado=='CERRADO'">
                                    <span class="label label-danger">CERRADO</span>
                                </div>
                            </td>
                            <td width="10px">
                                 <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button" aria-expanded="false">Planilla<span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                    <li><a href="#" @click="Procesarplanilla(planilla.cod_planilla,planilla.planilla_estado_cod_plla_estado)">Procesar</a>
                                    </li>
                                    <li><a href="#" @click="Limpiarplanilla(planilla.cod_planilla,planilla.planilla_estado_cod_plla_estado)">Limpiar</a>
                                    </li>
                                    <li><a href="#" @click="Cerrarplanilla(planilla.cod_planilla,planilla.planilla_estado_cod_plla_estado)">Cerrar</a>
                                    </li>
                                    </ul>
                                </div>
                            </td>
                            <td width="10px">
                            <button type="button" @click="abrirModalplanilla('planilla','actualizar',planilla,planilla.cod_plla_estado)" class="btn btn-primary btn-sm">Editar</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="eliminarPlanilla(planilla.cod_planilla,planilla.cod_plla_estado)" class="btn btn-danger btn-sm">Eliminar</button>
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
              <div class="modal fade" :class="{'mostrar':modalplanilla}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalplanilla()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalplanilla"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                     <div class="col-md-4">
                                        <label for="text-input">Periodo</label>
                                        <input type="text" v-model="pll_periodo" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Tipo de Planilla</label>
                                        <select class="form-control" v-model="tipo_planilla_cod_tipo_planilla">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipoplanilla in arrayTipoPlanilla" :key="tipoplanilla.cod_tipo_planilla" :value="tipoplanilla.cod_tipo_planilla" v-text="tipoplanilla.tpll_tipo_planilla"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Clase de Planilla</label>
                                        <select class="form-control" v-model="clase_planilla_cod_clase_planilla">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="claseplanilla in arrayClasePlanilla" :key="claseplanilla.cod_clase_planilla" :value="claseplanilla.cod_clase_planilla" v-text="claseplanilla.cpll_clase_planilla"></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="text-input">Detalle Planilla</label>
                                        <input type="text" v-model="pll_detalle" class="form-control">
                                    </div>
                                </div>
                               
                                <div v-show="errorPersonal" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersonal" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalplanilla()">Cerrar</button>
                            <button type="button" v-if="tipoAccionplanilla==1" class="btn btn-primary" @click="registrarPlanilla()">Guardar</button>
                            <button type="button" v-if="tipoAccionplanilla==2" class="btn btn-primary" @click="actualizarPlanilla()">Actualizar</button>
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
                arrayPlanilla: [],
                arrayTipoPlanilla: [],
                arrayClasePlanilla: [],
                cod_planilla: [],
                criterio: 'pll_periodo',
                modalplanilla: 0,
                tituloModalplanilla: '',
                tipoAccionplanilla: 0,
                errorPersonal: 0,
                errorMostrarMsjPersonal: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                offset: 3,
                buscar: '',
                pll_periodo: '',
                tipo_planilla_cod_tipo_planilla: '',
                clase_planilla_cod_clase_planilla: '',
                pll_detalle: '',
                pll_periodo: '',
                
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
            
            listarPlanilla(page,buscar,criterio){
                let me=this;
                var url= 'planilla?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPlanilla=respuesta.planilla.data;
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
                me.listarPlanilla(page,buscar,criterio);

            },

            registrarPlanilla() {

                //if (this.validarPersonal()) {
                //     return;
                // }

                var me = this;

                axios.post('planilla/store', {
                    'tipo_planilla_cod_tipo_planilla': this.tipo_planilla_cod_tipo_planilla,
                    'clase_planilla_cod_clase_planilla': this.clase_planilla_cod_clase_planilla,
                    'pll_periodo': this.pll_periodo,
                    'pll_detalle': this.pll_detalle,
                }).then(function (response) {
                    me.cerrarModalplanilla();
                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Planilla Aperturada Satisfactoriamente',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    me.listarPlanilla(1, '', 'pll_periodo');
                }).catch(function (error) {
                    console.log(error);
                });
        },

            actualizarPlanilla() {
        
                var me = this;

                axios.put('planilla/update', {
                    'cod_planilla': this.cod_planilla,
                    'tipo_planilla_cod_tipo_planilla': this.tipo_planilla_cod_tipo_planilla,
                    'clase_planilla_cod_clase_planilla': this.clase_planilla_cod_clase_planilla,
                    'pll_periodo': this.pll_periodo,
                    'pll_detalle': this.pll_detalle,
                }).then(function (response) {
                    me.cerrarModalplanilla();
                Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Proceso Realizado con Éxito',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    me.listarPlanilla(1, '', 'pll_periodo');
                }).catch(function (error) {
                    console.log(error);
                });
            },

            eliminarPlanilla(id,estado){

                if(estado != '03'){
                    
                    let me=this;

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de Eliminar?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'No, Cancelar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.value) {

                            axios.put('planilla/destroy', {
                                'cod_planilla': id
                            }).then(function (response) {
                                me.listarPlanilla(1, '', 'pll_periodo');
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Planilla Eliminada',
                                    showConfirmButton: false,
                                    timer: 1500
                                    })
                            }).catch(function (error) {
                                console.log(error);
                            });

                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Eliminación Cancelada',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        }
                        })

                }else{
                    Swal.fire('Planilla en  estado "Cerrado"','','info')
                }

            },


            cerrarModalplanilla(){
                this.modalplanilla = 0;
                this.tituloModalplanilla = '';
                //this.errorPersonal = 0;
                // this.errorMostrarMsjPersonal = [];
            },

            validarPersonal(){
                this.errorPersonal = 0;
                this.errorMostrarMsjPersonal = [];

                if (!this.p_a_paterno) this.errorMostrarMsjPersonal.push("El Apellido Paterno no Puede estar Vacia");
                if (!this.p_a_materno) this.errorMostrarMsjPersonal.push("El Apellido Materno no Puede estar Vacia");

                if (this.errorMostrarMsjPersonal.length) this.errorPersonal = 1;
                return this.errorPersonal;
            },

            abrirModalplanilla(modelo,accion,data=[],estado){
                switch(modelo){
                    case "planilla":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modalplanilla=1;
                                this.tituloModalplanilla='Nueva Planilla';
                                this.pll_periodo='';
                                this.pll_detalle='';
                                this.tipoAccionplanilla=1;
                                this.tipo_planilla_cod_tipo_planilla = 0;
                                this.clase_planilla_cod_clase_planilla=0;
                                break;
                            }
                            case 'actualizar':
                            {
                                if(estado != '03'){
                                //console.log(data);
                                        this.modalplanilla = 1;
                                        this.tituloModalplanilla = "Editar Planilla";
                                        this.tipoAccionplanilla = 2;
                                        this.tipo_planilla_cod_tipo_planilla = data['tipo_planilla_cod_tipo_planilla'];
                                        this.clase_planilla_cod_clase_planilla = data['clase_planilla_cod_clase_planilla'];
                                        this.cod_planilla = data['cod_planilla'];
                                        this.pll_periodo = data['pll_periodo'];
                                        this.pll_detalle = data['pll_detalle'];
                                        break;
                                }else{
                                    swal('Desabilitada para planillas en estado "Cerrado"','','info')
                                }
                            }
                        }
                    }
                }
            },

            Procesarplanilla(cod_planilla,estado){
                
                if(estado=='01'){
                    
                    var me = this;

                        let timerInterval
                            Swal.fire({
                            title: 'Procesar',
                            html: 'Procesando la planilla',
                            timerProgressBar: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            });

                    axios.post('planilla/procesarplanilla', {
                        'cod_planilla': cod_planilla,
                    }).then(function (response) {
                        me.listarPlanilla(1, '', 'pll_periodo');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Planilla Procesada',
                            showConfirmButton: false,
                            timer: 1500
                            })
                    }).catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        console.log('hola');
                    });;
                }else{
                    Swal.fire('Planilla debe estar en estado "Aperturado"','','info')
                }
                
            },

            Cerrarplanilla(cod_planilla,estado){
            
                if(estado=='02'){

                    var me = this;

                    axios.post('planilla/cerrarplanilla', {
                        'cod_planilla': cod_planilla,
                    }).then(function (response) {
                        me.listarPlanilla(1, '', 'pll_periodo');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Planilla Cerrada',
                            showConfirmButton: false,
                            timer: 1500
                            })
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                }else{
                Swal.fire('Planilla debe estar en estado "Procesado"','','info')
                }
            
            },

            Limpiarplanilla(cod_planilla,estado){
            
                if(estado=='02'){
            
                    var me = this;

                    let timerInterval
                            Swal.fire({
                            title: 'Procesar',
                            html: 'Procesando la planilla',
                            timerProgressBar: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            });

                    axios.post('planilla/limpiarplanilla', {
                        'cod_planilla': cod_planilla,
                    }).then(function (response) {
                        me.listarPlanilla(1, '', 'pll_periodo');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Planilla Aperturada',
                            showConfirmButton: false,
                            timer: 1500
                            })
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                }else{
                Swal.fire('Planilla debe estar en estado "Procesado"','','info')
                }
            
            },

            selectTipoPlanilla() {
                var me = this;
                var url = 'planilla/selecttipoplanilla';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayTipoPlanilla = respuesta.tipoplanilla;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            selectClasePlanilla() {
                var me = this;
                var url = 'planilla/selectclaseplanilla';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayClasePlanilla = respuesta.claseplanilla;
                }).catch(function (error) {
                    console.log(error);
                });
            },

        },
        mounted() {
            this.listarPlanilla(1,this.buscar,this.criterio);
            this.selectTipoPlanilla();
            this.selectClasePlanilla();
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
