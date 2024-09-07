<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Administrador de Pensiones</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalAdminpen('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="cod_admin_pension">Codigo</option>
                            <option value="ap_admin_pension">Administrador de Pensión</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarAdminpen(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarAdminpen(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
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
                        
                          <tr v-for="(adminpension,index) in arrayAdminpensiones" :key="adminpension.cod_admin_pension" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="adminpension.ap_admin_pension"></td>
                            <td class=" " v-text="adminpension.ap_comision"></td>
                            <td class=" " v-text="adminpension.ap_prima"></td>
                            <td class=" " v-text="adminpension.ap_aporte"></td>
                            <td class=" " v-text="adminpension.ap_aporte_fijo"></td>
                            <td class=" " v-text="adminpension.ap_total_admpen"></td>
                            <td>
                            <button type="button" @click="abrirModalAdminpen('actualizar',adminpension)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarAdminpen(adminpension.cod_admin_pension)" title='Eliminar' class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i></button>
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
              <div class="modal fade" :class="{'mostrar':modalAdminpen}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalAdminpen()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModaladminpen"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                              <div class="form-group row">
                               <div class="col-md-2">
                                    <label for="text-input">Codigo</label>
                                    <input type="text" v-model="adminpension.cod_admin_pension" id="cod_admin_pension" class="form-control">
                                </div>
                              </div>

                                <div class="form-group row">
                                <div class="col-md-6">

                                <label for="text-input">Regimen de Pensión</label>
                                    <select class="form-control" v-model="adminpension.regimen_pension_cod_regimen_pension"  @change="selectRegimenpension(adminpension.regimen_pension_cod_regimen_pension)" id="regimen_pension_cod_regimen_pension">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="regimenpension in arrayRegimenpension" :key="regimenpension.cod_regimen_pension " :value="regimenpension.cod_regimen_pension " v-text="regimenpension.rp_regimen_pension"></option>
                                    </select>
                                    <span v-if="errors.cod_regimen_pension" class="error">{{errors.cod_regimen_pension[0]}}</span>
                                </div>

                                <div class="col-md-6">
                                        <label for="text-input">Administrador de Pensiones</label>
                                        <input type="text" v-model="adminpension.ap_admin_pension" id="ap_admin_pension" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="text-input">%Comisión</label>
                                        <input type="text" v-model="adminpension.ap_comision" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">%Prima</label>
                                        <input type="text" v-model="adminpension.ap_prima" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">%Aporte</label>
                                        <input type="text" v-model="adminpension.ap_aporte" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">%Ap. Fijo</label>
                                        <input type="text" v-model="adminpension.ap_aporte_fijo" class="form-control">
                                    </div>
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalAdminpen()">Cerrar</button>
                            <button type="button" v-if="tipoAccionadminpension==1" class="btn btn-primary" @click="registrarAdminpen()">Guardar</button>
                            <button type="button" v-if="tipoAccionadminpension==2" class="btn btn-primary" @click="actualizarAdminpen()">Actualizar</button>
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
                criterio:'cod_admin_pension',
                arrayPeriodos: [],
                arrayRegimenpension: [],
                arrayAdminpensiones:[],
                arrayDetalleplanilla:[],
                modalAdminpen: 0,
                tituloModaladminpen: '',
                tipoAccionadminpension: 0,
                errorPersonal: 0,
                errorMostrarMsjPersonal: [],
                adminpension:{
                    cod_admin_pension:'',
                    ap_admin_pension:'',
                    regimen_pension_cod_regimen_pension:'',
                    ap_comision:'',
                    ap_prima:'',
                    ap_aporte:'',
                    ap_aporte_fijo:'',
                    ap_total_admpen:'',
                    det_resumen:'',
                },
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
                errors:[],
               
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
            
        listarAdminpen(page,buscar,criterio){
                let me=this;
                var url= 'adminpension/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayAdminpensiones=respuesta.adminpension.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            selectRegimenpension() {
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

        cambiarPagina(page,buscar,criterio){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarAdminpen(page,buscar,criterio);

            },


        abrirModalAdminpen(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalAdminpen=1;
                    this.tituloModaladminpen='Nuevo Administrador de Pensiones';
                    this.adminpension.cod_admin_pension='';
                    this.adminpension.ap_admin_pension='';
                    this.adminpension.regimen_pension_cod_regimen_pension='';
                    this.adminpension.ap_comision='';
                    this.adminpension.ap_prima='';
                    this.adminpension.ap_aporte='';
                    this.adminpension.ap_aporte_fijo='';
                    this.adminpension.ap_total_admpen='';
                    this.tipoAccionadminpension=1;
                    document.getElementById("cod_admin_pension").disabled = false;
                    document.getElementById("regimen_pension_cod_regimen_pension").disabled = false;
                    document.getElementById("ap_admin_pension").disabled = false;
                    break;
                }
                case 'actualizar':
                {
                    this.modalAdminpen = 1;
                    this.tituloModaladminpen= "Editar Administrador de Pensiones";
                    this.adminpension.cod_admin_pension = data['cod_admin_pension'];
                    this.adminpension.ap_admin_pension = data['ap_admin_pension'];
                    this.adminpension.regimen_pension_cod_regimen_pension = data['regimen_pension_cod_regimen_pension'];
                    this.adminpension.ap_comision = data['ap_comision'];
                    this.adminpension.ap_prima = data['ap_prima'];
                    this.adminpension.ap_aporte = data['ap_aporte'];
                    this.adminpension.ap_aporte_fijo = data['ap_aporte_fijo'];
                    this.adminpension.ap_total_admpen = data['ap_total_admpen'];
                    document.getElementById("cod_admin_pension").disabled = true;
                    document.getElementById("regimen_pension_cod_regimen_pension").disabled = true;
                    document.getElementById("ap_admin_pension").disabled = true;
                    this.tipoAccionadminpension = 2;
                    break;
                }
            }
        
        },

        cerrarModalAdminpen(){
            this.modalAdminpen = 0;
            this.tituloModaladminpen = '';
        },

        registrarAdminpen() {

            this.errors=[];

            var me = this;

            axios.post('adminpension/store', {
                'cod_admin_pension' : me.adminpension.cod_admin_pension,
                'ap_admin_pension' : me.adminpension.ap_admin_pension,
                'regimen_pension_cod_regimen_pension':me.adminpension.regimen_pension_cod_regimen_pension,
                'ap_comision' : me.adminpension.ap_comision,
                'ap_prima' : me.adminpension.ap_prima,
                'ap_aporte' : me.adminpension.ap_aporte,
                'ap_aporte_fijo':me.adminpension.ap_aporte_fijo,
                'ap_total_admpen':me.adminpension.ap_total_admpen,
            }).then(function (response) {
                me.cerrarModalAdminpen();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarAdminpen(1, '', 'cod_admin_pension');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarAdminpen() {

            this.errors=[];
        
            var me = this;

            axios.put('adminpension/update', {
                'cod_admin_pension' : me.adminpension.cod_admin_pension,
                'ap_admin_pension' : me.adminpension.ap_admin_pension,
                'regimen_pension_cod_regimen_pension':me.adminpension.regimen_pension_cod_regimen_pension,
                'ap_comision' : me.adminpension.ap_comision,
                'ap_prima' : me.adminpension.ap_prima,
                'ap_aporte' : me.adminpension.ap_aporte,
                'ap_aporte_fijo':me.adminpension.ap_aporte_fijo,
                'ap_total_admpen':me.adminpension.ap_total_admpen,
            }).then(function (response) {
                me.cerrarModalAdminpen();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarAdminpen(1, '', 'cod_admin_pension');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarAdminpen(id){
            
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
                    axios.put('adminpension/destroy', {
                        'cod_admin_pension' : id,
                    }).then(function (response) {
                        me.listarAdminpen(1, '', 'cod_admin_pension');
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
            this.listarAdminpen(1,this.buscar,this.criterio);
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
