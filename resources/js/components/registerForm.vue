<template>
  <div class="login text-center">
    <div class="close" @click="closeRegister"><span>x</span></div>
    <h1>New Account Register</h1>
    <form method="POST" @submit.prevent="registerForm">
      <input
        type="text"
        name="name"
        id="name"
        required
        placeholder="Name"
        v-model="data.name"
      />
      <span class="error" v-if="error.name">{{ error.name[0] }}</span>

      <input
        type="email"
        name="email"
        id="email"
        required
        placeholder="Email Address"
        v-model="data.email"
      />
      <span class="error" v-if="error.email">{{ error.email[0] }}</span>

      <input
        type="password"
        name="password"
        id="pa"
        required
        placeholder="Enter Password"
        v-model="data.password"
      />
      <input
        type="password"
        name="password_confirmation"
        id=""
        required
        placeholder="Confirm Password"
        v-model="data.password_confirmation"
      />
      <span class="error" v-if="error.password">{{ error.password[0] }}</span>

      <button type="submit" class="btn mt-5">Register</button>
    </form>
  </div>
</template>


<script>
import axios from "axios";
export default {
  data() {
    return {
      data: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      error: [],
    };
  },
  methods: {
    closeRegister() {
      this.$emit("closeRegister");
    },
    registerForm() {
      axios
        .post("/api/user/register", this.data)
        .then((response) => {
          //console.log(response);
          if ((response.status = 200)) {
            //    this.$router.push('/');
            this.$emit("clicked", true);
          }
        })
        .catch((error) => {
          this.error = error.response.data.errors;
        });
    },
  },
};
</script>

<style scoped>
.error {
  margin: 5px 0;
  color: white;
  padding: 5px 10px;
  background-color: #ea5a47;
  text-align: left;
  font-size: 12px;
  font-weight: normal;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-radius: 4px;
  font-family: "Nunito Sans", sans-serif;
}
h1 {
  color: white;
}
form {
  display: flex;
  flex-direction: column;
  /* align-items: center; */
}
.login {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: block;
  width: auto;
  z-index: 9;
  background: #313a46;
  padding: 80px 90px;
  /* border-radius: 20px; */
  box-shadow: 1px 0px 10px 2px rgba(121, 121, 121, 0.7);
}
input {
  width: 100%;
  outline: none;
  height: 46px;
  padding-left: 15px;
  border: 1px solid transparent;
  margin-bottom: 20px;
  border-radius: 0;
  font-family: "Nunito Sans", sans-serif;
  font-size: 14px;
  color: #000;
  font-weight: 500;
  border-radius: 10px;
  margin: 10px auto;
}
.btn {
  margin: 0 10px;
  height: 46px;
  border: none;
  border-radius: 20px;
  padding: 5px 40px;
  font-size: 14px;
  color: #fff;
  font-weight: 600;
  background-color: #03b5e6;
  transition: 0.3s ease;
  display: inline-block;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.btn:hover {
  background-color: #ff5b61;
}
.close span {
  position: absolute;
  top: 20px;
  right: 20px;
  color: #ff5b61;
  font-weight: bolder;
  font-size: 30px;
  cursor: pointer;
}
.close span:hover {
  color: white;
}
</style>