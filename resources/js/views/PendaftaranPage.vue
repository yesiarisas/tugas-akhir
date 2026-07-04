<script setup>
import { reactive, ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const homepage = ref({})
const kategoriList = ref([])

const form = reactive({
    kategori_id: '',
    nama_pendaftar: '',
    tanggal_lahir: '',
    no_hp: '',
    alamat: ''
})

onMounted(async () => {
    try {
        // Ambil data Homepage
        const homepageResponse = await axios.get('/api/homepage')
        homepage.value = homepageResponse.data.data || {}

        // Menggunakan rute yang sesuai dengan api.php kamu: /api/kategori-latihan
        const kategoriResponse = await axios.get('/api/kategori-latihan')
        kategoriList.value = kategoriResponse.data.data || []

    } catch (error) {
        console.error("Gagal memuat data awal:", error)
    }
})

const submitForm = async () => {
    try {
        const response = await axios.post('/api/pendaftaran', form)
        alert(response.data.message)

        // Redirect ke halaman status dengan menyertakan parameter query no_hp
        router.push('/status-pendaftaran?no_hp=' + form.no_hp)

    } catch (error) {
        console.error("Gagal menyimpan pendaftaran:", error)
        if (error.response?.data?.message) {
            alert(error.response.data.message)
        } else {
            alert('Terjadi kesalahan saat menyimpan data.')
        }
    }
}
</script>

<template>
<div class="pendaftaran-page">

    <nav class="navbar">
        <div class="logo-section">
            <img
                v-if="homepage.logo"
                :src="'/storage/' + homepage.logo"
                class="logo"
            >
            <h2>
                {{ homepage.nama_sanggar || 'Nama Sanggar' }}
            </h2>
        </div>
    </nav>

    <section class="content-section">
        <h1 class="title">
            Form Pendaftaran
        </h1>

        <div class="form-center">
            <div class="form-wrapper">
                <form @submit.prevent="submitForm">

                    <div class="form-group">
                        <label>Nama Pendaftar</label>
                        <input
                            type="text"
                            v-model="form.nama_pendaftar"
                            placeholder="Nama Pendaftar"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input
                            type="date"
                            v-model="form.tanggal_lahir"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>No HP</label>
                        <input
                            type="text"
                            v-model="form.no_hp"
                            placeholder="Contoh: 081234567890"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea
                            v-model="form.alamat"
                            placeholder="Alamat Lengkap"
                            required
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label>Kategori Latihan</label>
                        <select v-model="form.kategori_id" required>
                            <option value="">
                                Pilih Kategori
                            </option>
                            <option
                                v-for="item in kategoriList"
                                :key="item.id"
                                :value="item.id"
                            >
                                {{ item.nama_kategori }}
                            </option>
                        </select>
                    </div>

                    <div class="button-wrapper">
                        <button type="submit" class="submit-btn">
                            Simpan Pendaftaran
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-left">
            <div class="footer-logo">
                <img
                    v-if="homepage.logo"
                    :src="'/storage/' + homepage.logo"
                >
                <h2>
                    {{ homepage.nama_sanggar || 'Nama Sanggar' }}
                </h2>
            </div>
            <p>
                {{ homepage.footer_deskripsi || 'Deskripsi Sanggar' }}
            </p>
        </div>

        <div class="footer-right">
            <h3>Kontak</h3>
            <p>
                Telepon : {{ homepage.footer_telepon || '-' }}
            </p>
            <p>
                Alamat : {{ homepage.footer_alamat || '-' }}
            </p>
        </div>
    </footer>

</div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#ECE8DD;
    font-family:'Poppins', sans-serif;
}

.pendaftaran-page{
    width:100%;
    min-height:100vh;
}

/* NAVBAR */
.navbar{
    width:100%;
    background:#006080;
    border-bottom:3px solid #F5C400;
    padding:18px 60px;
}

.logo-section{
    display:flex;
    align-items:center;
    gap:16px;
}

.logo{
    width:58px;
    height:58px;
    border-radius:50%;
    object-fit:cover;
}

.logo-section h2{
    color:white;
    font-size:24px;
    font-family:'Playfair Display', serif;
}

/* CONTENT */
.content-section{
    width:100%;
    padding:60px 20px 90px;
    display:flex;
    flex-direction:column;
    align-items:center;
}

.title{
    text-align:center;
    font-size:58px;
    font-weight:700;
    margin-bottom:45px;
    color:#111;
}

/* FORM */
.form-center{
    width:100%;
    display:flex;
    justify-content:center;
}

.form-wrapper{
    width:100%;
    max-width:950px;
    background:#D9D9D9;
    padding:50px;
    border-radius:6px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

.form-group{
    margin-bottom:28px;
}

.form-group label{
    display:block;
    margin-bottom:10px;
    font-size:21px;
    font-weight:600;
    color:#222;
}

.form-group input,
.form-group select{
    width:100%;
    height:56px;
    border:1px solid #C9C9C9;
    border-radius:4px;
    padding:0 18px;
    font-size:16px;
    outline:none;
    background:white;
}

.form-group textarea{
    width:100%;
    min-height:120px;
    border:1px solid #C9C9C9;
    border-radius:4px;
    padding:15px;
    font-size:16px;
    resize:none;
    outline:none;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
    border:1px solid #006080;
}

.button-wrapper{
    width:100%;
    display:flex;
    justify-content:center;
    margin-top:40px;
}

.submit-btn{
    background:#004A63;
    color:white;
    border:none;
    padding:15px 55px;
    border-radius:5px;
    font-size:18px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.submit-btn:hover{
    background:#006080;
}

/* FOOTER */
.footer{
    width:100%;
    background:#006080;
    color:white;
    display:flex;
    justify-content:space-between;
    gap:40px;
    padding:55px 70px;
}

.footer-left{
    max-width:620px;
}

.footer-logo{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:22px;
}

.footer-logo img{
    width:60px;
    height:60px;
    border-radius:50%;
}

.footer-logo h2{
    font-family:'Playfair Display', serif;
    font-size:38px;
}

.footer-left p{
    line-height:1.8;
    font-size:18px;
    font-style:italic;
}

.footer-right h3{
    margin-bottom:18px;
    font-size:28px;
}

.footer-right p{
    margin-bottom:12px;
}

/* RESPONSIVE */
@media(max-width:992px){
    .navbar{ padding:18px 30px; }
    .title{ font-size:44px; }
    .form-wrapper{ padding:35px 25px; }
    .footer{ flex-direction:column; padding:45px 30px; }
}

@media(max-width:768px){
    .title{ font-size:34px; }
    .form-group label{ font-size:18px; }
    .footer-logo{ flex-direction:column; align-items:flex-start; }
    .footer-logo h2{ font-size:30px; }
}

@media(max-width:576px){
    .content-section{ padding:40px 15px 70px; }
    .form-wrapper{ padding:25px 18px; }
    .submit-btn{ width:100%; }
    .footer{ padding:35px 20px; }
}
</style>