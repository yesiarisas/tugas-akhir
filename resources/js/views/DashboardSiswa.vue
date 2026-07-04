<template>
<div class="dashboard-layout">

    <aside class="sidebar" :class="{ 'open': isSidebarOpen }">
        <div class="sidebar-top" @click="changeMenu('dashboard')" title="Kembali ke Dashboard">
            <div class="logo-box">
                <h2>Langlang Buana</h2>
            </div>
        </div>

        <nav class="sidebar-menu">
            <button 
                class="menu-item" 
                :class="{ active: activeMenu === 'dashboard' }" 
                @click="changeMenu('dashboard')"
            >
                📢 Dashboard & Info
            </button>

            <button 
                class="menu-item" 
                :class="{ active: activeMenu === 'profil' }" 
                @click="changeMenu('profil')"
            >
                👤 Data Diri
            </button>

            <button 
                class="menu-item" 
                :class="{ active: activeMenu === 'pengumuman' }" 
                @click="changeMenu('pengumuman')"
            >
                🔔 Pengumuman
            </button>

            <button 
                class="menu-item" 
                :class="{ active: activeMenu === 'jadwal' }" 
                @click="changeMenu('jadwal')"
            >
                📅 Jadwal Latihan
            </button>

            <button 
                class="menu-item" 
                :class="{ active: activeMenu === 'grafik' }" 
                @click="changeMenu('grafik')"
            >
                📈 Grafik Perkembangan
            </button>

            <button 
                class="menu-item" 
                :class="{ active: activeMenu === 'pembayaran' }" 
                @click="changeMenu('pembayaran')"
            >
                💳 Riwayat Pembayaran
            </button>
        </nav>

        <button class="logout-btn" @click="logout">
            Logout Akun 🚪
        </button>
    </aside>

    <div v-if="isSidebarOpen" class="sidebar-overlay" @click="toggleSidebar"></div>

    <main class="main-content">

        <div class="topbar">
            <div class="menu-icon" @click="toggleSidebar">☰</div>
            <h1 v-if="activeMenu === 'dashboard'">Dashboard Siswa</h1>
            <h1 v-else-if="activeMenu === 'profil'">Data Diri</h1>
            <h1 v-else-if="activeMenu === 'pengumuman'">Pengumuman</h1>
            <h1 v-else-if="activeMenu === 'jadwal'">Jadwal Latihan</h1>
            <h1 v-else-if="activeMenu === 'grafik'">Grafik Perkembangan</h1>
            <h1 v-else-if="activeMenu === 'pembayaran'">Riwayat Pembayaran</h1>
        </div>

        <div v-if="isLoading" class="loading-state">
            <p>Memuat informasi siswa...</p>
        </div>

        <div v-else class="content-body">
            
            <div v-if="activeMenu === 'dashboard'" class="dashboard-widgets">
                <div class="welcome-banner">
                    <h3>Selamat Datang, {{ profil.nama || 'Siswa' }}! 👋</h3>
                    <p>Selamat berlatih di Sanggar Tari Langlang Buana. Tetap semangat melestarikan seni budaya.</p>
                </div>

                <div class="widgets-grid">
                    <div class="widget-card text-center display-flex-center">
                        <h4>Tingkat Kelas</h4>
                        <div class="class-text-display">{{ kelasJenjang }}</div>
                        <p>Kategori jenjang tari kamu berdasarkan umur.</p>
                    </div>

                    <div class="widget-card">
                        <h4>Jadwal Latihan Terdekat</h4>
                        
                        <div v-if="listJadwal && listJadwal.length > 0">
                            <div class="widget-info-box">
                                <p class="main-text">📆 {{ listJadwal[0].hari }}</p>
                                <p class="sub-text">🕒 {{ formatWaktu(listJadwal[0].jam_mulai) }} - {{ formatWaktu(listJadwal[0].jam_selesai) }} WIB</p>
                                <p class="sub-text">📍 {{ listJadwal[0].lokasi }}</p>
                            </div>
                            <button class="read-more-link" style="margin-top: 8px;" @click="changeMenu('jadwal')">
                                Lihat Semua Jadwal ➡️
                            </button>
                        </div>

                        <div v-else class="widget-info-box alert-danger">
                            <p class="main-text">⚠️ Belum Ada Jadwal</p>
                            <p class="sub-text">Jadwal latihan aktif belum diatur oleh admin.</p>
                        </div>
                    </div>

                    <div class="widget-card">
                        <h4>Status Iuran Terakhir</h4>
                        <div 
                            class="widget-info-box" 
                            :class="statusIuranTerakhir.status === 'lunas' ? 'alert-success' : 'alert-danger'"
                        >
                            <p class="main-text">
                                {{ statusIuranTerakhir.status === 'lunas' ? '🟢 Lunas' : '🔴 Belum Lunas / Transaksi Kosong' }}
                            </p>
                            <p class="sub-text">Periode: {{ statusIuranTerakhir.periode }}</p>
                            <p class="sub-text" v-if="statusIuranTerakhir.tanggal">Tanggal Bayar: {{ formatTanggalIndo(statusIuranTerakhir.tanggal) }}</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-announcement-box">
                    <h4>📌 Pengumuman Terbaru</h4>
                    
                    <div v-if="pengumumanTerbaru" class="announcement-item-mini">
                        <h5>{{ pengumumanTerbaru.judul }}</h5>
                        <p class="date-text">Diterbitkan: {{ pengumumanTerbaru.tanggal }}</p>
                        <p>
                            {{
                                pengumumanTerbaru?.isi
                                    ? (pengumumanTerbaru.isi.length > 150 ? pengumumanTerbaru.isi.substring(0, 150) + '...' : pengumumanTerbaru.isi)
                                    : '-'
                            }}
                        </p>
                        <button class="read-more-link" @click="changeMenu('pengumuman')">
                            Baca Selengkapnya ➡️
                        </button>
                    </div>

                    <div v-else class="announcement-item-mini text-center">
                        <p style="color: #999; padding: 10px 0;">Belum ada pengumuman resmi terbaru saat ini.</p>
                    </div>
                </div>
            </div>

            <ProfilSiswa v-else-if="activeMenu === 'profil'" :siswaId="idSiswaLogin" />

            <PengumumanSiswa v-else-if="activeMenu === 'pengumuman'" />

            <JadwalSiswa v-else-if="activeMenu === 'jadwal'" />

            <GrafikSiswa v-else-if="activeMenu === 'grafik'" :siswaId="idSiswaLogin" />

            <RiwayatPembayaran v-else-if="activeMenu === 'pembayaran'" :siswaId="idSiswaLogin" />

        </div>
    </main>
