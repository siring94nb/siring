<style lang="less" scoped>

</style>
<template>
    <div>
        <Row>
            <Col span="24">
                <Card>
                    <p slot="title" style="height: 32px">
                        <Button type="primary" @click="Export" :loading="modalSetting.loading" icon="md-cloud-upload">备份</Button>
                    </p>
                    <div>
                        <Table :columns="columnsList" :data="tableData" border disabled-hover></Table>
                    </div>
                    <div class="margin-top-15" style="text-align: center">
                        <Page :total="tableShow.listCount" :current="tableShow.currentPage"
                              :page-size="tableShow.pageSize" @on-change="changePage"
                              @on-page-size-change="changeSize" show-elevator show-sizer show-total></Page>
                    </div>
                </Card>
            </Col>
        </Row>
    </div>
</template>
<script>
    import axios from 'axios';
    import config from '../../../build/config';
    const editButton = (vm, h, currentRow, index) => {
        return h('Poptip', {
            props: {
                confirm: true,
                title: '您确定要下载这条数据吗? ',
                transfer: true
            },
            on: {
                'on-ok': () => {
                    axios.post('BackupSql/save', {
                        time: currentRow.time
                    }).then(function (response) {
                        currentRow.loading = false;
                        if (response.data.code === 1) {
                            vm.tableData.splice(index, 1);
                            vm.$Message.success(response.data.msg);
                        } else {
                            vm.$Message.error(response.data.msg);
                        }
                    });
                }
            }
        }, [
            h('Button', {
                style: {
                    margin: '0 5px'
                },
                props: {
                    type: 'primary',
                    placement: 'top',
                    loading: currentRow.isDeleting
                }
            }, '下载')
        ]);
    };
    const deleteButton = (vm, h, currentRow, index) => {
        return h('Poptip', {
            props: {
                confirm: true,
                title: '您确定要删除这条数据吗? ',
                transfer: true
            },
            on: {
                'on-ok': () => {
                    axios.post('BackupSql/del', {
                        time: currentRow.time
                    }).then(function (response) {
                        currentRow.loading = false;
                        if (response.data.code === 1) {
                            vm.tableData.splice(index, 1);
                            vm.$Message.success(response.data.msg);
                        } else {
                            vm.$Message.error(response.data.msg);
                        }
                    });
                }
            }
        }, [
            h('Button', {
                style: {
                    margin: '0 5px'
                },
                props: {
                    type: 'error',
                    placement: 'top',
                    loading: currentRow.isDeleting
                }
            }, '删除')
        ]);
    };

    export default {
        name: 'system_user',
        data () {
            return {
                columnsList: [
                    {
                        title: '序号',
                        type: 'index',
                        width: 65,
                        align: 'center',
                        key: 'id'
                    },
                    {
                        title: '名称',
                        align: 'center',
                        key: 'title',
                    },
                    {
                        title: '备份时间',
                        align: 'center',
                        key: 'created_at',
                    },
                    {
                        title: '备份大小',
                        align: 'center',
                        key: 'size',
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        width: 260,
                        handle: ['edit', 'delete']
                    }
                ],
                tableData: [],
                groupList: [],
                tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                searchConf: {
                    name: '',
                },
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                formItem: {
                    id: 0,
                    name: '',
                    num:1,
                    range: 0,
                    full: 1,
                    reduce: 1,
                    status: 1,
                    type: 0,
                },
                ruleValidate: {
                    name: [
                        { required: true, message: '请输入名称', trigger: 'blur' }
                    ],
                    // add_time: [
                    //     { required: true, message: '请选择开始时间', trigger: 'blur' }
                    // ],
                    // end_time: [
                    //     { required: true, message: '请选择结束时间', trigger: 'blur' }
                    // ],
                    // type: [
                    //     { required: true, message: '请选择范围', trigger: 'change' }
                    // ],
                },
            };
        },
        created () {
            this.init();
            this.getList();
        },
        methods: {
            init () {
                let vm = this;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param) => {
                            let currentRowData = vm.tableData[param.index];
                            return h('div', [
                                editButton(vm, h, currentRowData, param.index),
                                deleteButton(vm, h, currentRowData, param.index)
                            ]);
                        };
                    }
                });
            },
            Export () {
                let vm = this;
                vm.modalSetting.loading = true;
                axios.post('BackupSql/create',{
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                    }
                }).then(function(response){
                    vm.modalSetting.loading = false;
                    let res = response.data;
                    if (res.code === 1) {
                        vm.$Message.success(response.data.msg);
                        vm.getList();
                        vm.cancel();
                    } else {
                        vm.modalSetting.loading = false;
                        vm.$Message.error(response.data.msg);
                    }
                });
            },
            alertAdd () {
                this.modalSetting.show = true;
            },
            submit () {
                let self = this;
                this.$refs['myForm'].validate((valid) => {
                    if (valid) {
                        self.modalSetting.loading = true;
                        let target = '';
                        if (this.formItem.id === 0) {
                            target = 'BackupSql/add';
                        } else {
                            target = 'BackupSql/upd';
                        }
                        this.formItem.rule = new Object();
                        this.formItem.rule.full = this.formItem.full;
                        this.formItem.rule.reduce = this.formItem.reduce;
                        axios.post(target, this.formItem).then(function (response) {
                            if (response.data.code === 1) {
                                self.$Message.success(response.data.msg);
                                self.getList();
                                self.cancel();
                            } else {
                                self.modalSetting.loading = false;
                                self.$Message.error(response.data.msg);
                            }
                        });
                    }
                });
            },
            cancel () {
                this.modalSetting.show = false;
                this.formItem.id = 0;
            },
            doCancel (data) {
                if (!data) {
                    this.formItem.id = 0;
                    this.$refs['myForm'].resetFields();
                    this.modalSetting.loading = false;
                    this.modalSetting.index = 0;
                    this.cancel();
                }
            },
            changePage (page) {
                this.tableShow.currentPage = page;
                this.getList();
            },
            changeSize (size) {
                this.tableShow.pageSize = size;
                this.getList();
            },
            search () {
                this.tableShow.currentPage = 1;
                this.getList();
            },
            getList () {
                let vm = this;
                axios.get('BackupSql/index', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        name: vm.searchConf.name,
                    }
                }).then(function (response) {
                    let res = response.data;
                    if (res.code === 1) {
                        vm.tableData = res.data.list;
                        vm.tableShow.listCount = res.data.count;
                    } else {
                        if (res.code === -14) {
                            vm.$store.commit('logout', vm);
                            vm.$router.push({
                                name: 'login'
                            });
                        } else {
                            vm.$Message.error(res.msg);
                        }
                    }
                });
            }
        },
        mounted(){

        }
    };
</script>
