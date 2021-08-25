<template>
   <div>
      <h2>Top Frequently Asked Questions</h2>
      <div v-for="(faq,index) in faqs" :key="index"> 
      <div class="card bg-gradient-light text-dark collapsed-card">
         <div class="card-header border-0 ui-sortable-handle" data-card-widget="collapse" style="cursor: move;">
            <h3 class="card-title">
            <button type="button" class="btn btn-light btn-sm" data-card-widget="collapse" title="Collapse">
               <i class="fas fa-plus"></i>
            </button>
               {{faq.question}}
            </h3>
         </div>
         <div class="card-body" style="display: none;">
            {{faq.answer}}
         </div>
      </div>
         
         
      </div>
   </div>
</template>

<script>
export default {
   name:'welcome-faq',
   data(){
      return{
         faqs:[],
      }
   },
 created(){
    axios.get('/api/faqs').then(resp => {
       console.log(resp)
       if(resp.data.status ==200){
          this.faqs=resp.data.faqs
       }
    }).catch(err=>{
       console.log(err)
    })
 } 
}
</script>

<style 
Buttonscoped>

</style>