</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

import ProfilSiswa from './ProfilSiswa.vue'
import PengumumanSiswa from './PengumumanSiswa.vue'
import GrafikSiswa from './GrafikSiswa.vue'
import RiwayatPembayaran from './RiwayatPembayaran.vue'
import JadwalSiswa from './JadwalSiswa.vue'

const router = useRouter()

const isSidebarOpen = ref(true)
const profil = ref({})
const kelasJenjang = ref('-')
const isLoading = ref(true)
const pengumumanTerbaru = ref(null)
const idSiswaLogin = ref(null)
const activeMenu = ref('dashboard')
const listJadwal = ref([])

const statusIuranTerakhir = ref({
    status: 'belum',
    periode: '-',
    tanggal: null
})

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value
}

const formatWaktu = (timeStr) => {
    if (!timeStr) return '--:--'
    return timeStr.substring(0, 5)
}

const formatTanggalIndo = (dateStr) => {
    if (!dateStr) return '-'
    const opsi = { year: 'numeric', month: 'short', day: 'numeric' }
    return new Date(dateStr).toLocaleDateString('id-ID', opsi)
}

const fetchJadwalSiswaUntukWidget = async () => {
    if (!idSiswaLogin.value) return
    try {
        const res = await axios.get(`/api/siswa/jadwal/${idSiswaLogin.value}`)
        if (res.data && res.data.status) {
            listJadwal.value = res.data.data || []
        }
    } catch (err) {
        console.error("Gagal widget jadwal:", err)
    }
}

const fetchRingkasanPembayaran = async () => {
    if (!idSiswaLogin.value) return
    try {
        const res = await axios.get(`/api/siswa/pembayaran/${idSiswaLogin.value}`)
        if (res.data && res.data.status && res.data.data.length > 0) {
            const terupdate = res.data.data[0]
            statusIuranTerakhir.value = {
                status: terupdate.status,
                periode: terupdate.periode,
                tanggal: terupdate.tanggal
            }
        }
    } catch (err) {
        console.error("Gagal widget pembayaran:", err)
    }
}

onMounted(async () => {
    if (window.innerWidth <= 768) {
        isSidebarOpen.value = false
    }

    const userData = localStorage.getItem('user')
    if (!userData) {
        router.push('/login-siswa')
        return
    }

    const user = JSON.parse(userData)
    idSiswaLogin.value = user.id || user.id_user || null

    try {
        if (idSiswaLogin.value) {
            const profilRes = await axios.get(`/api/siswa/profil/${idSiswaLogin.value}`)
            if (profilRes.data) {
                profil.value = profilRes.data.siswa || {}
                kelasJenjang.value = profilRes.data.kelas || '-'
            }
        }

        const pengumumanRes = await axios.get('/api/pengumuman')
        if (pengumumanRes.data && pengumumanRes.data.length > 0) {
            pengumumanTerbaru.value = pengumumanRes.data[0]
        }

        await fetchJadwalSiswaUntukWidget()
        await fetchRingkasanPembayaran()
    } catch (err) {
        console.error("Gagal load info:", err)
    } finally {
        isLoading.value = false
    }
})

