<script setup>

import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const route = useRoute()

const agenda = ref({})

onMounted(async () => {

    try {

        const response = await axios.get(
            '/api/agenda/' + route.params.id
        )

        agenda.value = response.data.data

    } catch (error) {

        console.log(error)

    }

})

</script>

<template>

<div class="detail-page">

    <div class="detail-container">

        <img
            :src="'/storage/' + agenda.gambar"
            class="detail-image"
        >

        <div class="detail-content">

            <h1>
                {{ agenda.judul }}
            </h1>

            <div class="detail-date">
                📅 {{ agenda.tanggal }}
            </div>

            <div class="detail-location">
                📍 {{ agenda.lokasi }}
            </div>

            <div class="detail-description">
                {{ agenda.deskripsi }}
            </div>

        </div>

    </div>

</div>

</template>

<style scoped>

.detail-page{
    min-height:100vh;
    background:#ECE8DD;
    padding:60px 20px;
}

.detail-container{
    max-width:1000px;
    margin:auto;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.detail-image{
    width:100%;
    height:450px;
    object-fit:cover;
}

.detail-content{
    padding:40px;
}

.detail-content h1{
    font-size:42px;
    color:#005F7F;
    margin-bottom:20px;
    font-family:'Poppins', sans-serif;
}

.detail-date,
.detail-location{
    margin-bottom:10px;
    font-size:18px;
    font-family:'Poppins', sans-serif;
    color:#444;
}

.detail-description{
    margin-top:30px;
    line-height:1.9;
    font-size:18px;
    color:#333;
    font-family:'Poppins', sans-serif;
}

</style>