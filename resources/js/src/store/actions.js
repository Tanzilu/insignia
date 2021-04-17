/*=========================================================================================
  File Name: actions.js
  Description: Vuex Store - actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import $axios from '@/axios.js'
import axios from 'axios'

const actions = {

  // /////////////////////////////////////////////
  // COMPONENTS
  // /////////////////////////////////////////////

  // Vertical NavMenu
  updateVerticalNavMenuWidth ({ commit }, width) {
    commit('UPDATE_VERTICAL_NAV_MENU_WIDTH', width)
  },

  // VxAutoSuggest
  updateStarredPage ({ commit }, payload) {
    commit('UPDATE_STARRED_PAGE', payload)
  },

  // The Navbar
  arrangeStarredPagesLimited ({ commit }, list) {
    commit('ARRANGE_STARRED_PAGES_LIMITED', list)
  },
  arrangeStarredPagesMore ({ commit }, list) {
    commit('ARRANGE_STARRED_PAGES_MORE', list)
  },

  // /////////////////////////////////////////////
  // UI
  // /////////////////////////////////////////////

  toggleContentOverlay ({ commit }) {
    commit('TOGGLE_CONTENT_OVERLAY')
  },
  updateTheme ({ commit }, val) {
    commit('UPDATE_THEME', val)
  },

  // /////////////////////////////////////////////
  // User/Account
  // /////////////////////////////////////////////

  updateUserInfo ({ commit }, payload) {
    commit('UPDATE_USER_INFO', payload)
  },

  checkLogin ({commit}, payload) {
    return $axios
      .post('api/login', payload)
      .then((response) => {
        if (response.data.status == 'success') {
          localStorage.setItem('app-buffer', true)
          localStorage.setItem('name', response.data.userData.name)
          commit('setUserId', response.data.userData.id, { root: true })
          commit('setUserData', response.data.userData, { root: true })
        } else {
          commit('setError', { invalid: response.data.status }, { root: true })
        }
        return response.data
      })
      .catch((error) => {
        if (error.response.status == 422) {
          commit('setErrors', error.response.data.errors, { root: true })
        }
      })
  },
  logout ({commit}) {
    $axios
      .post('api/logout')
      .then(function (response) {
        if (response.data.status == 'success') {  
          localStorage.removeItem('app-buffer')
          localStorage.removeItem('name')
          commit('setUserId', null, { root: true })
          commit('clearUserData', { root: true })
        }
      })
      .catch(function (error) {
        console.log(error)
      })
  }
}

export default actions
