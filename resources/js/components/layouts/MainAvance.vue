<template>
    <div class="principal">
        <nav class="navbar navbar-expand-lg fixed-top shadow header-personal">
        <!-- <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light shadow" style="border: 3px solid #2FEAF0"> -->
            <a class="navbar-brand" href="#"  @click.prevent="redireccionar('InicioGestion')">

                <img :src="$baseUrlVue('img/logo/logotipo-version-5.png')"  height="40" class="d-inline-block align-top" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav mr-auto ml-2">

                </ul>

                <div class="row">
                    <span class="row col-6 col-sm-6 col-md-6 col-lg-9 text-right">
                        <strong class="col-12 align-self-center"  v-text="getUserName('nombres')"></strong>
                    </span>
                    <div class="btn-group ml-0 col-6 col-sm-6 col-md-6 col-lg-3 text-center">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-online">
                            <img :src="$baseUrlVue(getAvatar())" class="rounded-circle" alt="avatar" width="40" height="40"/>
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button" @click="cerrarSesion">Cerrar sesión</button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row flex-xl-nowrap">

                <div class="col-12 col-md-3 col-xl-2 bd-sidebar p-0">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header p-0" id="headingOne">
                                <h6 class="mb-0">
                                    <button class="btn btn-light w-100 text-left font-weight-bold p-menu" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="font-size:20px;">
                                        <i class="fa fa-indent w-ico me-3"></i>AVANCE DE PROYECTOS
                                    </button>
                                </h6>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <ul class="list-unstyled ps-0" style="font-size:20px;">
                                    <!-- <li class="mb-1" >
                                        <a class="nav-link" href="#" @click.prevent="redireccionar('InicioAdmin')">
                                            <i class="fa fa-home  me-3"></i>Inicio
                                        </a>
                                    </li> -->
                                    

                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Tarea')">
                                            <i class="fas fa-tag me-3"></i>Actividades
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('SubTarea')">
                                            <i class="fas fa-tag me-3"></i>Tareas
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
  
                    </div>
                </div>
                <!-- <div class="d-none d-xl-block col-xl-2 bd-toc">
                    <sidebar-aportar></sidebar-aportar>
                </div> -->
                <main class="col-12 col-md-9 col-xl-10 bd-content" role="main">
                    <router-view :key="$route.params.id"> </router-view>
                </main>
            </div>

        </div>

    </div>
</template>

<script>

import Crypt from "../../services/Crypt";

export default {
    name: 'Main',
    data(){
        return {
            usuario: '',
            infoAyuda:{
                    mostrar: false,
                    titulo: 'Ayuda',
                    contenido: [
                        {titulo: '.', imagen:'ayuda_inicio.png', descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis augue ac porttitor interdum. Aenean cursus eros imperdiet ante aliquet imperdiet.', activo:'active',},
                        {titulo: '.', imagen:'ayuda_inicio.png', descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis augue ac porttitor interdum.', activo:'false',},
                    ]
                }
        }
    },
    mounted(){
        this.init();
    },
    methods:{
        init(){
            if(!this.$store.getters.getAuthUser('identificador')){
                axios.get("api/auth/user")
                .then((response) => {
                    console.log(response);
                    let usuario = response.data;
                    this.$store.dispatch('setAuthUserDetail',{//aqui extrae la info el usuario y lo asigno a la variable
                        identificador: Crypt.encrypt(usuario.id),
                        email: usuario.email,
                        nombres: usuario.persona.nombres,
                        apellidos: usuario.persona.apellido_pat+' '+usuario.persona.apellido_mat,
                        usuario: usuario.usuario,
                        avatar: usuario.avatar,
                        rol: usuario.tipo_usuario
                    });

                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                    this.cerrarSesion();
                    return false;
                });
            } 
        },
        validarPermisos(rol){
            if(this.$store.getters.getAuthUser('rol') >= rol){
                return true;
            }
            return false;
        },
        redireccionar(name){
            this.$router.push({name: name})
        },
        getUserName(name){
            return this.$store.getters.getAuthUserNameComplete();
        },
        getAvatar(){
            let avatar = this.$store.getters.getAuthUser('avatar');
            if(avatar)
                return 'user/users/' + avatar;
            return 'img/auth/user-alt.png';
        },
        cerrarSesion(){
            axios.post('api/auth/logout').then(response => {
                localStorage.removeItem('token_linkedin');
                localStorage.removeItem('token_laravel');
                this.$store.dispatch('resetAuthUserDetail');
                this.$router.push('/login');
                axios.defaults.headers.common['Authorization'] = null;
                this.$toastr.s(response.data.message);
                return true;
            }).catch(error => {
                console.log(error);
                return false;
            });
        },

    }
}
</script>

<style>

    .p-menu{
        padding: 1rem 0.5rem 1rem 1rem;
    }
    .w-ico{
        width: 1em!important;
    }
  
</style>
