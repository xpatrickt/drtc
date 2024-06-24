<template>
  <div class="col-12 d-flex flex-wrap align-items-center pt-5 pxa-5" >
    <div class="col-12 col-sm-6 pb-5" @click.prevent="redireccionar('InicioGestion')">
      <div class="card-content">
        <div class="card-body pb-0 pt-0 color-white">
          <div class="row justify-content-center">
              <div class="col-10 col-xl-6 col-lg-8 col-md-8 align-items-center justify-content-center text-center shadow-sm bg-white text-dark rounded-lg ">
                <img :src="$baseUrlVue('img/auth/gestionp.png')" alt="" class="mt-3"/>
                <h5 class="my-4 font-weight-bold">
                  GESTIÓN DE PROYECTOS
                </h5>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 pb-5" @click.prevent="redireccionar('InicioAvance')">
      <div class="card-content">
        <div class="card-body pb-0 pt-0 color-white">
          <div class="row justify-content-center">
              <div class="col-10 col-xl-6 col-lg-8 col-md-8 align-items-center justify-content-center text-center shadow-sm bg-white text-dark rounded-lg ">
                <img :src="$baseUrlVue('img/auth/avance.jpg')" alt="" class="mt-3"/>
                <h5 class="my-4 font-weight-bold">
                  AVANCE DE PROYECTOS
                </h5>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 pb-5" @click.prevent="redireccionar('InicioSeguimiento')">
      <div class="card-content">
        <div class="card-body pb-0 pt-0 color-white">
          <div class="row justify-content-center">
              <div class="col-10 col-xl-6 col-lg-8 col-md-8 align-items-center justify-content-center text-center shadow-sm bg-white text-dark rounded-lg ">
                <img :src="$baseUrlVue('img/auth/seguimiento.jpg')" alt="" class="mt-3"/>
                <h5 class="my-4 font-weight-bold">
                  SEGUIMIENTO Y REPORTES
                </h5>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 pb-5" @click.prevent="redireccionar('InicioConfiguracion')">
      <div class="card-content">
        <div class="card-body pb-0 pt-0 color-white">
          <div class="row justify-content-center">
              <div class="col-10 col-xl-6 col-lg-8 col-md-8 align-items-center justify-content-center text-center shadow-sm bg-white text-dark rounded-lg ">
                <img :src="$baseUrlVue('img/auth/administracion.jpg')" alt="" class="mt-3"/>
                <h5 class="my-4 font-weight-bold">
                  ADMINISTRACIÓN Y CONFIGURACIÓN
                </h5>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data(){
    return{
      recuerdame: false,
      tipo:  this.$store.getters.getAuthUser('rol')
    }
  },
  created(){
  },
  methods:{
    redireccionar(name){
      this.$router.push({name: name})
    },
  },
}
</script>

<style scoped>
.minh-100 {
  height: 100vh;
}
.l-auth li{
    margin-top:25px;
}
.mt-3{
width: 80%;
}

.pxa-5{
    padding-right: 10%;
    padding-left: 10%;
}
</style>
