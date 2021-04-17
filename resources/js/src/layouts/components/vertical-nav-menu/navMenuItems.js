/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  {
    url: "/admin/dashboard",
    name: "Dashboard",
    slug: "dashboard",
    icon: "HomeIcon",
  },
  {
    url: null ,
    name: "Report",
    slug: "report",
    icon: "FileIcon",
    submenu: [
      {
        url: "/admin/reportNonActive",
        name: 'Non Active Parking',
        slug: 'non-active-parking',
        i18n: 'List'
      },
      {
        url: "/admin/reportActive",
        name: 'Active Parking',
        slug: 'active-parking',
        i18n: 'List'
      }
    ]
  }
]
