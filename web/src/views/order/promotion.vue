<style lang="less" scoped>
</style>
<template>
    <div>
        <Row>
            <Col span="24">
                <Card style="margin-bottom: 10px">
                    <Form inline>
                        <FormItem style="margin-bottom: 0">
                            <Input v-model="searchConf.phone" placeholder="请输入账号"></Input>
                        </FormItem>
                        <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.start_time" placeholder="请输入开始时间" style="width: 200px"></DatePicker>
                        </FormItem>
                        <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.end_time" placeholder="请输入结束时间" style="width: 200px"></DatePicker>
                        </FormItem>
                        <FormItem style="margin-bottom: 0">
                            <Button type="primary" @click="search">查询/刷新</Button>
                        </FormItem>
                    </Form>
                </Card>
            </Col>
        </Row>
        <Row>
            <Col span="24">
                <Card><!-- tableData视图加载页面 -->
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
        <Modal v-model="modalSetting.show" width="600"  :styles="{top: '60px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{formItem.id ? '审核' : '新增'}}</span>
            </p>	              show-total
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="审核状态" prop="status">
                    <Select v-model="formItem.status" style="width:200px">
                        <Option :value="2" >{{'审核成功'}}</Option>
                        <Option :value="3" >{{'驳回'}}</Option>
                        <Option :value="3" >{{'关闭'}}</Option>
                    </Select>
                    <span style="color: red;">(状态,一旦操作不可修改)</span>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button type="text" @click="cancel" style="margin-right: 8px">取消</Button>
                <Button type="primary" @click="submit" :loading="modalSetting.loading">确定</Button>
            </div>
        </Modal>
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
                    vm.formItem.status = currentRow.status;
                    //console.log(vm.formItem.cash_mode);
                    //图片	            name: "goods_add",
                    vm.modalSetting.show = true;
                    vm.modalSetting.index = index;
                }
            }
        }, '审核' );
    };
    export default {
        name: 'cash_list',
        data () {
            return {
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
                        title: '项目编号',
                        align: 'center',
                        key: 'no',
                        width: 190,
                    },
                    {
                        title: '用户名',
                        align: 'center',
                        key: 'realname'
                    },
                    {
                        title: '用户账号',
                        align: 'center',
                        key: 'phone'
                    },
                    {
                        title: '标题',
                        align: 'center',
                        key: 'name'
                    },
                    {
                        title: '稿件类型',
                        align: 'center',
                        key: 'role_type'
                    },
                    {
                        title: '套餐费用',
                        align: 'center',
                        key: 'packagefee'
                    },
                    {
                        title: '稿件费用',
                        align: 'center',
                        key: 'money'
                    },
                    {
                        title: '总计费用',
                        align: 'center',
                        key: 'money'
                    },
                    {
                        title: '创建时间',
                        align: 'center',
                        key: 'created_at'
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        handle: ['edit']
                    }
                ],
                tableData: [],//视图加载tableData
                tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                formItem:{
                    status : '',
                },
                searchConf: {
                    phone: '',
                    start_time:'',
                    end_time:''
                },
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                ruleValidate: {
                    // status: [
                    //     {required: true, message: '不能为空', trigger: 'blur'}
                    // ]
                },
                // 图片
                visible: false,
                // 图片
            };
        },
        created () {
            this.init();
            this.getList();
            key: "plate_form"
        },
        methods: {
            init () {
                let vm = this;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param ) => {
                            let currentRowData = vm.tableData[param.index];//tableData视图加载页面
                            return h('div', [
                                // stickButton(vm, h, currentRowData, param.index)// stickButton定义操作控件
                                editButton(vm, h, currentRowData, param.index),
                            ]);
                        };
                    }
                });
            },
            alertAdd () {
                //图片
                this.modalSetting.show = true;
            },
            submit () {
                let self = this;
                this.$refs['myForm'].validate((valid) => {
                    if (valid) {
                        self.modalSetting.loading = true;
                        let target = '';
                        if (this.formItem.id === 0) {
                            target = 'Promotion/add';
                        } else {
                            target = 'Promotion/upd';
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
                // this.formItem.img = '';
                // // 移除图片
                // this.visible = false;
                // for(var i = 0; i < this.uploadList.length; i++){
                //     this.handleRemove(this.uploadList[i]);
                // }
                // this.iconList = [];
                this.getList();
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
                axios.get('Promotion/index', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        phone: vm.searchConf.phone,
                        start_time: vm.searchConf.start_time,
                        end_time: vm.searchConf.end_time
                        // is_examine: vm.searchConf.status
                    }
                }).then(function (response) {
                    let res = response.data;
                    if (res.code === 1) {
                        vm.tableData = res.data.list;//视图加载tableData
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
                    this.formItem.id = 0;
                    this.$refs['myForm'].resetFields();
                    this.modalSetting.loading = false;
                    this.modalSetting.index = 0;
                }
            },
            // 图片上传
        },
        mounted () {
            //照片

        },
    };
</script>


