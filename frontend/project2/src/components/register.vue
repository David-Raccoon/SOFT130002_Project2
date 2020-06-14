<template>
<div>
    <Navigate />
    <div class="container">
        <h2>Register</h2>
        <a href="#" @click="login">Already have an account? Login now!</a>
        <div class="form-group">
            <label for="text">Username:</label>
            <input type="text" class="form-control" v-model="username" placeholder="Enter username">
        </div>
        <div class="alert alert-success" v-show="successMsgUsername!=''">
            {{successMsgUsername}}
        </div>
        <div class="alert alert-danger" v-show="errorMsgUsername!=''">
            {{errorMsgUsername}}
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" v-model="password" placeholder="Enter password">
        </div>
        <div class="alert alert-success" v-show="successMsgPassword!=''">
            {{successMsgPassword}}
        </div>
        <div class="alert alert-danger" v-show="errorMsgPassword!=''">
            {{errorMsgPassword}}
        </div>
        <div class="form-group">
            <label for="pwd">Confirm Password:</label>
            <input type="password" class="form-control" v-model="rePassword" placeholder="Enter re-password">
        </div>
        <div class="alert alert-success" v-show="successMsgRePassword!=''">
            {{successMsgRePassword}}
        </div>
        <div class="alert alert-danger" v-show="errorMsgRePassword!=''">
            {{errorMsgRePassword}}
        </div>
        <div class="form-group">
            <label for="pwd">Email:</label>
            <input type="email" class="form-control" v-model="email" placeholder="Enter email">
        </div>
        <div class="alert alert-success" v-show="successMsgEmail!=''">
            {{successMsgEmail}}
        </div>
        <div class="alert alert-danger" v-show="errorMsgEmail!=''">
            {{errorMsgEmail}}
        </div>
        <input type="submit" class="btn btn-primary" value="register" @click="register" />
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
            rePassword: '',
            email: '',
            successMsgUsername: '',
            successMsgPassword: '',
            successMsgRePassword: '',
            successMsgEmail: '',
            errorMsgUsername: '',
            errorMsgPassword: '',
            errorMsgRePassword: '',
            errorMsgEmail: '',
            errorMsg: ''
        }
    },
    methods: {
        login() {
            this.$router.push({
                name: "Login"
            })
        },
        register() {
            if (this.errorMsgUsername == '' &&
                this.errorMsgPassword == '' &&
                this.errorMsgRePassword == '' &&
                this.errorMsgEmail == '' &&
                this.username != '' &&
                this.password != '' &&
                this.rePassword != '' &&
                this.email != '') {
                var httpRequest = new XMLHttpRequest()
                var vm = this
                httpRequest.open('POST', backend_path + 'register.php', true)
                httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
                httpRequest.send('username=' + this.username + '&password=' + this.password + '&email=' + this.email)
                httpRequest.onreadystatechange = function () {
                    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                        if (httpRequest.responseText == 'success') {
                            alert('Success!')
                            vm.$router.push({
                                path: "/login"
                            })
                        } else
                            vm.errorMsg = httpRequest.responseText
                    }
                };
            } else {
                this.errorMsg = 'You have not finished the form correctly yet!'
            }
        }
    },
    watch: {
        username: function () {
            var reg = /^[a-zA-Z0-9_.]*$/;
            if (reg.test(this.username)) {
                var httpRequest = new XMLHttpRequest()
                var vm = this
                httpRequest.open('GET', backend_path + 'checkUserName.php?username=' + this.username, true)
                httpRequest.send()
                httpRequest.onreadystatechange = function () {
                    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                        if (httpRequest.responseText == "true") {
                            vm.successMsgUsername = 'Vaild username.'
                            vm.errorMsgUsername = ''
                            return
                        } else {
                            vm.errorMsgUsername = 'Username already exists.'
                            vm.successMsgUsername = ''
                            return
                        }
                    }
                };
            } else {
                this.errorMsgUsername = 'Only characters in set [a-zA-Z0-9] are allowed.'
                this.successMsgUsername = ''
                return
            }
        },
        password: function () {
            var reg = /^[a-zA-Z0-9]*$/;
            if (reg.test(this.password)) {
                if (this.password.length >= 8) {
                    this.successMsgPassword = 'Vaild password.'
                    this.errorMsgPassword = ''
                    return
                } else {
                    this.errorMsgPassword = 'Password too short! 8 characters at least.'
                    this.successMsgPassword = ''
                    return
                }
            } else {
                this.errorMsgPassword = 'Only characters in set [a-zA-Z0-9] are allowed.'
                this.successMsgPassword = ''
                return
            }
        },
        rePassword: function () {
            if (this.password == this.rePassword) {
                this.successMsgRePassword = 'Correct confirm password.'
                this.errorMsgRePassword = ''
                return
            } else {
                this.errorMsgRePassword = 'The password is inconsistent with the confirmation password.'
                this.successMsgRePassword = ''
                return
            }
        },
        email: function () {
            var reg = /^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
            if (reg.test(this.email)) {
                this.successMsgEmail = 'Vaild email address.'
                this.errorMsgEmail = ''
                return
            } else {
                this.errorMsgEmail = 'Invalid email address.'
                this.successMsgEmail = ''
                return
            }
        }
    }
}
</script>
