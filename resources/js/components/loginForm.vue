<template>
    <div class="login text-center">
        <div class="close" @click="closeLogin"><span>x</span></div>
        <h1>Login To Your Account</h1>
        <form method="post" @submit.prevent="loginUser">
            <input type="email" name="email" id=""  placeholder="Email Address" v-model="datalog.email">
           <input type="password" name="password" id=""  placeholder="*******" v-model="datalog.password">
           
           <span v-if="error.email" class="error">{{error.email[0]}} </span>
           <span v-if="error.password" class="error">{{error.password[0]}} </span>
           <button type="submit" class="btn">Login</button>
           
        </form>
    </div>
</template>


<script>
import axios from 'axios';
export default {
    data(){
        return{
            datalog:{
                email:'',
                password:'',
            },
            error:[]
        }
    },
    methods:{
        closeLogin(){
            this.$emit('closeLogin');
            
        },
        loginUser(){
            axios.post('/api/user/login', this.datalog)
            .then( response => {
               //console.log('logedin');
                 this.$router.push('/account');
                 localStorage.setItem('logstate', 'loggedIn')
                  
            })
            .catch( error => {
                
                this.error = error.response.data.errors;
            })
        }
    },
}
</script>

<style scoped>
    .error{
        margin: 5px 0 20px;
        color: white;
        padding: 5px 10px;
        background-color: #ea5a47;
        text-align: left;
        font-size: 12px;
        font-weight: normal;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 4px;
        font-family: 'Nunito Sans', sans-serif;
        width: 100%;
    }
    h1{
        color: white;
    }
    form{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .login{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        display: block;
        width: auto;
        z-index: 9;
        background: #313a46;
        padding: 80px 90px;
        
         /* border-radius: 20px; */
        box-shadow: 1px 0px 10px 2px rgba(121, 121, 121, 0.7);
    }
    input{
        width: 100%;
        outline: none;
        height: 46px;
        padding-left: 15px;
        border: 1px solid transparent;
        margin-bottom: 20px;
        border-radius: 0;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 14px;
        color: #000;
        font-weight: 500;
        border-radius: 10px;
        margin: 10px auto;
    }
    .btn{
        margin: 0 10px;
        height: 46px;
        border: none;
        border-radius: 20px;
        padding: 5px 40px;
        font-size: 14px;
        color: #fff;
        font-weight: 600;
        background-color: #03b5e6;
        transition: .3s ease;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 1px;
        
    }
    .btn:hover{
        color: #ff5b61;
    }
    .close{
        position: absolute;
        top: 20px;
        right:20px;
        color: #ff5b61;
        font-weight: bolder;
        font-size: 30px;
        cursor: pointer;
    }
    .close:hover{
        color: gray;
    }
</style>