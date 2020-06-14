<template>
<div>
    <Navigate />
    <div class="container">
        <div class="card">
            <div class="card-header bg-secondary text-light">Photo details: {{title}}</div>
            <div class="card-body">
                <h3>{{title}} (by {{username}})</h3>
                <h5>{{description}}</h5>
                <div class="row">
                    <div class="col-6">
                        <img :src="src">
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header bg-secondary text-light">Classification</div>
                            <div class="card-body border">Content: {{content}}</div>
                            <div class="card-body border">Country: {{country}}</div>
                            <div class="card-body border">City: {{city}}</div>
                            <div class="card-body border">
                                <div class="row">
                                    <div class="col-6">
                                        Current like number: {{likeNumber}}
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-success form-control" v-show="!isFavor" @click="addFavorite">Add to my favorite!</button>
                                        <button class="btn btn-danger form-control" v-show="isFavor" @click="removeFavorite">Remove from my favorite</button>
                                    </div>
                                </div>
                            </div>
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
import Navigate from './non-route/navigate.vue'
import Footer from './non-route/footer.vue'
import {
    backend_path,
    img_path
} from '../assets/config.js'

export default {
    components: {
        Navigate,
        Footer
    },
    data() {
        return {
            src: "",
            title: "",
            originName: "",
            description: "",
            content: "scenery",
            country: "",
            city: "",
            imageID: 0,
            username: "",
            likeNumber: 0,
            isFavor: false
        }
    },
    methods: {
        loadPhotoInfo() {
            var path = this.$route.params.src.split('/')
            var imgName = path[path.length - 1]
            this.originName = imgName
            this.src = img_path + 'origin/' + imgName
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', backend_path + 'getPhotoInfo.php?src=' + imgName, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    vm.title = httpRequest.responseText.split(':')[0]
                    vm.description = httpRequest.responseText.split(':')[1]
                    vm.content = httpRequest.responseText.split(':')[2]
                    vm.country = httpRequest.responseText.split(':')[3]
                    vm.city = httpRequest.responseText.split(':')[4]
                    vm.imageID = httpRequest.responseText.split(':')[5]
                    vm.username = httpRequest.responseText.split(':')[6]
                    vm.getLikeNumber()
                    vm.checkFavorite()
                }
            };
        },
        checkFavorite() {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', backend_path + 'checkFavorite.php?imageID=' + this.imageID + "&username=" + localStorage.getItem('username'), true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == 'true') {
                        vm.isFavor = true
                    } else {
                        vm.isFavor = false
                    }
                }
            };
        },
        getLikeNumber() {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', backend_path + 'getLikeNumber.php?imageID=' + this.imageID, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    vm.likeNumber = httpRequest.responseText
                }
            };
        },
        addFavorite() {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', backend_path + 'addFavorite.php?imageID=' + this.imageID + "&username=" + localStorage.getItem('username'), true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == 'success') {
                        vm.getLikeNumber()
                        vm.checkFavorite()
                    } else
                        alert(httpRequest.responseText)
                }
            };
        },
        removeFavorite() {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', backend_path + 'removeFavorite.php?src=' + this.originName + '&username=' + localStorage.getItem('username'), true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == 'success') {
                        vm.getLikeNumber()
                        vm.checkFavorite()
                    } else {
                        alert(httpRequest.responseText)
                    }
                }
            };
        },
    },
    mounted() {
        this.loadPhotoInfo()
    }
}
</script>

<style scoped>
img {
    width: 100%;
}
</style>
