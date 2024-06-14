<template>
    <div class="p-3 pt-5">
        <h4 class="text-color-2 mb-3">GESTIÓN DE PROYECTOS</h4>
        <hr>
        <div class="row justify-content-md-center">
            <img :src="$baseUrlVue('img/auth/gestion.png')" alt="" class="mt-3 opacity-10"/>
           <!-- <div class="col-md-4">
                <div class="form-group text-center">
                    <label for="">Usuarios</label>
                    <br>
                    <h1 style="font-weight: 900; font-size: 50px;" v-text="cantidadUsuarios"></h1>
                </div>
            </div>  
            <div class="col-md-4">
                <div class="form-group text-center">
                    <label for="">Contenido</label>
                    <br>
                    <h1 style="font-weight: 900; font-size: 50px;" v-text="cantidadContenidos"></h1>
                </div>
            </div> -->
        </div>
        <!-- <hr> -->
        <!-- <div class="row justify-content-md-center">
            <div class="col-md-4">
                <div class="form-group text-center">
                    <chart v-if="cargaCompleta"
                        :key="1"
                        :dataSet="doughnutChart1"
                        :keyChart="1"
                    >
                    </chart>
                    Total preguntas: <span v-text="cantidadPreguntas"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group text-center">
                    <chart v-if="cargaCompleta"
                        :key="2"
                        :dataSet="doughnutChart2"
                        :keyChart="2"
                    >
                    </chart>
                    Total contenido: <span v-text="cantidadContenidos"></span>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="form-group text-center">
                    <chart v-if="cargaCompleta"
                        :key="3"
                        :dataSet="doughnutChart3"
                        :keyChart="3"
                    >
                    </chart>
                    Total usuarios: <span v-text="cantidadUsuarios"></span>
                </div>
            </div> 
        </div> -->
    </div>
</template>