<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Gestión de Contratos</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="row">
                      <div class="col-sm-5 mail_list_column">

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
         

                     <div class="table-responsive col-md-12 col-sm-12 col-xs-12">
                        <button type="button" @click="abrirModalContrato()" class="btn btn-danger float-right">
                            <i class="fas fa-plus"></i>&nbsp;Nuevo
                        </button>
                      <table class="table table-striped jambo_table bulk_action table-bordered con-radios">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Numero de Contrato</th>
                            <th class="column-title">Inicio</th>
                            <th class="column-title">Termino</th>
                            <th class="column-title">Seleccionar</th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="contratos in arrayContratos" :key="contratos.cod_contrato" class="even pointer">
                            <td class=" " v-text="contratos.c_numero"></td>
                            <td class=" " v-text="contratos.c_fech_ini"></td>
                            <td class=" " v-text="contratos.c_fech_ter"></td>
                            <td width="10px">
                                 <input type="radio" name="radios" id="radios" @click="SeleccionarContrato(contratos)">
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                      <nav>
                          <ul class="pagination">
                              <li class="page-item" v-if="pagination.current_page>1">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,cod_personal)">Anterior</a>
                              </li>
                               <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(page,cod_personal)" v-text="page">1</a>
                              </li>
                               <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,cod_personal)">Siguiente</a>
                              </li>
                          </ul>
                      </nav>
                    </div>

    
                       
                       
                      </div>
                      <!-- /MAIL LIST -->

                      <!-- CONTENT MAIL -->
                      <div class="col-sm-7 mail_view">
                        <div class="inbox-body">
                          
                         <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Contrato</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Ingresos</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="true">Ocasional</a>
                        </li>
                         <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="true">Descuentos</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="true">Beneficiarios</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab6" data-toggle="tab" aria-expanded="true">Pagos</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                
                            <div class="x_title">

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Codigo de Contrato</label>
                                        <input type="text" v-model="cod_contrato" class="form-control" disabled="disabled">
                                    </div>
                                    <div class="col-md-4">
                                       
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Estado</label>
                                        <select class="form-control" v-model="estado_personal_cod_estado_personal">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="estadopersonal in arrayEstadopersonal" :key="estadopersonal.cod_estado_personal" :value="estadopersonal.cod_estado_personal" v-text="estadopersonal.	es_estado_personal"></option>
                                        </select>
                                    </div>
                                </div>
                                
                                    <div class="clearfix"></div>
                                </div>

                                 <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="text-input">Nº Contrato</label>
                                        <input type="text" v-model="c_numero" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Codigo Plaza</label>
                                        <input type="text" v-model="c_plaza" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Fecha Contrato</label>
                                        <input type="text" v-model="c_fech_contrato" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Fecha Inicio</label>
                                        <input type="text" v-model="c_fech_ini" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Fecha Termino</label>
                                        <input v-if="c_fech_ter=='31/12/2999'" type="text" v-model="indeterminado" class="form-control"/>
                                        <input v-else type="text" v-model="c_fech_ter" class="form-control"/>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Regimen Laboral</label>
                                        <select class="form-control" v-model="regimen_laboral_cod_regimen_laboral">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="regimenlaboral in arrayRegimenlaboral" :key="regimenlaboral.cod_regimen_laboral" :value="regimenlaboral.cod_regimen_laboral" v-text="regimenlaboral.rl_regimen_laboral"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Área</label>
                                         <select class="form-control" v-model="area_a_cod_area">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="area in arrayArea" :key="area.a_cod_area" :value="area.a_cod_area" v-text="area.a_area"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Cargo</label>
                                        <select class="form-control" v-model="cargo_cod_cargo">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="cargo in arrayCargo" :key="cargo.cod_cargo" :value="cargo.cod_cargo" v-text="cargo.c_abrev_cargo"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="text-input">Clasificador</label>
                                        <select class="form-control" v-model="clasificador_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="clasificador in arrayClasificador" :key="clasificador.idclasificador" :value="clasificador.idclasificador" v-text="clasificador.clasificador+'-'+clasificador.cla_descripcion"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Meta</label>
                                        <select class="form-control" v-model="meta_m_cod_meta">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="meta in arrayMeta" :key="meta.m_cod_meta" :value="meta.m_cod_meta" v-text="meta.meta+'-'+meta.m_anio_per+' '+meta.descripcion"></option>
                                        </select>
                                    </div>
                                     <div class="col-md-3">
                                        <label for="text-input">Clase de Planilla</label>
                                        <select class="form-control" v-model="tipo_trabajador_cod_tipo_trabajador">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipotrabajador in arrayTipotrabajador" :key="tipotrabajador.cod_tipo_trabajador" :value="tipotrabajador.cod_tipo_trabajador" v-text="tipotrabajador.tt_tipo_trabajador"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Tipo de Planilla</label>
                                        <select class="form-control" v-model="tipo_planilla_cod_tipo_planilla">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipoplanilla in arrayTipoPlanilla" :key="tipoplanilla.cod_tipo_planilla" :value="tipoplanilla.cod_tipo_planilla" v-text="tipoplanilla.tpll_tipo_planilla"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">
                                        <label for="text-input">Jor. Lab.</label>
                                        <input type="text" v-model="c_horas" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                    <label for="text-input">Dias Lab.</label>
                                        <input type="text" v-model="c_dias_lab" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                    <label for="text-input">Dias Licencia</label>
                                        <input type="text" v-model="c_dias_lic" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Tipo de Pago</label>
                                        <select class="form-control" v-model="tipo_pago_cod_tipo_pago">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipopago in arrayTipopago" :key="tipopago.cod_tipo_pago" :value="tipopago.cod_tipo_pago" v-text="tipopago.tp_tipo_pago"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>
                                            <div class="checkbox-css">
                                            <input type="checkbox" name="sus_renta" v-model="sus_renta" />
                                            <span>Sus. Renta 4ta</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9">
                                        <label for="text-input">Observación</label>
                                        <input type="text" v-model="c_observacion" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Num. Operación</label>
                                        <input type="text" v-model="num_operacion" class="form-control">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    
                                    <!-- <div class="col-md-2">
                                        <label>
                                            <div class="checkbox-css">
                                                <input type="checkbox" name="aseguradora_cod_aseguradora" v-model="aseguradora_cod_aseguradora" />
                                                <span>Afiliado a EPS</span>
                                            </div>
                                        </label>
                                    </div> -->

                                    <div class="col-md-3">
                                        <label for="text-input">Aseguradora</label>
                                        <select class="form-control" v-model="aseguradora_cod_aseguradora">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="aseguradoras in arrayAseguradora" :key="aseguradoras.cod_aseguradora" :value="aseguradoras.cod_aseguradora" v-text="aseguradoras.aseguradora"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Plan Prima EPS</label>
                                        <select class="form-control" v-model="plan_eps_cod_plan_eps">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="planeps in arrayPlaneps" :key="planeps.cod_plan_eps" :value="planeps.cod_plan_eps" v-text="planeps.pe_des_plan_eps"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Composición / Etario</label>
                                        <select class="form-control" v-model="comp_fam_cod_comp_fam">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="compfam in arrayCompfam" :key="compfam.cod_comp_fam" :value="compfam.cod_comp_fam" v-text="compfam.cf_des_comp_fam"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Monto EPS</label>
                                        <input type="text" v-model="monto_eps" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Num Afiliados</label>
                                        <input type="text" v-model="afiliados_eps" class="form-control">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <div class="col-md-1">
                                        <label for="text-input">Dias</label>
                                        <input type="text" v-model="c_desc_dias" class="form-control">
                                    </div>
                                    <div class="col-md-1">
                                        <label for="text-input">Horas</label>
                                        <input type="text" v-model="c_desc_horas" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Minutos</label>
                                        <input type="text" v-model="c_desc_min" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input">Permisos</label>
                                        <input type="text" v-model="c_desc_perm" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Tipo de Registro AIRHSP</label>
                                        <select class="form-control" v-model="tipo_registro_airhsp_tra_id">
                                            <option value="" disabled>Seleccione</option>
                                            <option v-for="tipoRegistroairhsp in arrayTiporegistroairhsp" :key="tipoRegistroairhsp.tra_id" :value="tipoRegistroairhsp.tra_id">{{ tipoRegistroairhsp.tra_id + ' - '+tipoRegistroairhsp.tra_descripcion}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Codigo Registro AIRHSP</label>
                                        <input type="text" v-model="c_cod_reg_airhsp" class="form-control">
                                    </div>
                                </div>
                                
                                <div v-show="errorPersonal" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersonal" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="actualizarContrato()"><i class="fas fa-sync-alt"></i>&nbsp;Actualizar</button>
                        </div>


                        </div>

                       <!-- PANEL INGRESOS -->

                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab2">
                          

                    <div class="table-responsive col-md-12 col-sm-12 col-xs-12">
                        <button type="button" @click="abrirModalIngreso('ingreso','registrar')" class="btn btn-danger float-right">
                            <i class="fas fa-plus"></i>&nbsp;Nuevo
                        </button>
                      <table class="table table-striped jambo_table bulk_action table-bordered con-radios">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Codigo</th>
                            <th class="column-title">Concepto</th>
                            <th class="column-title">Monto</th>
                            <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="ingresos in arrayIngresos" :key="ingresos.cod_ingreso" class="even pointer">
                            <td class=" " v-text="ingresos.cod_concepto"></td>
                            <td class=" " v-text="ingresos.con_abrev"></td>
                            <td class=" " v-text="ingresos.i_monto"></td>
                            <td width="10px">
                            <button type="button" @click="abrirModalIngreso('ingreso','actualizar',ingresos)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>&nbsp;Editar</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="eliminarIngreso(ingresos.cod_ingreso)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>

                        </div>

                        <!-- FIN PANEL INGRESOS -->

                        <!-- PANEL PAGOS OCASIONALES -->

                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab3">
                          
                          <div class="table-responsive col-md-12 col-sm-12 col-xs-12">
                        <button type="button" @click="abrirModalOcasional('ocasional','registrar')" class="btn btn-danger float-right">
                            <i class="fas fa-plus"></i>&nbsp;Nuevo
                        </button>
                      <table class="table table-striped jambo_table bulk_action table-bordered con-radios">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Codigo</th>
                            <th class="column-title">Concepto</th>
                            <th class="column-title">Monto</th>
                            <th class="column-title">Inicio</th>
                            <th class="column-title">Termino</th>
                            <th class="column-title no-link last"  colspan="2" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="pagosocasionales in arrayPagoocasional" :key="pagosocasionales.cod_pago_ocasional" class="even pointer">
                            <td class=" " v-text="pagosocasionales.cod_concepto"></td>
                            <td class=" " v-text="pagosocasionales.con_abrev"></td>
                            <td class=" " v-text="pagosocasionales.po_monto"></td>
                            <td class=" " v-text="pagosocasionales.po_inicio"></td>
                            <td class=" " v-text="pagosocasionales.po_termino"></td>
                            <td width="10px">
                            <button type="button" @click="abrirModalOcasional('ocasional','actualizar',pagosocasionales)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>&nbsp;Editar</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="eliminarOcasional(pagosocasionales.cod_pago_ocasional)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>


                        </div>

                        <!-- FIN PANEL REINTEGROS -->

                        <!-- PANEL DESCUENTOS -->

                         <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab4">
                          
                          

                        <div class="table-responsive col-md-12 col-sm-12 col-xs-12">
                        <button type="button" @click="abrirModaldescuento('descuento','registrar')" class="btn btn-danger float-right">
                            <i class="fas fa-plus"></i>&nbsp;Nuevo
                        </button>
                      <table class="table table-striped jambo_table bulk_action table-bordered con-radios">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Codigo</th>
                            <th class="column-title">Concepto</th>
                            <th class="column-title">Monto</th>
                            <th class="column-title">Inicio</th>
                            <th class="column-title">Termino</th>
                            <th class="column-title no-link last"  colspan="2" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="descuentos in arrayDescuentos" :key="descuentos.cod_descuento" class="even pointer">
                            <td class=" " v-text="descuentos.cod_concepto"></td>
                            <td class=" " v-text="descuentos.con_abrev"></td>
                            <td class=" " v-text="descuentos.d_monto"></td>
                            <td class=" " v-text="descuentos.d_inicio"></td>
                            <td class=" " v-text="descuentos.d_termino"></td>
                            <td width="10px">
                            <button type="button" @click="abrirModaldescuento('descuento','actualizar',descuentos)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>&nbsp;Editar</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="eliminarDescuento(descuentos.cod_descuento)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>




                        </div>

                        <!-- FIN PANEL DESCUENTOS -->

                        <!-- BENEFICIARIOS -->

                        <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab5">
                          

                            <div class="table-responsive col-md-12 col-sm-12 col-xs-12">
                        <button type="button" @click="abrirModalbeneficiario('beneficiario','registrar')" class="btn btn-danger float-right">
                            <i class="fas fa-plus"></i>&nbsp;Nuevo
                        </button>
                      <table class="table table-striped jambo_table bulk_action table-bordered con-radios">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">A_Paterno</th>
                            <th class="column-title">A_Materno</th>
                            <th class="column-title">Nombres</th>
                            <th class="column-title">Num_Doc</th>
                            <th class="column-title">Fijo</th>
                            <th class="column-title">%</th>
                            <th class="column-title">Estado</th>
                            <th class="column-title no-link last"  colspan="2" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="beneficiarios in arrayBeneficiario" :key="beneficiarios.cod_beneficiario" class="even pointer">
                            <td class=" " v-text="beneficiarios.b_paterno"></td>
                            <td class=" " v-text="beneficiarios.b_materno"></td>
                            <td class=" " v-text="beneficiarios.b_nombres"></td>
                            <td class=" " v-text="beneficiarios.b_numdoc"></td>
                            <td class=" " v-text="beneficiarios.b_fijo"></td>
                            <td class=" " v-text="beneficiarios.b_porcentaje"></td>
                            <td class=" ">
                                <div v-if="beneficiarios.estado_idestado=='01'">
                                    <span class="label label-success">habilitado</span>
                                </div>
                                <div v-if="beneficiarios.estado_idestado=='02'">
                                    <span class="label label-danger">baja</span>
                                </div>
                            </td>
                            <td width="10px">
                            <button type="button" @click="abrirModalbeneficiario('beneficiario','actualizar',beneficiarios)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>&nbsp;Editar</button>
                            </td>
                            <td width="10px">
                            <button type="button" @click="eliminarBeneficiario(beneficiarios.cod_beneficiario)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>


                        </div>

                        <!-- FIN BENEFICIARIOS -->

                        <!-- PAGOS -->

                        <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab6">
                         
                         <div class="table-responsive col-md-12 col-sm-12 col-xs-12">

                      <table class="table table-striped jambo_table bulk_action table-bordered con-radios">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Periodo</th>
                            <th class="column-title">Bruto</th>
                            <th class="column-title">Descuentos</th>
                            <th class="column-title">Liquido</th>
                            <th class="column-title">Aporte</th>
                            <th class="column-title">Estado</th>
                            <th class="column-title no-link last" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="pagocontratos in arrayPagos" :key="pagocontratos.cod_detalle_planilla" class="even pointer">
                            <td class=" " v-text="pagocontratos.pll_periodo"></td>
                            <td class=" " v-text="pagocontratos.dpll_bruto"></td>
                            <td class=" " v-text="pagocontratos.dpll_descuentos"></td>
                            <td class=" " v-text="pagocontratos.dpll_liquido"></td>
                            <td class=" " v-text="pagocontratos.dpll_aport"></td>
                            <td class=" ">
                                <div v-if="pagocontratos.planilla_estado_cod_plla_estado=='02'">
                                    <span class="label label-success">Procesado</span>
                                </div>
                                <div v-if="pagocontratos.planilla_estado_cod_plla_estado=='03'">
                                    <span class="label label-danger">Cerrado</span>
                                </div>
                            </td>
                            <td width="10px">
                            <button type="button" @click="abrirModalpago(pagocontratos)" class="btn btn-primary btn-sm">Ver</button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>

                        </div>

                        <!-- FIN PAGOS -->

                      </div>
                    </div>

                  </div>
   
                        </div>

                      </div>
                      <!-- /CONTENT MAIL -->
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

			<!--Inicio del modal registrar Nuevo Contrato-->
              <div class="modal fade" :class="{'mostrar':modalcontrato}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalcontrato()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel">Nuevo Contrato</h3> 
                        </div>

                        <div class="modal-body">
                            
                            
                           <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                
                                 <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Numero de contrato</label>
                                        <input type="text" v-model="c_numero" class="form-control">
                                        <span v-if="errors.c_numero" class="error">{{errors.c_numero[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Numero de Plaza</label>
                                        <input type="text" v-model="c_plaza" class="form-control">
                                        <span v-if="errors.c_plaza" class="error">{{errors.c_plaza[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Fecha de Contrato</label>
                                        <input type="text" v-model="c_fech_contrato" class="form-control">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Fecha de Inicio</label>
                                        <input type="text" v-model="c_fech_ini" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Fecha de Termino</label>
                                        <input type="text" v-model="c_fech_ter" class="form-control">
                                    </div>
                                     <div class="col-md-4">
                                        <label for="text-input">Regimen Laboral</label>
                                        <select class="form-control" v-model="regimen_laboral_cod_regimen_laboral">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="regimenlaboral in arrayRegimenlaboral" :key="regimenlaboral.cod_regimen_laboral" :value="regimenlaboral.cod_regimen_laboral" v-text="regimenlaboral.rl_regimen_laboral"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Área</label>
                                        <select class="form-control" v-model="area_a_cod_area">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="area in arrayArea" :key="area.a_cod_area" :value="area.a_cod_area" v-text="area.a_area"></option>
                                        </select>
                                    </div>
                                     <div class="col-md-4">
                                        <label for="text-input">Cargo</label>
                                        <select class="form-control" v-model="cargo_cod_cargo">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="cargo in arrayCargo" :key="cargo.cod_cargo" :value="cargo.cod_cargo" v-text="cargo.c_abrev_cargo"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Clasificador</label>
                                        <select class="form-control" v-model="clasificador_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="clasificador in arrayClasificador" :key="clasificador.idclasificador" :value="clasificador.idclasificador" v-text="clasificador.clasificador+'-'+clasificador.cla_descripcion"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Meta</label>
                                        <select class="form-control" v-model="meta_m_cod_meta">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="meta in arrayMeta" :key="meta.m_cod_meta" :value="meta.m_cod_meta" v-text="meta.meta+'-'+meta.m_anio_per+' '+meta.descripcion"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Clase de Planilla</label>
                                        <select class="form-control" v-model="tipo_trabajador_cod_tipo_trabajador">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipotrabajador in arrayTipotrabajador" :key="tipotrabajador.cod_tipo_trabajador" :value="tipotrabajador.cod_tipo_trabajador" v-text="tipotrabajador.tt_tipo_trabajador"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Tipo de Planilla</label>
                                        <select class="form-control" v-model="tipo_planilla_cod_tipo_planilla">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipoplanilla in arrayTipoPlanilla" :key="tipoplanilla.cod_tipo_planilla" :value="tipoplanilla.cod_tipo_planilla" v-text="tipoplanilla.tpll_tipo_planilla"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                   
                                    <div class="col-md-2">
                                        <label for="text-input">Jor. Lab.</label>
                                        <input type="text" v-model="c_horas" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                    <label for="text-input">Dias Lab.</label>
                                        <input type="text" v-model="c_dias_lab" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Tipo de Pago</label>
                                        <select class="form-control" v-model="tipo_pago_cod_tipo_pago">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipopago in arrayTipopago" :key="tipopago.cod_tipo_pago" :value="tipopago.cod_tipo_pago" v-text="tipopago.tp_tipo_pago"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="text-input">Observación</label>
                                        <input type="text" v-model="c_observacion" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="text-input">Tipo de Registro AIRHSP</label>
                                        <select class="form-control" v-model="tipo_registro_airhsp_tra_id">
                                            <option value="" disabled>Seleccione</option>
                                            <option v-for="tipoRegistroairhsp in arrayTiporegistroairhsp" :key="tipoRegistroairhsp.tra_id" :value="tipoRegistroairhsp.tra_id">{{ tipoRegistroairhsp.tra_id + ' - '+tipoRegistroairhsp.tra_descripcion}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Codigo Registro AIRHSP</label>
                                        <input type="text" v-model="c_cod_reg_airhsp" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="checkbox-css">
                                        <label>
                                            <input type="checkbox" name="sus_renta" v-model="sus_renta" />
                                            <span>Suspension de Renta </span>
                                        </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input">Num. Operación</label>
                                        <input type="text" v-model="num_operacion" class="form-control">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalcontrato()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="registrarContrato()"><i class="far fa-save"></i>&nbsp;Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal Ingresos-->
              <div class="modal fade" :class="{'mostrar':modalingresos}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalingreso()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" v-text="tituloModalingreso"></h4>
                        </div>

                        <div class="modal-body">
                            
                            
                           <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                
                                 <div class="form-group row">
                                     <div class="col-md-12">
                                        <label for="text-input">Concepto</label>
                                        <select class="form-control" v-model="concepto_cod_concepto">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="concepto in arrayConceptos" :key="concepto.cod_concepto" :value="concepto.cod_concepto" v-text="concepto.con_abrev"></option>
                                        </select>
                                        <span v-if="errors.concepto_cod_concepto" class="error">{{errors.concepto_cod_concepto[0]}}</span>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="text-input">Monto</label>
                                        <input type="text" v-model="i_monto" class="form-control">
                                        <span v-if="errors.i_monto" class="error">{{errors.i_monto[0]}}</span>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalingreso()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                            <button type="button" v-if="tipoAccioningreso==1" class="btn btn-primary" @click="registrarIngreso()"><i class="far fa-save"></i>&nbsp;Guardar</button>
                            <button type="button" v-if="tipoAccioningreso==2" class="btn btn-primary" @click="actualizarIngreso()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

             <!--Inicio del modal Ocasional-->
              <div class="modal fade" :class="{'mostrar':modalocasional}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalocasional()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" v-text="tituloModalocasional"></h4>
                        </div>

                        <div class="modal-body">
                            
                            
                           <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                
                                 <div class="form-group row">
                                     <div class="col-md-12">
                                        <label for="text-input">Concepto</label>
                                        <select class="form-control" v-model="concepto_cod_concepto">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="concepto in arrayConceptos" :key="concepto.cod_concepto" :value="concepto.cod_concepto" v-text="concepto.con_abrev"></option>
                                        </select>
                                        <span v-if="errors.concepto_cod_concepto" class="error">{{errors.concepto_cod_concepto[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="text-input">Monto</label>
                                        <input type="text" v-model="po_monto" class="form-control">
                                        <span v-if="errors.po_monto" class="error">{{errors.po_monto[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="text-input">Periodo Inicio</label>
                                        <input type="text" v-model="po_inicio" class="form-control">
                                        <span v-if="errors.po_inicio" class="error">{{errors.po_inicio[0]}}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="text-input">Periodo Termino</label>
                                        <input type="text" v-model="po_termino" class="form-control">
                                        <span v-if="errors.po_termino" class="error">{{errors.po_termino[0]}}</span>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalocasional()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                            <button type="button" v-if="tipoAccionocasional==1" class="btn btn-primary" @click="registrarOcasional()"><i class="far fa-save"></i>&nbsp;Guardar</button>
                            <button type="button" v-if="tipoAccionocasional==2" class="btn btn-primary" @click="actualizarOcasional()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal Descuento-->
              <div class="modal fade" :class="{'mostrar':modaldescuento}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModaldescuento()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" v-text="tituloModaldescuento"></h4>
                        </div>

                        <div class="modal-body">
                            
                            
                           <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                
                                 <div class="form-group row">
                                     <div class="col-md-12">
                                        <label for="text-input">Concepto</label>
                                        <select class="form-control" v-model="concepto_cod_concepto">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="concepto in arrayConceptos" :key="concepto.cod_concepto" :value="concepto.cod_concepto" v-text="concepto.con_abrev"></option>
                                        </select>
                                        <span v-if="errors.concepto_cod_concepto" class="error">{{errors.concepto_cod_concepto[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="text-input">Monto</label>
                                        <input type="text" v-model="d_monto" class="form-control">
                                        <span v-if="errors.d_monto" class="error">{{errors.d_monto[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="text-input">Periodo Inicio</label>
                                        <input type="text" v-model="d_inicio" class="form-control">
                                        <span v-if="errors.d_inicio" class="error">{{errors.d_inicio[0]}}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="text-input">Periodo Termino</label>
                                        <input type="text" v-model="d_termino" class="form-control">
                                        <span v-if="errors.d_termino" class="error">{{errors.d_termino[0]}}</span>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModaldescuento()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                            <button type="button" v-if="tipoAcciondescuento==1" class="btn btn-primary" @click="registrarDescuento()"><i class="far fa-save"></i>&nbsp;Guardar</button>
                            <button type="button" v-if="tipoAcciondescuento==2" class="btn btn-primary" @click="actualizarDescuento()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal beneficiario-->
              <div class="modal fade" :class="{'mostrar':modalbeneficiario}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalbeneficiario()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" v-text="tituloModalbeneficiario"></h4>
                        </div>

                        <div class="modal-body">
                            
                            
                           <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                 <div class="form-group row">
                                     <div class="col-md-4">
                                        
                                    </div>
                                    <div class="col-md-4">
                                        
                                    </div>
                                     <div class="col-md-4" v-if="tipoAccionbeneficiario==2">
                                        <label for="text-input">Estado</label>
                                        <select class="form-control" v-model="b_estado_idestado">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="estadopersonal in arrayEstadopersonal" :key="estadopersonal.cod_estado_personal" :value="estadopersonal.cod_estado_personal" v-text="estadopersonal.	es_estado_personal"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Apellido Paterno</label>
                                        <input type="text" v-model="b_paterno" class="form-control">
                                        <span v-if="errors.b_paterno" class="error">{{errors.b_paterno[0]}}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Apellido Materno</label>
                                        <input type="text" v-model="b_materno" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Nombres</label>
                                        <input type="text" v-model="b_nombres" class="form-control">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                     <div class="col-md-4">
                                        <label for="text-input">Tipo de Documento</label>
                                        <select class="form-control" v-model="b_tipo_documento_cod_tipo_documento">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipodocumento in arrayTipodocumento" :key="tipodocumento.cod_tipo_documento" :value="tipodocumento.cod_tipo_documento" v-text="tipodocumento.td_documento"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Numero de Documento</label>
                                        <input type="text" v-model="b_numdoc" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Resolucion Judicial</label>
                                        <input type="text" v-model="b_resjudicial" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Fecha Resolución</label>
                                        <input type="text" v-model="b_fechjudicial" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Monto Fijo</label>
                                        <input type="text" v-model="b_fijo" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Porcentaje</label>
                                        <input type="text" v-model="b_porcentaje" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="text-input">Tipo de Pago</label>
                                        <select class="form-control" v-model="b_tipo_pago_cod_tipo_pago">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipopago in arrayTipopago" :key="tipopago.cod_tipo_pago" :value="tipopago.cod_tipo_pago" v-text="tipopago.tp_tipo_pago"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Banco</label>
                                        <select class="form-control" v-model="b_banco_cod_banco">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="banco in arrayBanco" :key="banco.cod_banco" :value="banco.cod_banco" v-text="banco.b_banco"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="text-input">Cuenta de Ahorros</label>
                                        <input type="text" v-model="b_cuenta" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="text-input">Observación</label>
                                        <input type="text" v-model="b_observacion" class="form-control">
                                    </div>
                                </div>
                            
                                <div v-show="errorPersonal" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersonal" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalbeneficiario()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                            <button type="button" v-if="tipoAccionbeneficiario==1" class="btn btn-primary" @click="registrarBeneficiario()"><i class="far fa-save"></i>&nbsp;Guardar</button>
                            <button type="button" v-if="tipoAccionbeneficiario==2" class="btn btn-primary" @click="actualizarBeneficiario()"><i class="fas fa-sync-alt"></i>&nbsp;Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            <!--Inicio del modal Pago-->
              <div class="modal fade" :class="{'mostrar':modalpago}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalpago()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" v-text="tituloModalbeneficiario"></h4>
                        </div>

                        <div class="modal-body">
                            
                        <div class="btitulo3">BOLETA DE PAGO - DECRETO LEGISLATIVO N° 1057</div>
                        <div class="datospersonales">
                        <table class="tablarep">
                        <tbody>
                                <tr>
                                <td colspan="5"><div class="btitulo1">UNIDAD DE GESTION EDUCATIVA LOCAL N° 07</div></td>
                                <td v-text="'PERIODO: '+p_periodo"></td>
                                </tr>
                                <tr>
                                <td colspan="5"><div class="btitulo2">RUC:20334929281</div></td>
                                </tr>
                                <tr>
                                <td class="bordesuperior">COD_PERSONAL</td>
                                <td class="bordesuperior" v-text="p_cod_personal"></td>
                                <td class="bordesuperior">ESTADO CIVIL</td>
                                    <td class="bordesuperior" v-text="p_estado_civil_cod_estado_civil"></td>
                                <td class="bordesuperior">FECH_CONTRATO</td>
                                <td class="bordesuperior" v-text="p_c_fech_contrato"></td>
                                </tr>
                                <tr>
                                <td>APE_PATERNO</td>
                                <td v-text="p_a_paterno"></td>
                                <td>ADM. PENSION</td>
                                <td v-text="p_admin_pension_cod_admin_pension"></td>
                                <td>FECH_INICIO</td>
                                <td v-text="p_c_fech_ini"></td>
                                </tr>
                                <tr>
                                <td>APE_MATERNO</td>
                                <td v-text="p_a_materno"></td>
                                <td>CUSPP</td>
                                <td v-text="p_cuspp"></td>
                                <td>FECH_TERMINO</td>
                                <td v-text="p_c_fech_ter"></td>
                                </tr>
                                <tr>
                                <td>NOMBRES</td>
                                <td v-text="p_nombres"></td>
                                <td>FECH_AFIL</td>
                                <td v-text="p_fech_afiliacion"></td>
                                <td>ESTABLECIMIENTO</td>
                                <td v-text="p_Establecimiento_cod_establecimiento"></td>
                                </tr>
                                <tr>
                                <td>SEXO</td>
                                <td v-text="p_s_sexo"></td>
                                <td>BANCO</td>
                                <td v-text="p_banco_cod_banco"></td>
                                <td>REG_LABORAL</td>
                                <td v-text="p_regimen_laboral_cod_regimen_laboral"></td>
                                </tr>
                                <tr>
                                <td>N° DOCUMENTO</td>
                                <td v-text="p_num_doc"></td>
                                <td>N° CUENTA</td>
                                <td v-text="p_num_cuenta"></td>
                                <td>TIP_TRABAJADOR</td>
                                <td v-text="p_tipo_trabajador_cod_tipo_trab"></td>
                                </tr>
                                <tr>
                                <td>FECH_NACIMIENTO</td>
                                <td v-text="p_fech_nac"></td>
                                <td>N° CONTRATO</td>
                                <td v-text="p_c_numero"></td>
                                <td>HORAS</td>
                                <td v-text="p_c_horas"></td>
                                </tr>
                                <tr>
                                <td>RUC</td>
                                <td v-text="p_ruc"></td>
                                <td>PLAZA</td>
                                <td v-text="p_c_plaza"></td>
                                <td>CARGO</td>
                                <td v-text="p_cargo_cod_cargo"></td>
                                </tr>
                                </tbody>
                        </table>

                        </div>
                        <div class="montos bordeinferior">
                        <table class="tablarep">
                                <tr>
                                <td class="bordesuperior bordeinferior bordederecha bordeizquierda">INGRESOS</td>
                                <td class="bordesuperior bordeinferior bordederecha bordeizquierda">DESCUENTOS</td>
                                <td class="bordesuperior bordeinferior bordederecha bordeizquierda">APORTES DEL EMPLEADOR</td>
                                </tr>

                             <tbody>
                            <tr class="detallemontos">
                                <td>
                                <table v-for="arrayhaberes in arrayhaberes" :key="arrayhaberes.cod_contrato" class="even pointer">
                                    <tr v-if="arrayhaberes.tipo_concepto_cod_tip_concepto=='1' || arrayhaberes.tipo_concepto_cod_tip_concepto=='3'">
                                    <td class=" " v-text="arrayhaberes.concepto_cod_concepto+'-'+arrayhaberes.con_abrev"></td>
                                    <td class="alinearnumero" v-text="arrayhaberes.pll_id_monto"></td>
                                    </tr>
                                </table>
                                </td>
                                <td>
                                <table v-for="arrayhaberes in arrayhaberes" :key="arrayhaberes.cod_contrato" class="even pointer">
                                    <tr v-if="arrayhaberes.tipo_concepto_cod_tip_concepto=='2'">
                                    <td class=" " v-text="arrayhaberes.concepto_cod_concepto+'-'+arrayhaberes.con_abrev"></td>
                                    <td class="alinearnumero" v-text="arrayhaberes.pll_id_monto"></td>
                                    </tr>
                                </table>  
                                </td>
                                <td>
                                <table v-for="arrayhaberes in arrayhaberes" :key="arrayhaberes.cod_contrato" class="even pointer">
                                    <tr v-if="arrayhaberes.tipo_concepto_cod_tip_concepto=='4'">
                                    <td class=" " v-text="arrayhaberes.concepto_cod_concepto+'-'+arrayhaberes.con_abrev"></td>
                                    <td class="alinearnumero" v-text="arrayhaberes.pll_id_monto"></td>
                                    </tr>
                                </table>  
                                </td>
                            </tr>
                            
                        </tbody>
                        </table>
                        </div>

                        <div class="totales">
                        <table class="tablarep bordesuperior bordeinferior bordederecha bordeizquierda">
                        <tbody>
                                <tr>
                                <td>
                                <table class="tabladet">
                                    <tr>
                                    <td>TOTAL REMUNERACION</td>
                                    <td class="alinearnumero" v-text="dpll_bruto"></td>
                                    </tr> 
                                </table>
                                </td>
                                <td>
                                <table class="tabladet">
                                    <tr>
                                    <td>TOTAL DESCUENTOS</td>
                                    <td class="alinearnumero" v-text="dpll_descuentos"></td>
                                    </tr>
                                </table>
                                </td>
                                <td>
                                <table class="tabladet">
                                    <tr>
                                    <td>TOTAL APORTACION</td>
                                    <td class="alinearnumero" v-text="dpll_aport"></td>
                                    </tr>
                                </table>
                                </td>
                                </tr>

                                <tr>
                                <td>
                                <table class="tabladet">
                                    <tr>
                                    <td>MONTO BASE CALCULO</td>
                                    <td class="alinearnumero" v-text="dpll_base_calculo"></td>
                                    </tr>
                                </table>
                                </td>
                                <td>
                                    <table class="tabladet">
                                    <tr>
                                    <td></td>
                                    <td></td>
                                    </tr>
                                </table>
                                </td>
                                <td>
                                <table class="tabladet">
                                    <tr>
                                    <td>MONTO LIQUIDO</td>
                                    <td class="alinearnumero" v-text="dpll_liquido"></td>
                                    </tr>
                                </table>
                                </td>
                                </tr>
                                </tbody>
                        </table>
                        </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalpago()"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
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
                indeterminado:'Indeterminado',
                criteriobuscar: 'p_num_doc',
                cod_personal:'',
                cod_contrato:'',
                cod_ingreso:'',
                cod_ocasional:'',
                cod_descuento:'',
                buscardni: '',
                tipo_planilla_cod_tipo_planilla:0,
                arrayPersonal:[],
                arrayContratos:[],
                arrayEstadopersonal:[],
                arrayIngresos:[],
                arrayPagoocasional:[],
                arrayDescuentos:[],
                arrayBeneficiario:[],
                arrayNiveleducativo:[],
                arrayArea:[],
                arrayCargo:[],
                arrayTipotrabajador:[],
                arrayClasificador:[],
                arrayMeta:[],
                arrayRegimenlaboral:[],
                arrayTipopago:[],
                arrayConceptos:[],
                arrayTipodocumento:[],
                arrayBanco:[],
                arrayPagos:[],
                arrayhaberes:[],
                arrayPlaneps:[],
                arrayCompfam:[],
                arrayAseguradora:[],
                arrayTiporegistroairhsp:[],
                modal : 0,
                modalbuscar:0,
                modalcontrato:0,
                modalingresos:0,
                modalocasional:0,
                modaldescuento:0,
                modalbeneficiario:0,
                b_numdoc: '',
                b_apaterno:'',
                b_amaterno:'',
                b_nombres:'',
                modalpago:0,
                tituloModal: '',
                tituloModalingreso: '',
                tipoAccion:0,
                tipoAccioningreso:0,
                errorDepartamento:0,
                errorMostrarMsjDepartamento:[],
                pagination : {
                    'total' : 0, 
                    'current_page': 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from': 0,
                    'to': 0,
                },
                offset:3,
                criterio:'cod_departamento',
                buscar: '',
                errors:[],

                ape_nombres:'',
                p_num_doc:'',
                p_correo:'',
                p_celular:'',
                ap_admin_pension:'',
                fotopersonal:'fotos/default.jpg',
                estado_personal_cod_estado_personal:'',
                c_numero:'',
                c_plaza:'',
                c_fech_contrato:'',
                c_fech_ini:'',
                c_fech_ter:'',
                regimen_laboral_cod_regimen_laboral:'',
                area_a_cod_area:'',
                cargo_cod_cargo:'',
                clasificador_id:'',
                meta_m_cod_meta:'',
                tipo_trabajador_cod_tipo_trabajador:'',
                c_horas:'',
                arrayTipoPlanilla:[],
                c_dias_lab:'',
                c_dias_lic:'',
                tipo_pago_cod_tipo_pago:'',
                sus_renta:'',
                c_observacion:'',
                num_operacion:'',
                aseguradora_cod_aseguradora:'',
                plan_eps_cod_plan_eps:'',
                comp_fam_cod_comp_fam:'',
                monto_eps:'',
                afiliados_eps:'',
                c_desc_dias:'',
                c_desc_horas:'',
                c_desc_min:'',
                c_desc_perm:'',
                errorPersonal:'',
                errorMostrarMsjPersonal:'',
                concepto_cod_concepto:'',
                i_monto:'',
                tituloModalocasional:'',
                concepto_cod_concepto:'',
                po_monto:'',
                po_inicio:'',
                po_termino:'',
                tipoAccionocasional:'',
                tituloModaldescuento:'',
                concepto_cod_concepto:'',
                d_monto:'',
                d_inicio:'',
                d_termino:'',
                tipoAcciondescuento:'',
                tituloModalbeneficiario:'',
                tipoAccionbeneficiario:'',
                b_paterno:'',
                b_materno:'',
                b_materno:'',
                b_tipo_documento_cod_tipo_documento:'',
                b_resjudicial:'',
                b_fechjudicial:'',
                b_fijo:'',
                b_porcentaje:'',
                b_tipo_pago_cod_tipo_pago:'',
                b_banco_cod_banco:'',
                b_cuenta:'',
                b_observacion:'',
                p_periodo:'',
                p_cod_personal:'',
                p_estado_civil_cod_estado_civil:'',
                p_c_fech_contrato:'',
                p_a_paterno:'',
                p_admin_pension_cod_admin_pension:'',
                p_c_fech_ini:'',
                p_a_materno:'',
                p_cuspp:'',
                p_c_fech_ter:'',
                p_nombres:'',
                p_fech_afiliacion:'',
                p_Establecimiento_cod_establecimiento:'',
                p_s_sexo:'',
                p_banco_cod_banco:'',
                p_regimen_laboral_cod_regimen_laboral:'',
                p_num_cuenta:'',
                p_tipo_trabajador_cod_tipo_trab:'',
                p_fech_nac:'',
                p_c_numero:'',
                p_c_horas:'',
                p_ruc:'',
                p_c_plaza:'',
                p_cargo_cod_cargo:'',
                dpll_bruto:'',
                dpll_descuentos:'',
                dpll_aport:'',
                dpll_base_calculo:'',
                dpll_liquido:'',
                tipo_registro_airhsp_tra_id:'',
                c_cod_reg_airhsp:''

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

            limpiarbusqueda(){
                this.b_numdoc='';
                this.b_apaterno='';
                this.b_amaterno='';
                this.b_nombres='';
                this.listarPersonal(1,'','','','');
            },

             listarContratos(page,cod_personal){
                let me=this;
                var url= 'contratos?page='+page+'&cod_personal='+cod_personal;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayContratos=respuesta.contratos.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            listarIngresos(cod_contrato) {
                var me = this;
                var url = 'ingreso/listIngreso?cod_contrato='+cod_contrato;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayIngresos = respuesta.ingreso;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            listarPagoocasional(cod_contrato) {
                var me = this;
                var url = 'pagoocasional/listPagoocasional?cod_contrato='+cod_contrato;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPagoocasional = respuesta.pagoocasional;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            listarDescuentos(cod_contrato) {
                var me = this;
                var url = 'descuentos/listDescuentos?cod_contrato='+cod_contrato;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayDescuentos = respuesta.descuentos;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            listarBeneficiarios(cod_contrato) {
                var me = this;
                var url = 'beneficiario/listBeneficiarios?cod_contrato='+cod_contrato;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayBeneficiario = respuesta.beneficiario;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            listarPagos(cod_contrato) {
                var me = this;
                var url = 'planilla/PagosContrato?cod_contrato='+cod_contrato;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPagos = respuesta.pagoscontrato;
                }).catch(function (error) {
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
                this.listarContratos(1,this.cod_personal);
                this.limpiarformularios();
                this.arrayPersonal=[];
                this.buscardni='';
            },

            selectEstadopersonal() {
            var me = this;
            var url = 'estadopersonal/selectEstadopersonal';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayEstadopersonal = respuesta.estadopersonal;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectArea() {
            var me = this;
            var url = 'are/selectarea';
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arrayArea = respuesta.area;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectCargo(){
            var me = this;
            var url = 'cargo/selectcargo';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayCargo = respuesta.cargo;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectTipotrabajador(){
            var me = this;
            var url = 'tipotrabajador/selectTipotrabajador';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayTipotrabajador = respuesta.tipotrabajador;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectRegimenlaboral(){
            var me = this;
            var url = 'regimenlaboral/selectRegimenlaboral';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayRegimenlaboral = respuesta.regimenlaboral;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectClasificador(){
            var me = this;
            var url = 'clasificador/selectClasificador';
            axios.get(url).then(function (response) {
                // console.log(response);
                let respuesta = response.data;
                me.arrayClasificador = respuesta.clasificador;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectMeta(){
            var me = this;
            var url = 'meta/selectMeta';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayMeta = respuesta.meta;
            }).catch(function (error) {
                console.log(error);
            });
            },

            selectTipopago(){
                var me = this;
                var url = 'tipopago/selectTipopago';
                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.arrayTipopago = respuesta.tipopago;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            selectConceptos(tipo_concepto){
                var me = this;
                var url = 'concepto/selectConcepto?tipo_concepto='+tipo_concepto;
                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.arrayConceptos = respuesta.concepto;
                }).catch(function (error) {
                    console.log(error);
                });
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

        selectAseguradora() {
            var me = this;
            var url = 'aseguradora';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayAseguradora = respuesta.aseguradora;
            }).catch(function (error) {
                console.log(error);
            });
            },

        selectplaneps() {
            var me = this;
            var url = 'plan_eps/selectplaneps';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayPlaneps = respuesta.planeps;
            }).catch(function (error) {
                console.log(error);
            });
            },

        selectcompfam() {
            var me = this;
            var url = 'compfam/selectcompfam';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayCompfam = respuesta.compfam;
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

            selectTiporegistroairhsp(){
            var me = this;
            var url = 'registroAirhsp/selectTiporegistroairhsp';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayTiporegistroairhsp = respuesta.tipoRegistroairhsp;
            }).catch(function (error) {
                console.log(error);
            });
            },

            cambiarPagina(page,cod_personal){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarContratos(page,cod_personal);

            },

            SeleccionarContrato(data=[]){
                this.cod_contrato = data['cod_contrato'];
                this.c_numero = data['c_numero'];
                this.c_plaza = data['c_plaza'];
                this.c_cod_reg_airhsp = data['c_cod_reg_airhsp'];
                this.c_fech_contrato = moment(data['c_fech_contrato']).format("DD/MM/YYYY");
                this.c_fech_ini = moment(data['c_fech_ini']).format("DD/MM/YYYY");
                this.c_fech_ter = moment(data['c_fech_ter']).format("DD/MM/YYYY");
                this.area_a_cod_area = data['area_a_cod_area'];
                this.cargo_cod_cargo = data['cargo_cod_cargo'];
                this.tipo_trabajador_cod_tipo_trabajador = data['tipo_trabajador_cod_tipo_trabajador'];
                this.tipo_planilla_cod_tipo_planilla = data['tipo_planilla_cod_tipo_planilla'];
                this.clasificador_id = data['clasificador_id'];
                this.meta_m_cod_meta = data['meta_m_cod_meta'];
                this.regimen_laboral_cod_regimen_laboral = data['regimen_laboral_cod_regimen_laboral'];
                this.c_horas = data['c_horas'];
                this.sus_renta = data['sus_renta'];
                this.num_operacion = data['num_operacion'];
                this.aseguradora_cod_aseguradora = data['aseguradora_cod_aseguradora'];
                this.plan_eps_cod_plan_eps = data['plan_eps_cod_plan_eps'];
                this.comp_fam_cod_comp_fam = data['comp_fam_cod_comp_fam'];
                this.monto_eps = data['monto_eps'];
                this.afiliados_eps = data['afiliados_eps'];
                this.c_dias_lab = data['c_dias_lab'];
                this.c_dias_lic = data['c_dias_lic'];
                this.c_desc_dias = data['c_desc_dias'];
                this.c_desc_horas = data['c_desc_horas'];
                this.c_desc_min = data['c_desc_min'];
                this.c_desc_perm = data['c_desc_perm'];
                this.c_observacion = data['c_observacion'];
                this.personal_cod_personal = data['personal_cod_personal'];
                this.tipo_pago_cod_tipo_pago = data['tipo_pago_cod_tipo_pago'];
                this.estado_personal_cod_estado_personal = data['estado_personal_cod_estado_personal'];
                this.tipo_registro_airhsp_tra_id = data['tipo_registro_airhsp_tra_id'];
                this.listarIngresos(data['cod_contrato']);
                this.listarPagoocasional(data['cod_contrato']);
                this.listarDescuentos(data['cod_contrato']);
                this.listarBeneficiarios(data['cod_contrato']);
                this.listarPagos(data['cod_contrato']);
            },

        registrarContrato(){

            this.errors=[];

            let me=this;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de Registrar?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, Registrar',
                    cancelButtonText: 'No, Cancelar',
                    reverseButtons: true
                }).then((result) => {
                if (result.value) {

            axios.post('contratos/store',{
                    'c_numero':this.c_numero,
                    'c_plaza':this.c_plaza,
                    'c_cod_reg_airhsp':this.c_cod_reg_airhsp,
                    'c_fech_contrato':this.c_fech_contrato,
                    'c_fech_ini':this.c_fech_ini,
                    'c_fech_ter':this.c_fech_ter,
                    'area_a_cod_area':this.area_a_cod_area,
                    'cargo_cod_cargo':this.cargo_cod_cargo,
                    'tipo_trabajador_cod_tipo_trabajador':this.tipo_trabajador_cod_tipo_trabajador,
                    'tipo_planilla_cod_tipo_planilla':this.tipo_planilla_cod_tipo_planilla,
                    'clasificador_id':this.clasificador_id,
                    'meta_m_cod_meta':this.meta_m_cod_meta,
                    'regimen_laboral_cod_regimen_laboral':this.regimen_laboral_cod_regimen_laboral,
                    'c_horas':this.c_horas,
                    'sus_renta':this.sus_renta,
                    'num_operacion':this.num_operacion,
                    'c_dias_lab':this.c_dias_lab,
                    'c_observacion':this.c_observacion,
                    'cod_personal':this.cod_personal,
                    'tipo_pago_cod_tipo_pago':this.tipo_pago_cod_tipo_pago,
                    'tipo_registro_airhsp_tra_id':this.tipo_registro_airhsp_tra_id
            }).then(function(response){
                me.cerrarModalcontrato();
                me.listarContratos(1,me.cod_personal);
                me.limpiarformularios();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Actualizado Satisfactoriamente',
                    showConfirmButton: false,
                    timer: 1500
                    })
                document.querySelectorAll('[name=radios]').forEach((x) => x.checked = false);
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                    me.errors=error.response.data.errors;
                }
            });

        } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                   Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cancelado, no se Registro',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
                })

            },

        
        actualizarContrato(){

            this.errors=[];

            let me=this;


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de Actualizar?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, Actualizar',
                    cancelButtonText: 'No, Cancelar',
                    reverseButtons: true
                }).then((result) => {
                if (result.value) {


                    axios.put('contratos/update',{
                        'cod_contrato':this.cod_contrato,
                        'c_numero':this.c_numero,
                        'c_plaza':this.c_plaza,
                        'c_cod_reg_airhsp':this.c_cod_reg_airhsp,
                        'c_fech_contrato':this.c_fech_contrato,
                        'c_fech_ini':this.c_fech_ini,
                        'c_fech_ter':this.c_fech_ter,
                        'area_a_cod_area':this.area_a_cod_area,
                        'cargo_cod_cargo':this.cargo_cod_cargo,
                        'tipo_trabajador_cod_tipo_trabajador':this.tipo_trabajador_cod_tipo_trabajador,
                        'tipo_planilla_cod_tipo_planilla':this.tipo_planilla_cod_tipo_planilla,
                        'clasificador_id':this.clasificador_id,
                        'meta_m_cod_meta':this.meta_m_cod_meta,
                        'regimen_laboral_cod_regimen_laboral':this.regimen_laboral_cod_regimen_laboral,
                        'c_horas':this.c_horas,
                        'sus_renta':this.sus_renta,
                        'num_operacion':this.num_operacion,
                        'aseguradora_cod_aseguradora':this.aseguradora_cod_aseguradora,
                        'plan_eps_cod_plan_eps':this.plan_eps_cod_plan_eps,
                        'comp_fam_cod_comp_fam':this.comp_fam_cod_comp_fam,
                        'monto_eps':this.monto_eps,
                        'afiliados_eps':this.afiliados_eps,
                        'c_dias_lab':this.c_dias_lab,
                        'c_dias_lic':this.c_dias_lic,
                        'c_desc_dias':this.c_desc_dias,
                        'c_desc_horas':this.c_desc_horas,
                        'c_desc_min':this.c_desc_min,
                        'c_desc_perm':this.c_desc_perm,
                        'c_observacion':this.c_observacion,
                        'cod_personal':this.cod_personal,
                        'tipo_pago_cod_tipo_pago':this.tipo_pago_cod_tipo_pago,
                        'estado_personal_cod_estado_personal':this.estado_personal_cod_estado_personal,
                        'tipo_registro_airhsp_tra_id':this.tipo_registro_airhsp_tra_id
                    }).then(function(response){
                            me.listarContratos(1,me.cod_personal);
                            me.limpiarformularios();
                            document.querySelectorAll('[name=radios]').forEach((x) => x.checked = false);

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Actualizado Satisfactoriamente',
                                showConfirmButton: false,
                                timer: 1500
                                })
                    }).catch(function(error){
                        console.log(error);
                        if(error.response.status==422){
                             me.errors=error.response.data.errors;
                            }
                    });

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                   Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cancelado, no se eliminó la selección',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
                })
                
        },

        abrirModalIngreso(modelo,accion,data=[]){
            if (this.cod_contrato==""){
                swal('Debe seleccionar un contrato','','info')
            }else{
                switch(modelo){
                    case "ingreso":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modalingresos=1;
                                this.tituloModalingreso='Nuevo Ingreso';
                                this.selectConceptos(1);
                                this.concepto_cod_concepto=0;
                                this.i_monto='';
                                this.tipoAccioningreso=1;
                                this.errors=[];
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modalingresos=1;
                                this.tituloModalingreso="Editar Ingreso";
                                this.errors=[];
                                this.selectConceptos(1);
                                this.tipoAccioningreso=2;
                                this.cod_ingreso=data['cod_ingreso'];
                                this.concepto_cod_concepto=data['concepto_cod_concepto'];
                                this.i_monto=data['i_monto'];
                                break;
                            }
                        }
                    }
                }
            }
        },

        cerrarModalingreso(){
            this.modalingresos=0;
            this.errors=[];
        },

        registrarIngreso(){

            this.errors=[];

            let me=this;

            axios.post('ingreso/store',{
                    'i_monto':this.i_monto,
                    'c_plaza':this.c_plaza,
                    'contrato_cod_contrato':this.cod_contrato,
                    'concepto_cod_concepto':this.concepto_cod_concepto,
            }).then(function(response){
                me.cerrarModalingreso();
                me.listarIngresos(me.cod_contrato);
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registrado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                    me.errors=error.response.data.errors;
                }
            });

            },

        actualizarIngreso(){

            this.errors=[];

            let me=this;

            axios.put('ingreso/update',{
                'cod_ingreso':this.cod_ingreso,
                'i_monto':this.i_monto,
                'concepto_cod_concepto':this.concepto_cod_concepto,
            }).then(function(response){
                    me.cerrarModalingreso();
                    me.listarIngresos(me.cod_contrato);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Actualizado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                    if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });

        },

        eliminarIngreso(id){
            
            let me=this;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
              
              swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de Actualizar?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, Actualizar',
                    cancelButtonText: 'No, Cancelar',
                    reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    axios.put('ingreso/destroy', {
                        'cod_ingreso': id
                    }).then(function (response) {
                        me.listarIngresos(me.cod_contrato);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
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
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cancelado, no se eliminó la selección',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
              })

        },

        cerrarModalbuscar(){
            this.modalbuscar=0;
            this.arrayPersonal=[];
            this.buscardni='';
        },

        abrirModalbuscar(){
            this.modalbuscar=1;
            this.limpiarbusqueda();
        },

        limpiarformularios(){
            this.cod_contrato='';
            this.c_numero='';
            this.c_plaza='';
            this.c_fech_contrato='';
            this.c_fech_ini='';
            this.c_fech_ter='';
            this.nivel_educativo='';
            this.area_a_cod_area=0;
            this.cargo_cod_cargo=0;
            this.tipo_trabajador_cod_tipo_trabajador=0;
            this.tipo_planilla_cod_tipo_planilla=0;
            this.clasificador_id=0;
            this.meta_m_cod_meta=0;
            this.regimen_laboral_cod_regimen_laboral=0;
            this.c_horas='';
            this.sus_renta=0;
            this.num_operacion='';
            this.aseguradora_cod_aseguradora=0;
            this.c_dias_lic='';
            this.c_dias_lab='';
            this.c_desc_dias='';
            this.c_desc_horas='';
            this.c_desc_min='';
            this.c_desc_perm='';
            this.c_observacion='';
            this.tipo_registro_airhsp_tra_id='',
            this.c_cod_reg_airhsp= '',
            this.sus_renta = false,
            this.num_operacion = '',
            this.personal_cod_personal=0;
            this.tipo_pago_cod_tipo_pago=0;
            this.estado_personal_cod_estado_personal=0;
            this.listarIngresos('');
            this.listarPagoocasional('');
            this.listarDescuentos('');
            this.listarBeneficiarios('');
        },

        abrirModalContrato(){
            if (this.cod_personal==""){
                Swal.fire('Debe seleccionar un personal','','info');
            }else{
                this.modalcontrato=1;
                this.limpiarformularios(); 
                this.errors=[];
            }  
        },

        

        abrirModalOcasional(modelo,accion,data=[]){
            if (this.cod_contrato==""){
                swal('Debe seleccionar un contrato','','info')
            }else{
                switch(modelo){
                    case "ocasional":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modalocasional=1;
                                this.tituloModalocasional='Registrar ocasional';
                                this.selectConceptos(3);
                                this.concepto_cod_concepto=0;
                                this.po_monto='';
                                this.po_inicio='';
                                this.po_termino='';
                                this.errors=[];
                                this.tipoAccionocasional=1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modalocasional=1;
                                this.tituloModalocasional="Actualizar ocasional";
                                this.selectConceptos(3);
                                this.tipoAccionocasional=2;
                                this.cod_ocasional=data['cod_pago_ocasional'];
                                this.po_monto=data['po_monto'];
                                this.po_inicio=data['po_inicio'];
                                this.po_termino=data['po_termino'];
                                this.concepto_cod_concepto=data['concepto_cod_concepto'];
                                this.errors=[];
                                break;
                            }
                        }
                    }

                    
                }
            }
        },

        cerrarModalocasional(){
            this.modalocasional=0;
            this.errors=[];
        },

        registrarOcasional(){

            this.errors=[];

            let me=this;

            axios.post('pagoocasional/store',{
                    'po_monto':this.po_monto,
                    'po_inicio':this.po_inicio,
                    'po_termino':this.po_termino,
                    'contrato_cod_contrato':this.cod_contrato,
                    'concepto_cod_concepto':this.concepto_cod_concepto,
            }).then(function(response){
                me.cerrarModalocasional();
                me.listarPagoocasional(me.cod_contrato);
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registrado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });

            },

        actualizarOcasional(){

            this.errors=[];

            let me=this;

            axios.put('pagoocasional/update',{
                'cod_pago_ocasional':this.cod_ocasional,
                'po_monto':this.po_monto,
                'po_inicio':this.po_inicio,
                'po_termino':this.po_termino,
                'concepto_cod_concepto':this.concepto_cod_concepto,
            }).then(function(response){
                    me.cerrarModalocasional();
                    me.listarPagoocasional(me.cod_contrato);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Actualizado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
                    
        },

    eliminarOcasional(id){
            
            let me=this;

            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {

                   axios.put('pagoocasional/destroy', {
                        'cod_pago_ocasional': id
                    }).then(function (response) {
                        me.listarPagoocasional(me.cod_contrato);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: '¡Eliminado!, Se Elimino Correctamente',
                            showConfirmButton: false,
                            timer: 1500
                            })
                    }).catch(function (error) {
                        console.log(error);
                    });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cancelado, no se eliminó la selección',
                    showConfirmButton: false,
                    timer: 1500
                    })
            }
            })
           

        },

    abrirModaldescuento(modelo,accion,data=[]){
            if (this.cod_contrato==""){
                swal('Debe seleccionar un contrato','','info')
            }else{
                switch(modelo){
                    case "descuento":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modaldescuento=1;
                                this.tituloModaldescuento='Registrar descuento';
                                this.selectConceptos(2);
                                this.concepto_cod_concepto=0;
                                this.d_monto='';
                                this.d_inicio='';
                                this.d_termino='';
                                this.tipoAcciondescuento=1;
                                this.errors=[];
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modaldescuento=1;
                                this.tituloModaldescuento="Actualizar ocasional";
                                this.selectConceptos(2);
                                this.tipoAcciondescuento=2;
                                this.cod_descuento=data['cod_descuento'];
                                this.d_monto=data['d_monto'];
                                this.d_inicio=data['d_inicio'];
                                this.d_termino=data['d_termino'];
                                this.concepto_cod_concepto=data['concepto_cod_concepto'];
                                this.errors=[];
                                break;
                            }
                        }
                    }

                    
                }
            }
        },

        cerrarModaldescuento(){
            this.modaldescuento=0;
            this.errors=[];
        },

        registrarDescuento(){

            this.errors=[];

            let me=this;

            axios.post('descuento/store',{
                    'd_monto':this.d_monto,
                    'd_inicio':this.d_inicio,
                    'd_termino':this.d_termino,
                    'contrato_cod_contrato':this.cod_contrato,
                    'concepto_cod_concepto':this.concepto_cod_concepto,
            }).then(function(response){
                me.listarDescuentos(me.cod_contrato);
                me.cerrarModaldescuento();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registrado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });

            },

        actualizarDescuento(){

            this.errors=[];

            let me=this;

            axios.put('descuento/update',{
                'cod_descuento':this.cod_descuento,
                'd_monto':this.d_monto,
                'd_inicio':this.d_inicio,
                'd_termino':this.d_termino,
                'concepto_cod_concepto':this.concepto_cod_concepto,
            }).then(function(response){
                    me.listarDescuentos(me.cod_contrato);
                    me.cerrarModaldescuento();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Actualizado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                    me.errors=error.response.data.errors;
                }
            });
        },

    eliminarDescuento(id){
            
            let me=this;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
              
                swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {

                    axios.put('descuento/destroy', {
                        'cod_descuento': id
                    }).then(function (response) {
                        me.listarDescuentos(me.cod_contrato);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: '¡Eliminado!, Se Elimino Correctamente',
                            showConfirmButton: false,
                            timer: 1500
                            })
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                  // Read more about handling dismissals
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cancelado, no se eliminó la selección',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
              })

        },

    abrirModalbeneficiario(modelo,accion,data=[]){
            if (this.cod_contrato==""){
                swal('Debe seleccionar un contrato','','info')
            }else{
                switch(modelo){
                    case "beneficiario":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.tipoAccionbeneficiario=1;
                                this.modalbeneficiario=1;
                                this.tituloModalbeneficiario='Registrar beneficiario';
                                this.selectTipodocumento();
                                this.selectBanco();
                                this.cod_beneficiario=0;
                                this.b_paterno='';
                                this.b_materno='';
                                this.b_nombres='';
                                this.b_tipo_documento_cod_tipo_documento=0;
                                this.b_numdoc='';
                                this.b_resjudicial='';
                                this.b_fechjudicial='';
                                this.b_fijo='';
                                this.b_porcentaje='';
                                this.b_tipo_pago_cod_tipo_pago=0;
                                this.b_banco_cod_banco=0;
                                this.b_cuenta='';
                                this.b_observacion='';
                                this.b_estado_idestado='01';
                                this.errors=[];
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.tipoAccionbeneficiario=2;
                                this.modalbeneficiario=1;
                                this.tituloModalbeneficiario="Actualizar Beneficiario";
                                this.selectTipodocumento();
                                this.selectBanco();
                                this.cod_beneficiario=data['cod_beneficiario'];
                                this.b_paterno=data['b_paterno'];
                                this.b_materno=data['b_materno'];
                                this.b_nombres=data['b_nombres'];
                                this.b_tipo_documento_cod_tipo_documento=data['tipo_documento_cod_tipo_documento'];
                                this.b_numdoc=data['b_numdoc'];
                                this.b_resjudicial=data['b_resjudicial'];
                                this.b_fechjudicial=data['b_fechjudicial'];
                                this.b_fijo=data['b_fijo'];
                                this.b_porcentaje=data['b_porcentaje'];
                                this.b_tipo_pago_cod_tipo_pago=data['tipo_pago_cod_tipo_pago'];
                                this.b_banco_cod_banco=data['banco_cod_banco'];
                                this.b_cuenta=data['b_cuenta'];
                                this.b_observacion=data['b_observacion'];
                                this.b_estado_idestado=data['estado_idestado'];
                                this.errors=[];
                                break;
                            }
                        }
                    }

                    
                }
            }
        },

        cerrarModalbeneficiario(){
            this.modalbeneficiario=0;
            this.errors=[];
        },

        registrarBeneficiario(){

            let me=this;

            axios.post('beneficiario/store',{
                    'b_paterno':this.b_paterno,
                    'b_materno':this.b_materno,
                    'b_nombres':this.b_nombres,
                    'tipo_documento_cod_tipo_documento':this.b_tipo_documento_cod_tipo_documento,
                    'b_numdoc':this.b_numdoc,
                    'b_resjudicial':this.b_resjudicial,
                    'b_fechjudicial':this.b_fechjudicial,
                    'b_fijo':this.b_fijo,
                    'b_porcentaje':this.b_porcentaje,
                    'tipo_pago_cod_tipo_pago':this.b_tipo_pago_cod_tipo_pago,
                    'banco_cod_banco':this.b_banco_cod_banco,
                    'b_cuenta':this.b_cuenta,
                    'b_observacion':this.b_observacion,
                    'contrato_cod_contrato':this.cod_contrato,
                    'estado_idestado':this.b_estado_idestado,
            }).then(function(response){
                me.cerrarModalbeneficiario();
                me.listarBeneficiarios(me.cod_contrato);
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registrado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });

            },

        actualizarBeneficiario(){

            let me=this;

            axios.put('beneficiario/update',{
                'cod_beneficiario':this.cod_beneficiario,
                'b_paterno':this.b_paterno,
                'b_materno':this.b_materno,
                'b_nombres':this.b_nombres,
                'tipo_documento_cod_tipo_documento':this.b_tipo_documento_cod_tipo_documento,
                'b_numdoc':this.b_numdoc,
                'b_resjudicial':this.b_resjudicial,
                'b_fechjudicial':this.b_fechjudicial,
                'b_fijo':this.b_fijo,
                'b_porcentaje':this.b_porcentaje,
                'tipo_pago_cod_tipo_pago':this.b_tipo_pago_cod_tipo_pago,
                'banco_cod_banco':this.b_banco_cod_banco,
                'b_cuenta':this.b_cuenta,
                'b_observacion':this.b_observacion,
                'contrato_cod_contrato':this.cod_contrato,
                'estado_idestado':this.b_estado_idestado,
            }).then(function(response){
                    me.cerrarModalbeneficiario();
                    me.listarBeneficiarios(me.cod_contrato);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Actualizado Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }).catch(function(error){
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

    eliminarBeneficiario(id){
            
            let me=this;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
              
                swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {

                    axios.put('beneficiario/destroy', {
                        'cod_beneficiario': id
                    }).then(function (response) {
                        me.listarBeneficiarios(me.cod_contrato);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: '¡Eliminado!, Se Elimino Correctamente',
                            showConfirmButton: false,
                            timer: 1500
                            })
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                  // Read more about handling dismissals
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cancelado, no se eliminó la selección',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
              })

        },

        cerrarModalcontrato(){
            this.modalcontrato=0;
           // this.cod_departamento='';
            //this.dep_departamento='';
        },

        abrirModalpago(data=[]){
           
            this.modalpago=1;
            this.p_periodo=data['pll_periodo'];
            this.p_cod_personal=data['cod_personal'];
            this.p_estado_civil_cod_estado_civil=data['estado_civil_cod_estado_civil'];
            this.p_c_fech_contrato=data['c_fech_contrato'];
            this.p_a_paterno=data['p_a_paterno'];
            this.p_admin_pension_cod_admin_pension=data['admin_pension_cod_admin_pension'];
            this.p_c_fech_ini=data['c_fech_ini'];
            this.p_a_materno=data['p_a_materno'];
            this.p_cuspp=data['p_cuspp'];
            this.p_c_fech_ter=data['c_fech_ter'];
            this.p_nombres=data['p_nombres'];
            this.p_fech_afiliacion=data['p_fech_afiliacion'];
            this.p_Establecimiento_cod_establecimiento=data['Establecimiento_cod_establecimiento'];
            this.p_s_sexo=data['s_sexo'];
            this.p_banco_cod_banco=data['banco_cod_banco'];
            this.p_regimen_laboral_cod_regimen_laboral=data['regimen_laboral_cod_regimen_laboral'];
            this.p_num_doc=data['p_num_doc'];
            this.p_num_cuenta=data['p_num_cuenta'];
            this.p_tipo_trabajador_cod_tipo_trab=data['tipo_trabajador_cod_tipo_trab'];
            this.p_fech_nac=data['p_fech_nac'];
            this.p_c_numero=data['c_numero'];
            this.p_c_horas=data['c_horas'];
            this.p_ruc=data['p_ruc'];
            this.p_c_plaza=data['c_plaza'];
            this.p_cargo_cod_cargo=data['cargo_cod_cargo'];
            this.arrayhaberes=data['planilla__conceptos'];
            this.dpll_bruto=data['dpll_bruto'];
            this.dpll_descuentos=data['dpll_descuentos'];
            this.dpll_aport=data['dpll_aport'];
            this.dpll_liquido=data['dpll_liquido'];
            this.dpll_base_calculo=data['dpll_base_calculo'];
        },

        cerrarModalpago(){
            this.modalpago=0;
        },


        },

        mounted() {
           this.selectEstadopersonal();
           this.selectArea();
           this.selectCargo();
           this.selectTipotrabajador();
           this.selectRegimenlaboral();
           this.selectMeta();
           this.selectTipopago();
           this.selectAseguradora();
           this.selectplaneps();
           this.selectcompfam();
           this.selectTipoPlanilla();
           this.selectTiporegistroairhsp();
            this.selectClasificador();
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

        .text-error{
          color: red !important;
          font-weight: bold;
        }

        .img-foto {
            width: 100%;
            height: 100%;
        }


        .btitulo1{
            font-weight: bold;
            font-size: 12px;
            }

            .btitulo2{
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            }

            .btitulo3{
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 10px;
            text-align: center;
            }


        .tablarep {
                border-collapse: collapse;
                width: 100%;
            }

            .bordesuperior {
                border-top: 1px solid #000;
            }

            .bordeinferior {
                border-bottom: 1px solid #000;
            }

            .bordederecha {
                border-right: 1px solid #000;
            }

            .bordeizquierda {
                border-left: 1px solid #000;
            }

            .tablarep td, #tablarep th {
                /*border: 1px solid #ddd;*/
                padding: 2px;
                font-size: 12px;
                width: 16.66%;
            }

        .tablarep th {
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #4CAF50;
                font-size: 10px;
                color: white;
        }
        
        .detallemontos{
            vertical-align: top;
        }

        .datospersonales{
            margin: 10px 0;
        }

        .montos{
            margin: 5px 0;
            height: 220px;
        }

        .totales{
            margin-bottom: 15px;
            height: 55px;
            width: 100%;
        }

        .alinearnumero{
            text-align: right;
        }

        .tabladet td, #tabladet th {
                font-size: 12px;
                width: 100%;
            }

        .mensajes{
            margin-bottom: 10px 0;
            width: 100%;
        }

        .checkbox-css{
            padding-top: 28px;
        }

        .no-gutters {
            height: 200px;
            margin-right: 10px;
            margin-left: 10px;
            margin-bottom: 10px;
            border:solid;
            border-width: .2px;
            border-color:#F1F1F1;
            border-radius: .5px;
            display: flex;
        }

        .div-imagen {
            width: 150px;
            height: 100%;
            padding: 10px 5px;
        }

        .card-img{
            width: 100%;
            height: 100%;
        }

</style>
