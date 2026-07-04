<script setup>
import { reactive, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const form = reactive({
    no_hp: '',
    email: '',
    password: '',
    confirm_password: ''
})

/*
|--------------------------------------------------------------------------
| AMBIL NO HP DARI URL
|--------------------------------------------------------------------------
*/
onMounted(() => {
    form.no_hp = route.query.no_hp || ''
})

/*
|--------------------------------------------------------------------------
| REGISTER / AKTIVASI
|--------------------------------------------------------------------------
*/
const register = async () => {

    // 1. Validasi eksistensi No HP dari URL
    if (!form.no_hp) {
        alert('Gagal Aktivasi: No HP tidak terdeteksi dari sistem/URL.')
        return
    }

    // 2. Validasi kelengkapan field
    if (!form.email || !form.password || !form.confirm_password) {
        alert('Semua field wajib diisi!')
        return
    }

    // 3. Validasi batas minimal karakter password (sinkron dengan backend)
    if (form.password.length < 6) {
        alert('Password minimal harus 6 karakter!')
        return
    }

    // 4. Validasi kecocokan konfirmasi password
    if (form.password !== form.confirm_password) {
        alert('Konfirmasi password tidak sama!')
        return
    }

    try {
        const response = await axios.post('/api/aktivasi-akun', {
            no_hp: form.no_hp,
            email: form.email,
            password: form.password
        })

        alert(response.data.message)
        
        // Langsung arahkan ke halaman login siswa jika berhasil
        router.push('/login-siswa')

    } catch (error) {
        console.error('ERROR RESPONS:', error.response?.data)

        // Menampilkan pesan error validasi spesifik dari Laravel jika status 422
        if (error.response?.status === 422 && error.response?.data?.errors) {
            const validationErrors = error.response.data.errors
            const errorMessages = Object.values(validationErrors).flat().join('\n')
            alert(errorMessages)
        } else {
            // Menampilkan error umum (404 tidak ditemukan / 400 sudah aktivasi)
            alert(error.response?.data?.message || 'Terjadi kesalahan sistem, silakan coba lagi.')
        }
    }
}
</script>

<template>
<div class="register-page">
    <div class="register-card">
        <h1>Aktivasi Akun</h1>

        <form @submit.prevent="register">
            <div class="form-group">
                <label>No HP</label>
                <input
                    type="text"
                    v-model="form.no_hp"
                    placeholder="No HP pendaftar"
                    readonly
                >
            </div>

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    v-model="form.email"
                    placeholder="username@gmail.com"
                >
            </div>

            <div class="form-group">
                <label>Password (Min. 6 Karakter)</label>
                <input
                    type="password"
                    v-model="form.password"
                    placeholder="Masukkan password"
                >
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input
                    type="password"
                    v-model="form.confirm_password"
                    placeholder="Ulangi password"
                >
            </div>

            <button type="submit" class="register-btn">
                Aktivasi Akun
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <router-link to="/login-siswa"> Login disini</router-link>
        </div>
    </div>
</div>
</template>

<style>
/* Style bawaan kamu sudah rapi, tidak perlu ada yang diubah di bagian css */
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
.register-page{
    width:100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}
.register-card{
    width:100%;
    max-width:560px;
    background:#D9D9D9;
    border-radius:22px;
    padding:55px 50px;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}
.register-card h1{
    text-align:center;
    font-size:58px;
    color:#006080;
    margin-bottom:45px;
    font-weight:700;
}
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
.register-btn{
    width:100%;
    height:58px;
    border:none;
    border-radius:12px;
    background:#006080;
    color:white;
    font-size:22px;
    font-weight:500;
    cursor:pointer;
    margin-top:15px;
    transition:0.3s;
}
.register-btn:hover{
    background:#004A63;
}
.login-link{
    text-align:center;
    margin-top:35px;
    font-size:18px;
    color:#333;
}
.login-link a{
    color:#006080;
    text-decoration:none;
    font-weight:600;
}
@media(max-width:768px){
    .register-card{ padding:40px 25px; }
    .register-card h1{ font-size:42px; }
}
@media(max-width:576px){
    .register-card h1{ font-size:34px; }
    .form-group label{ font-size:16px; }
    .register-btn{ font-size:18px; }
}
</style>