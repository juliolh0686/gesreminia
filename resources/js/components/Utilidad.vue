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
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="text-input">Seleccionar Periodo</label>
                        <select class="form-control" v-model="pll_periodo">
                            <option value="0" disabled>Seleccione</option>
                            <option v-for="planilla in arrayPlanilla" :key="planilla.pll_periodo" :value="planilla.pll_periodo" v-text="planilla.pll_periodo"></option>
                        </select>
                    </div>
                    <div class="col-md-9 col-sm-12 col-xs-12 form-group">
                        <label for="text-input">Detalle</label>
                        <input type="text" v-model="pll_detalle" class="form-control">
                    </div>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Tipo de Utilidad</th>
                            <th class="column-title">Acciones</th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr class="even pointer">
                            <td class=" " >Boletas de Pago de Remuneración</td>
                            <td width="10px">
                            <button type="button" @click="Generarboletas()" class="btn btn-primary btn-sm">Generar</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >Resumen de Planilla</td>
                            <td width="10px">
                            <button type="button" @click="Generarresumen()" class="btn btn-primary btn-sm">Generar</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >Archivos de Interface para el SIAF-SP</td>
                            <td width="10px">
                            <button type="button" @click="Generarinterface()" class="btn btn-primary btn-sm">Generar</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >Archivos para Declaración del PDT</td>
                            <td width="10px">
                            <button type="button" @click="Generarboletas()" class="btn btn-primary btn-sm">Generar</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >Archivos de Carga para el AFPNet</td>
                            <td width="10px">
                            <button type="button" @click="Generarboletas()" class="btn btn-primary btn-sm">Generar</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >...</td>
                            <td width="10px">
                            <button type="button" @click="Generarboletas()" class="btn btn-primary btn-sm">Generar</button>
                            </td>
                          </tr>
                          <tr class="even pointer">
                            <td class=" " >...</td>
                            <td width="10px">
                            <button type="button" @click="Generarboletas()" class="btn btn-primary btn-sm">Generar</button>
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
                pll_periodo:'',
            }

        },

        computed:{
           
        },

        methods: {

        selectPlanilla() {
            var me = this;
            var url = 'planillascerradas';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayPlanilla = respuesta.planilla;
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

        Generarinterface(){
        
        var dir = "planilla/generarinterface?periodo="+this.pll_periodo;
        window.open(dir, '_blank');
        
        },
            

        },
        mounted() {
            this.selectPlanilla();
        }
    }
</script>