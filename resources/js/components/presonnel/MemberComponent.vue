<template>
    <b-container fluid>
        <!-- User Interface controls -->
        <b-card-group deck>
            <b-card>
                <div slot="header">
                    <b-row>
                        <b-col cols="12" md="5">
                            <b-form-select v-model="perPage" :options="pageOptions" class="my-1"
                                           style="width: 60px;">
                            </b-form-select>
                        </b-col>
                        <b-col cols="12" md="5" class="search-group">
                            <b-form-input class="rounded-pill text-center my-1" v-model="filter"
                                          placeholder="Type to Search">
                            </b-form-input>
                            <span class="fa fa-search z-1"></span>
                        </b-col>
                        <b-col cols="12" md="2">
                            <!--<b-button block variant="outline-secondary" class="col-md btn-block my-1"-->
                                      <!--disabled-->
                                      <!--v-b-modal.create-prevent @click="create">-->
                                <!--<span class="d-md-none d-lg-inline">Create</span>-->
                                <!--<i class="fa fa-plus"></i>-->
                            <!--</b-button>-->
                        </b-col>
                    </b-row>
                </div>
                <b-card-text>
                    <!-- Main table element -->
                    <b-table
                            show-empty
                            stacked="sm"
                            :items="items"
                            :fields="fields"
                            :current-page="currentPage"
                            :per-page="perPage"
                            :filter="filter"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                            :sort-direction="sortDirection"
                            :striped="striped"
                            :bordered="bordered"
                            :hover="hover"
                            :small="small"
                            @filtered="onFiltered"
                    >
                        <template slot="thumbnail" slot-scope="row">
                            <!--<pre>{{ row }}</pre>-->
                            <div v-if="row.item.thumbnail">
                                <b-img :src="imgSrc(row.item)" height="60"></b-img>
                            </div>
                            <div v-else>
                                <b-img src="/storage/default.jpg" height="60"></b-img>
                            </div>
                        </template>
                    </b-table>

                    <b-row>
                        <b-col md="6" cols="10" class="my-1">
                            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage"
                                          class="my-0"
                            >
                            </b-pagination>
                        </b-col>
                    </b-row>
                </b-card-text>
            </b-card>
        </b-card-group>
    </b-container>
</template>

<script>
  const items = []
  export default {
    data () {
      return {
        // modalShow: false,
        items        : items,
        fields       : [
          {
            key          : 'name',
            label        : '姓名',
            sortable     : true,
            sortDirection: 'desc',
          },
          {
            key          : 'email',
            label        : '信箱',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'habook',
            label        : 'habookID',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'thumbnail',
            label        : '縮圖',
          },
          // {
          //   key  : 'actions',
          //   label: '操作'
          // }

        ],

        currentPage  : 1,
        perPage      : 10,
        totalRows    : 1,
        pageOptions  : [10, 15, 25, 50, 100],
        sortBy       : null,
        sortDesc     : false,
        sortDirection: 'asc',
        filter       : null,
        striped      : true,
        bordered     : true,
        small        : true,
        hover        : true,
        state        : null,
        disabled     : true

      }
    },
    computed: {
      sortOptions () {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return {
              text : f.label,
              value: f.key
            }
          })
      },

    },

    methods : {
      onFiltered (filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows   = filteredItems.length
        this.currentPage = 1
      },

      getUserList () {
        // let groupUserUrl = '/api/group/user'
          let groupUserUrl = `api/users`;
        let _this        = this
        axios.get(groupUserUrl).then((response) => {
          // console.log(response);
          _this.items     = response.data
          _this.totalRows = response.data.length
        }).catch((error) => {
          console.log(error)
        })

      },

        imgSrc(v) {
            return `${this.$store.state.path.user}${v.id}/${v.thumbnail}`;
            // return `${_this.$store.path.group}${d.id}/${d.thumbnail}`;

        },

      init () {
        this.getUserList()
      }
    },

    mounted () {
        this.init();
    }
  }
</script>
<style scoped lang="scss">
    .search-group {
        input {
            position: relative;
        }

        span {
            position: absolute;
            color: #dbdbdb;
            pointer-events: none;;
            top: 17px;
            left: 30px;
            width: 2.25rem;
        }
    }
</style>
