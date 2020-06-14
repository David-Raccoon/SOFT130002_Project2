<template>
<div>
    <Navigate />
    <Banner />
    <div class="container-fluid">
        <div style="text-align:center">
            <button class="btn btn-primary" @click="refresh(true)">Change another groups of photos</button>
        </div>
        <br />
        <div class="row" v-for="i in 3" :key=i>
            <div class="col" v-for="j in 3" :key=j>
                <div class="alert alert-dark">
                    <div class="row">
                        <div class="col-4">
                            <a href="#" @click="details(src[j-1+3*(i-1)])">
                                <img :src="src[j-1+3*(i-1)]" style="width:100%" />
                            </a>
                        </div>
                        <div class="col-8">
                            <p>{{title[j-1+3*(i-1)]}}</p>
                            <p class="description">{{description[j-1+3*(i-1)]}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import Vue from 'vue'
import Navigate from './non-route/navigate.vue'
import Footer from './non-route/footer.vue'
import Banner from './non-route/banner.vue'
import {
    backend_path,
    img_path
} from '../assets/config.js'

export default {
    components: {
        Navigate,
        Footer,
        Banner
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
            httpRequest.open('GET', backend_path + 'homePagePicture.php?random=' + isRandom, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var res = httpRequest.responseText.split('&')
                    for (let key in res) {
                        Vue.set(vm.src, key, img_path + 'square/' + res[key].split(':')[0])
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
.description {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>
