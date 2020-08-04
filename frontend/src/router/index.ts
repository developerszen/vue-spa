import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import DefaultLayout from "@/layouts/default.vue";
import AdminLayout from "@/layouts/admin.vue";

import { auth } from "@/router/app/auth";
import { admin } from "@/router/app/admin";


Vue.use(VueRouter)

  const routes: Array<RouteConfig> = [
  {
      path: '*',
      redirect: '/'
  },
  {
    path: '/',
    component: DefaultLayout,
    children: [...auth]
  },
  {
      path: "/admin",
      component: AdminLayout,
      children: [...admin]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');

    if (!token && to.meta.auth) {
        next({ name: 'auth.login' })
    } else if (to.meta.home_redirect && token) {
        next({ name: 'admin.home' })
    } else {
        next();
    }
});

export default router
