<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Operaciones Masivas</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="table">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Tipo de Operación</th>
                            <th class="column-title" colspan="2" align="center">Acción</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="even pointer">
                            <td class=" " >Restablecer Datos de Contratos</td>
                            <td width="10px">
                            <button type="button" @click="restablecerPlanilla()" class="btn btn-round btn-primary"><i class="fas fa-cog"></i> Procesar</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >Generar Aguinaldo Masivo</td>
                            <td width="10px">
                            <button type="button" @click="abrirModalAguinaldoMasivo()" class="btn btn-round btn-primary"><i class="fas fa-cog"></i> Procesar</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>


      <!--Inicio del modal agregar/actualizar planilla-->
              <div class="modal fade" :class="{'mostrar':modal}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-sm" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="cerrarModalAguinaldoMasivo()"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Generar Aguinaldo</h3>
                    </div>
                    <div class="modal-body">

                          <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                              <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="text-input">Periodo</label>
                                    <input type="text" v-model="periodo" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="text-input">Monto Aguinaldo</label>
                                    <input type="text" v-model="m_aguinaldo" class="form-control">
                                </div>
                            </div>
                            
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" @click="cerrarModalAguinaldoMasivo()">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="ProcesarAguinaldoMasivo()">Procesar</button>
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
          
          <div id="capaFondo"><div class="lds-facebook"><div></div><div></div><div></div></div></div>
        </div>

</template>

<script>

    export default {
        data(){
            return {
                periodo:'',
                modal: 0,
                m_aguinaldo:''
            }

        },

        computed:{
           
        },

        methods: {

          restablecerPlanilla(){

            var me = this;

            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
              title: '¿Desea restablecer datos de los contratos?',
              text: "Este proceso limpiara los campos de inasistencias, tardanzas y permisos, dias laborados, dias de licencia de los contratos activos",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Si, Procesar',
              cancelButtonText: 'No, cancelar',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {

                axios.put('contratos/restablecer', {
                  }).then(function (response) {
                    swalWithBootstrapButtons.fire(
                      'Procesado',
                      'Registros Actualizados',
                      'success'
                    )
                  }).catch(function (error) {
                      console.log(error);
                      swalWithBootstrapButtons.fire(
                      'No procesado',
                      'Ocurrio un error',
                      'error'
                    )
                  })

                
              } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelado',
                  'Proceso cancelado :)',
                  'error'
                )
              }
            })

        },

        ProcesarAguinaldoMasivo(){

           let me = this;

            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
              },
              buttonsStyling: false,
              allowOutsideClick: false
            })

            swalWithBootstrapButtons.fire({
              title: '¿Desea Registrar el Pago de Aguinaldo de todo el Personal?',
              text: "Este proceso registra el aguinaldo en el periodo indicado a todo el personal con estado habilitado y licencia con Goce",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Si, Procesar',
              cancelButtonText: 'No, cancelar',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                me.cerrarModalAguinaldoMasivo();
                me.abrirLoading();
                axios.put('contratos/aguimasivo', {
                  'periodo' : me.periodo,
                  'pll_id_monto' : me.m_aguinaldo,
                  }).then(function (response) {
                    swalWithBootstrapButtons.fire(
                      'Procesado',
                      'Registros Actualizados',
                      'success'
                    )
                    me.cerrarLoading();
                  }).catch(function (error) {
                      console.log(error);
                      swalWithBootstrapButtons.fire(
                      'No procesado',
                      'Ocurrio un error',
                      'error'
                    )
                    me.cerrarLoading();
                  })

                
              } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelado',
                  'Proceso cancelado :)',
                  'error'
                )
              }
            })

        },

        cerrarModalAguinaldoMasivo(){
            this.modal = 0;
        },

        abrirModalAguinaldoMasivo(){
            this.modal=1;
                
            },

        abrirLoading(){
          document.getElementById("capaFondo").style.visibility="visible";
          // document.getElementById("capaVentana").style.visibility="visible";
          //document.formulario.bAceptar.focus();
          },
          
        cerrarLoading(){
          document.getElementById("capaFondo").style.visibility="hidden";
          // document.getElementById("capaVentana").style.visibility="hidden";
          //document.formulario.bAceptar.blur();
          }

        },

        
 
        mounted() {
            
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

  .lds-facebook {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
    left: 50%;
    top: 50%;
  }

  .lds-facebook div {
    display: inline-block;
    position: absolute;
    left: 8px;
    width: 16px;
    background: white;
    animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
  }

  .lds-facebook div:nth-child(1) {
    left: 8px;
    animation-delay: -0.24s;
  }

  .lds-facebook div:nth-child(2) {
    left: 32px;
    animation-delay: -0.12s;
  }

  .lds-facebook div:nth-child(3) {
    left: 56px;
    animation-delay: 0;
  }

  @keyframes lds-facebook {
    0% {
      top: 8px;
      height: 64px;
    }
    50%, 100% {
      top: 24px;
      height: 32px;
    }
  }

  #capaFondo{
    visibility:hidden;
    position:absolute;
    padding:0px;
    left:0px;
    top:0px;
    right:0px;
    bottom:0px;
    background-color: #706e6e7a;
    background-repeat:repeat;
    width:100%;
    height:100%;
    z-index:2;
  }

</style>