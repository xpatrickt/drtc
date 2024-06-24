<template>
    <div class="row mt-3">
        <div class="col-md-6 offset-3">
            <div class="card border border-dark">
                <div class="card-header bg-dark">
                    <div class="card-body">
                        <Bar :chart-options="chartOptions" :chart-data="charData"></Bar>
                    </div>
                </div>
            </div>
        </div>
     </div>   
  </template>
  
  <script>
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
  
  export default {
  name: 'BarChart',
  components: { Bar },
  props:{
    chartId:{
        type: String,
        default: 'bar-chart'
    }
  },
  data() {
    return {
      etiquetas:[],valores:[],charData:[],
      chartOptions: {
        responsive: true
      }
    }
  },
  async mounted(){
    const totales=await axios.get('http://laraprododucts.run/api/totales');
    totales.data.map((row)=>(
    this.etiquetas.push(row.producto),
    this.valores.push(row.total)
    ))
    this.charData={
        labels:this.etiquetas,
        datasets:[
            {label:'Productos',data:this.valores,backgroundColor:'#f87979'}
        ]
    }
  }
}
  </script>