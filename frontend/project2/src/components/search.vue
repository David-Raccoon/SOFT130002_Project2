<template>
<div>
    <Navigate />
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card">
                <div class="card-header bg-secondary text-light">Search</div>
                <div class="card-body">
                    <form>
                        <div class="radio">
                            <label><input type="radio" value="byTitle" v-model="method">Search by title</label>
                        </div>
                        <input type="text" class="form-control" v-model="searchTitle">
                        <div class="radio">
                            <label><input type="radio" value="byDescription" v-model="method">Search by description</label>
                        </div>
                        <textarea class="form-control" rows="3" v-model="searchDescription"></textarea>
                    </form>
                    <br />
                    <button class="btn btn-success form-control" @click="search">search</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-secondary text-light">Result</div>
                <div class="card-body border">
                    <div class="row border" v-for="i in pageSize" :key="i" v-show="i+pageSize*(currentPage-1)<=resultCount">
                        <div class="col-3 ">
                            <a href="#" @click="details(src[i-1+pageSize*(currentPage-1)])">
                                <img :src="src[i-1+pageSize*(currentPage-1)]">
                            </a>
                        </div>
                        <div class="col-9">
                            <p>{{title[i-1+pageSize*(currentPage-1)]}}</p>
                            <p class="description">{{description[i-1+pageSize*(currentPage-1)]}}</p>
                        </div>
                    </div>
                    <br>
                    <div style="text-align:center">
                        <div class="btn-group btn-group-sm">
                            <button type="button" v-show="pageCount>=1" class="btn btn-primary" @click="turnToPage(currentPage-1)">《</button>
                            <button type="button" v-for="i in pageCount" :key="i" :id="i" class="btn btn-primary" @click="turnToPage(i)">{{i}}</button>
                            <button type="button" v-show="pageCount>=1" class="btn btn-primary" @click="turnToPage(currentPage+1)">》</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
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
            searchTitle: '',
            searchDescription: '',
            src: [],
            title: [],
            description: [],
            method: 'byTitle',
            pageCount: 1,
            resultCount: 0,
            currentPage: 1,
            pageSize: 5,
        }
    },
    methods: {
        setPage() {
            this.resultCount = this.src.length
            this.pageCount = Math.ceil(this.resultCount / this.pageSize)
        },
        search() {
            if (this.method == 'byTitle')
                this.searchByTitle(this.searchTitle)
            else
                this.searchByDescription(this.searchDescription)
        },
        searchByTitle(keyword) {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', backend_path + 'searchByTitle.php?keyword=' + keyword, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var res = httpRequest.responseText.split('&')
                    vm.src = []
                    vm.title = []
                    vm.description = []
                    for (let key in res) {
                        if (res[key] == "")
                            continue
                        Vue.set(vm.src, key, img_path + 'square/' + res[key].split(':')[0])
                        Vue.set(vm.title, key, res[key].split(':')[1])
                        Vue.set(vm.description, key, res[key].split(':')[2])
                    }
                    vm.setPage()
                    vm.turnToPage(1)
                }
            };
        },
        searchByDescription(keyword) {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', backend_path + 'searchByDescription.php?keyword=' + keyword, true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var res = httpRequest.responseText.split('&')
                    vm.src = []
                    vm.title = []
                    vm.description = []
                    for (let key in res) {
                        if (res[key] == "")
                            continue
                        Vue.set(vm.src, key, img_path + 'square/' + res[key].split(':')[0])
                        Vue.set(vm.title, key, res[key].split(':')[1])
                        Vue.set(vm.description, key, res[key].split(':')[2])
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
        this.searchByTitle('')
    }
}
</script>

<style scoped>
.description {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
