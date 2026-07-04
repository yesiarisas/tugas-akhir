import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../views/HomePage.vue'
import PendaftaranPage from '../views/PendaftaranPage.vue'
import StatusPendaftaranPage from '../views/StatusPendaftaranPage.vue'
import RegisterSiswaPage from '../views/RegisterSiswaPage.vue'
import LoginSiswaPage from '../views/LoginSiswaPage.vue'
import DashboardSiswa from '../views/DashboardSiswa.vue'
import GaleriPrestasi from '../views/GaleriPrestasi.vue' // ✅ Jalur import sudah diperbaiki

const routes = [
    { path: '/', component: HomePage },
    { path: '/pendaftaran', component: PendaftaranPage },
    { path: '/status-pendaftaran', component: StatusPendaftaranPage },
    { path: '/register-siswa', component: RegisterSiswaPage },
    { path: '/login-siswa', component: LoginSiswaPage },
    
    { 
        path: '/galeri-prestasi', 
        name: 'galeri-prestasi',
        component: GaleriPrestasi 
    },

    {
        path: '/dashboard-siswa',
        name: 'dashboard-siswa',
        component: DashboardSiswa,
        beforeEnter: (to, from, next) => {
            const user = localStorage.getItem('user')
            if (user) {
                next()
            } else {
                alert('Akses ditolak! Silakan login terlebih dahulu.')
                next('/login-siswa')
            }
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router