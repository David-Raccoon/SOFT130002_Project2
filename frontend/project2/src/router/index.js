import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/components/index'
import Login from '@/components/login'
import Browse from '@/components/browse'
import Search from '@/components/search'
import Upload from '@/components/upload'
import MyPhotos from '@/components/myPhotos'
import MyFavorite from '@/components/myFavorite'
import Modify from '@/components/modify'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Index',
      component: Index
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/browse',
      name: 'Browse',
      component: Browse
    },
    {
      path: '/search',
      name: 'Search',
      component: Search
    },
    {
      path: '/upload',
      name: 'Upload',
      component: Upload
    },
    {
      path: '/myPhotos',
      name: 'MyPhotos',
      component: MyPhotos
    },
    {
      path: '/myFavorite',
      name: 'MyFavorite',
      component: MyFavorite
    },
    {
      path: '/modify',
      name: 'Modify',
      component: Modify
    }
  ]
})
