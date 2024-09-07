<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Archivos de importación para el SIAF-MCPP</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
               
                <div class="row">
                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                    <label for="text-input">Tipo de Planilla</label>
                        <select class="form-control" v-model="tipo_planilla_cod_tipo_planilla">
                            <option value="0" disabled>Seleccione</option>
                            <option v-for="tipoplanilla in arrayTipoPlanilla" :key="tipoplanilla.cod_tipo_planilla" :value="tipoplanilla.cod_tipo_planilla" v-text="tipoplanilla.tpll_tipo_planilla"></option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label for="text-input">Clase de Planilla</label>
                            <select class="form-control" v-model="clase_planilla_cod_clase_planilla" @change="selectPlanilla(tipo_planilla_cod_tipo_planilla,clase_planilla_cod_clase_planilla)">
                                <option value="0" disabled>Seleccione</option>
                                <option v-for="claseplanilla in arrayClasePlanilla" :key="claseplanilla.cod_clase_planilla" :value="claseplanilla.cod_clase_planilla" v-text="claseplanilla.cpll_clase_planilla"></option>
                            </select>
                    </div>
                    <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                        <label for="text-input">Seleccionar Periodo</label>
                        <select class="form-control" v-model="cod_planilla">
                            <option value="0" disabled>Seleccione</option>
                            <option v-for="planilla in arrayPlanilla" :key="planilla.cod_planilla" :value="planilla.cod_planilla" v-text="planilla.pll_periodo+' - '+planilla.pll_detalle"></option>
                        </select>
                    </div>
                </div>
       

                    <div class="table">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Archivos - Planilla Mensual</th>
                            <th class="column-title" colspan="2" align="center">Generar</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="even pointer">
                            <td class="texto-reportes">Planilla</td>
                            <td width="10px">
                            <button type="button" @click="Generarinterface(4)" class="btn btn-round btn-info"><i class="fa fa-file-pdf-o"></i> TXT</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class="texto-reportes">Planilla - Archivo MCPP Web</td>
                            <td width="10px">
                            <button type="button" @click="Generarinterfacemcppweb()" class="btn btn-round btn-info"><i class="fa fa-file-pdf-o"></i> Archivo TXT</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="table">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Archivos - Personal Registrado en el Mes</th>
                            <th class="column-title" colspan="2" align="center">Generar</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="even pointer">
                            <td class="texto-reportes">Datos Personales</td>
                            <td width="10px">
                            <button type="button" @click="Generarinterface(1)" class="btn btn-round btn-info"><i class="fa fa-file-pdf-o"></i>  TXT</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class="texto-reportes">Datos Laborales</td>
                            <td width="10px">
                            <button type="button" @click="Generarinterface(2)" class="btn btn-round btn-info"><i class="fa fa-file-pdf-o"></i> TXT</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class="texto-reportes">Datos Bancarios</td>
                            <td width="10px">
                            <button type="button" @click="Generarinterface(3)" class="btn btn-round btn-info"><i class="fa fa-file-pdf-o"></i> TXT</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

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
                pll_periodo:'',
                tipo_planilla_cod_tipo_planilla:0,
                clase_planilla_cod_clase_planilla:0,
                cod_planilla:0
            }

        },

        computed:{
           
        },

        methods: {

        selectPlanilla(tipoplanilla, claseplanilla) {
            var me = this;
            var url = 'planillascerradas?claseplanilla=' + claseplanilla+'&tipoplanilla=' + tipoplanilla;
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayPlanilla = respuesta.planilla;
            }).catch(function (error) {
                console.log(error);
            });
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

        Generarinterface(tipointer){

        var dir = 'planilla/generarinterface?codplanilla='+this.cod_planilla+'&tipointer='+tipointer;
        window.open(dir, '_blank');
        
        },

        Generarinterfacemcppweb(){

          var dir = 'planilla/generarinterfacemcppweb?codplanilla='+this.cod_planilla;
          window.open(dir, '_blank');

        },

        },
        mounted() {
            this.selectTipoPlanilla();
            this.selectClasePlanilla();
        }
    }
</script>

<style>

.texto-reportes{
  font-size: 14px;
}

th {
    text-align: center;
}

</style>