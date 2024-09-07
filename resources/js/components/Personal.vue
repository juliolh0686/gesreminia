<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Gestión de Personal</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModal('personal','registrar')" class="btn btn-danger float-right">
                            <i class="fas fa-plus"></i>&nbsp;Nuevo
                </button>
               
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
                    <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="b_nombres" @keyup.enter="listarPersonal(1,b_numdoc,b_apaterno,b_amaterno,b_nombres)" class="form-control" placeholder="Nombres" @input="b_nombres = $event.target.value.toUpperCase()">
                    </div>
                    <button type="submit" @click="listarPersonal(1,b_numdoc,b_apaterno,b_amaterno,b_nombres)" class="btn btn-primary"><i class="fab fa-sistrix"></i>&nbsp;Buscar</button>
                    <button type="button" @click="limpiarbusqueda()" class="btn btn-info"><i class="fas fa-broom"></i>&nbsp;Limpiar</button>
                </div>
       
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Nº</th>
                            <th class="column-title">Doc. Identidad</th>
                            <th class="column-title">Apellido Paterno</th>
                            <th class="column-title">Apellido Materno</th>
                            <th class="column-title">Nombres</th>
                            <th class="column-title">RUC</th>
                            <th class="column-title">Celular</th>
                            <th class="column-title no-link last"  colspan="1" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(personal,index) in arrayPersonal" :key="personal.cod_personal" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="personal.p_num_doc"></td>
                            <td class=" " v-text="personal.p_a_paterno"></td>
                            <td class=" " v-text="personal.p_a_materno"></td>
                            <td class=" " v-text="personal.p_nombres"></td>
                            <td class=" " v-text="personal.p_ruc"></td>
                            <td class=" " v-text="personal.p_celular"></td>
                            <td width="10px">
                            <button type="button" @click="abrirModal('personal','actualizar',personal)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>&nbsp;Editar</button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                      <nav>
                          <ul class="pagination">
                              <li class="page-item" v-if="pagination.current_page>1">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1)">Anterior</a>
                              </li>
                               <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page">1</a>
                              </li>
                               <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1)">Siguiente</a>
                              </li>
                          </ul>
                      </nav>
                    </div>
				<!--Inicio del modal agregar/actualizar-->
              <div class="modal fade" :class="{'mostrar':modal}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModal()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModal"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">

                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <div class="col-md-12">
                                                    <label for="text-input">Apellido Paterno</label>
                                                    <input type="text" v-model="p_a_paterno" class="form-control" style="text-transform:uppercase;" @input="p_a_paterno = $event.target.value.toUpperCase()">
                                                    <span v-if="errors.p_a_paterno" class="error">{{errors.p_a_paterno[0]}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-12">
                                                <label for="text-input">Apellido Materno</label>
                                                    <input type="text" v-model="p_a_materno" class="form-control" style="text-transform:uppercase;" @input="p_a_materno = $event.target.value.toUpperCase()">
                                                    <span v-if="errors.p_a_materno" class="error">{{errors.p_a_materno[0]}}</span>
                                                </div>
                                            </td>
                                            <td rowspan="3">

                                            <div class="image-upload">
                                                    <label for="file-input" class="file-input">
                                                        <div class="img-container">
                                                        <img id="imagenfoto" class="foto" v-bind:src="fotopersonal" alt ="Click aquí para subir tu foto"> 
                                                         <p>Click para subir imagen</p>
                                                        </div>
                                                    </label>
                                                    <input name="foto" id="file-input" type="file" @change="imageChanged" accept="image/x-png,image/jpeg"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-4">
                                                <div>
                                                    <label for="text-input">Nombres</label>
                                                    <input type="text" v-model="p_nombres" class="form-control" style="text-transform:uppercase;" @input="p_nombres = $event.target.value.toUpperCase()">
                                                    <span v-if="errors.p_nombres" class="error">{{errors.p_nombres[0]}}</span>
                                                </div>
                                            </td>
                                            <td class="col-md-4">
                                               <label for="text-input">Fecha de Nacimiento</label>
                                                <input type="text" v-model="p_fech_nac" class="form-control">
                                                <span v-if="errors.p_fech_nac" class="error">{{errors.p_fech_nac[0]}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-4">
                                                <div>
                                                <label for="text-input">Tipo de Documento</label>
                                                    <select class="form-control" v-model="tipo_documento_cod_tipo_documento">
                                                        <option value="0" disabled>Seleccione</option>
                                                        <option v-for="tipodocumento in arrayTipodocumento" :key="tipodocumento.cod_tipo_documento" :value="tipodocumento.cod_tipo_documento" v-text="tipodocumento.td_documento"></option>
                                                    </select>
                                                    <span v-if="errors.tipo_documento_cod_tipo_documento" class="error">{{errors.tipo_documento_cod_tipo_documento[0]}}</span>
                                                </div>
                                            </td>
                                            <td class="col-md-4">
                                              <div>
                                                <label for="text-input">Numero de Documento</label>
                                                    <input type="text" v-model="p_num_doc" class="form-control">
                                                    <span v-if="errors.p_num_doc" class="error">{{errors.p_num_doc[0]}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                    
                                 <div class="form-group row">
                                    <div class="col-md-4">
                                    <label for="text-input">Sexo</label>
                                        <select class="form-control" v-model="sexo_cod_sexo" @change="selectSexofoto(sexo_cod_sexo)">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="sexo in arraySexo" :key="sexo.cod_sexo" :value="sexo.cod_sexo" v-text="sexo.s_sexo"></option>
                                        </select>
                                        <span v-if="errors.sexo_cod_sexo" class="error">{{errors.sexo_cod_sexo[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Estado Civil</label>
                                        <select class="form-control" v-model="estado_civil_cod_estado_civil" >
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="estadocivil in arrayEstadocivil" :key="estadocivil.cod_estado_civil" :value="estadocivil.cod_estado_civil" v-text="estadocivil.ec_estado_civil"></option>
                                        </select>
                                        <span v-if="errors.estado_civil_cod_estado_civil" class="error">{{errors.estado_civil_cod_estado_civil[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">RUC</label>
                                        <input type="text" v-model="p_ruc" class="form-control">
                                        <span v-if="errors.p_ruc" class="error">{{errors.p_ruc[0]}}</span>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="col-md-4">
                                    <label for="text-input">Departamento</label>
                                        <select class="form-control" v-model="iddepartamento"  @change="selectProvincia(iddepartamento)">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="departamento in arrayDepartamento" :key="departamento.cod_departamento" :value="departamento.cod_departamento" v-text="departamento.dep_departamento"></option>
                                        </select>
                                        <span v-if="errors.iddepartamento" class="error">{{errors.iddepartamento[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Provincia</label>
                                        <select class="form-control" v-model="idprovincia" @change="selectDistrito(idprovincia)">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="provincia in arrayProvincia" :key="provincia.cod_provincia" :value="provincia.cod_provincia" v-text="provincia.pro_provincia"></option>
                                        </select>
                                        <span v-if="errors.idprovincia" class="error">{{errors.idprovincia[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Distrito</label>
                                        <select class="form-control" v-model="distrito_cod_distrito">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="distrito in arrayDistrito" :key="distrito.cod_distrito" :value="distrito.cod_distrito" v-text="distrito.dis_distrito"></option>
                                        </select>
                                        <span v-if="errors.distrito_cod_distrito" class="error">{{errors.distrito_cod_distrito[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8">
                                    <label for="text-input">Dirección</label>
                                        <input type="text" v-model="p_direccion" class="form-control" style="text-transform:uppercase;" @input="p_direccion = $event.target.value.toUpperCase()">
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Correo Electronico</label>
                                        <input type="text" v-model="p_correo" class="form-control">
                                        <span v-if="errors.p_correo" class="error">{{errors.p_correo[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">
                                    <label for="text-input">Telefono</label>
                                        <input type="text" v-model="p_telefono" class="form-control">
                                        <span v-if="errors.p_telefono" class="error">{{errors.p_telefono[0]}}</span>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="text-input">Celular</label>
                                        <input type="text" v-model="p_celular" class="form-control">
                                        <span v-if="errors.p_celular" class="error">{{errors.p_celular[0]}}</span>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="text-input">Observación</label>
                                        <input type="text" v-model="p_observacion" class="form-control" style="text-transform:uppercase;" @input="p_observacion = $event.target.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                    <label for="text-input">Regimen de Pensión</label>
                                        <select class="form-control" v-model="idregimenpension" @change="selectAdminpension(idregimenpension)">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="regimenpension in arrayRegimenpension" :key="regimenpension.cod_regimen_pension" :value="regimenpension.cod_regimen_pension" v-text="regimenpension.rp_regimen_pension"></option>
                                        </select>
                                        <span v-if="errors.idregimenpension" class="error">{{errors.idregimenpension[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Administradora de Pensión</label>
                                        <select class="form-control" v-model="admin_pension_cod_admin_pension">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="adminpension in arrayAdminpension" :key="adminpension.cod_admin_pension" :value="adminpension.cod_admin_pension" v-text="adminpension.ap_admin_pension"></option>
                                        </select>
                                        <span v-if="errors.admin_pension_cod_admin_pension" class="error">{{errors.admin_pension_cod_admin_pension[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">CUSPP</label>
                                        <input type="text" v-model="p_cuspp" class="form-control">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="col-md-4">
                                    <label for="text-input">Fecha de Afiliación</label>
                                        <input type="text" v-model="p_fech_afiliacion" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Banco</label>
                                        <select class="form-control" v-model="banco_cod_banco">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="banco in arrayBanco" :key="banco.cod_banco" :value="banco.cod_banco" v-text="banco.b_banco"></option>
                                        </select>
                                        <span v-if="errors.banco_cod_banco" class="error">{{errors.banco_cod_banco[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="text-input">Numero de Cuenta</label>
                                        <input type="text" v-model="p_num_cuenta" class="form-control">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersonal()"><i class="far fa-save"></i>&nbsp;Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersonal()"><i class="fas fa-sync-alt"></i>&nbsp;Actualizar</button>
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
                
                tipo_documento_cod_tipo_documento :'',
                p_num_doc:'',
                p_a_paterno:'',
                p_a_materno:'',
                p_nombres:'',
                p_fech_nac:'',
                sexo_cod_sexo:'',
                p_ruc:'',
                distrito_cod_distrito:'',
                p_direccion:'',
                p_correo:'',
                p_telefono:'',
                p_celular:'',
                p_observacion:'',
                admin_pension_cod_admin_pension:'',
                p_cuspp:'',
                p_fech_afiliacion:'',
                banco_cod_banco:'',
                foto:'',
                p_num_cuenta:'',

                cod_personal: '',
                tipo_documento_cod_tipo_documento: 0,
                estado_civil_cod_estado_civil: 0,
                sexo_cod_sexo: 0,
                iddepartamento: 0,
                idprovincia: 0,
                distrito_cod_distrito: 0,
                idregimenpension: 0,
                admin_pension_cod_admin_pension: 0,
                banco_cod_banco: 0,
                arrayPersonal: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
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
                criterio: 'cod_personal',
                b_numdoc: '',
                b_apaterno:'',
                b_amaterno:'',
                b_nombres:'',
                arrayTipodocumento: [],
                arraySexo: [],
                arrayEstadocivil: [],
                arrayDepartamento: [],
                arrayProvincia: [],
                arrayDistrito: [],
                arrayRegimenpension: [],
                arrayAdminpension: [],
                arrayBanco: [],
                fotopersonal:'',
                variablefoto:0,
                errors:[]
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

            listarPersonal(page,b_numdoc,b_apaterno,b_amaterno,b_nombres){

                let me=this;
                var url= 'personal?page='+page+'&b_numdoc='+b_numdoc+'&b_apaterno='+b_apaterno+'&b_amaterno='+b_amaterno+'&b_nombres='+b_nombres;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPersonal=respuesta.personal.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            cambiarPagina(page){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarPersonal(page,this.b_numdoc,this.b_apaterno,this.b_amaterno,this.b_nombres);

            },

            limpiarbusqueda(){
                this.b_numdoc='';
                this.b_apaterno='';
                this.b_amaterno='';
                this.b_nombres='';
                this.listarPersonal(1,'','','','');
            },

            selectSexofoto(estado_civil_cod_estado_civil){
                this.fotopersonal='fotos/default-'+estado_civil_cod_estado_civil+'.jpg';
            },

            imageChanged(e){
                console.log(e.target.files[0])
                
                var fileReader = new FileReader()

                fileReader.readAsDataURL(e.target.files[0])

                fileReader.onload=(e)=>{
                    this.fotopersonal=e.target.result,
                    this.foto=e.target.files,
                    this.variablefoto=1
                }


            },

            selectTipodocumento() {
            var me = this;
            var url = 'tipodocumento/selectTipodocumento';
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arrayTipodocumento = respuesta.tipodocumento;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectSexo() {
                var me = this;
                var url = 'sexo/selectSexo';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arraySexo = respuesta.sexo;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            selectEstadocivil() {
                var me = this;
                var url = 'estadocivil/selectEstadocivil';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayEstadocivil = respuesta.estadocivil;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            selectDepartamento() {
            var me = this;
            var url = 'departamentos/selectDepartamento';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayDepartamento = respuesta.departamento;
            }).catch(function (error) {
                console.log(error);
            });
        },

        selectProvincia(iddepartamento) {
            var me = this;
            var url = 'provincia/selectProvincia?iddepartamento=' + iddepartamento;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arrayProvincia = respuesta.provincia;
            }).catch(function (error) {
                console.log(error);
            });
        },

        selectDistrito(idprovincia) {
            var me = this;
            var url = 'distrito/selectDistrito?idprovincia=' + idprovincia;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arrayDistrito = respuesta.distrito;
            }).catch(function (error) {
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

         selectAdminpension(idregimenpension) {
            var me = this;
            var url = 'adminpension/selectAdminpension?idregimenpension=' + idregimenpension;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arrayAdminpension = respuesta.adminpension;
            }).catch(function (error) {
                console.log(error);
            });
        },

        selectBanco() {
            var me = this;
            var url = 'banco/selectBanco';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayBanco = respuesta.banco;
            }).catch(function (error) {
                console.log(error);
            });
        },

    registrarPersonal() {

            this.errors=[];

            this.cod_personal = "10" + this.p_num_doc;

            var me = this;

            axios.post('personal/store', {
                'cod_personal': this.cod_personal,
                'tipo_documento_cod_tipo_documento': this.tipo_documento_cod_tipo_documento,
                'p_num_doc': this.p_num_doc,
                'p_a_paterno': this.p_a_paterno,
                'p_a_materno': this.p_a_materno,
                'p_nombres': this.p_nombres,
                'fotopersonal':this.fotopersonal,
                'p_fech_nac': this.p_fech_nac,
                'sexo_cod_sexo': this.sexo_cod_sexo,
                'estado_civil_cod_estado_civil': this.estado_civil_cod_estado_civil,
                'p_ruc': this.p_ruc,
                'distrito_cod_distrito': this.distrito_cod_distrito,
                'p_direccion': this.p_direccion,
                'p_correo': this.p_correo,
                'p_telefono': this.p_telefono,
                'p_celular': this.p_celular,
                'p_observacion': this.p_observacion,
                'admin_pension_cod_admin_pension': this.admin_pension_cod_admin_pension,
                'p_cuspp': this.p_cuspp,
                'p_fech_afiliacion': this.p_fech_afiliacion,
                'banco_cod_banco': this.banco_cod_banco,
                'p_num_cuenta': this.p_num_cuenta,
                 'variablefoto':this.variablefoto
            }).then(function (response) {
                me.cerrarModal();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarPersonal(1,'','','','');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                    me.errors=error.response.data.errors;
                }
            });
        },

        actualizarPersonal() {

            this.errors=[];

            var me = this;

            axios.put('personal/update', {
                'cod_personal': this.cod_personal,
                'tipo_documento_cod_tipo_documento': this.tipo_documento_cod_tipo_documento,
                'p_num_doc': this.p_num_doc,
                'p_a_paterno': this.p_a_paterno,
                'p_a_materno': this.p_a_materno,
                'p_nombres': this.p_nombres,
                'fotopersonal':this.fotopersonal,
                'p_fech_nac': this.p_fech_nac,
                'sexo_cod_sexo': this.sexo_cod_sexo,
                'estado_civil_cod_estado_civil': this.estado_civil_cod_estado_civil,
                'p_ruc': this.p_ruc,
                'distrito_cod_distrito': this.distrito_cod_distrito,
                'p_direccion': this.p_direccion,
                'p_correo': this.p_correo,
                'p_telefono': this.p_telefono,
                'p_celular': this.p_celular,
                'p_observacion': this.p_observacion,
                'admin_pension_cod_admin_pension': this.admin_pension_cod_admin_pension,
                'p_cuspp': this.p_cuspp,
                'p_fech_afiliacion': this.p_fech_afiliacion,
                'banco_cod_banco': this.banco_cod_banco,
                'p_num_cuenta': this.p_num_cuenta,
                'variablefoto':this.variablefoto
            }).then(function (response) {
                me.cerrarModal();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarPersonal(1,'','','','');
                me.variablefoto=0;
            }).catch(function (error) {
                console.log(error);
                 if(error.response.status==422){
                    me.errors=error.response.data.errors;
                }
            });
        },

        cerrarModal(){
            this.modal = 0;
            this.tituloModal = '';
            this.cod_personal = '',
            this.errorPersonal = 0;
            this.errorMostrarMsjPersonal = [];
            this.errors=[];
            this.variablefoto=0;
        },

        abrirModal(modelo,accion,data=[]){
            switch(modelo){
                case "personal":
                {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal=1;
                            this.tituloModal='Nuevo Personal';
                            this.tipoAccion=1;
                            this.tipo_documento_cod_tipo_documento = 0;
                            this.cod_personal = '';
                            this.p_num_doc = '';
                            this.p_a_paterno = '';
                            this.p_a_materno = '';
                            this.p_nombres = '';
                            this.p_fech_nac = '';
                            this.sexo_cod_sexo = 0;
                            this.fotopersonal='fotos/default.jpg';
                            this.estado_civil_cod_estado_civil = 0;
                            this.p_ruc = '';
                            this.iddepartamento = 0;
                            this.idprovincia = 0;
                            this.distrito_cod_distrito = 0;
                            this.p_direccion = '';
                            this.p_correo = '';
                            this.p_telefono = '';
                            this.p_celular = '';
                            this.p_observacion = ''
                            this.idregimenpension = 0;
                            this.admin_pension_cod_admin_pension = 0;
                            this.p_cuspp = '';
                            this.p_fech_afiliacion = '';
                            this.banco_cod_banco = 0;
                            this.p_num_cuenta = '';
                            break;
                        }
                        case 'actualizar':
                        {
                            //console.log(data);
                            this.modal = 1;
                            this.tituloModal = "Editar Personal";
                            this.tipoAccion = 2;
                            this.tipo_documento_cod_tipo_documento = data['tipo_documento_cod_tipo_documento'];
                            this.cod_personal = data['cod_personal'];
                            this.p_num_doc = data['p_num_doc'];
                            this.p_a_paterno = data['p_a_paterno'];
                            this.p_a_materno = data['p_a_materno'];
                            this.p_nombres = data['p_nombres'];
                            this.fotopersonal = 'fotos/'+data['foto'];
                            this.p_fech_nac = moment(data['p_fech_nac']).format("DD/MM/YYYY"); 
                            this.sexo_cod_sexo = data['sexo_cod_sexo'];
                            this.estado_civil_cod_estado_civil = data['estado_civil_cod_estado_civil'];
                            this.p_ruc = data['p_ruc'];
                            this.iddepartamento = data['cod_departamento'];
                            this.selectProvincia(this.iddepartamento);
                            this.idprovincia = data['cod_provincia'];
                            this.selectDistrito(this.idprovincia);
                            this.distrito_cod_distrito = data['cod_distrito'];
                            this.p_direccion = data['p_direccion'];
                            this.p_correo = data['p_correo'];
                            this.p_telefono = data['p_telefono'];
                            this.p_celular = data['p_celular'];
                            this.p_observacion = data['p_observacion'];
                            this.idregimenpension = data['cod_regimen_pension'];
                            this.selectAdminpension(this.idregimenpension);
                            this.admin_pension_cod_admin_pension = data['cod_admin_pension'];
                            this.p_cuspp = data['p_cuspp'];
                            if (data['p_fech_afiliacion']!==null){
                            this.p_fech_afiliacion = moment(data['p_fech_afiliacion']).format("DD/MM/YYYY");
                            }
                            this.banco_cod_banco = data['banco_cod_banco'];
                            this.p_num_cuenta = data['p_num_cuenta'];
                            break;
                        }
                    }
                }
            }
        }

        },
        mounted() {
            this.listarPersonal(1,'','','','');
            this.selectTipodocumento();
            this.selectSexo();
            this.selectEstadocivil();
            this.selectDepartamento();
            this.selectRegimenpension();
            this.selectBanco();
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

        .error{
          color: red !important;
          margin-left: 5px;
        }

        .image-upload > input
        {
            display: none;
        }

        .image-upload img
        {
            cursor: pointer;
        }

        
        .foto{
            width:140px;
            height:160px;
            display: block;
            margin: auto;
            border: 1px solid;
            border-color:#2A3F54;
            border-top-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .file-input{
            display: block;
            margin: auto;
        }

        .img-container {
            width: 140px;
            height: 160px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            display: block;
            margin: auto;
            }

        .img-container:before {
            content: '';
            width: inherit;
            height: inherit;
            position: absolute;
            background: #000;
            opacity: 0;
            transition: opacity .3s linear;   
        }

        .img-container:hover:before { 
        opacity: .20;
        }

        .img-container p {
            width: inherit;  
            color: #fff;
            text-align: center;
            position: absolute;
            top: 100%; 
            transition: top .3s linear;
        }
        
        .img-container:hover p {    
            top: 70%;
        }

</style>
