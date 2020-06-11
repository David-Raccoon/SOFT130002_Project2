<template>
<div>
    <Navigate />
    <div class="container">
        <div class="card">
            <div class="card-header bg-secondary text-light">Upload</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3 border">
                        <img id="preview" :src="previewSrc">
                        <input type="file" id="file" class="form-control" @change="setPreview" accept="image/jpg,image/jpeg,image/png,image/PNG">
                    </div>
                    <div class="col-9 border">
                        <p>Title</p>
                        <input type="text" class="form-control" v-model="title">
                        <p>Description</p>
                        <textarea class="form-control" rows="3" v-model="description"></textarea>
                        <div class="row">
                            <div class="col-4">
                                <p>Content</p>
                                <select class="form-control" v-model="selectedContent">
                                    <option value="scenery">scenery</option>
                                    <option value="city">city</option>
                                    <option value="people">people</option>
                                    <option value="animal">animal</option>
                                    <option value="building">building</option>
                                    <option value="wonder">wonder</option>
                                    <option value="other">other</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p>Country</p>
                                <select v-model="selectedCountry" class="form-control">
                                    <option v-for="(country,index) in countries" :key="index" :value="country">{{country}}</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <p>City</p>
                                <select v-model="selectedCity" class="form-control">
                                    <option v-for="(city,index) in cities" :key="index" :value="city">{{city}}</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-success" @click="modify">modify</button>
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

export default {
    components: {
        Navigate,
        Footer
    },
    data() {
        return {
            previewSrc: "",
            title: "",
            originName: "",
            description: "",
            selectedContent: "scenery",
            selectedCountry: "",
            selectedCity: "",
            imageID: "",
            countries: [],
            cities: [],
            file: null
        }
    },
    methods: {
        loadPhotoInfo() {
            var path = this.$route.params.src.split('/')
            var imgName = path[path.length - 1]
            this.originName = imgName
            this.previewSrc = 'http://localhost:8080/SOFT130002_Project2/travel-images/origin/' + imgName
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/getPhotoInfo.php?src=' + imgName, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    vm.title = httpRequest.responseText.split(':')[0]
                    vm.description = httpRequest.responseText.split(':')[1]
                    vm.selectedContent = httpRequest.responseText.split(':')[2]
                    vm.selectedCountry = httpRequest.responseText.split(':')[3]
                    vm.selectedCity = httpRequest.responseText.split(':')[4]
                    vm.imageID = httpRequest.responseText.split(':')[5]
                }
            };
        },
        setPreview() {
            var reader = new FileReader()
            var vm = this
            this.file = document.getElementById('file').files[0]
            reader.readAsDataURL(this.file)
            reader.onload = function (e) {
                vm.previewSrc = this.result;
            }
        },
        modify() {
            var formData = new FormData()
            formData.append('originName', this.originName)
            formData.append('username', localStorage.getItem('username'))
            formData.append('imageID', this.imageID)
            formData.append('title', this.title)
            formData.append('description', this.description)
            formData.append('country', this.selectedCountry)
            formData.append('city', this.selectedCity)
            formData.append('content', this.selectedContent)
            formData.append('img', this.file)
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('POST', 'http://localhost:8080/SOFT130002_Project2/backend/modify.php', true)
            httpRequest.send(formData)
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == 'success') {
                        alert('Success!');
                        vm.$router.push({
                            path: "/myphotos"
                        })
                    } else
                        alert(httpRequest.responseText);
                }
            };
        },
        upload() {
            var formData = new FormData()
            formData.append('title', this.title)
            formData.append('description', this.description)
            formData.append('country', this.selectedCountry)
            formData.append('city', this.selectedCity)
            formData.append('content', this.selectedContent)
            formData.append('img', this.file)
            formData.append('username', localStorage.getItem('username'))
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('POST', 'http://localhost:8080/SOFT130002_Project2/backend/upload.php', true)
            httpRequest.send(formData)
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    console.log(httpRequest.responseText)
                }
            };
        }
    },
    mounted() {
        var httpRequest = new XMLHttpRequest()
        var vm = this
        httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/getAllCountries.php', true)
        httpRequest.send()
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                vm.countries = httpRequest.responseText.split('&')
            }
        };
        this.loadPhotoInfo()
    },
    watch: {
        selectedCountry: function () {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/getAllCities.php?country=' + this.selectedCountry, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    vm.cities = httpRequest.responseText.split('&')
                }
            };
            this.cities = []
        }
    }
}
</script>

<style scoped>
img {
    width: 100%;
}
</style>
