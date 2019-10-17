<style lang="less" scoped>
    @import './vip.less';
</style>
<template>
    <div>
        <Row>
            <Col span="24">
            <Card style="margin-bottom: 10px">
                <Form inline>
                    <FormItem style="margin-bottom: 0">
                        <Select v-model="searchConf.status" clearable placeholder='请选择等级' style="width:100px">
                            <Option :value="-1">全部</Option>
                            <Option :value="0">黄金</Option>
                            <Option :value="1">白金</Option>
                            <Option :value="2">钻石</Option>
                        </Select>
                    </FormItem>
                    <FormItem style="margin-bottom: 0">
                        <Input v-model="searchConf.keywords" placeholder="请输入手机号"></Input>
                    </FormItem>
                    <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.start_time" placeholder="请输入开始时间" style="width: 200px"></DatePicker>
                        </FormItem>
                        <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.end_time" placeholder="请输入结束时间" style="width: 200px"></DatePicker>
                        </FormItem>
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
                <!--<p slot="title" style="height: 32px">-->
                    <!--<Button type="primary" @click="alertAdd" icon="md-add">新增</Button>-->
                <!--</p>-->
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

    const editButton = ( vm , h , currentRow , index) => {
        return h( 'Button' , {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    vm.formItem.id = currentRow.id;
                    vm.formItem.is_accept = currentRow.is_accept;
                    vm.modalSetting.show = true;
                    vm.modalSetting.index = index;
                }
            }
        }, '审核' );
    };
    const deleteButton = ( vm , h , currentRow , index ) => {
        return h( 'Poptip' , {
            props: {
                confirm: true,
                title: '您确定要删除这条数据吗? ',
                transfer: true
            },
            on: {
                'on-ok': () => {
                    axios.post('Feedback/Delete', {
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
        name: 'vip_list',
        data () {
            const validatePhone = (rule, value, callback) => {
                var reg = /^1\d{10}$/;
                if ( !reg.test( value ) ) {
                    callback(new Error('手机号码格式不正确'));
                }
                callback();
            };
            return {
                UploadAction: '',
                UploadHeader: '',
                uploadList: [],
                DefaultList: [],
                confirmRefresh: false,
                columnsList: [
                    {
                        title: '序号',
                        type: 'index',
                        width: 65,
                        align: 'center',
                        key: 'id'
                    },
                    {
                        title: '会员账号',
                        align: 'center',
                        key: 'phone'
                    },
                    {
                        title: '会员昵称',
                        align: 'center',
                        key: 'realname',
                        width: 150
                    },
                    {
                        title: '会员等级',
                        align: 'center',
                        key: 'grade_name',
                    },
                    {
                        title: '反馈内容',
                        align: 'center',
                        key: 'con',
                    },
                    {
                        title: '创建时间',
                        align: 'center',
                        key: 'created_at',
                        width: 150
                    },
                    // {
                    //     title: '操作',
                    //     align: 'center',
                    //     key: 'handle',
                    //     width: 200,
                    //     handle: ['edit', 'delete']
                    // }
                ],
                tableData: [],
                tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                formItem:{
                    
                },
                searchConf: {
                    keywords: '',
                    status: -1,
                    start_time: '',
                    end_time: '',
                },
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                ruleValidate: {
                    nickname: [
                        {required: true, message: '昵称不能为空', trigger: 'blur'}
                    ],
                }
            };
        },
        created () {
            this.init();
            this.getList();
        },
        methods: {
            init () {

                this.UploadAction = config.front_url+'api/upload';
                // this.UploadHeader = {'ApiAuth': sessionStorage.getItem('apiAuth')};
                let vm = this;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param ) => {
                            let currentRowData = vm.tableData[param.index];
                            return h('div', [
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
                        if (this.formItem.id ) {
                            target = 'Feedback/Edit';
                        } else {
                            target = 'Feedback/Add';
                        }
                        axios.post(target, self.formItem).then(function (response) {
                            self.modalSetting.loading = false;
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
                for(var i = 0; i < this.uploadList.length; i++){
                    this.handleRemove(this.uploadList[i]);
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
                axios.get('Feedback/index', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        keywords: vm.searchConf.keywords,
                        status: vm.searchConf.status,
                        start_time: vm.searchConf.start_time,
                        end_time: vm.searchConf.end_time,
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
            },
            doCancel (data) {
                if (!data) {
                    this.cancel();
                    this.formItem.id = 0;
                    this.$refs['myForm'].resetFields();
                    this.modalSetting.loading = false;
                    this.modalSetting.index = 0;
                }
            },

        },
        mounted () {

        }
    };
</script>
