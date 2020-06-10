<template>
<div class="container">
    <h2>Login</h2>
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
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'

export default {
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
            httpRequest.open('POST', 'http://localhost:8080/SOFT130002_Project2/backend/login.php', true)
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
        }
    }
}
</script>
