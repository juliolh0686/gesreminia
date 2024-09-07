<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Carga Masiva del Reporte de Inasistencias y Tardanzas</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="table">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ppppppp</th>
                            <th class="column-title" colspan="2" align="center">Proceso</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="even pointer">
                            <td class=" " >Calculo de Aguinaldo Masivo</td>
                            <td width="10px">
                            <button type="button" @click="abrirModalplanilla()" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i> Calcular</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >Importación Inasistencias Tardanzas y Permisos</td>
                            <td width="10px">
                            <button type="button" @click="abrirModalplanilla()" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i>Importar</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>


      <!--Inicio del modal agregar/actualizar planilla-->
              <div class="modal fade" :class="{'mostrar':modal}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalaguinaldo()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel">Generar Aguinaldo</h3>
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                 <div class="form-group row">
                                    <div class="col-md-2">
                                        <label for="text-input">Periodo</label>
                                        <input type="text" v-model="pll_periodo" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Monto Aguinaldo</label>
                                        <input type="text" v-model="m_aguinaldo" class="form-control">
                                    </div>
                                </div>
                               
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalaguinaldo()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="registrarPlanilla()">Guardar</button>
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
                arrayPlanillascerradas: [],
                pll_periodo:'',
                modal: 0,
                tituloModalplanilla: '',
            }

        },

        computed:{
           
        },

        methods: {

        cerrarModalaguinaldo(){
            this.modal = 0;
        },

        selectPlanillascerradas() {
            var me = this;
            var url = 'planillascerradas';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayPlanillascerradas = respuesta.planilla;
            }).catch(function (error) {
                console.log(error);
            });
        },

        Generarboletas(){
        
        var dir = "planilla/generarboletas?periodo="+this.pll_periodo;
        window.open(dir, '_blank');
        
        },

        Generarresumen(){
        
        var dir = "planilla/generarresumen?periodo="+this.pll_periodo;
        window.open(dir, '_blank');
        
        },

        Generarinterface(tipointer){
        
        var dir = "planilla/generarinterface?periodo="+this.pll_periodo+"&tipointer="+tipointer;
        window.open(dir, '_blank');
        
        },

        GenerarinterfaceDP(){
        
        var dir = "planilla/generarinterface?periodo="+this.pll_periodo+"&tipointer=2";
        window.open(dir, '_blank');
        
        },

        GenerarinterfaceDL(){
        
        var dir = "planilla/generarinterface?periodo="+this.pll_periodo+"&tipointer=3";
        window.open(dir, '_blank');
        
        },

        GenerarinterfaceDB(){
        
        var dir = "planilla/generarinterface?periodo="+this.pll_periodo+"&tipointer=4";
        window.open(dir, '_blank');
        
        },

        Reportepersonal(){
        
        var dir = "personal/reportepersonal";
        window.open(dir, '_blank');
        
        },

        Reportedetalleplanilla(){
        
        var dir = "detalleplanilla/rp_DetallePlanilla?periodo="+this.pll_periodo;
        window.open(dir, '_blank');
        
        },

        Reportedetalleplanillaexcel(){
        
        var dir = "detalleplanilla/Rp_DetallePlanillaExcel?periodo="+this.pll_periodo;
        window.open(dir, '_blank');
        
        },


        Reportepersonalexcel(){
        
         var dir = "personal/reportepersonalexcel";
        window.open(dir, '_parent');
        
        },

        abrirModalplanilla(){
            this.modal=1;
                
            }
        },
 
        mounted() {
            this.selectPlanillascerradas();
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