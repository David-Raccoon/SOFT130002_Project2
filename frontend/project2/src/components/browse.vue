<template>
<div>
    <Navigate />
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header bg-secondary text-light">Search By Title</div>
                <div class="card-footer">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="keyword">
                        <button class="btn btn-primary" @click="searchByTitle">search</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-secondary text-light">Hot country</div>
                <div class="card-body border" v-for="(country,index) in countries" :key="index" v-show="index<8">
                    <a @click="filter('',country,'')" href="#">{{country}}</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-secondary text-light">Select a content</div>
                <div class="card-body border" v-for="(content,index) in contents" :key="index">
                    <a @click="filter(content,'','')" href="#">{{content}}</a>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header bg-secondary text-light">Filter</div>
                <div class="card-body border">
                    <div class="row">
                        <div class="col-3">
                            <select class="form-control" v-model="selectedContent">
                                <option v-for='(content,index) in contents' :key="index" :value="content">{{content}}</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select v-model="selectedCountry" class="form-control">
                                <option v-for="(country,index) in countries" :key="index" :value="country">{{country}}</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select v-model="selectedCity" class="form-control">
                                <option v-for="(city,index) in cities" :key="index" :value="city">{{city}}</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-success" @click="filter(selectedContent,selectedCountry,selectedCity)">Filter</button>
                            <button class="btn btn-warning" @click="selectedContent=selectedCountry=selectedCity=''">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="card-body border">
                    <div class="row" v-for="i in 4" :key="i">
                        <div class="col-3" v-for="j in 4" :key="j">
                            <a href="#" @click="details(src[4*(i-1)+j-1+16*(currentPage-1)])">
                                <img :src="src[4*(i-1)+j-1+16*(currentPage-1)]" />
                            </a>
                        </div>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" v-show="pageCount>=1" class="btn btn-primary" @click="turnToPage(currentPage-1)">《</button>
                        <button type="button" v-for="i in pageCount" :key="i" :id="i" class="btn btn-primary" @click="turnToPage(i)">{{i}}</button>
                        <button type="button" v-show="pageCount>=1" class="btn btn-primary" @click="turnToPage(currentPage+1)">》</button>
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
            contents: ['scenery', 'city', 'people', 'animal', 'building', 'wonder', 'other'],
            countries: [],
            cities: [],
            src: [],
            pageCount: 1,
            resultCount: 0,
            currentPage: 1,
            pageSize: 16,
            keyword: "",
            selectedContent: "",
            selectedCountry: "",
            selectedCity: "",
        }
    },
    methods: {
        setPage() {
            this.resultCount = this.src.length
            this.pageCount = Math.ceil(this.resultCount / this.pageSize)
        },
        searchByTitle() {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/searchByTitle.php?keyword=' + this.keyword, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var res = httpRequest.responseText.split('&')
                    vm.src = []
                    for (let key in res) {
                        if (res[key] == "")
                            continue
                        Vue.set(vm.src, key, "http://localhost:8080/SOFT130002_Project2/travel-images/square/" + res[key].split(':')[0])
                    }
                    vm.setPage()
                    vm.turnToPage(1)
                }
            };
        },
        filter(content, country, city) {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/filter.php?content=' + content + "&country=" + country + "&city=" + city, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var res = httpRequest.responseText.split('&')
                    vm.src = []
                    for (let key in res) {
                        if (res[key] == "")
                            continue
                        Vue.set(vm.src, key, "http://localhost:8080/SOFT130002_Project2/travel-images/square/" + res[key])
                    }
                    vm.setPage()
                    vm.turnToPage(1)
                }
            };
        },
        turnToPage(num) {
            if (num > this.pageCount || num < 1)
                return
            this.currentPage = num
            for (let i = 1; i <= this.pageCount; i++) {
                if (document.getElementById(String(i)) == null)
                    continue
                if (i == num)
                    document.getElementById(String(i)).setAttribute('class', 'btn btn-success')
                else
                    document.getElementById(String(i)).setAttribute('class', 'btn btn-primary')
            }
        },
        details(imgSrc) {
            this.$router.push({
                path: "/details",
                name: "Details",
                params: {
                    src: imgSrc
                }
            })
        },
    },
    mounted() {
        this.searchByTitle()
        var httpRequest = new XMLHttpRequest()
        var vm = this
        httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/getCountriesByPhotoCount.php', true)
        httpRequest.send()
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                vm.countries = httpRequest.responseText.split('&')
            }
        };
    },
    watch: {
        selectedCountry: function () {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/getCitiesByPhotoCount.php?country=' + this.selectedCountry, true)
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
</style>
