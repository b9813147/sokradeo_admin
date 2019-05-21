<template>
    <b-container fluid>
        <!-- User Interface controls -->
        <b-row class="pb-3">
            <b-col md="12" class="my-1">
                <b-button variant="success" size="sm" v-b-modal.create-prevent @click="create">ADD</b-button>
            </b-col>
            <b-col md="8" class="my-1">
                <b-form-group label-cols-sm="2" label="Filter" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Type to Search"></b-form-input>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col md="4" class="my-1">
                <b-form-group label-cols-sm="3" label="Per page" class="mb-0">
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
            <template slot="group_name" slot-scope="row">
                {{ row.item.group_name }}
            </template>
            <template slot="name" slot-scope="row">
                {{ row.item.name }}
            </template>
            <template slot="member_status" slot-scope="row">
                {{ row.item.member_status }}
            </template>
            <template slot="member_duty" slot-scope="row">
                {{ row.item.member_duty }}
            </template>

            <template slot="actions" slot-scope="row">
                <b-button size="sm" v-b-modal.modal-prevent @click="setValue(row.item)">edit</b-button>
            </template>
            <!-- The modal -->
        </b-table>

        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" class="my-0"></b-pagination>
            </b-col>
        </b-row>

        <!-- create modal-->
        <b-modal id="create-prevent" ref="create-modal" title="create">
            <form>
                <b-form-group label="群組名稱">
                    <b-form-select v-model="groupId" :options="groups" required></b-form-select>
                </b-form-group>
                <b-form-group label="HaBookID">
                    <b-form-input id="input-live" v-model="habook" aria-describedby="input-live-help input-live-feedback" :state="state"></b-form-input>
                    <b-form-invalid-feedback id="input-live-feedback">{{ message }}</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="狀態">
                    <b-form-select v-model="selectValue.member_status" :options="member_status" required></b-form-select>
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
                    <b-form-select v-model="selectValue.member_status" :options="member_status" required></b-form-select>
                </b-form-group>
                <b-form-group label="身份">
                    <b-form-select v-model="selectValue.member_duty" :options="member_duty" required></b-form-select>
                </b-form-group>
            </form>
        </b-modal>
    </b-container>
</template>

<script>
    const items = [];
    export default {
        name    : "tableComponent",
        data() {
            return {
                // modalShow: false,
                items        : items,
                fields       : [
                    {
                        key          : 'group_name',
                        label        : '群組名稱',
                        sortable     : true,
                        sortDirection: 'desc'
                    },
                    {
                        key          : 'name',
                        label        : '名字',
                        sortable     : true,
                        sortDirection: 'desc'
                    },
                    {
                        key          : 'member_status',
                        label        : '狀態',
                        sortable     : true,
                        sortDirection: 'desc'
                    },
                    {
                        key          : 'member_duty',
                        label        : '身份',
                        sortable     : true,
                        sortDirection: 'desc'
                    },
                    {
                        key  : 'actions',
                        label: '操作'
                    }

                ],
                member_duty  : [
                    {
                        text : '管理者',
                        value: 'Admin'
                    },
                    {
                        text : '專家',
                        value: 'Expert'
                    },
                    {
                        text : '一般身份',
                        value: null
                    }
                ],
                member_status: [
                    {
                        text : '啟用',
                        value: 1
                    },
                    {
                        text : '停用',
                        value: 0
                    }
                ],
                groups       : [],
                currentPage  : 1,
                perPage      : 10,
                totalRows    : items.length,
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
            sortOptions() {
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
            habook(v) {
                return this.syncMember(v)
            },
            groupId(v) {
                return this.syncMember(v)
            }
        },
        methods : {
            syncMember(v) {
                console.log(v);
                let url = '/api/group/user/exist/';
                let _this = this;
                _this.selectValue.group_name = _this.groupId;
                _this.selectValue.habook = _this.habook;
                axios.get(url, {
                    params: {
                        group_id: _this.selectValue.group_name,
                        habook  : _this.selectValue.habook
                    }
                })
                    .then((response) => {
                        if (response.data === 'habook not found') {
                            _this.message = '無此用戶';
                            _this.state = false;
                            return;
                        }
                        if (!response.data) {
                            this.message = '可加入頻道';
                            _this.state = true;
                            _this.disabled = false;
                            return;
                        } else {
                            _this.message = '使用者已存在此頻道';
                            _this.state = false;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            create() {
                let _this = this;
                _this.selectValue = {};
            },

            setValue(v) {
                let _this = this;
                _this.selectValue = v;

            },
            createdHandleOk() {
                let _this = this;
                let url = `/group/member`;
                axios.post(url, _this.selectValue)
                    .then((response) => {
                        console.log(response);
                        _this.init();
                    })
                    .catch((error) => {

                    });
                _this.$refs['create-modal'].hide();
            },
            handleOk(e) {
                let _this = this;
                let url = `/group/member/${_this.selectValue.user_id}`;
                axios.put(url, _this.selectValue)
                    .then((response) => {
                        if (!response.data) {
                            console.log(404);
                        }
                        _this.init();
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            },
            clear(e) {
                let _this = this;
                console.log(e);
                _this.selectValue = {};
                _this.init();
                _this.$refs['create-modal'].hide();
            },
            handleSubmit() {
                // let _this = this;
                // console.log(_this.selectValue);
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            },

            getListGroupUser() {
                let groupUserUrl = '/api/group/user';
                let _this = this;
                axios.get(groupUserUrl).then((response) => {
                    // console.log(response);
                    _this.items = response.data;
                }).catch((error) => {
                    console.log(error);
                });

                let groupUrl = '/api/group';
                axios.get(groupUrl)
                    .then((response) => {
                        _this.groups = response.data.map(d => {
                            return {
                                text : d.name,
                                value: d.id
                            }
                        });
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            init() {
                this.getListGroupUser();
            }
        },
        mounted() {
            let _this = this;
            _this.getListGroupUser();
        }
    }
</script>

<style scoped>

</style>
