<template>
<div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="#">Logo</a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#" @click="home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" @click="browse">Browse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" @click="search">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" @click="login" v-show="!isLogin">Login</a>
            </li>
            <li class="nav-item dropdown" v-show="isLogin">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    My acount
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" @click="upload">Upload</a>
                    <a class="dropdown-item" href="#" @click="myPhotos">My Photos</a>
                    <a class="dropdown-item" href="#" @click="myFavorite">My Favorite</a>
                    <a class="dropdown-item" href="#" @click="logout">Log out</a>
                </div>
            </li>
        </ul>

    </nav>
</div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import 'jquery'

export default {
    data() {
        return {
            isLogin: localStorage.getItem('username') != undefined
        }
    },
    methods: {
        home() {
            this.$router.push({
                name: "Index"
            })
        },
        browse() {
            this.$router.push({
                name: "Browse"
            })
        },
        search() {
            this.$router.push({
                name: "Search"
            })
        },
        login() {
            this.$router.push({
                name: "Login"
            })
        },
        upload() {
            this.$router.push({
                name: "Upload"
            })
        },
        myPhotos() {
            this.$router.push({
                name: "MyPhotos"
            })
        },
        myFavorite() {
            this.$router.push({
                name: "MyFavorite"
            })
        },
        logout() {
            localStorage.removeItem('username')
            this.$router.push({
                name: "Index"
            })
        },
    }
}
</script>

<style scoped>
</style>