const changeMenu = (menuName) => {
    activeMenu.value = menuName
    if (window.innerWidth <= 768) {
        isSidebarOpen.value = false
    }
    if (menuName === 'dashboard') {
        fetchJadwalSiswaUntukWidget()
        fetchRingkasanPembayaran()
    }
}

const logout = () => {
    localStorage.removeItem('user')
    router.push('/login-siswa')
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

.dashboard-layout{
    display:flex;
    width: 100%;
    min-height:100vh;
    background:#ECE8DD;
    font-family:'Poppins',sans-serif;
    overflow-x: hidden;
}

.sidebar{
    width: 0;
    min-width: 0;
    opacity: 0;
    visibility: hidden;
    background:#ECE8DD;
    border-right: 1px solid #d5d5d5;
    display:flex;
    flex-direction:column;
    height: 100vh;
    position: sticky;
    top: 0;
    transition: all 0.3s ease;
    overflow: hidden;
    z-index: 99;
}

.sidebar.open {
    width: 300px;
    min-width: 300px;
    opacity: 1;
    visibility: visible;
}

.sidebar-top{
    background:#005F7F;
    padding:25px;
    border-bottom:4px solid #d4b000;
    cursor:pointer;
    white-space: nowrap;
}
.sidebar-top:hover {
    background: #004d66;
}

.logo-box h2{
    color:white;
    font-size:26px;
    font-weight:600;
}

.sidebar-menu{
    padding:20px;
    display:flex;
    flex-direction:column;
    gap:12px;
    flex-grow: 1;
    overflow-y: auto;
}

.menu-item{
    border:none;
    background:white;
    min-height:65px;
    font-size:16px;
    font-weight:600;
    text-align:left;
    padding:0 20px;
    cursor:pointer;
    border-radius:6px;
    color: #444;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.menu-item:hover {
    background: #f5f5f5;
}

.menu-item.active{
    background:#8DB1BA;
    color: white;
}

.logout-btn{
    margin: 25px;
    height:50px;
    border:none;
    background:#005F7F;
    color:white;
    border-radius:5px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition: background 0.2s;
    white-space: nowrap;
}
.logout-btn:hover { background: #cc3333; }

.main-content{
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.topbar{
    height:95px;
    background:#005F7F;
    border-bottom:4px solid #d4b000;
    display:flex;
    align-items:center;
    gap:20px;
    padding:0 40px;
}

.menu-icon{
    font-size:30px;
    color:white;
    cursor: pointer;
    padding: 5px 10px;
    user-select: none;
    border-radius: 4px;
    transition: background 0.2s;
}
.menu-icon:hover {
    background: rgba(255, 255, 255, 0.1);
}

.topbar h1{
    color:white;
    font-size:32px;
    font-weight:700;
}

.content-body {
    padding: 40px;
    flex: 1;
}

.loading-state {
    padding: 50px;
    font-size: 18px;
    color: #005F7F;
}

.welcome-banner {
    background: #005F7F;
    color: white;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    border-left: 6px solid #d4b000;
}
.welcome-banner h3 { font-size: 24px; margin-bottom: 5px; }

.widgets-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}
.widget-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.widget-card h4 { color: #555; font-size: 16px; margin-bottom: 15px; }
.text-center { text-align: center; }

.display-flex-center {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}

.class-text-display {
    color: #005F7F;
    font-size: 28px;
    font-weight: 700;
    padding: 15px 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.widget-info-box {
    background: #f9f9f9;
    padding: 12px;
    border-radius: 6px;
    border-left: 4px solid #8DB1BA;
}
.widget-info-box.alert-success {
    background: #e6f4ea;
    border-left-color: #137333;
}
.widget-info-box.alert-danger {
    background: #fce8e6;
    border-left-color: #c5221f;
}
.main-text { font-weight: 600; color: #222; font-size: 16px; }
.sub-text { font-size: 13px; color: #666; margin-top: 2px; }

.dashboard-announcement-box {
    background: white;
    padding: 25px;
    border-radius: 8px;
}
.dashboard-announcement-box h4 { margin-bottom: 15px; color: #005F7F; }
.announcement-item-mini {
    padding: 15px;
    background: #fdfbf7;
    border: 1px solid #f1e6cc;
    border-radius: 6px;
}
.announcement-item-mini h5 { font-size: 16px; color: #333; }
.date-text { font-size: 12px; color: #999; margin-bottom: 8px; }

.read-more-link {
    background: none;
    border: none;
    color: #005F7F;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    padding: 0;
    margin-top: 10px;
    display: inline-block;
}
.read-more-link:hover {
    text-decoration: underline;
    color: #004d66;
}

@media(max-width:992px){
    .widgets-grid { grid-template-columns: 1fr; }
}

@media(max-width:768px){
    .topbar { padding: 0 20px; height: 80px; }
    .topbar h1 { font-size: 24px; }
    .content-body { padding: 20px; }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
    }

    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        z-index: 90;
    }
}
</style>