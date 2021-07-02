<template>
<div>
    <b-card class="content" >
        <b-row>
            <b-col cols="" class="text-center">
                <a href="javascript:;">
                    <b-img src="/images/user.png"
                    fluid
                    rounded="circle"
                    class="img-top shadow shadow-lg--hover mb-4" style="width: 140px;" />
                </a>
                <h5 class="h3 title">
                <span class="d-block mb-1">{{user.first_name}} {{user.last_name}}</span>
                <small class="h4 font-weight-light text-muted">{{user.type.toUpperCase()}}</small>
                </h5>
                <b-list-group class="text-left" flush>
                    <b-list-group-item><b>First Name: </b>{{user.first_name}}</b-list-group-item>
                    <b-list-group-item><b>Last Name: </b>{{user.last_name}}</b-list-group-item>
                    <b-list-group-item><b>Email: </b>{{user.email}}</b-list-group-item>
                    <b-list-group-item><b>Phone Number: </b>{{user.phone}}</b-list-group-item>
                </b-list-group>    
                <b-button block pill size="md" variant="primary" v-b-modal.edit-account-modal class="mt-2 mr-5">Edit</b-button>
                <div>
                    <b-modal
                    id="edit-account-modal"
                    centered 
                    ref="modal"
                    title="Edit Account"
                    @ok="editProfile"
                    @hide="updateUser"
                    >
                    <form ref="form" @submit.stop.prevent="handleSubmit">
                        <b-form-group
                        label="First Name"
                        label-for="first-name-input"
                        invalid-feedback="First Name is required"
                        :state="nameState"
                        >
                        <b-form-input
                            id="first-name-input"
                            v-model="user.first_name"
                            :state="nameState"
                            required
                        ></b-form-input>
                        </b-form-group>

                        <b-form-group
                        label="Last Name"
                        label-for="last-name-input"
                        invalid-feedback="Last Name is required"
                        :state="nameState"
                        >
                        <b-form-input
                            id="last-name-input"
                            v-model="user.last_name"
                            :state="nameState"
                            required
                        ></b-form-input>
                        </b-form-group>

                        <b-form-group
                        label="Email"
                        label-for="email-input"
                        >
                        <b-form-input
                            id="email-input"
                            type="email"
                            v-model="user.email"
                            :state="nameState"
                            required
                        ></b-form-input>
                        </b-form-group>

                          <b-form-group
                        label="Phone Number"
                        label-for="phone-number-input"
                        >
                        <b-form-input
                            id="phone-number-input"
                            v-model="user.phone"
                        ></b-form-input>
                        </b-form-group>
                    </form>
                    </b-modal>
                </div>
            </b-col>
        </b-row>
    </b-card>
</div>
</template>

<script>
  export default {
    data() {
      return {
        fields: [
            {
                key:"user_name",
                label:"User Name"
            },
            {
                key:"first_name",
                label:"First Name"
            },
            {
                key:"last_name",
                label:"Last Name"
            },
             {
                key:"email",
                label:"Email"
            },
            {
                key:"phone",
                label:"Phone Number"
            },
            ],
        name: '',
        nameState: null,
        submittedNames: [],
        user:{},
      }
    },
  
    methods: {
        editProfile(){
            
            axios.post('/api/account', {...this.user})
                .then((resp)=>{
                    window.user= resp.data.user
                    this.setUser(window.user)
                    // console.log(this.user)
                   
            }).catch((error)=>console.log(error))
            // console.log(this.user)
        },
        setUser(loggedInUser){
            this.user.id = loggedInUser.id
            this.user.user_name = loggedInUser.user_name
            this.user.first_name = loggedInUser.first_name
            this.user.last_name = loggedInUser.last_name
            this.user.email = loggedInUser.email
            this.user.phone = loggedInUser.phone
            this.user.type = loggedInUser.type
        },
        updateUser(){
            this.user = window.user
        }
    },
    created(){
        let logged = window.user;
        this.setUser(logged)
    }
  }
</script>


<style scoped>
.content {
    margin-top: 2.1rem;
    margin-left: 25%;
    max-width: 50%;
    max-height: 100%;
}
.row {
    margin: 2.2rem 2.2rem;
}
.edit_button {

}
</style>