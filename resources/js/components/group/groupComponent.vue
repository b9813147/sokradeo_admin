<template>
    <b-container fluid>
        <!-- User Interface controls -->
        <b-row class="pb-3">
            <b-col md="12" class="my-1">
                <b-button variant="success" size="sm" v-b-modal.create-prevent @click="create">ADD</b-button>
            </b-col>
            <b-col md="9" class="my-1">
                <b-form-group label-cols-sm="1" label="Filter" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Type to Search"></b-form-input>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="3" class="my-1">
                <b-form-group label-cols-sm="4" label="Per page" class="mb-0">
                    <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                </b-form-group>
            </b-col>
        </b-row>

        <!-- Main table element -->
        <b-table
                show-empty
                stacked="md"
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
            <template slot="school_code" slot-scope="row">
                {{ row.item.school_code }}
            </template>
            <template slot="name" slot-scope="row">
                {{ row.item.name }}
            </template>
            <template slot="description" slot-scope="row">
                {{ row.item.description }}
            </template>
            <template slot="status" slot-scope="row">
                {{ row.item.status }}
            </template>
            <template slot="public" slot-scope="row">
                {{ row.item.public }}
            </template>
            <template slot="thumbnail" slot-scope="row">
                <div v-if="row.item.thumbnail">
                    <b-img :src="imgSrc(row.item)" height="60"></b-img>
                </div>
                <div v-else>
                    <b-img src="/storage/default.jpg" height="60"></b-img>
                </div>
            </template>

            <template slot="actions" slot-scope="row">
                <b-button size="sm" v-b-modal.edit-prevent @click="modify(row.item)">edit</b-button>
            </template>
            <!-- The modal -->
        </b-table>

        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" class="my-0"></b-pagination>
            </b-col>
        </b-row>

        <!-- create modal-->
        <b-modal id="create-prevent" ref="create-modal" title="create" @ok="handle" @cancel="cancel">
            <form>
                <b-form-group label="school_code">
                    <b-form-input v-model="selectValue.school_code" :state="state.school_code"
                                  aria-describedby="input-live-help input-live-school_code">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-school_code">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="name">
                    <b-form-input v-model="selectValue.name" :state="state.name"
                                  aria-describedby="input-live-name">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-name">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="description">
                    <b-form-input v-model="selectValue.description" :state="state.description"
                                  aria-describedby="input-live-description">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-description">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="status">
                    <b-form-input v-model="selectValue.status" :state="state.status"
                                  aria-describedby="input-live-status">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-status">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="public">
                    <b-form-input v-model="selectValue.public" :state="state.public"
                                  aria-describedby="input-live-public">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-public">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="thumbnail">
                    <b-form-file v-model="selectValue.thumbnail" ref="thumbnail" class="mb-2"></b-form-file>
                </b-form-group>
            </form>
        </b-modal>

        <!-- Edit -->
        <b-modal id="edit-prevent" ref="edit-modal" title="edit" @ok="handle" @cancel="cancel">
            <form>
                <b-form-group label="school_code">
                    <b-form-input v-model="selectValue.school_code" :state="state.school_code"
                                  aria-describedby="input-live-help input-live-school_code">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-school_code">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="name">
                    <b-form-input v-model="selectValue.name" :state="state.name"
                                  aria-describedby="input-live-name">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-name">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="description">
                    <b-form-input v-model="selectValue.description" :state="state.description"
                                  aria-describedby="input-live-description">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-description">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="status">
                    <b-form-input v-model="selectValue.status" :state="state.status"
                                  aria-describedby="input-live-status">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-status">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="public">
                    <b-form-input v-model="selectValue.public" :state="state.public"
                                  aria-describedby="input-live-public">
                    </b-form-input>
                    <b-form-invalid-feedback class="input-live-public">
                        Enter at least 3 letters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="thumbnail">
                    <b-form-file v-model="selectValue.thumbnail" ref="thumbnail" class="mb-2"></b-form-file>
                    <div v-if="selectValue.thumbnail">
                        <b-img :src="imgSrc(selectValue)" height="60"></b-img>
                    </div>
                    <div v-else>
                        <b-img src="/storage/default.jpg" height="60"></b-img>
                    </div>
                </b-form-group>
            </form>
        </b-modal>
    </b-container>
</template>

