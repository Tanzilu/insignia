/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'
import store from './store/store.js'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [

    {
    // =============================================================================
    // MAIN LAYOUT ROUTES
    // =============================================================================
      path: '/admin',
      component: () => import('@/layouts/main/Main.vue'),
      meta: { requiresAuth: true},
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {
          path: '/admin/order',
          name: 'order',
          component: () => import('@/views/backoffice/Home.vue')
        },
        {
          path: '/admin/scraping',
          name: 'scraping',
          component: () => import('@/views/backoffice/Scraping.vue')
        }
      ]
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================
        {
          path: '/',
          name: 'login',
          component: () => import('@/views/pages/Login.vue')
        },
        {
          path: '/pages/error-404',
          name: 'page-error-404',
          component: () => import('@/views/pages/Error404.vue')
        }
      ]
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/pages/error-404'
    }
  ]
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

router.beforeEach((to, from, next) => {
  const auth = localStorage.getItem('app-buffer')
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!auth) {
      next({name: 'login'})
    } else {
      next()
    }
  } else {
    next()
  }
})


export default router
