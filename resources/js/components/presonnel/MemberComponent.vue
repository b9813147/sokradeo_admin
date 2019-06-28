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
                            <b-button block variant="outline-secondary" class="col-md btn-block my-1"
                                      v-b-modal.create-prevent @click="create">
                                <span class="d-md-none d-lg-inline">Create</span>
                                <i class="fa fa-plus"></i>
                            </b-button>
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
                        <template slot="group_name" slot-scope="row">
                            {{ row.item.group_name }}
                        </template>
                        <template slot="name" slot-scope="row">
                            {{ row.item.name }}
                        </template>
                        <template slot="member_status" slot-scope="row">
                            {{ (row.item.member_status) ? '啟用' : '停用' }}
                        </template>
                        <template slot="member_duty" slot-scope="row">
                            {{
                            (row.item.member_duty === 'Expert')
                            ? '專家'
                            :((row.item.member_duty === 'Admin')
                            ? '管理員': '一般身份')
                            }}
                        </template>

                        <template slot="actions" slot-scope="row">
                            <b-button variant="outline-info" size="sm" v-b-modal.modal-prevent
                                      @click="setValue(row.item)">編輯
                            </b-button>
                        </template>
                    </b-table>

                    <b-row>
                        <b-col md="6" cols="10" class="my-1">
                            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage"
                                          class="my-0">
                            </b-pagination>
                        </b-col>
                    </b-row>
                </b-card-text>
            </b-card>
        </b-card-group>
        <!-- create modal-->
        <b-modal id="create-prevent" ref="create-modal" title="create">
            <form>
                <b-form-group label="群組名稱">
                    <b-form-select v-model="groupId" :options="groups" required></b-form-select>
                </b-form-group>
                <b-form-group label="HaBookID">
                    <b-form-input id="input-live" v-model="habook"
                                  aria-describedby="input-live-help input-live-feedback" :state="state"></b-form-input>
                    <b-form-invalid-feedback id="input-live-feedback">{{ message }}</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="狀態">
                    <b-form-select v-model="selectValue.member_status" :options="member_status"
                                   required></b-form-select>
                </b-form-group>
                <b-form-group label="身份">
                    <b-form-select v-model="selectValue.member_duty" :options="member_duty" required></b-form-select>
                </b-form-group>
            </form>
            <div slot="modal-footer">
                <b-button variant="secondary" @click="clear" size="xl">cancel</b-button>
                <b-button variant="primary" @click="createdHandleOk" size="xl" :disabled="disabled">ok</b-button>
            </div>
        </b-modal>

        <!-- edit modal -->
        <b-modal id="modal-prevent" ref="modal" title="edit" @ok=handleOk @cancel="clear">
            <form @submit.stop.prevent="handleSubmit">
                <b-form-group label="群組名稱">
                    <b-form-input v-model="selectValue.group_name" disabled></b-form-input>
                </b-form-group>
                <b-form-group label="名字">
                    <b-form-input v-model="selectValue.name" disabled></b-form-input>
                </b-form-group>
                <b-form-group label="狀態">
                    <b-form-select v-model="selectValue.member_status" :options="member_status"
                                   required></b-form-select>
                </b-form-group>
                <b-form-group label="身份">
                    <b-form-select v-model="selectValue.member_duty" :options="member_duty" required></b-form-select>
                </b-form-group>
            </form>
        </b-modal>
    </b-container>
</template>

<script>
  const items = []
  export default {
    name    : 'tableComponent',
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
            key          : 'habookID',
            label        : 'habookID',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'thumbnail',
            label        : '縮圖',
          },
          {
            key  : 'actions',
            label: '操作'
          }

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
        selectValue  : {},
        habook       : '',
        groupId      : '',
        state        : null,
        message      : '',
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
    watch   : {
      habook (v) {
        return this.syncMember(v)
      },
      groupId (v) {
        return this.syncMember(v)
      }
    },
    methods : {
      create () {
        let _this         = this
        _this.selectValue = {}
      },

      setValue (v) {
        let _this         = this
        _this.selectValue = v

      },
      createdHandleOk () {
        let _this = this
        let url   = `/group/member`
        axios.post(url, _this.selectValue)
          .then((response) => {
            console.log(response)
            _this.init()
          })
          .catch((error) => {

          })
        _this.$refs['create-modal'].hide()
      },
      handleOk (e) {
        let _this = this
        let url   = `/group/member/${_this.selectValue.user_id}`
        axios.put(url, _this.selectValue)
          .then((response) => {
            if (!response.data) {
              console.log(404)
            }
            _this.init()
          })
          .catch((error) => {
            console.log(error)
          })

      },
      clear (e) {
        let _this = this
        console.log(e)
        _this.selectValue = {}
        _this.init()
        _this.$refs['create-modal'].hide()
      },
      handleSubmit () {
        // let _this = this;
        // console.log(_this.selectValue);
      },

      onFiltered (filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows   = filteredItems.length
        this.currentPage = 1
      },

      getListGroupUser () {
        let groupUserUrl = '/api/group/user'
        let _this        = this
        axios.get(groupUserUrl).then((response) => {
          // console.log(response);
          _this.items     = response.data
          _this.totalRows = response.data.length
        }).catch((error) => {
          console.log(error)
        })

        let groupUrl = '/api/group'
        axios.get(groupUrl)
          .then((response) => {
            _this.groups = response.data.map(d => {
              return {
                text : d.name,
                value: d.id
              }
            })
          })
          .catch((error) => {
            console.log(error)
          })
      },

      init () {
        this.getListGroupUser()
      }
    },
    mounted () {
      let _this = this
      _this.getListGroupUser()
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
