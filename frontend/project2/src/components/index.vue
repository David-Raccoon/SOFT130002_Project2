<template>
<div>
    <Navigate />
    <div class="container-fluid">
        <div class="row" v-for="i in 3" :key=i>
            <div class="col" v-for="j in 3" :key=j>
                <div class="alert alert-dark">
                    <a href="#" @click="details(src[j-1+3*(i-1)])">
                        <img :src="src[j-1+3*(i-1)]" />
                    </a>
                    <p>{{title[j-1+3*(i-1)]}}</p>
                    <p>{{description[j-1+3*(i-1)]}}</p>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" @click="refresh(true)">refresh</button>
    <Footer />
</div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import Vue from 'vue'
import Navigate from './non-route/navigate.vue'
import Footer from './non-route/footer.vue'

export default {
    components: {
        Navigate,
        Footer
    },
    data() {
        return {
            title: [],
            description: [],
            src: [],
        }
    },
    methods: {
        details(imgSrc) {
            this.$router.push({
                path: "/details",
                name: "Details",
                params: {
                    src: imgSrc
                }
            })
        },
        refresh(isRandom) {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/homePagePicture.php?random=' + isRandom, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var res = httpRequest.responseText.split('&')
                    for (let key in res) {
                        Vue.set(vm.src, key, "http://localhost:8080/SOFT130002_Project2/travel-images/square/" + res[key].split(':')[0])
                        Vue.set(vm.title, key, res[key].split(':')[1])
                        Vue.set(vm.description, key, res[key].split(':')[2])
                    }
                }
            };
        },
    },
    mounted() {
        this.refresh(false)
    }
}
</script>

<style scoped>
footer {
    position: fixed;
}

img {
    width: 30%;
}
</style>
