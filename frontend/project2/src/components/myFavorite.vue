<template>
<div>
    <Navigate />
    <div class="container">
        <div class="card">
            <div class="card-header bg-secondary text-light">My Favorite</div>
            <div class="card-body">
                <!-- 模态框 -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- 模态框头部 -->
                            <div class="modal-header">
                                <h4 class="modal-title">Are you sure to remove this favorite?</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- 模态框主体 -->
                            <div class="modal-body">
                                {{deleteTitle}}
                            </div>
                            <!-- 模态框底部 -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeFavorite">Confirm</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row border" v-for="i in 5" :key="i" v-show="i+5*(currentPage-1)<=resultCount">
                    <div class="col-3 ">
                        <a href="#" @click="details(src[i-1+5*(currentPage-1)])">
                            <img :src="src[i-1+5*(currentPage-1)]">
                        </a>
                    </div>
                    <div class="col-9">
                        <p>{{title[i-1+5*(currentPage-1)]}}</p>
                        <p>{{description[i-1+5*(currentPage-1)]}}</p>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal" @click="deleteIndex=i-1+5*(currentPage-1);deleteTitle=title[deleteIndex]">
                            Remove from favorite
                        </button>
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
            deleteTitle: "",
            deleteIndex: 0,
            src: [],
            title: [],
            description: [],
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
        removeFavorite() {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            var path = this.src[this.deleteIndex].split('/')
            var imgName = path[path.length - 1]
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/removeFavorite.php?src=' + imgName + '&username=' + localStorage.getItem('username'), true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == 'success')
                        vm.refresh()
                    else {
                        console.log(httpRequest.responseText)
                    }
                }
            };
        },
        refresh() {
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('GET', 'http://localhost:8080/SOFT130002_Project2/backend/getMyFavorite.php?username=' + localStorage.getItem('username'), true)
            httpRequest.send()
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var res = httpRequest.responseText.split('&')
                    vm.src = []
                    vm.title = []
                    vm.description = []
                    for (let key in res) {
                        Vue.set(vm.src, key, "http://localhost:8080/SOFT130002_Project2/travel-images/square/" + res[key].split(':')[0])
                        Vue.set(vm.title, key, res[key].split(':')[1])
                        Vue.set(vm.description, key, res[key].split(':')[2])
                    }
                    vm.page = (vm.src.length - 1) / 5 + 1
                    vm.resultCount = vm.src.length
                    vm.setPage()
                    vm.turnToPage(1)
                }
            };
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
        this.refresh()
    }
}
</script>

<style scoped>
</style>
