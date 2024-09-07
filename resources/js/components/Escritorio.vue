<template>

<div class="right_col" role="main">
          <div class="">
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-users"></i></div>
                  <div class="count" v-text="numpersonal"></div>
                  <h3>Personal</h3>
                  <p>Personal Registrado a la Fecha</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-table"></i></div>
                  <div class="count" v-text="numplanillas"></div>
                  <h3>Planillas</h3>
                  <p>Planillas Registrados a la Fecha</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-file-text"></i></div>
                  <div class="count" v-text="numcontratos"></div>
                  <h3>Contratos</h3>
                  <p>Contratos Registrados a la Fecha</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-male"></i></div>
                  <div class="count" v-text="numbeneficiarios"></div>
                  <h3>Beneficiarios</h3>
                  <p>Beneficiarios registrados a la Fecha</p>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">

                  <div class="x_title">
                    <h2>Historial de Planilla<small>Continua</small></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="chart-container">
                        <canvas id="ingresos"></canvas>
                      </div>
                    
                      <div class="tiles">
                        <div class="col-md-3 tile">
                          <span v-text="'Meses - ' + anio"></span>
                          <h2 v-text="countmeses"></h2>
                          <span class="sparkline11 graph" style="height: 160px;">
                               <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                        <div class="col-md-3 tile">
                          <span v-text="'Total Bruto - ' + anio"></span>
                          <h2 v-text="totales.tbruto"></h2>
                          <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                        <div class="col-md-3 tile">
                          <span v-text="'Total Descuentos - ' + anio"></span>
                          <h2 v-text="totales.tdesc"></h2>
                          <span class="sparkline11 graph" style="height: 160px;">
                                 <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                        <div class="col-md-3 tile">
                          <span v-text="'Total Liquido - ' + anio"></span>
                          <h2 v-text="totales.tliq"></h2>
                          <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

</template>

<script>
  
  export default{
    data(){
      return{
        VarIngreso:null,
        chartIngreso:null,
        ingresos:[],
        varTotalIngreso:[],
        varDescuento:[],
        varLiquido:[],
        varMesIngreso:[],
        countmeses:0,
        totales:[],
        anio:'',
        numpersonal:0,
        numplanillas:0,
        numcontratos:0,
        numbeneficiarios:0
      }
    },

    methods:{
      getIngresos(){
        let me=this;
        var url='/dashboard';
        axios.get(url).then(function(response){
          var respuesta=response.data;
          me.ingresos= respuesta.ingresos;
          me.totales=respuesta.totales;
          me.anio=respuesta.anio;
          me.numpersonal=respuesta.tpersonal.numpersonal;
          me.numplanillas=respuesta.tplanillas.numplanillas;
          me.numcontratos=respuesta.tcontratos.numcontratos;
          me.numbeneficiarios=respuesta.tbeneficiarios.numbeneficiarios;
          //cargamos los datos del chart
          me.countmeses=me.ingresos.length;
          me.loadIngresos();

        })
        .catch(function(error){
          console.log(error);
        })
      },

      loadIngresos(){
        let me=this;
        me.ingresos.map(function(x){
          me.varMesIngreso.push(x.mes);
          me.varTotalIngreso.push(x.bruto);
          me.varDescuento.push(x.desc);
          me.varLiquido.push(x.liq);
        });

        me.varIngreso = document.getElementById('ingresos').getContext('2d');

        me.chartIngreso = new Chart(me.varIngreso, {
            type: 'bar',
            data: {
                labels: me.varMesIngreso,
                datasets: [{
                    label: 'Ingreso',
                    data: me.varTotalIngreso,
                    backgroundColor:'rgba(54, 162, 235, 0.2)',
                    borderColor:'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },{
                    label: 'Descuentos',
                    data: me.varDescuento,
                    backgroundColor:'rgba(255, 99, 132, 0.2)',
                    borderColor:'rgba(255,99,132,1)',
                    borderWidth: 1
                },{
                    label: 'Liquido',
                    data: me.varLiquido,
                    backgroundColor:'rgba(255, 206, 86, 0.2)',
                    borderColor:'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
               maintainAspectRatio: false,
              scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
            }
        });


      }
    },

    mounted(){
        this.getIngresos();

    }




  }

</script>

<style>
.chart-container{
  height: 400px;
}
</style>


