<style lang="less" scoped>
    
</style>
<template>
    <div>
        <Row>
            <Col span="24">
                <Card style="margin-bottom: 10px">
                    <Form inline>
                        <FormItem style="margin-bottom: 0">
                            <Input v-model="searchConf.title" placeholder="请输入标题"></Input>
                        </FormItem>
                        <!-- <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.start_time" placeholder="请输入开始时间" style="width: 200px"></DatePicker>
                        </FormItem>
                        <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.end_time" placeholder="请输入结束时间" style="width: 200px"></DatePicker>
                        </FormItem> -->
                        <FormItem style="margin-bottom: 0">
                            <Button type="primary" @click="search">查询</Button>
                        </FormItem>
                    </Form>
                </Card>
            </Col>
        </Row>
        <Row>
            <Col span="24">
                <Card>
                    <p slot="title" style="height: 32px">
                        <Button type="primary" @click="alertAdd" icon="md-add">新增</Button>
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
        <Modal v-model="modalSetting.show" width="1000" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{formItem.id ? '编辑' : '新增'}}</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="标题" prop="title">
                    <Input v-model="formItem.title" style="width: 500px" placeholder="请输入标题"></Input>
                </FormItem>
                <FormItem label="推流地址" prop="push_address">
                    <Input v-model="formItem.title" style="width: 700px" placeholder="请输入推流"></Input>
                </FormItem>
                <FormItem label="拉流地址" prop="pull_address">
                    <Input v-model="formItem.title" style="width: 700px" placeholder="请输入拉流"></Input>
                </FormItem>
                <!-- <FormItem label="内容" prop="con">
                    <div id="wangeditor" v-model="formItem.con" ></div>
                </FormItem> -->
            </Form>
            <div slot="footer">
                <Button type="text" @click="cancel" style="margin-right: 8px">取消</Button>
                <Button type="primary" @click="submit" :loading="modalSetting.loading">确定</Button>
            </div>
        </Modal>
        <Modal v-model="infoSetting.show" width="1000" :styles="{top: '30px'}" @on-visible-change="infoCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{'详情'}}</span>
            </p>
            <Form ref="" :model="infoItem" :label-width="80">
                <div style="background:#eee;word-wrap:break-word;">
                    <Card :bordered="false">
                        <p slot="title">标题</p>
                        <p>{{infoItem.title}}</p>
                    </Card>
                </div>
                <!-- <div style="background:#eee;word-wrap:break-word;">
                    <Card :bordered="false">
                        <p slot="title">内容</p>
                        <p v-html="infoItem.con"></p>
                    </Card>
                </div> -->
            </Form>
            <div slot="footer">
                
            </div>
        </Modal>
    </div>
</template>
<script>
    import axios from 'axios';
    import config from '../../../build/config';
   // import wangEditor from 'wangeditor';
    const infoButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    axios.get('LiveConfig/info',{params:{id:currentRow.id}}).then(function (response) {
                        let res = response.data;
                        if (res.code === 1) {
                            vm.infoItem.title = res.data.info.title;
                            vm.infoItem.con = res.data.info.con;
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
                    vm.infoSetting.show = true;
                    vm.infoSetting.index = index;
                }
            }
        }, '详情');
    };
    const editButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    vm.formItem.id = currentRow.id;
                    axios.get('LiveConfig/info',{params:{id:currentRow.id}}).then(function (response) {
                        let res = response.data;
                        if (res.code === 1) {
                            vm.formItem.title = res.data.info.title;
                            vm.formItem.push_address = res.data.info.push_address;
                            vm.formItem.pull_address = res.data.info.pull_address;
                            //vm.formItem.con = res.data.info.con;
                            //vm.editor.txt.html(res.data.info.con);
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
                    vm.modalSetting.show = true;
                    vm.modalSetting.index = index;
                }
            }
        }, '编辑');
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
                    axios.post('LiveConfig/del', {
                        id: currentRow.id
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
                        title: '标题',
                        align: 'center',
                        key: 'title',
                        
                    },
                    {
                        title: '推流地址',
                        align: 'center',
                        key: 'push_address',
                       
                    },
                    {
                        title: '拉流地址',
                        align: 'center',
                        key: 'pull_address',
                       
                    },
                    {
                        title: '创建时间',
                        align: 'center',
                        key: 'creatr_time',
                    },
                    {
                        title: '修改时间',
                        align: 'center',
                        key: 'update_time',
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        width: 260,
                        handle: ['info', 'edit', 'delete']
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
                    title: '',
                    start_time: '',
                    end_time: ''
                },
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                formItem: {
                    id: 0,
                    title: '',
                    con: '',
                },
                ruleValidate: {
                    title: [
                        { required: true, message: '请输入标题', trigger: 'blur' }
                    ],
                    push_address: [
                        { required: true, message: '请输入推流地址', trigger: 'blur' }
                    ],
                    pull_address: [
                        { required: true, message: '请输入拉流地址', trigger: 'blur' }
                    ],
                },
                infoSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                infoItem: {
                    title: '',
                    con: '',
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
                                //infoButton(vm, h, currentRowData, param.index),
                                editButton(vm, h, currentRowData, param.index),
                                deleteButton(vm, h, currentRowData, param.index)
                            ]);
                        };
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
                            target = 'LiveConfig/add';
                        } else {
                            target = 'LiveConfig/upd';
                        }
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
                this.formItem.title = '';
                this.formItem.con = '';
                this.editor.txt.html('');
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
            infoCancel (data) {
                if (!data) {
                    this.infoSetting.loading = false;
                    this.infoSetting.index = 0;
                    this.infoItem.title = '';
                    this.infoItem.con = '';
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
                axios.get('LiveConfig/index', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        title: vm.searchConf.title,
                        start_time: vm.searchConf.start_time,
                        end_time: vm.searchConf.end_time
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
            // let vm = this;
            // this.editor = new wangEditor("#wangeditor");
            // this.editor.customConfig.uploadFileName = 'file';
            // this.editor.customConfig.uploadImgMaxLength = 1;
            // this.editor.customConfig.uploadImgServer = config.front_url + 'api/upload';
            // this.editor.customConfig.uploadImgHooks = {
            //     customInsert:function(insertImg,result,editor){
            //         if(result.code == 1){
            //             insertImg(result.data);
            //         }
            //     }
            // };
            // this.editor.customConfig.onchange = function(html){
            //     vm.formItem.con = html;
            // }
            // this.editor.create();
        }
    };
</script>
