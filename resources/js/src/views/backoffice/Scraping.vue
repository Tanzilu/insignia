<template>
  <div class="vx-row">
    <div class="vx-col w-full mb-base">
      <vx-card title="Orders">
        <!-- TABLE ACTION ROW -->
        <div class="flex flex-wrap justify-between items-center">
          <!-- ITEMS PER PAGE -->

          <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
            <vs-dropdown
              vs-trigger-click
              class="cursor-pointer mb-4 md:mb-0 mr-4"
            >
              <div
                class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
              >
                <span class="mr-2"
                  >{{
                    currentPage * paginationPageSize - (paginationPageSize - 1)
                  }}
                  -
                  {{
                    products.length - currentPage * paginationPageSize > 0
                      ? currentPage * paginationPageSize
                      : products.length
                  }}
                  of {{ products.length }}</span
                >
                <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
              </div>
              <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
              <vs-dropdown-menu>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(20)">
                  <span>20</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(50)">
                  <span>50</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(100)">
                  <span>100</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(150)">
                  <span>150</span>
                </vs-dropdown-item>
              </vs-dropdown-menu>
            </vs-dropdown>
          </div>
          <div class="mb-4 md:mb-0 mr-4 justify-between"></div>

          <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
          <div
            class="flex flex-wrap items-center justify-between ag-grid-table-actions-right"
          >
            <vs-input
              class="mb-4 md:mb-0 mr-4"
              v-model="searchQuery"
              @input="updateSearchQuery"
              placeholder="Search..."
            />
            <vs-input
              class="mb-4 md:mb-0 mr-4"
              v-model="keyword"
              placeholder="keyword..."
            />
            <vs-button class="mr-3 my-2" v-on:click="find">Submit</vs-button>
          </div>
        </div>
        <ag-grid-vue
          ref="agGridTable"
          :gridOptions="gridOptions"
          class="ag-theme-material w-100 my-4 ag-grid-table"
          :columnDefs="columnDefs"
          :defaultColDef="defaultColDef"
          :rowData="products"
          rowSelection="multiple"
          colResizeDefault="shift"
          :animateRows="true"
          :floatingFilter="true"
          :pagination="true"
          :suppressExcelExport="true"
          :paginationPageSize="paginationPageSize"
          :suppressPaginationPanel="true"
          :enableRtl="$vs.rtl"
        >
        </ag-grid-vue>
        <vs-pagination
          :total="totalPages"
          :max="maxPageNumbers"
          v-model="currentPage"
        />
      </vx-card>
    </div>
  </div>
</template>

<script>
import { AgGridVue } from 'ag-grid-vue'
import axios from 'axios'
import CreateOrder from './CreateOrder.vue'


import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  components: {
    AgGridVue,
    CreateOrder
  },
  data () {
    return {
      searchQuery: '',
      keyword: '',
      gridOptions: {},
      maxPageNumbers: 7,
      gridApi: null,
      defaultColDef: {
        sortable: true,
        resizable: true,
        suppressMenu: true
      },
      columnDefs: [
        {
          headerName: 'Name',
          field: 'name',
          width: 175,
          filter: true
        },
        {
          headerName: 'Category',
          field: 'categoryName',
          filter: true,
          width: 175
        },
        {
          headerName: 'Review',
          field: 'countReview',
          filter: true,
          width: 175
        },
        {
          headerName: 'Price',
          field: 'price',
          filter: true,
          width: 175
        },
        {
          headerName: 'Rating',
          field: 'rating',
          filter: true,
          width: 150
        },
        {
          headerName: 'Rating Average',
          field: 'ratingAverage',
          filter: true,
          width: 175
        },
        {
          headerName: 'Shop Name',
          field: 'shop.name',
          filter: true,
          width: 175
        },
        {
          headerName: 'Image',
          field: 'imageUrl',
          filter: true,
          width: 175
        },
      ],
      products: []
    }
  },
  watch: {
    '$store.state.windowWidth' (val) {
      if (val <= 576) {
        this.maxPageNumbers = 4
        this.gridOptions.columnApi.setColumnPinned('email', null)
      } else this.gridOptions.columnApi.setColumnPinned('email', 'left')
    }
  },
  computed: {
    paginationPageSize () {
      if (this.gridApi) return this.gridApi.paginationGetPageSize()
      else return 50
    },
    totalPages () {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages()
      else return 0
    },
    currentPage: {
      get () {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1
        else return 1
      },
      set (val) {
        this.gridApi.paginationGoToPage(val - 1)
      }
    }
  },
  created () {
    this.fetchData()
  },
  methods: {
    updateSearchQuery (val) {
      this.gridApi.setQuickFilter(val)
    },
    fetchData () {
      axios
        .post('http://localhost:3000/api/v1/find')
        .then((response) => {
          this.products = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    find () {
      const input = {
        keyword: this.keyword
      }
      axios
        .post('http://localhost:3000/api/v1/find', input)
        .then((response) => {
          console.log(response.data)
          this.products = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    }
  },
  mounted () {
    this.gridApi = this.gridOptions.api

    /* =================================================================
      NOTE:
      Header is not aligned properly in RTL version of agGrid table.
      However, we given fix to this issue. If you want more robust solution please contact them at gitHub
    ================================================================= */
    if (this.$vs.rtl) {
      const header = this.$refs.agGridTable.$el.querySelector(
        '.ag-header-container'
      )
      header.style.left = `-${String(
        Number(header.style.transform.slice(11, -3)) + 9
      )}px`
    }
  }
}
</script>