<template>
    <h1>User list page</h1>
</template>
<script>

export default({

    methods:{
        fetchUser(){
            fetch('api/users').then((user)=>{

                console.log(user)
            }).catch(err=>console.log('errr'))
        }
    },
    created(){
        this.fetchUser();
    }
})
</script>
