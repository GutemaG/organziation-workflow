export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.is_admin ===  1 ;
    }

    isUser(){
        return this.user.type ===  0 ;
    }
    
    isAdminOrUser(){
        if(this.user.type ===  0  || this.user.type ===  1 ){
            return true;
        }
    }
}

