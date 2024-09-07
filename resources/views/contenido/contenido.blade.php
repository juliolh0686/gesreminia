@extends('principal')

@section('contenido')
    <template v-if="menu==0">
    <escritorio></escritorio>
    </template>

    <template v-if="menu==1">
    <personal></personal>
    </template>

    <template v-if="menu==2">
        <contratos></contratos>
    </template>

    <template v-if="menu==3">
        <planilla></planilla>
    </template>

    <template v-if="menu==4">
        <aporcomprim-component></aporcomprim-component>
    </template>

    <template v-if="menu==6">
        <declaracion></declaracion>
    </template>

    <template v-if="menu==7">
        <boletas></boletas>
    </template>

    <template v-if="menu==8">
        <operaciones></operaciones>
    </template>

    <template v-if="menu==9">
        <usuarios></usuarios>
    </template>

    <template v-if="menu==10">
        <roles></roles>
    </template>

    <template v-if="menu==11">
        <depart-component></depart-component>
    </template>

    <template v-if="menu==12">
        <compriafp></compriafp>
    </template>

    <template v-if="menu==13">
        <compromiso></compromiso>
    </template>

    <template v-if="menu==14">
        <mcpp></mcpp>
    </template>

    <template v-if="menu==15">
        <generarplanilla></generarplanilla>
    </template>

    <template v-if="menu==16">
        <importinastar></importinastar>
    </template>

    <template v-if="menu==17">
        <uejecutora-component></uejecutora-component>
    </template>

    <template v-if="menu==18">
        <parametros-component></parametros-component>
    </template>

    <template v-if="menu==19">
        <tipodoc-component></tipodoc-component>
    </template>

    <template v-if="menu==20">
        <sexo-component></sexo-component>
    </template>

    <template v-if="menu==21">
        <estadocivil-component></estadocivil-component>
    </template>

    <template v-if="menu==22">
        <provincia-component></provincia-component>
    </template>

    <template v-if="menu==23">
        <users-component></users-component>
    </template>

    <template v-if="menu==24">
        <modpermissions-component></modpermissions-component>
    </template>

    <template v-if="menu==25">
        <roles-component></roles-component>
    </template>

    <template v-if="menu==26">
        <distrito-component></distrito-component>
    </template>

    <template v-if="menu==28">
        <regpension-component></regpension-component>
    </template>

    <template v-if="menu==29">
        <adminpen-component></adminpen-component>
    </template>

    <template v-if="menu==30">
        <banco-component></banco-component>
    </template>

    <template v-if="menu==31">
        <reglaboral-component></reglaboral-component>
    </template>

    <template v-if="menu==32">
        <area-component></area-component>
    </template>

    <template v-if="menu==33">
        <cargo-component></cargo-component>
    </template>

    <template v-if="menu==34">
        <meta-component></meta-component>
    </template>

@endsection