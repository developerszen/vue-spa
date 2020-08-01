import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import DefaultLayout from "@/layouts/default.vue";
import AdminLayout from "@/layouts/admin.vue";
import AdminHome from "@/views/admin/home.vue";

import Login from "@/views/auth/login.vue";

Vue.use(VueRouter)

  const routes: Array<RouteConfig> = [
  {
    path: '/',
    component: DefaultLayout,
    children: [
        {
            path: "",
            name: "auth.login",
            component: Login
        }
    ]
  },
  {
      path: "/admin",
      component: AdminLayout,
      children: [
          {
              path: "home",
              component: AdminHome,
              name: "admin.home"
          }
      ]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
