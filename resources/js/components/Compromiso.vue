<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Reportes y Archivos para el Compromiso de Planilla</h3>
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
                            <th class="column-title">Tipo de Reportes o Archivos</th>
                            <th class="column-title" colspan="2" align="center">Generar</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="even pointer">
                            <td class="texto-reportes">Planilla Total x Clasificador y Meta</td>
                            <td width="10px">
                            <button type="button" @click="planillatotal()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="Reportedetalleplanillaexcel()" class="btn btn-success"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class="texto-reportes">Planilla Descuentos x Clasificador y Meta</td>
                            <td width="10px">
                            <button type="button" @click="planilladescuentos()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="Reportedetalleplanillaexcel()" class="btn btn-success"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class="texto-reportes">Planilla Aportes x Clasificador y Meta</td>
                            <td width="10px">
                            <button type="button" @click="planillaaportes()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="Reportedetalleplanillaexcel()" class="btn btn-success"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class="texto-reportes">Planilla AFP x por AFP</td>
                            <td width="10px">
                            <button type="button" @click="planillaafp()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="Reportedetalleplanillaexcel()" class="btn btn-success"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class="texto-reportes">Planilla AFP x Clasificador y Meta</td>
                            <td width="10px">
                            <button type="button" @click="planillaafpresumen()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="Reportedetalleplanillaexcel()" class="btn btn-success"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
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


        planillatotal(){
        
          var dir = 'planilla/generarresumen?codplanilla='+this.cod_planilla;
          window.open(dir, '_blank');
        
        },

        planilladescuentos(){
        
          var dir = 'planilla/planilladescuentos?codplanilla='+this.cod_planilla;
          window.open(dir, '_blank');
        
        },

        planillaaportes(){
        
          var dir = 'planilla/planillaaportes?codplanilla='+this.cod_planilla;
          window.open(dir, '_blank');
        
        },

        planillaafp(){
        
          var dir = 'planilla/afp?codplanilla='+this.cod_planilla;
          window.open(dir, '_blank');
        
        },

        planillaafpresumen(){
        
          var dir = 'planilla/afpresumen?codplanilla='+this.cod_planilla;
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