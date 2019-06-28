<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-5">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                v-model="per_page">
                            {{ per_page }}
                        </button>
                        <div class="dropdown-menu mt-2" aria-labelledby="dropdownMenuButton" style="min-width: 1rem;">
                            <a class="dropdown-item" href="#" v-for="(v, k) in pageOptions" @click="onSelectItem(v)">
                                {{ v }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 search-group">
                    <input type="text" class="form-control rounded-pill text-center" name="search" placeholder="Search"
                           v-model="filter">
                    <span class="fa fa-search z-1"></span>
                </div>
                <div class="col-md-2">
                    <a href="" class="btn btn-outline-secondary col-md btn-block">
                        <span class="d-md-none d-lg-inline">Create</span>
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col" width="40">#</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">habook</th>
                    <th scope="col" width="80">thumbnail</th>
                    <th scope="col" width="70">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(v, k) in users" :key="k">
                    <th scope="row">{{ k+1 }}</th>
                    <td>{{ v.name }}</td>
                    <td>{{ v.email }}</td>
                    <td>{{ v.habook }}</td>
                    <td v-if="v.thumbnail">
                        <img :src="imgSrc(v)" alt="img" class="img-thumbnail" style="width: 50px;">
                    </td>
                    <td v-else>
                        <img :src="imgDefault" class="img-thumbnail" style="width: 50px;" alt="img">
                    </td>
                    <td>
                        <a href="" class="btn btn-outline-info btn-sm" @click.prevent="openModal(false,v)">編輯</a>
                    </td>
                </tr>
                </tbody>
            </table>

            <v-pagination v-model="currentPage"
                          :classes="bootstrapPaginationClasses"
                          :labels="customLabels"
                          :page-count="pageCount"
            ></v-pagination>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title " id="productModalLabel">編輯成員</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="email" class="form-control" id="name" aria-describedby="name"
                                       placeholder="Enter name" v-model="tempUser.name" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Enter email" v-model="tempUser.email">
                            </div>
                            <div class="form-group">
                                <label for="haBook">habook</label>
                                <input type="email" class="form-control" id="haBook" aria-describedby="emailHelp"
                                       placeholder="Enter haBook ID" v-model="tempUser.habook" required>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" ref="files"
                                       @change="uploadFile">
                                <label class="custom-file-label" for="customFile">上傳圖片
                                    <!--                                    <i class="fas fa-spinner fa-spin" v-if="status.fileUploading"></i>-->
                                </label>
                            </div>
                            <div v-if="tempUser.thumbnail">
                                <img :src="imgSrc(tempUser)" alt="img" class="img-thumbnail mt-2" style="width: 200px;">
                            </div>
                            <div v-else>
                                <img :src="imgDefault" class="img-thumbnail mt-2" style="width: 200px;" alt="img">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary btn-sm" @click="updateUser">確認</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import vPagination from 'vue-plain-pagination'

  export default {
    components: {
      vPagination
    },

    data () {
      return {
        filter     : null,
        test       : '',
        pageOptions: [10, 15, 20, 25, 30],
        users      : [],
        paginate   : {},
        per_page   : 10,
        currentPage: 1,
        pageCount  : 1,
        tempUser   : {},
        isNew      : false,
        isLoading  : false,
        status     : {
          fileUploading: false
        },
        imgDefault : '',

        bootstrapPaginationClasses: { // http://getbootstrap.com/docs/4.1/components/pagination/
          ul       : 'pagination',
          li       : 'page-item',
          liActive : 'active',
          liDisable: 'disabled',
          button   : 'page-link'
        },

        customLabels: {
          first: '«',
          prev : '‹',
          next : '›',
          last : '»'
        }
      }
    },
    computed: {
      rows () {
        return this.users.length
      }
    },
    watch   : {
      currentPage (v) {
        this.getUserList(v, this.per_page)
      },
      filter (v) {
        if (v.trim().length === 0) {
          return this.getUserList()
        }
        this.search(1, v)
      }
    },

    methods: {
      //選擇顯示幾筆資料
      onSelectItem (per_page) {
        let _this      = this
        let page       = _this.paginate.current_page
        _this.per_page = per_page
        _this.getUserList(page, per_page)
      },

      getUserList (page = 1, per_page = this.per_page) {
        let _this = this

        let url = `api/users?page=${page}&per_page=${per_page}`

        axios.get(url).then((response) => {
          _this.users       = response.data.data.data
          _this.paginate    = response.data.paginate
          _this.currentPage = response.data.paginate.current_page
          _this.pageCount   = response.data.paginate.last_page

        }).catch((error) => {
          console.log(error)
        })
      },

      search (page = 1, search) {
        let _this = this
        let url   = `api/users?page=${page}&per_page=${_this.per_page}&search=${search}`

        axios.get(url).then((response) => {
          _this.users       = response.data.data.data
          _this.paginate    = response.data.paginate
          _this.currentPage = response.data.paginate.current_page
          _this.pageCount   = response.data.paginate.last_page

        }).catch((error) => {
          console.log(error)
        })
      },

      openModal (isNew, item) {
        if (isNew) {
          this.tempUser = {}
          this.isNew    = true
        } else {
          this.tempUser = Object.assign({}, item)
          this.isNew    = false
        }
        $('#productModal').modal('show')
      },

      uploadFile () {
        const _this      = this
        const uploadFile = _this.$refs.files.files[0]
        const url        = `${process.env.VUE_APP_API}/api/${process.env.VUE_APP_CUSTOM}/admin/upload`
        const formDate   = new FormData()

        _this.status.fileUploading = true

        formDate.append('file-to-upload', uploadFile)
        this.axios.post(url, formDate, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then((response) => {
          if (response.data.success) {

            _this.$set(_this.tempProduct, 'imageUrl', response.data.imageUrl)

            _this.status.fileUploading = false
            // this.$bus.$emit('message:push', '上傳成功', 'success');
          } else {
            _this.status.fileUploading = false
            // this.$bus.$emit('message:push', response.data.message, 'danger');
          }
        }).catch((error) => {
          console.log(error)
        })
      },

      updateUser () {

      },

      imgSrc (v) {
        let _this = this
        return `${this.$store.state.path.user}${v.id}/${v.thumbnail}`

      },

      init () {
        this.getUserList()
        this.imgDefault = this.$store.state.path.imgDefault
      },
    },

    mounted () {
      this.init()
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
            top: 13px;
            left: 30px;
            width: 2.25rem;
        }
    }
</style>
