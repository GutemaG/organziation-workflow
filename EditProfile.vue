<template>
<div style="width: 100%">
    
        <div v-show="sucessMessage!=null" class="alert alert-sucess alert-message mt-2 mb-2">

            {{ sucessMessage }}

          </div>
    <h2 class="text-center mb-5">{{se('edit_pro1')}}</h2>
    <div id="message_display" class="mb-3"></div>
    <div class="centering rounded ">
        <form @submit.prevent="changeProfile">
        <div class="mb-4 input_container" >
            
                     <label for="text" class="text"><i class="fas fa-user"></i> {{tr('Full Name')}}</label>
                     <input  v-model="NewfullName" required  type="text"  :placeholder="name" class="form-input p-2" id="full_name">
                     <div class="prog_bar">
                        <div class="prog"></div>
                    </div>
                </div>
                <div class="mb-4 input_container" >
                    
                     <label for="text" class="text"><i class="fas fa-envelope-fill"></i> {{tr('Email')}}</label>
                     <input   required v-model="NewEmail" type="email"  :placeholder="email" class="form-input p-2" id="edit_email">
                     <div class="prog_bar">
                        <div class="prog"></div>
                    </div>
                </div>
        <Button :btn_name="tr('Change')" type="submit" icon="fas fa-brush"/>
        </form>
    </div>
    
    
</div>
</template>
<script>

import Button from '../components/Button';
import * as global from '../assets/global';
import axios from 'axios';
import * as cookies from '../assets/cookies.js';
export default {
    name: 'EditProfile',
    data(){
        return{
        user_token:null,
        username:null,
        NewfullName:null,
        NewEmail:null,
        sucessMessage:null,
        }

    
    },
    emits:['refresh'],
    created(){
        this.NewEmail=this.email
        this.NewfullName=this.name
        this.user_token=cookies.get('token')
        this.username=cookies.get('username')
    },
    props: {
        name: String,
        email: String,
    },
    components: {
       
        Button
    },
    methods: {
        tr(word){
            return global.translate(word);
        },
        se(identifier){
            return global.sentence_translate(identifier);
        },
        change_lang(language){
            global.lang_change(language);
        },
        changeProfile(){
            let data=new FormData();
            data.append('token',this.user_token);
            data.append('username',this.username);
            data.append('email',this.NewEmail);
            data.append('name',this.NewfullName);
            axios.post(this.$store.state.ServerUrl+"/Users/edit", data)
            .then((response)=>{
                console.log(response.data,)
                if(response.data.header.error=='false'){
    
                    this.$swal.fire({
                       icon:'success',
                       title:'',
                       text:'profile updated Sucessfully',
                       confirmButtonColor:'orangered'
                   });
                    this.$emit('refresh')
                }
                else if(response.data.header.error=='true'){
                    this.$swal.fire({
                       icon:'error',
                       title:'',
                       text:'Information is not saved',
                       confirmButtonColor:'orangered'
                   });
                }
                }).
            catch(error=>{
                console.log(error)
            });
        }
    }
}

</script>