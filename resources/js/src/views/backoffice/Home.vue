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
                    orders.length - currentPage * paginationPageSize > 0
                      ? currentPage * paginationPageSize
                      : orders.length
                  }}
                  of {{ orders.length }}</span
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
            <create-order></create-order>
          </div>
        </div>
        <ag-grid-vue
          ref="agGridTable"
          :gridOptions="gridOptions"
          class="ag-theme-material w-100 my-4 ag-grid-table"
          :columnDefs="columnDefs"
          :defaultColDef="defaultColDef"
          :rowData="orders"
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
import axios from '@/axios.js'
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
      gridOptions: {},
      maxPageNumbers: 7,
      gridApi: null,
      defaultColDef: {
        sortable: true,
        editable: true,
        resizable: true,
        suppressMenu: true
      },
      columnDefs: [
        {
          headerName: 'Invoice Number',
          field: 'invoice',
          width: 175,
          filter: true
        },
        {
          headerName: 'Date',
          field: 'created_at',
          filter: true,
          width: 200
        },
        {
          headerName: 'Customer',
          field: 'email',
          filter: true,
          width: 230
        },
        {
          headerName: 'Payment',
          field: 'payment_status',
          filter: true,
          width: 175
        },
        {
          headerName: 'Fulfillment Status',
          field: 'fulfillment_status',
          filter: true,
          width: 200
        },
        {
          headerName: 'Total',
          field: 'total',
          filter: true,
          width: 175
        }
      ],
      orders: []
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
        .get('api/getOrders')
        .then((response) => {
          this.orders = response.data.orders
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