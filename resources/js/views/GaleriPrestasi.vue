<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios' // <--- FIX: Diubah dari 'vue-pointer' ke 'axios' asli agar data muncul

const galeri = ref([])

onMounted(async () => {
    try {
        const response = await axios.get('/api/galeri-prestasi')
        galeri.value = response.data.data
    } catch (error) {
        console.log(error)
    }
})
</script>

<template>

<div class="galeri-page">

    <div class="galeri-header-page">
        <h1>
            Galeri Prestasi
        </h1>
        <p>
            Dokumentasi prestasi dan kegiatan sanggar
        </p>
    </div>

    <div class="galeri-container">
        <div
            class="galeri-card"
            v-for="item in galeri"
            :key="item.id"
        >
            <div class="galeri-img-box">
                <img
                    v-if="item.gambar"
                    :src="'/storage/' + item.gambar"
                >
            </div>

            <div class="galeri-content">
                <h2>
                    {{ item.judul }}
                </h2>
                <p>
                    {{ item.deskripsi }}
                </p>
            </div>
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

.galeri-page{
    background:#ECE8DD;
    min-height:100vh;
    padding:60px 0;
    font-family:'Poppins', sans-serif;
}

/* ================= HEADER ================= */
.galeri-header-page{
    text-align:center;
    margin-bottom:40px;
}

.galeri-header-page h1{
    width: 90%;
    max-width:420px;
    margin:auto;
    background:#005F7F;
    color:white;
    padding:16px 20px;
    border-radius:14px;
    font-size:32px;
    font-weight:600;
    box-shadow:0 4px 10px rgba(0,0,0,0.18);
}

.galeri-header-page p{
    display:none;
}

/* ================= CONTAINER ================= */
.galeri-container{
    width:calc(100% - 60px);
    max-width:1400px;
    margin:auto;
    background:#D9D9D9;
    padding:30px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.12);
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap:20px;
}

/* ================= KOTAK RATA OTOMATIS ================= */
.galeri-card{
    background:white;
    border-radius:6px;
    overflow:hidden;
    border:1px solid #B5B5B5;
    box-shadow:0 3px 8px rgba(0,0,0,0.15);
    transition:0.3s;
    display:flex;
    flex-direction:column;
    height:100%;
}

.galeri-card:hover{
    transform:translateY(-4px);
}

/* ================= IMAGE BOX ================= */
.galeri-img-box {
    width: 100%;
    height: 150px;
    overflow: hidden;
    padding: 10px 10px 5px 10px;
}

.galeri-card img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius: 4px;
}

/* ================= ISI KOTAK SEJAJAR HORIZONTAL ================= */
.galeri-content{
    display:flex;
    flex-direction:column;
    flex-grow:1;
}

.galeri-content h2{
    background:#005F7F;
    color:white;
    text-align:center;
    padding:14px 10px;
    font-size:15px;
    font-style:italic;
    font-weight:400;
    margin:0;
    flex-grow:1;
    display:flex;
    align-items:center;
    justify-content:center;
    line-height:1.4;
}

.galeri-content p{
    display:none;
}

/* ================= RESPONSIVE LAYOUT ================= */
@media(max-width:768px){
    .galeri-header-page h1{ font-size:26px; }
    .galeri-container {
        width: calc(100% - 30px);
        padding: 20px;
        gap: 15px;
        grid-template-columns: repeat(3, 1fr);
    }
}

@media(max-width:560px){
    .galeri-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        padding: 15px;
    }
    .galeri-img-box { height: 120px; padding: 6px; }
    .galeri-content h2 { font-size: 13px; padding: 10px 6px; }
}

@media(max-width:360px){
    .galeri-container {
        grid-template-columns: 1fr;
    }
}
</style>