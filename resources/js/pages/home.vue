<template>
  <div>
    
      <div class="boolk--home">
        <div class="block text-center">
          <img src="/book.png" alt="logo" class="mb-3"/>
          <h1 class="display-1"> Welcome To Library App</h1>
          <p>Store And Track The Books You read.</p>
          <div class="d-flex mx-auto justify-content-center">
            <button class="btn btn-style login-btn" @click="showLogin =!showLogin" v-if="state">Login</button>
            <button class="btn btn-style register-btn" @click="showRegister=!showRegister" v-if="state">Register</button>
            <router-link v-if="!state" to="/account" class="my-account">My Account</router-link>
          </div>
        </div>
        
        
        <div v-if="showLogin">
          <loginForm @closeLogin="showLogin=!showLogin" ></loginForm>
        </div>
        <div v-if="showRegister">
          <registerLogin  @closeRegister="showRegister=!showRegister" @clicked="onclick"></registerLogin>
        </div>
        
      </div>

  </div>
</template>
<script>

import loginForm from '../components/loginForm'
import registerLogin from '../components/registerForm'
export default {
  components:{loginForm, registerLogin },
  data(){
    return{
      showLogin : false,
      showRegister : false,
      state : null,
    }
  },
  mounted(){
    axios.get('/api/user/check').then(res=>{
      //console.log(res.data);
      this.state = res.data
    }).catch(error =>{
        console.log(error)
    } )
    
  },
  methods:{
    onclick(val){
      console.log(val);
      this.showLogin = val;
      this.showRegister=!val;
    }
  }
}
</script>

<style scoped>
  .my-account{
    background:#03b5e6; 
    padding: 10px 20px;
    color: white;
    text-decoration: none;
    font-size: 14px;
    letter-spacing: 1px;
    font-weight: bold;

  }
    .block--home{
      width: 100vh;
      position: relative;
      display: block;
    }
    .block{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%,-50%);
      display: block;
      width: 50%;
      z-index: 2;
    }
    img{
      width: 150px;
    }
    p{
      color: #6c757d;
      font-size: 18px;
      font-weight: normal;
      text-transform: capitalize;
      letter-spacing: 0.5px;
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
    .login-btn{
      background: #ff5b61;
    }
    .register-btn{
      background: #20d0c2;
    }
    .login-btn:hover,.register-btn:hover{
      background-color: #03b5e6;
    }
</style>