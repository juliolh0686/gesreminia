<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Aportaciones, Comisiones y Primas</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Administrador de Pensiones</th>
                            <th class="column-title">% Comisión Sobre Flujo o Mixta</th>
                            <th class="column-title">% Prima de Seguros</th>
                            <th class="column-title">% Aporte Obligatorio</th>
                            <th class="column-title">% Aporte Fijo</th>
                            <th class="column-title">% Total Aporte</th>
                            <th class="column-title no-link last"  colspan="1" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="adminpension in arrayAdminpensiones" :key="adminpension.cod_admin_pension" class="even pointer">
                            <td class=" " v-text="adminpension.ap_admin_pension"></td>
                            <td class=" " v-text="adminpension.ap_comision"></td>
                            <td class=" " v-text="adminpension.ap_prima"></td>
                            <td class=" " v-text="adminpension.ap_aporte"></td>
                            <td class=" " v-text="adminpension.ap_aporte_fijo"></td>
                            <td class=" " v-text="adminpension.ap_total_admpen"></td>
                            <td width="10px">
                            <button type="button" @click="abrirModaladminpensiones('actualizar',adminpension)" class="btn btn-primary btn-sm">Editar</button>
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
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalplanilla()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalplanilla"></h3>
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                             

                                <div class="form-group row">

                                    <div class="col-md-6">
                                    <label for="text-input">Regimen Pensionario</label>
                                    <select class="form-control" v-model="regimen_pension_cod_regimen_pension" id="regimen_pension_cod_regimen_pension" disabled='disabled'>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="regimenpension in arrayRegimenpension" :key="regimenpension.cod_regimen_pension" :value="regimenpension.cod_regimen_pension" v-text="regimenpension.rp_regimen_pension"></option>
                                    </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="text-input">Administrador de Pensiones</label>
                                        <input type="text" v-model="ap_admin_pension" id="cod_admin_pension" class="form-control" disabled='disabled'>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="text-input">%Comisión</label>
                                        <input type="text" v-model="ap_comision" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">%Prima</label>
                                        <input type="text" v-model="ap_prima" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">%Aporte</label>
                                        <input type="text" v-model="ap_aporte" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">%Ap. Fijo</label>
                                        <input type="text" v-model="ap_aporte_fijo" class="form-control">
                                    </div>
                                </div>
                               
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalplanilla()">Cerrar</button>
                            <button type="button"  class="btn btn-primary" @click="actualizaradmpen()">Actualizar</button>
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
                arrayPeriodos: [],
                arrayRegimenpension: [],
                regimen_pension_cod_regimen_pension:0,
                arrayAdminpensiones:[],
                arrayDetalleplanilla:[],
                cod_admin_pension:'',
                ap_admin_pension:'',
                ap_comision:0,
                ap_prima:0,
                ap_aporte:0,
                ap_aporte_fijo:0,
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

        cambiarPagina(page,buscar,criterio){

            let me = this;
            //actualizar la pagina actual
            me.pagination.current_page=page;
            //envia la peticion para visualizar la data de esa pagina
            me.listaradminpension(page,buscar,criterio);

        },
            
        listaradminpension(page,buscar,criterio){
                let me=this;
                var url= 'adminpension/adminpensiones?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayAdminpensiones=respuesta.adminpensiones.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

        selectRegimenpension(){
            var me = this;
            var url = 'regimenpension/selectRegimenpension';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayRegimenpension = respuesta.regimenpension;
            }).catch(function (error) {
                console.log(error);
            });
        },

    

        registrarPlanilla() {

            var me = this;

            axios.post('planilla/store', {
                'pll_periodo': this.pll_periodo,
                'pll_detalle': this.pll_detalle,
            }).then(function (response) {
                me.cerrarModalplanilla();
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'Planilla Aperturada Satisfactoriamente',
                    showConfirmButton: false,
                    timer: 1500
                    })
                me.listarPlanilla(1, '', 'pll_periodo');
            }).catch(function (error) {
                console.log(error);
            });
        },

        actualizaradmpen() {

            var me = this;

            axios.put('adminpension/update', {
                'cod_admin_pension': this.cod_admin_pension,
                'ap_comision': this.ap_comision,
                'ap_prima': this.ap_prima,
                'ap_aporte': this.ap_aporte,
                'ap_aporte_fijo': this.ap_aporte_fijo,
            }).then(function (response) {
                me.cerrarModalplanilla();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Actualizado Satisfactoriamente',
                    showConfirmButton: false,
                    timer: 1500
                    })
                me.listaradminpension(1, '','');
            }).catch(function (error) {
                console.log(error);
            });
        },

        eliminarPlanilla(id){
            
            let me=this;

            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
              })
              
              swalWithBootstrapButtons({
                title: '¿Está seguro de Eliminar?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
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
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: '¡Eliminado!, Se Elimino Correctamente',
                            showConfirmButton: false,
                            timer: 1500
                            })
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                  // Read more about handling dismissals
                  result.dismiss === swal.DismissReason.cancel
                ) {
                  swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'Cancelado, no se eliminó la selección',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
              })

        },


        cerrarModalplanilla(){
            this.modalplanilla = 0;
            this.tituloModalplanilla = '';
            //this.errorPersonal = 0;
           // this.errorMostrarMsjPersonal = [];
        },

        //ABRIR MODAL PARA MODIFICACION DE DATOS
        abrirModaladminpensiones(accion,data=[]){
            switch(accion){
                case 'registrar':
                    {
                        this.modalplanilla=1;
                        this.cod_admin_pension='';
                        document.getElementById("cod_admin_pension").disabled = '';
                        document.getElementById("regimen_pension_cod_regimen_pension").disabled = '';
                        this.ap_admin_pension='';
                        this.ap_comision='';
                        this.ap_prima='';
                        this.ap_aporte='';
                        this.ap_aporte_fijo='';
                        break;
                    }
                case 'actualizar':
                    {
                        this.modalplanilla=1;
                        this.cod_admin_pension=data['cod_admin_pension'];
                        this.regimen_pension_cod_regimen_pension = data['regimen_pension_cod_regimen_pension'];
                        document.getElementById("cod_admin_pension").disabled = 'disabled';
                        document.getElementById("regimen_pension_cod_regimen_pension").disabled = 'disabled';
                        this.ap_admin_pension=data['ap_admin_pension'];
                        this.ap_comision=data['ap_comision'];
                        this.ap_prima=data['ap_prima'];
                        this.ap_aporte=data['ap_aporte'];
                        this.ap_aporte_fijo=data['ap_aporte_fijo'];
                        break;
                    }
                        
            }

        },

        Procesarplanilla(cod_planilla,estado){
        
            if(estado=='01'){
                //if (this.validarPersonal()) {
            //     return;
            // }

                var me = this;

                axios.post('planilla/procesarplanilla', {
                    'cod_planilla': cod_planilla,
                }).then(function (response) {
                    me.listarPlanilla(1, '', 'pll_periodo');
                }).catch(function (error) {
                    console.log(error);
                });
            }else{
                alert('planilla debe estar en estado aperturado')
            }
        
        },

        Cerrarplanilla(cod_planilla,estado){
        
            if(estado=='02'){
                //if (this.validarPersonal()) {
            //     return;
            // }

                var me = this;

                axios.post('planilla/cerrarplanilla', {
                    'cod_planilla': cod_planilla,
                }).then(function (response) {
                    me.listarPlanilla(1, '', 'pll_periodo');
                }).catch(function (error) {
                    console.log(error);
                });
                
            }else{
            alert('Planilla tiene que estar procesada')
            }
        
        },

        Limpiarplanilla(cod_planilla,estado){
        
            if(estado=='02'){
                //if (this.validarPersonal()) {
            //     return;
            // }

                var me = this;

                axios.post('planilla/limpiarplanilla', {
                    'cod_planilla': cod_planilla,
                }).then(function (response) {
                    me.listarPlanilla(1, '', 'pll_periodo');
                }).catch(function (error) {
                    console.log(error);
                });
                
            }else{
            alert('Planilla tiene que estar procesada')
            }
        
        }

        },
        mounted() {
           this.listaradminpension();
           this.selectRegimenpension();
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
