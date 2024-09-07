<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                
                  <li><a><i class="fa fa-users"></i>Trabajador<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    @can('index.personal')
                      <li @click="menu=1"><a href="#">Datos Personales y Laborales</a></li>
                    @endcan
                    @can('index.contratos')
                      <li @click="menu=2"><a href="#">Contratos</a></li>
                    @endcan
                    </ul>
                  </li>
                
                  <li><a><i class="fa fa-calculator"></i>Planillas<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    @can('index.afp')
                      <li @click="menu=29"><a href="#">Aportaciones, Comisiones y Primas</a></li>
                    @endcan
                    @can('index.planilla')
                      <li @click="menu=3"><a href="#">Gestionar Planilla</a></li>
                    @endcan
                    </ul>
                  </li>
                  
                  @can('index.reportes')
                  <li><a><i class="fa fa-file-text-o"></i>Generar<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      <li @click="menu=13"><a href="#">Compromiso</a></li>
                      
                      <li @click="menu=14"><a href="#">SIAF-MCPP</a></li>
                      <li @click="menu=15"><a href="#">Planilla</a></li>
                      <li @click="menu=6"><a href="#">Declaración</a></li>
                      <li @click="menu=7"><a href="#">Boletas</a></li>
                    </ul>
                  </li>
                  @endcan
                  
                  @can('index.herramientas')
                  <li><a><i class="fa fa-cubes"></i>Herramientas<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <!-- <li @click="menu=16"><a href="#">Inasistencias y Tardanzas</a></li> -->
                      <li @click="menu=8"><a href="#">Operaciones Masivas</a></li>
                    </ul>
                  </li>
                  @endcan
                  
                </ul>
              </div>
              @can('index.configuracion')
              <div class="menu_section">
                
                <h3>Configuración</h3>
                
                
                <ul class="nav side-menu">

                <li @click="menu=17"><a href="#"><i class="fa fa-building"></i>Unidad Ejecutora</a></li>

                <li @click="menu=18"><a href="#"><i class="fa fa-sliders"></i>Parametros</a></li>

                
                <li><a><i class="fa fa-table"></i>Datos Personales<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li @click="menu=19"><a href="#">Tipo de Documento</a></li>
                      <li @click="menu=20"><a href="#">Sexo</a></li>
                      <li @click="menu=21"><a href="#">Estado Civil</a></li>
                      <li @click="menu=11"><a href="#">Departamentos</a></li>
                      <li @click="menu=22"><a href="#">Provincia</a></li>
                      <li @click="menu=26"><a href="#">Distrito</a></li>
                    </ul>
                </li>
                
               
                <li><a><i class="fa fa-suitcase" aria-hidden="true"></i>Datos Laborales<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li @click="menu=28"><a href="#">Regimen de Pensión</a></li>
                      <li @click="menu=29"><a href="#">Administradora de Pensión</a></li>
                      <li @click="menu=30"><a href="#">Banco</a></li>
                      <li @click="menu=31"><a href="#">Regimen Laboral</a></li>
                      <li @click="menu=32"><a href="#">Área</a></li>
                      <li @click="menu=33"><a href="#">Cargo</a></li>
                      <li @click="menu=34"><a href="#">Meta</a></li>
                    </ul>
                  </li>
             
                  @can('super-Admin')
                  <li><a><i class="fa fa-user"></i>Administración<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    <li><a @click="menu=23">Usuarios</a></li>
                    <li><a @click="menu=24">Permisos</a></li>
                    <li><a @click="menu=25">Roles</a></li>
                    </ul>
                  </li>
                  @endcan
                </ul>
              </div>
              @endcan

            </div>