<script>
  const items = [];
  export default {
    name   : "groupComponent",
    data() {
      return {
        // modalShow: false,
        storageUrl   : '/storage/group/',
        items        : items,
        fields       : [
          {
            key          : 'school_code',
            label        : '學校代碼',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'name',
            label        : '群組名稱',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'description',
            label        : '描述',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'status',
            label        : '狀態',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'public',
            label        : '公開',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key          : 'thumbnail',
            label        : '縮圖',
            sortable     : true,
            sortDirection: 'desc'
          },
          {
            key  : 'actions',
            label: '操作'
          }
        ],
        status       : [
          {
            text : '啟用',
            value: 1
          }, {
            text : '停用',
            value: 0
          }
        ],
        public       : [
          {
            text : '啟用',
            value: 1
          }, {
            text : '停用',
            value: 0
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
        required     : true,
        selectValue  : {
          school_code: '',
          name       : '',
          description: '',
          status     : '',
          public     : '',
          thumbnail  : null
        },
        state        : {
          school_code: null,
          name       : null,
          description: null,
          status     : null,
          public     : null,
        },
        url          : '',


      }
    },
    methods: {
      init() {

        this.getGroupList();

        // location.reload();
        this.selectValue = {
          school_code: '',
          name       : '',
          description: '',
          status     : '',
          public     : '',
          thumbnail  : ''
        };
        this.state       = {
          school_code: null,
          name       : null,
          description: null,
          status     : null,
          public     : null,
        };
      },
      imgSrc(d) {
        let _this = this;
        return `${_this.storageUrl}${d.id}/${d.thumbnail}`;

      },

      create() {
        let _this = this;
        _this.url = '/group';

        _this.selectValue = {
          school_code: '',
          name       : '',
          description: '',
          status     : '',
          public     : '',
          thumbnail  : null
        };
        _this.state       = {
          school_code: null,
          name       : null,
          description: null,
          status     : null,
          public     : null,
        };
      },

      modify(data) {
        let _this         = this;
        _this.selectValue = data;
        // _this.url = `group/${_this.selectValue.id}`;
        _this.url         = `group/update/${_this.selectValue.id}`;
        console.log(data);
      },

      handle(e) {
        let _this = this;
        // Prevent modal from closing
        e.preventDefault();
        if (!_this.selectValue.school_code) {
          _this.state.school_code = false;
        }
        if (!_this.selectValue.name) {
          _this.state.name = false;
        }
        if (!_this.selectValue.description) {
          _this.state.description = false;
        }
        if (!_this.selectValue.status) {
          _this.state.status = false;
        }
        if (!_this.selectValue.public) {
          _this.state.public = false;
        }

        if (_this.selectValue.school_code) {
          _this.state.school_code = true;
        }
        if (_this.selectValue.name) {
          _this.state.name = true
        }
        if (_this.selectValue.description) {
          _this.state.description = true
        }
        if (_this.selectValue.status) {
          _this.state.status = true
        }
        if (_this.selectValue.public) {
          _this.state.public = true
        }

        if (_this.state.school_code && _this.state.name && _this.state.description && _this.state.status && _this.state.public) {
          this.submit();
        }

      },

      submit() {
        let _this    = this;
        let formData = new FormData();
        let config   = {
          headers: {
            'content-Type': 'multipart/form-data'
          }
        };
        formData.append('thumbnail', _this.selectValue.thumbnail);
        if (_this.url === 'group') {
          axios.post(_this.url, formData, {params: _this.selectValue,}, {config})
            .then((response) => {
              console.log(response);
              this.init();
              _this.$refs['create-modal'].hide();
              _this.$refs['edit-modal'].hide();
              // console.log(response.status);
              // console.log(_this.selectValue);
            })
            .catch((error) => {

            });
        } else {
          axios.post(_this.url, formData, {params: _this.selectValue,}, {config})
            .then((response) => {
              console.log(response);
              this.init();
              _this.$refs['create-modal'].hide();
              _this.$refs['edit-modal'].hide();
            })
            .catch((error) => {

            });
        }

        _this.$refs['create-modal'].hide();
        _this.$refs['edit-modal'].hide();

        this.init();


      },

      cancel() {
        let _this         = this;
        _this.selectValue = {
          school_code: '',
          name       : '',
          description: '',
          status     : '',
          public     : '',
          thumbnail  : ''
        };
      },

      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        let _this         = this;
        _this.totalRows   = filteredItems.length;
        _this.currentPage = 1
      },

      getGroupList() {
        let _this    = this;
        let groupUrl = '/api/group';
        axios.get(groupUrl)
          .then((response) => {
            _this.items     = [];
            _this.items     = response.data;
            _this.totalRows = response.data.length;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    mounted() {
      let _this = this;
      _this.getGroupList();

    },
  }
</script>

<style scoped>

</style>
