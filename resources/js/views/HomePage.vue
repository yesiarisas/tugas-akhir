<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const homepage = ref({})
const agenda = ref([])
const infoLomba = ref([])
const galeriPrestasi = ref([])
const activeTab = ref('agenda')

// State untuk mengontrol Sidebar Menu di HP
const isSidebarOpen = ref(false)

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value
}

const closeSidebar = () => {
    isSidebarOpen.value = false
}

onMounted(async () => {
    try {
        const response = await axios.get('/api/homepage')
        homepage.value = response.data.data || {}

        const responseAgenda = await axios.get('/api/agenda')
        agenda.value = responseAgenda.data.data || []

        const responseLomba = await axios.get('/api/info-lomba')
        infoLomba.value = responseLomba.data.data || []

        const responseGaleri = await axios.get('/api/galeri-prestasi')
        galeriPrestasi.value = responseGaleri.data.data || []

    } catch (error) {
        console.log(error)
    }
})

// Fungsi untuk mengarahkan ke halaman LoginSiswaPage
const goToLogin = () => {
    closeSidebar()
    router.push('/login-siswa')
}
</script>

<template>
<div class="website">

    <nav class="navbar">
        <div class="logo-section">
            <img
                v-if="homepage.logo"
                :src="'/storage/' + homepage.logo"
                class="logo"
            >
            <h2>
                {{ homepage.nama_sanggar }}
            </h2>
        </div>

        <div class="menu desktop-menu">
            <a href="#contact">Contact</a>
            <a href="#agenda">Agenda</a>
            <a href="#galeri">Galeri</a>
            <router-link to="/status-pendaftaran">Status</router-link>
            <button class="login-btn" @click="goToLogin">LOGIN</button>
        </div>

        <button class="hamburger-btn" @click="toggleSidebar" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

    <div class="sidebar-overlay" :class="{ 'active': isSidebarOpen }" @click="closeSidebar"></div>
    <div class="sidebar" :class="{ 'open': isSidebarOpen }">
        <button class="close-btn" @click="closeSidebar">&times;</button>
        <div class="sidebar-menu">
            <a href="#contact" @click="closeSidebar">Contact</a>
            <a href="#agenda" @click="closeSidebar">Agenda</a>
            <a href="#galeri" @click="closeSidebar">Galeri</a>
            <router-link to="/status-pendaftaran" @click="closeSidebar">Cek Status</router-link>
            <button class="login-btn mobile-login-btn" @click="goToLogin">LOGIN</button>
        </div>
    </div>

    <section
        class="hero"
        :style="homepage.hero_image
            ? { backgroundImage: `url(/storage/${homepage.hero_image})` }
            : {}"
    >
        <div class="overlay">
            <div class="hero-box">
                <h1>{{ homepage.hero_title }}</h1>
                <p>{{ homepage.hero_subtitle }}</p>
                <router-link
                    to="/pendaftaran"
                    class="gabung-btn"
                >
                    {{ homepage.hero_button_text }}
                </router-link>
            </div>
        </div>
    </section>

    <section class="kategori-section">
        <div class="section-title">
            Kategori Seni Sanggar
        </div>

        <div class="kategori-wrapper">
            <div class="kategori-card">
                <img
                    v-if="homepage.kategori1_gambar"
                    :src="'/storage/' + homepage.kategori1_gambar"
                >
                <div class="kategori-content">
                    <h2>{{ homepage.kategori1_nama }}</h2>
                    <p>{{ homepage.kategori1_deskripsi }}</p>
                </div>
            </div>

            <div class="kategori-card">
                <img
                    v-if="homepage.kategori2_gambar"
                    :src="'/storage/' + homepage.kategori2_gambar"
                >
                <div class="kategori-content">
                    <h2>{{ homepage.kategori2_nama }}</h2>
                    <p>{{ homepage.kategori2_deskripsi }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="tentang-section">
        <div class="tentang-container">
            <div class="tentang-text">
                <h1>{{ homepage.tentang_judul }}</h1>
                <div v-html="homepage.tentang_deskripsi"></div>
            </div>

            <div class="tentang-image">
                <img
                    v-if="homepage.tentang_gambar"
                    :src="'/storage/' + homepage.tentang_gambar"
                >
            </div>
        </div>
    </section>

    <section class="event-section" id="agenda">
        <div class="event-left">
            <div class="event-tabs">
                <button
                    :class="activeTab === 'agenda' ? 'active-tab' : 'inactive-tab'"
                    @click="activeTab = 'agenda'"
                >
                    📅 Agenda
                </button>
                <button
                    :class="activeTab === 'lomba' ? 'active-tab' : 'inactive-tab'"
                    @click="activeTab = 'lomba'"
                >
                    ⚠️ Info Lomba
                </button>
            </div>

            <div v-if="activeTab === 'agenda'" class="agenda-list">
                <div
                    class="agenda-item"
                    v-for="(item, index) in agenda"
                    :key="item.id"
                >
                    <div
                        class="agenda-date"
                        :class="index % 2 === 0 ? 'agenda-date-blue' : 'agenda-date-gray'"
                    >
                        <span class="day-num">{{ new Date(item.tanggal).getDate() }}</span>
                        <span class="month-name">{{ new Date(item.tanggal).toLocaleDateString('id-ID', { month: 'short' }) }}</span>
                    </div>
                    <div
                        class="agenda-content-list"
                        :class="index % 2 === 0 ? 'agenda-blue' : 'agenda-gray'"
                    >
                        {{ item.judul }}
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'lomba'" class="agenda-list">
                <div
                    class="agenda-item"
                    v-for="(item, index) in infoLomba"
                    :key="item.id"
                >
                    <div
                        class="agenda-date"
                        :class="index % 2 === 0 ? 'agenda-date-blue' : 'agenda-date-gray'"
                    >
                        <span class="day-num">{{ new Date(item.tanggal).getDate() }}</span>
                        <span class="month-name">{{ new Date(item.tanggal).toLocaleDateString('id-ID', { month: 'short' }) }}</span>
                    </div>
                    <div
                        class="agenda-content-list"
                        :class="index % 2 === 0 ? 'agenda-blue' : 'agenda-gray'"
                    >
                        {{ item.judul }}
                    </div>
                </div>
            </div>
        </div>

        <div class="event-right" id="galeri">
            <div class="galeri-header">
                <h2>Galeri Prestasi</h2>
                <router-link
                    to="/galeri-prestasi"
                    class="lihat-semua"
                >
                    Lihat semua >
                </router-link>
            </div>

            <div class="galeri-grid">
                <div
                    class="galeri-card"
                    v-for="item in galeriPrestasi.slice(0, 9)"
                    :key="item.id"
                >
                    <div class="galeri-img-container">
                        <img
                            v-if="item.gambar"
                            :src="'/storage/' + item.gambar"
                        >
                    </div>
                    <div class="galeri-title">
                        {{ item.judul }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer" id="contact">
        <div class="footer-left">
            <div class="footer-logo">
                <img
                    v-if="homepage.logo"
                    :src="'/storage/' + homepage.logo"
                >
                <h2>{{ homepage.nama_sanggar }}</h2>
            </div>
            <p>{{ homepage.footer_deskripsi }}</p>
        </div>

        <div class="footer-right">
            <h3>Kontak</h3>
            <p>Telepon : {{ homepage.footer_telepon }}</p>
            <p>Alamat : {{ homepage.footer_alamat }}</p>
        </div>
    </footer>

</div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,100..900;1,100..900&family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    scroll-behavior: smooth;
}

body{
    font-family:Arial, sans-serif;
    background:#ECE8DD;
    overflow-x: hidden;
}

.website{
    width:100%;
}

/* NAVBAR */
.navbar{
    background:#005F7F;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 50px;
    position: relative;
    z-index: 99;
}

.logo-section{
    display:flex;
    align-items:center;
    gap:15px;
}

.logo{
    width:65px;
    height:65px;
    border-radius:50%;
    object-fit:cover;
}

.logo-section h2{
    font-family:'Playfair Display', serif;
    font-size:40px;
}

.menu{
    display:flex;
    align-items:center;
    gap:35px;
}

.menu a{
    text-decoration:none;
    color:white;
    font-family:'Poppins', sans-serif;
    font-weight:500;
}

.login-btn{
    background:transparent;
    border:1px solid #FFCE0A;
    color:white;
    padding:12px 35px;
    border-radius:6px;
    cursor:pointer;
    font-family:'Poppins', sans-serif;
    transition: 0.3s;
}
.login-btn:hover {
    background: #FFCE0A;
    color: #005F7F;
}

/* HAMBURGER BUTTON */
.hamburger-btn {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 21px;
    background: transparent;
    border: none;
    cursor: pointer;
    z-index: 101;
}

.hamburger-btn span {
    width: 100%;
    height: 3px;
    background-color: white;
    border-radius: 2px;
}

/* SIDEBAR & OVERLAY */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
    opacity: 1;
    pointer-events: auto;
}

