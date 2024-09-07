<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard','DashboardController');

//Routes
//Route::middleware(['auth'])->group(function(){

        //Users

        Route::get('user','UserController@index')->name('user.index');

        //Roles
        
        Route::get('roles','RoleController@index')->name('roles.index');
        Route::get('role/userrole','RoleController@userRole')->name('role.userrole');
        Route::put('roles/update','RoleController@updateRoles')->name('roles.update');
        Route::post('role/store','RoleController@store')->name('role.store');
        Route::put('role/update','RoleController@update')->name('role.update');
        Route::put('role/destroy','RoleController@destroy')->name('role.destroy');

        //Permissions

        Route::get('permissions','PermissionController@index')->name('permissions.index');
        Route::get('permission/listPermissions','PermissionController@listPermissions')->name('permission.listPermissions');
        Route::put('permissions/update','PermissionController@updatePermissions')->name('permissions.update');

        //Personal
    
        Route::get('personal','PersonalController@index')->name('personal.index');

        Route::post('personal/store','PersonalController@store')->name('personal.store');
        
        Route::put('personal/update','PersonalController@update')->name('personal.update');

        Route::get('personal/reportepersonal','PersonalController@Reportepersonal')->name('personal.reportepersonal');
        
        Route::get('personal/reportepersonalexcel','PersonalController@Reportepersonalexcel')->name('personal.reportepersonalexcel');

        //Tipo de Documento

        Route::get('tipodoc/index','TipodocumentoController@index')->name('tipodoc.index');
        
        Route::post('tipodoc/store','TipodocumentoController@store')->name('tipodoc.store');
        
        Route::put('tipodoc/update','TipodocumentoController@update')->name('tipodoc.update');
        
        Route::put('tipodoc/destroy','TipodocumentoController@destroy')->name('tipodoc.destroy');

        Route::get('tipodocumento/selectTipodocumento','TipodocumentoController@selectTipodocumento')->name('tipodocumento.selectTipodocumento');

        //Sexo
        Route::get('sexo/index','SexoController@index')->name('sexo.index');

        Route::post('sexo/store','SexoController@store')->name('sexo.store');

        Route::put('sexo/update','SexoController@update')->name('sexo.update');
        
        Route::put('sexo/destroy','SexoController@destroy')->name('sexo.destroy');

        Route::get('sexo/selectSexo','SexoController@selectSexo')->name('sexo.selectSexo');

        //Estado Civil

        Route::get('estadocivil/index','EstadocivilController@index')->name('estadocivil.index');

        Route::post('estadocivil/store','EstadocivilController@store')->name('estadocivil.store');

        Route::put('estadocivil/update','EstadocivilController@update')->name('estadocivil.update');

        Route::put('estadocivil/destroy','EstadocivilController@destroy')->name('estadocivil.destroy');

        Route::get('estadocivil/selectEstadocivil','EstadocivilController@selectEstadocivil')->name('estadocivil.selectEstadocivil');

        
        //Departamentos
    
        Route::get('departamento/index','DepartamentoController@index')->name('departamento.index');

        Route::post('departamento/store','DepartamentoController@store')->name('departamento.store');

        Route::put('departamento/update','DepartamentoController@update')->name('departamento.update');

        Route::put('departamento/destroy','DepartamentoController@destroy')->name('departamento.destroy');
        
        Route::get('departamentos/selectDepartamento','DepartamentoController@selectDepartamento')->name('departamentos.selectDepartamento');

        //Provincia
        Route::get('provincia/index','ProvinciaController@index')->name('provincia.index');
        
        Route::post('provincia/store','ProvinciaController@store')->name('provincia.store');
        
        Route::put('provincia/update','ProvinciaController@update')->name('provincia.update');

        Route::put('provincia/destroy','ProvinciaController@destroy')->name('provincia.destroy');

        Route::get('provincia/selectProvincia','ProvinciaController@selectProvincia')->name('provincia.selectProvincia');
                
        //Distrito
        Route::get('distrito/index','DistritoController@index')->name('distrito.index');
        
        Route::post('distrito/store','DistritoController@store')->name('distrito.store');
        
        Route::put('distrito/update','DistritoController@update')->name('distrito.update');

        Route::put('distrito/destroy','DistritoController@destroy')->name('distrito.destroy');

        Route::get('distrito/selectDistrito','DistritoController@selectDistrito')->name('distrito.selectDistrito');

        //Regimen Pension
        Route::get('regimenpension/selectRegimenpension','RegimenpensionController@selectRegimenpension')->name('regimenpension.selectRegimenpension');

        Route::get('regimenpension/index','RegimenpensionController@index')->name('regimenpension.index');

        Route::post('regimenpension/store','RegimenpensionController@store')->name('regimenpension.store');

        Route::put('regimenpension/update','RegimenpensionController@update')->name('regimenpension.update');

        Route::put('regimenpension/destroy','RegimenpensionController@destroy')->name('regimenpension.destroy');
        
        //Admin Pension
        Route::get('adminpension/index','AdminpensionController@index')->name('adminpension.index');

        Route::post('adminpension/store','AdminpensionController@store')->name('adminpension.store');

        Route::get('adminpension/selectAdminpension','AdminpensionController@selectAdminpension')->name('adminpension.selectAdminpension');
        
        Route::get('adminpension/adminpensiones','AdminpensionController@Adminpensiones')->name('adminpension.adminpensiones');

        Route::put('adminpension/update','AdminpensionController@update')->name('adminpension.update');

        Route::put('adminpension/destroy','AdminpensionController@destroy')->name('adminpension.destroy');

        //Banco
        Route::get('banco/index','BancoController@index')->name('banco.index');

        Route::post('banco/store','BancoController@store')->name('banco.store');

        Route::put('banco/update','BancoController@update')->name('banco.update');

        Route::put('banco/destroy','BancoController@destroy')->name('banco.destroy');

        Route::get('banco/selectBanco','BancoController@selectbanco')->name('banco.selectbanco');

        //Estado Personal
        Route::get('estadopersonal/selectEstadopersonal','EstadopersonalController@selectEstadopersonal')->name('estadopersonal.selectEstadopersonal');

        //Ingreso
        Route::get('ingreso/listIngreso','IngresoController@listIngreso')->name('ingreso.listIngreso');
        
        Route::post('ingreso/store','IngresoController@store')->name('ingreso.store');

        Route::put('ingreso/update','IngresoController@update')->name('ingreso.update');
        
        Route::put('ingreso/destroy','IngresoController@destroy')->name('ingreso.destroy');
        
        //Pago ocasional
        Route::get('pagoocasional/listPagoocasional','PagoocasionalController@listPagoocasional')->name('pagoocasional.listPagoocasional');
        
        Route::post('pagoocasional/store','PagoocasionalController@store')->name('pagoocasional.store');
        
        Route::put('pagoocasional/update','PagoocasionalController@update')->name('pagoocasional.update');
           
        Route::put('pagoocasional/destroy','PagoocasionalController@destroy')->name('pagoocasional.destroy');

        //Descuentos
        Route::get('descuentos/listDescuentos','DescuentosController@listDescuentos')->name('descuentos.listDescuentos');
        
        Route::post('descuento/store','DescuentosController@store')->name('descuento.store');
        
        Route::put('descuento/update','DescuentosController@update')->name('descuento.update');
           
        Route::put('descuento/destroy','DescuentosController@destroy')->name('descuento.destroy');

        //Beneficiarios
        Route::get('beneficiario/listBeneficiarios','BeneficiarioController@listBeneficiarios')->name('beneficiario.listBeneficiarios');
        
        Route::post('beneficiario/store','BeneficiarioController@store')->name('beneficiario.store');
 
        Route::put('beneficiario/update','BeneficiarioController@update')->name('beneficiario.update');
    
        Route::put('beneficiario/destroy','BeneficiarioController@destroy')->name('beneficiario.destroy');

        //area
        Route::get('are/selectarea','AreaController@selectArea')->name('are.selectarea');

        Route::get('area/index','AreaController@index')->name('area.index');

        Route::post('area/store','AreaController@store')->name('area.store');

        Route::put('area/update','AreaController@update')->name('area.update');

        Route::put('area/destroy','AreaController@destroy')->name('area.destroy');

        //Cargos
        Route::get('cargo/selectcargo','CargoController@selectCargo')->name('cargo.selectCargo');

        Route::get('cargo/index','CargoController@index')->name('cargo.index');

        Route::post('cargo/store','CargoController@store')->name('cargo.store');

        Route::put('cargo/update','CargoController@update')->name('cargo.update');

        Route::put('cargo/destroy','CargoController@destroy')->name('cargo.destroy');

        //Tipo Trabajador
        Route::get('tipotrabajador/selectTipotrabajador','TipotrabajadorController@selectTipotrabajador')->name('tipotrabajador.selectTipotrabajador');
        
        //Meta
        Route::get('meta/selectMeta','MetaController@selectMeta')->name('meta.selectMeta');

        Route::get('meta/index','MetaController@index')->name('meta.index');

        Route::post('meta/store','MetaController@store')->name('meta.store');

        Route::put('meta/update','MetaController@update')->name('meta.update');

        Route::put('meta/destroy','MetaController@destroy')->name('meta.destroy');

        //Clasificador
        Route::get('clasificador/selectClasificador','ClasificadorController@selectClasificador')->name('clasificador.selectClasificador');

        //Tipo de pago
        Route::get('tipopago/selectTipopago','TipopagoController@selectTipopago')->name('tipopago.selectTipopago');

        //Regimen Laboral
        Route::get('regimenlaboral/selectRegimenlaboral','RegimenlaboralController@selectRegimenlaboral')->name('regimenlaboral.selectRegimenlaboral');

        Route::get('regimenlaboral/index','RegimenlaboralController@index')->name('regimenlaboral.index');

        Route::post('regimenlaboral/store','RegimenlaboralController@store')->name('regimenlaboral.store');

        Route::put('regimenlaboral/update','RegimenlaboralController@update')->name('regimenlaboral.update');

        Route::put('regimenlaboral/destroy','RegimenlaboralController@destroy')->name('regimenlaboral.destroy');

         //Contratos
    
        Route::get('contratos','ContratosController@index')->name('contratos.index');

        Route::post('contratos/store','ContratosController@store')->name('contratos.store');
        
        Route::put('contratos/update','ContratosController@update')->name('contratos.update');
      
        Route::put('contratos/restablecer','ContratosController@restablecercontratos')->name('contratos.restablecercontratos');

        Route::put('contratos/aguimasivo','ContratosController@aguinaldoMasivo')->name('contratos.aguimasivo');


        //Concepto
        Route::get('concepto/selectConcepto','ConceptoController@selectConcepto')->name('concepto.selectConcepto');
        
        //Planilla
    
        Route::get('planilla','PlanillaController@index')->name('planilla.index');

        Route::get('planillascerradas','PlanillaController@Planillascerradas')->name('planilla.planillascerradas');

        Route::post('planilla/store','PlanillaController@store')->name('planilla.store');
        
        Route::put('planilla/update','PlanillaController@update')->name('planilla.update');

        Route::put('planilla/destroy','PlanillaController@destroy')->name('planilla.destroy');

        Route::post('planilla/procesarplanilla','PlanillaController@Procesarplanilla')->name('planilla.Procesarplanilla');
        
        Route::post('planilla/cerrarplanilla','PlanillaController@Cerrarplanilla')->name('planilla.cerrarplanilla');
        
        Route::post('planilla/limpiarplanilla','PlanillaController@Limpiarplanilla')->name('planilla.limpiarplanilla');
        
        Route::get('planilla/generarboletas','PlanillaController@Generarboletas')->name('planilla.generarboletas');

        Route::get('planilla/generarboletasperiodo','PlanillaController@Generarboletasperiodo')->name('planilla.generarboletasperiodo');

        Route::get('planilla/generarboletasperiodov2','PlanillaController@Generarboletasperiodov2')->name('planilla.generarboletasperiodov2');

        Route::get('planilla/generarresumen','PlanillaController@GenerarResumen')->name('planilla.generarResumen');

        Route::get('planilla/generarinterface','PlanillaController@GenerarInterface')->name('planilla.generarinterface');

        Route::get('planilla/generarinterfacemcppweb','PlanillaController@GenerarInterfacemcppweb')->name('planilla.generarinterfacemcppweb');
        
        Route::get('planilla/generararchivoPDT','PlanillaController@GenerarArchivoPDT')->name('planilla.generararchivoPDT');

        Route::get('planilla/generararchivoPDTexcel','PlanillaController@GenerarArchivoPDTexcel')->name('planilla.generararchivoPDTexcel');
        
        Route::get('planilla/GenerarArchivoAFPNet','PlanillaController@GenerarArchivoAFPNet')->name('planilla.GenerarArchivoAFPNet');

        Route::get('planilla/PagosContrato','PlanillaController@PagosContrato')->name('planilla.PagosContrato');

        Route::get('planilla/ImportInasTarPer','PlanillaController@ImportInasTarPer')->name('planilla.ImportInasTarPer');

        Route::get('planilla/planilladescuentos','PlanillaController@PlanillaDescuentos')->name('planilla.planilladescuentos');
        
        Route::get('planilla/planillaaportes','PlanillaController@PlanillaAportes')->name('planilla.planillaaportes');
        
        Route::get('planilla/afp','PlanillaController@PlanillaAfp')->name('planilla.planillaafp');

        Route::get('planilla/afpresumen','PlanillaController@PlanillaAfpresumen')->name('planilla.planillaafpresumen');
        
        //Detalle PLanillas
    
        Route::get('detalleplanilla','DetalleplanillaController@index')->name('detalleplanilla.index');

        Route::get('detalleplanilla/rp_DetallePlanilla','DetalleplanillaController@Rp_DetallePlanilla')->name('detalleplanilla.rp_DetallePlanilla');

        Route::get('detalleplanilla/Rp_DetallePlanillaExcel','DetalleplanillaController@Rp_DetallePlanillaExcel')->name('detalleplanilla.Rp_DetallePlanillaExcel');

        //Aseguradora
        Route::get('aseguradora','AseguradoraController@selectAseguradora')->name('aseguradora');

        //Detalle ComPriSeg
        Route::get('compriseg/periodos','ComprisegController@Periodoscps')->name('compriseg.periodos');

        Route::get('compriseg/compriseg','ComprisegController@Compriseg')->name('compriseg.compriseg');

        Route::put('compriseg/update','ComprisegController@update')->name('compriseg.update');

        //Tipo de Planilla
        Route::get('planilla/selecttipoplanilla','TipoplanillaController@selectTipoplanilla')->name('planilla.selectTipoplanilla');

        //Tipo de Planilla
        Route::get('planilla/selectclaseplanilla','ClaseplanillaController@selectClaseplanilla')->name('planilla.selectClaseplanilla');

        //Plan EPS
        Route::get('plan_eps/selectplaneps','PlanepsController@selectPlaneps')->name('plan_eps.selectplaneps');

        //Composicion Familiar
        Route::get('compfam/selectcompfam','CompfamController@selectCompfam')->name('compfam.selectcompfam');
        
        //Unidad Ejecutora
        Route::get('uejecutora/index','UejecutoraController@index')->name('uejecutora.index');
                
        Route::post('uejecutora/store','UejecutoraController@store')->name('uejecutora.store');
        
        Route::post('uejecutora/update','UejecutoraController@update')->name('uejecutora.update');

        //Unidad Ejecutora
        Route::get('parametros/index','ParametrosController@index')->name('parametros.index');

        Route::post('parametros/store','ParametrosController@store')->name('parametros.store');
        
        Route::put('parametros/update','ParametrosController@update')->name('parametros.update');
        
        Route::put('parametros/destroy', 'ParametrosController@destroy')->name('parametros.destroy');

        //Planilla Judicial

        Route::get('planilla/planillajudicial','PlanillajudicialController@RepJudicialPDF');

        //Regimen Laboral
        Route::get('registroAirhsp/selectTiporegistroairhsp','TiporegistroairhspController@selectTiporegistroairhsp')->name('registroAirhsp.selectTiporegistroairhsp');


//});