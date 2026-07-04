<!-- resources/js/views/LoginSiswaPage.vue -->

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const form = reactive({

    email: '',

    password: ''

})

const login = async () => {

    try {

        const response = await axios.post('/api/login-siswa', form)

        localStorage.setItem(
            'user',
            JSON.stringify(response.data.user)
        )

        alert('Login berhasil')

        // redirect dashboard siswa
        router.push('/dashboard-siswa')

    } catch (error) {

        console.log(error)

        if(error.response?.data?.message){

            alert(error.response.data.message)

        }else{

            alert('Email atau password salah')

        }

    }

}
</script>

<template>

<div class="login-page">

    <div class="login-card">

        <!-- TITLE -->
        <h1>
            Login
        </h1>

        <!-- FORM -->
        <form @submit.prevent="login">

            <!-- EMAIL -->
            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    v-model="form.email"
                    placeholder="username@gmail.com"
                >

            </div>

            <!-- PASSWORD -->
            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    v-model="form.password"
                    placeholder="Password"
                >

            </div>

            <!-- FORGOT -->
            <div class="forgot-password">

                <a href="#">
                    Forgot Password?
                </a>

            </div>

            <!-- BUTTON -->
            <button type="submit" class="login-btn">

                Sign in

            </button>

        </form>

        <!-- REGISTER -->
        <div class="register-link">

            Belum punya akun?

            <router-link to="/pendaftaran">

                Daftar disini

            </router-link>

        </div>

    </div>

</div>

</template>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins', sans-serif;
    background:#ECE8DD;
}

.login-page{

    width:100%;
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;
}

.login-card{

    width:100%;
    max-width:560px;

    background:#D9D9D9;

    border-radius:22px;

    padding:55px 50px;

    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}

.login-card h1{

    text-align:center;

    font-size:72px;

    color:#006080;

    margin-bottom:45px;

    font-weight:700;
}

/* FORM */

.form-group{

    margin-bottom:25px;
}

.form-group label{

    display:block;

    margin-bottom:10px;

    font-size:18px;

    color:#333;

    font-weight:500;
}

.form-group input{

    width:100%;

    height:58px;

    border:none;

    border-radius:8px;

    padding:0 18px;

    font-size:16px;

    outline:none;

    background:#F5EFEF;
}

.form-group input::placeholder{

    color:#B8B8B8;
}

/* FORGOT */

.forgot-password{

    text-align:right;

    margin-top:-10px;

    margin-bottom:25px;
}

.forgot-password a{

    color:#006080;

    text-decoration:none;

    font-size:15px;
}

/* BUTTON */

.login-btn{

    width:100%;

    height:58px;

    border:none;

    border-radius:12px;

    background:#006080;

    color:white;

    font-size:22px;

    font-weight:500;

    cursor:pointer;

    transition:0.3s;
}

.login-btn:hover{

    background:#004A63;
}

/* REGISTER */

.register-link{

    text-align:center;

    margin-top:35px;

    font-size:18px;

    color:#333;
}

.register-link a{

    color:#006080;

    text-decoration:none;

    font-weight:600;
}

/* RESPONSIVE */

@media(max-width:768px){

    .login-card{

        padding:40px 25px;
    }

    .login-card h1{

        font-size:52px;
    }

}

@media(max-width:576px){

    .login-card h1{

        font-size:42px;
    }

    .form-group label{

        font-size:16px;
    }

    .login-btn{

        font-size:18px;
    }

}

</style>