.sidebar {
    position: fixed;
    top: 0;
    right: -280px;
    width: 280px;
    height: 100%;
    background: #004A63;
    z-index: 1000;
    padding: 30px;
    box-shadow: -4px 0 15px rgba(0,0,0,0.2);
    transition: right 0.3s ease;
    display: flex;
    flex-direction: column;
}

.sidebar.open {
    right: 0;
}

.close-btn {
    align-self: flex-end;
    background: transparent;
    border: none;
    color: white;
    font-size: 35px;
    cursor: pointer;
    line-height: 1;
    margin-bottom: 30px;
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.sidebar-menu a {
    color: white;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 500;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.mobile-login-btn {
    margin-top: 15px;
    width: 100%;
    text-align: center;
}

/* HERO */
.hero{
    height:650px;
    background-size:cover;
    background-position:center;
    position:relative;
}

.overlay{
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    display:flex;
    justify-content:center;
    align-items:center;
}

.hero-box{
    background:rgba(0,0,0,0.35);
    padding:40px 60px;
    text-align:center;
    color:white;
    width: 90%;
    max-width: 900px;
}

.hero-box h1{
    font-size:64px;
    margin:auto;
    line-height:1.2;
    font-family:'Playfair Display', serif;
    color:#FFEA96;
    font-weight:700;
}

.hero-box p{
    margin-top:20px;
    font-size:22px;
    margin-inline:auto;
    font-family:'Inter', sans-serif;
    font-style:italic;
    color:white;
    line-height:1.5;
}

.gabung-btn{
    display:inline-block;
    margin-top:30px;
    background:#004A63;
    border:2px solid #FFCE0A;
    color:white;
    padding:14px 55px;
    text-decoration:none;
    border-radius:6px;
    font-family:'Inter', sans-serif;
    font-size:18px;
}

/* KATEGORI */
.kategori-section{
    padding:60px 50px;
}

.section-title{
    background:#005F7F;
    color:white;
    width:100%;
    max-width: 420px;
    margin:auto;
    text-align:center;
    padding:16px;
    border-radius:8px;
    font-weight:bold;
    font-family:'Poppins', sans-serif;
}

.kategori-wrapper{
    margin-top:50px;
    display:flex;
    justify-content:center;
    gap:40px;
}

.kategori-card{
    width: 100%;
    max-width:420px;
    background:#005F7F;
    border-radius:10px;
    overflow:hidden;
    color:white;
}

.kategori-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.kategori-content{
    padding:20px;
    text-align:center;
}

.kategori-content h2{
    margin-bottom:10px;
    color:#FFEA96;
    font-size:34px;
    font-family:'Poppins', sans-serif;
    font-weight:700;
}

.kategori-content p{
    font-family:'Poppins', sans-serif;
    color:white;
    font-style:italic;
    line-height:1.6;
    font-size:16px;
}

/* TENTANG / SEJARAH SANGGAR */
.tentang-section{
    padding: 0 50px 30px;
    width: 100%;
}

.tentang-container {
    max-width: 950px;
    margin: 0 auto;
    display: flex;
    align-items: stretch;
    gap: 30px;
}

.tentang-text{
    flex: 1.3;
    background:#F5F2EA;
    padding: 25px 30px;
    border:1px solid #6CA5B2;
    border-radius: 6px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.tentang-text h1{
    font-size:26px;
    margin-bottom: 12px;
    font-family:'Poppins', sans-serif;
    font-weight:700;
}

.tentang-text div{
    line-height:1.6;
    font-size:15px;
    color:#333;
    font-family:'Poppins', sans-serif;
}

.tentang-image{
    flex: 0.7;
    display: flex;
    align-items: center;
}

.tentang-image img{
    width:100%;
    height: 100%;
    aspect-ratio: 16 / 9;
    object-fit:cover;
    border-radius: 6px;
}

/* EVENT & AGENDA */
.event-section{
    padding:0 50px 80px;
    display:grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap:40px;
    align-items:start;
}

.event-left{
    width:100%;
}

.event-right{
    width:100%;
    background:#D9D9D9;
    padding:25px;
    border-radius:5px;
}

/* TABS */
.event-tabs{
    display:flex;
    gap:20px;
    margin-bottom:30px;
}

.active-tab, .inactive-tab{
    border:none;
    padding:14px 25px;
    border-radius:8px;
    font-weight:bold;
    font-family:'Poppins', sans-serif;
    cursor:pointer;
    flex: 1;
    text-align: center;
}

.active-tab{ background:#005F7F; color:white; }
.inactive-tab{ background:#9BC2CF; color:white; }

/* AGENDA */
.agenda-list{
    display:flex;
    flex-direction:column;
    gap:15px;
    width:100%;
}

.agenda-item{
    display:flex;
    gap:12px;
    align-items:stretch;
    width:100%;
}

.agenda-date{
    width:65px;
    min-width:65px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    border-radius:6px;
    font-family:'Poppins', sans-serif;
    padding:6px;
    text-align:center;
}

.agenda-date .day-num {
    font-weight: 700;
    font-size: 20px;
    line-height: 1.1;
}

.agenda-date .month-name {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 500;
    margin-top: 2px;
}

.agenda-date-blue{ background:#79AEBB; color:#1D1D1D; }
.agenda-date-gray{ background:#C4C4C4; color:#1D1D1D; }

.agenda-content-list{
    flex:1;
    padding:14px 20px;
    border-radius:6px;
    font-family:'Poppins', sans-serif;
    font-style:italic;
    font-size:16px;
    display:flex;
    align-items:center;
}

.agenda-blue{ background:#79AEBB; color:#1D1D1D; }
.agenda-gray{ background:#C4C4C4; color:#1D1D1D; }

/* GALERI */
.galeri-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.galeri-header h2{
    color:#005F7F;
    font-family:'Poppins', sans-serif;
    font-size:26px;
}

.lihat-semua {
    text-decoration:none;
    color:#005F7F;
    font-family:'Poppins', sans-serif;
    font-weight:600;
    font-size:15px;
}

.galeri-grid{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:15px;
}

.galeri-card{
    background:white;
    overflow:hidden;
    border-radius:6px;
    display:flex;
    flex-direction:column;
    height:100%;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.galeri-img-container {
    width: 100%;
    height: 100px;
    overflow: hidden;
}

.galeri-card img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.galeri-title{
    background:#005F7F;
    color:white;
    text-align:center;
    padding:10px 6px;
    font-size:12px;
    font-family:'Poppins', sans-serif;
    flex-grow:1;
    display:flex;
    align-items:center;
    justify-content:center;
    line-height:1.3;
}

/* FOOTER */
.footer{
    background:#005F7F;
    color:white;
    padding:50px;
    display:flex;
    justify-content:space-between;
    gap:40px;
    height: auto;
}

.footer-logo{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:15px;
}

.footer-logo img{
    width:65px;
    height:65px;
    border-radius:50%;
}

.footer-logo h2{
    font-family:'Playfair Display', serif;
    font-size:36px;
}

.footer-left{
    max-width:500px;
}

.footer-left p{
    line-height:1.6;
    font-size:16px;
    font-family:'Poppins', sans-serif;
    font-style:italic;
}

.footer-right h3{
    margin-bottom:15px;
    font-size:24px;
    font-family:'Poppins', sans-serif;
}

.footer-right p{
    margin-bottom:10px;
    font-family:'Poppins', sans-serif;
}

/* ================= MEDIA QUERIES RESPONSIVE ================= */
@media(max-width:1200px){
    .hero-box h1{ font-size:48px; }
    .hero-box p{ font-size:18px; }
    .event-section{ grid-template-columns: 1fr; } 
}

@media(max-width:992px){
    .navbar { padding: 15px 30px; }
    .kategori-wrapper{ flex-direction:column; align-items:center; gap:25px; }
    .kategori-card{ max-width:100%; }
    .footer{ flex-direction:column; padding: 40px 30px; gap: 30px; }
}

@media(max-width:768px){
    .desktop-menu { display: none !important; }
    .hamburger-btn { display: flex; }

    .logo-section h2 { font-size: 26px; }
    .hero{ height:420px; }
    .hero-box h1{ font-size:32px; }
    .hero-box p{ font-size:15px; }
    .gabung-btn { padding: 10px 35px; font-size: 16px; }

    .tentang-section { padding: 0 20px 30px; }
    .tentang-container { flex-direction: row; gap: 15px; align-items: stretch; }
    .tentang-text { flex: 1.2; padding: 15px; }
    .tentang-text h1 { font-size: 18px; margin-bottom: 6px; }
    .tentang-text div { font-size: 12px; line-height: 1.5; }
    .tentang-image { flex: 0.8; }
    .tentang-image img { height: 100%; aspect-ratio: 16 / 9; }

    .galeri-grid{ grid-template-columns:repeat(3, 1fr); gap:10px; }
    .galeri-title { font-size: 11px; padding: 8px 4px; }
}

@media(max-width:480px){
    .navbar, .kategori-section, .event-section, .footer{ padding: 20px; }
    .logo-section h2 { font-size: 20px; }
    .logo { width: 45px; height: 45px; }
    .hero-box h1{ font-size:24px; }
    
    .tentang-text h1 { font-size: 14px; margin-bottom: 4px; }
    .tentang-text div { font-size: 10px; line-height: 1.4; }
    .tentang-text { padding: 10px; }
    .tentang-container { gap: 10px; }

    .event-tabs { flex-direction: row; gap: 10px; }
    .galeri-grid{ grid-template-columns:repeat(2, 1fr); gap:8px; }
    .galeri-img-container { height: 90px; }
}
</style>