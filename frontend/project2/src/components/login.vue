<template>
<div>
    <Navigate />
    <div class="container">
        <h2>Login</h2>
        <a href="#" @click="register">Do not have an account? Register now!</a>
        <div class="form-group">
            <label for="text">Username:</label>
            <input type="text" class="form-control" v-model="username" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" v-model="password" placeholder="Enter password">
        </div>
        <input type="submit" class="btn btn-primary" value="Login" @click="login" />
        <div class="alert alert-danger" v-show="errorMsg!=''">
            {{errorMsg}}
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
            username: '',
            password: '',
            errorMsg: ''
        }
    },
    methods: {
        login() {
            if (this.username == '' || this.password == '')
                return;
            var httpRequest = new XMLHttpRequest()
            var vm = this
            httpRequest.open('POST', backend_path + 'login.php', true)
            httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            httpRequest.send('username=' + this.username + '&password=' + this.password)
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == 'success') {
                        localStorage.setItem('username', vm.username)
                        vm.$router.push({
                            path: "/"
                        })
                    } else
                        vm.errorMsg = httpRequest.responseText
                }
            };
        },
        register() {
            this.$router.push({
                name: "Register"
            })
        }
    }
}
</script>
