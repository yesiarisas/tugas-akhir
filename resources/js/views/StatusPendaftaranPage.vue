<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = reactive({
    no_hp: ''
})

const dataPendaftar = ref(null)

const cekStatus = async () => {
    try {
        const response = await axios.post('/api/cek-status', form)
        dataPendaftar.value = response.data.data
    } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
            alert(error.response.data.message)
        } else {
            alert('Data tidak ditemukan atau terjadi kesalahan jaringan.')
        }
        dataPendaftar.value = null
    }
}

const keAktivasi = () => {
    router.push({
        path: '/register-siswa',
        query: {
            no_hp: form.no_hp
        }
    })
}
</script>

<template>
<div class="status-page">

    <div class="header">
        <h1>Cek Status Pendaftaran</h1>
    </div>

    <div class="form-wrapper">
        <input v-model="form.no_hp" placeholder="Masukkan No HP" @keyup.enter="cekStatus">
        <button @click="cekStatus">Cek Status</button>
    </div>

    <div v-if="dataPendaftar" class="status-card">

        <h2>{{ dataPendaftar.nama_pendaftar }}</h2>

        <div v-if="dataPendaftar.status === 'menunggu'" class="waiting-box">
            <h3>Menunggu</h3>
            <p class="ingat-text">Pendaftaran Anda sedang ditinjau oleh admin sanggar.</p>
        </div>

        <div v-if="dataPendaftar.status === 'ditolak'" class="reject-box">
            <h3>Ditolak</h3>
            <p class="ingat-text">Mohon maaf, pendaftaran Anda belum dapat kami terima.</p>
        </div>

        <div v-if="dataPendaftar.status === 'diterima'" class="accept-box">
            <h3>Diterima</h3>
            <p class="ingat-text" style="color: #222; font-weight: 500; margin-bottom: 20px;">
                Selamat pendaftaran anda diterima! Silakan lakukan aktivasi akun siswa.
            </p>
            <button class="register-btn" @click="keAktivasi">
                Aktivasi Akun
            </button>
        </div>

    </div>

</div>
</template>

<style scoped>
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

.status-page{
    width:100%;
    min-height:100vh;
    padding:60px 20px;
}

.header{
    text-align:center;
    margin-bottom:40px;
}

.header h1{
    font-size:48px;
    color:#005F7F;
    font-weight:700;
}

.form-wrapper{
    width:100%;
    max-width:600px;
    margin:auto;
    background:white;
    padding:40px;
    border-radius:12px;
    box-shadow:0 3px 12px rgba(0,0,0,0.08);
    display:flex;
    flex-direction:column;
    gap:20px;
}

.form-wrapper input{
    width:100%;
    height:55px;
    border:1px solid #D0D0D0;
    border-radius:8px;
    padding:0 18px;
    font-size:16px;
    outline:none;
}

.form-wrapper button{
    width:100%;
    height:55px;
    background:#005F7F;
    border:none;
    color:white;
    font-size:17px;
    font-weight:600;
    border-radius:8px;
    cursor:pointer;
    transition: background 0.2s;
}

.form-wrapper button:hover{
    background:#004d66;
}

.status-card{
    width:100%;
    max-width:600px;
    margin:40px auto 0;
    background:white;
    padding:40px;
    border-radius:12px;
    box-shadow:0 3px 12px rgba(0,0,0,0.08);
    text-align:center;
}

.status-card h2{
    margin-bottom:25px;
    font-size:30px;
    color:#333;
}

.waiting-box h3{
    color:#C58B00;
    margin-bottom:15px;
    font-size:24px;
    font-weight: 700;
}

.reject-box h3{
    color:#c5221f;
    margin-bottom:15px;
    font-size:24px;
    font-weight: 700;
}

.accept-box h3{
    color:#137333;
    margin-bottom:15px;
    font-size:24px;
    font-weight: 700;
}

.ingat-text{
    margin-top:15px;
    color:#666;
    font-size:15px;
    line-height:1.7;
}

.register-btn{
    display:inline-block;
    padding:14px 35px;
    background:#005F7F;
    color:white;
    border:none;
    text-decoration:none;
    border-radius:8px;
    font-weight:600;
    cursor:pointer;
    font-size:16px;
    transition: background 0.2s;
}

.register-btn:hover{
    background:#004d66;
}
</style>