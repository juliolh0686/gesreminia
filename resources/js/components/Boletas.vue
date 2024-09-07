<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Boletas de Pago</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">



                    <div class="col-sm-12 mail_view">
                        <div class="inbox-body">
                          
                         <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Masivo</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Individual</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            

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

                             <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action table-bordered">
                                <thead>
                                <tr class="headings">
                                    <th class="column-title">Tipo de Archivo</th>
                                    <th class="column-title">Generar</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr class="even pointer">
                                    <td class=" " >Boletas de Pagos</td>
                                    <td width="10px">
                                    <button type="button" @click="Generarboletas()" class="btn btn-round btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>



                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab2">
                           


                           <div class="row no-gutters">
                            <div class="div-imagen">
                                <img v-bind:src="fotopersonal" class="card-img" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">

                                     <h5 class="card-title">Datos Personales</h5>
                                        <div class="card-text">
                                           <h4 v-text="ape_nombres"></h4>
                                            <div class="row">
                                                <div class="col-md-4">Documento</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-7"><a v-text="p_num_doc"></a></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Email</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-7"><a v-text="p_correo"></a></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Pensión</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-7"><a v-text="ap_admin_pension"></a></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Cuenta</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-7"><a v-text="p_num_cuenta"></a></div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4"> <button type="button" class="btn btn-primary" @click="abrirModalbuscar()"><i class="fab fa-sistrix"></i>&nbsp;Buscar</button></div>
                                            </div>
                                        </div>
                                     
                
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                                    <div class="col-md-2">
                                        <label for="text-input">Periodo Inicial</label>
                                        <input type="text" v-model="p_inicial" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Periodo Final</label>
                                        <input type="text" v-model="p_final" class="form-control">
                                    </div>
                                    <div class="col-md-1">
                                        <label for="text-input">-</label>
                                        <button type="button" @click="Generarboletasperiodo()" class="form-control btn btn-round btn-danger"><i class="fa fa-file-pdf-o"></i>&nbsp;Generar</button>
                                    </div>
                                </div>

                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>



                        <!--Inicio del modal Buscar-->
              <div class="modal fade" :class="{'mostrar':modalbuscar}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" style="width: 65% !important;" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalbuscar()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel">Buscar de Personal</h3> 
                        </div>
                        <div class="modal-body">
                            
                        <div class="row">
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <input type="text" v-model="b_numdoc" @keyup.enter="listarPersonal(1,b_numdoc,b_apaterno,b_amaterno,b_nombres)" class="form-control" placeholder="Num. Documento">
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <input type="text" v-model="b_apaterno" @keyup.enter="listarPersonal(1,b_numdoc,b_apaterno,b_amaterno,b_nombres)" class="form-control" placeholder="Apellido Paterno" @input="b_apaterno = $event.target.value.toUpperCase()">
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <input type="text" v-model="b_amaterno" @keyup.enter="listarPersonal(1,b_numdoc,b_apaterno,b_amaterno,b_nombres)" class="form-control" placeholder="Apellido Materno" @input="b_amaterno = $event.target.value.toUpperCase()">
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <input type="text" v-model="b_nombres" @keyup.enter="listarPersonal(1,b_numdoc,b_apaterno,b_amaterno,b_nombres)" class="form-control" placeholder="Nombres" @input="b_nombres = $event.target.value.toUpperCase()">
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <button type="submit" @click="listarPersonal(1,b_numdoc,b_apaterno,b_amaterno,b_nombres)" class="btn btn-primary"><i class="fab fa-sistrix"></i>&nbsp;Buscar</button>
                                <button type="button" @click="limpiarbusqueda()" class="btn btn-info"><i class="fas fa-broom"></i>&nbsp;Limpiar</button>
                            </div>
                        </div>

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Nº</th>
                            <th class="column-title">Codigo de Personal</th>
                            <th class="column-title">Apellido Paterno</th>
                            <th class="column-title">Apellido Materno</th>
                            <th class="column-title">Nombres</th>
                            <th class="column-title">Doc. Identidad</th>
                            <th class="column-title no-link last" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(personal,index) in arrayPersonal" :key="personal.cod_personal" class="even pointer">
                            <td class=" " v-text="index+1"></td>
                            <td class=" " v-text="personal.cod_personal"></td>
                            <td class=" " v-text="personal.p_a_paterno"></td>
                            <td class=" " v-text="personal.p_a_materno"></td>
                            <td class=" " v-text="personal.p_nombres"></td>
                            <td class=" " v-text="personal.p_num_doc"></td>
                            <td width="10px">
                            <button type="button" @click="seleccionarPersonal(personal)" class="btn btn-primary btn-sm"><i class="far fa-check-circle"></i>&nbsp;Seleccionar</button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalbuscar()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
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
                arrayPersonal: [],
                arrayPlanilla: [],
                arrayTipoPlanilla: [],
                arrayClasePlanilla: [],
                pll_periodo:'',
                tipo_planilla_cod_tipo_planilla:0,
                clase_planilla_cod_clase_planilla:0,
                cod_planilla:0,
                p_inicial:'',
                p_final:'',
                p_num_doc:'',
                fotopersonal:'fotos/default.jpg',
                ape_nombres:'',
                p_correo:'',
                ap_admin_pension:'',
                p_num_cuenta:'',
                modalbuscar:0,
                b_numdoc:'',
                b_apaterno:'',
                b_amaterno:'',
                b_nombres:''
            }

        },

        computed:{
           
        },

        methods: {

        cerrarModalbuscar(){
            this.modalbuscar=0;
            this.arrayPersonal=[];
            this.buscardni='';
        },

        abrirModalbuscar(){
            this.modalbuscar=1;
            this.limpiarbusqueda();
        },

        limpiarbusqueda(){
                this.b_numdoc='';
                this.b_apaterno='';
                this.b_amaterno='';
                this.b_nombres='';
                this.listarPersonal(1,'','','','');
            },

        listarPersonal(page,b_numdoc,b_apaterno,b_amaterno,b_nombres){

                let me=this;
                var url= 'personal?page='+page+'&b_numdoc='+b_numdoc+'&b_apaterno='+b_apaterno+'&b_amaterno='+b_amaterno+'&b_nombres='+b_nombres;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPersonal=respuesta.personal.data;
                    if (me.arrayPersonal.length === 0) {
                            swal(
                                'No se encuentra personal',
                                '',
                                'info'
                                )
                        }                       
                })
                .catch(function (error) {
                    console.log(error);
                });

        },

        seleccionarPersonal(data=[]){
                this.modalbuscar = 0;
                //this.tipo_documento_cod_tipo_documento = data['tipo_documento_cod_tipo_documento'];
                this.cod_personal = data['cod_personal'];
                this.p_num_doc = data['p_num_doc'];
                this.p_a_paterno = data['p_a_paterno'];
                this.p_a_materno = data['p_a_materno'];
                this.p_nombres = data['p_nombres'];
                this.ape_nombres= data['p_a_paterno']+" "+data['p_a_materno']+" "+data['p_nombres'];
                this.fotopersonal = 'fotos/'+data['foto'];
                this.p_correo = data['p_correo'];
                this.p_num_cuenta = data['p_num_cuenta'];
                this.admin_pension_cod_admin_pension = data['cod_admin_pension'];
                this.ap_admin_pension = data['ap_admin_pension'];
                this.arrayPersonal=[];
                this.buscardni='';
            },

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

        Generarboletas(){
        
        var dir = "planilla/generarboletas?cod_planilla="+this.cod_planilla;
        window.open(dir, '_blank');
        
        },

        Generarboletasperiodo(){
        
        var dir = "planilla/generarboletasperiodo?p_num_doc="+this.p_num_doc+"&p_inicial="+this.p_inicial+"&p_final="+this.p_final;
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