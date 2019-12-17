<style lang="less" scoped>

</style>
<template>
    <div>
        <Row>
            <Col span="24">
                <Card style="margin-bottom: 10px">
                    <Form inline>
                        <FormItem style="margin-bottom: 0">
                            <Input v-model="searchConf.name" placeholder="请输入名称"></Input>
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
        <Modal v-model="modalSetting.show" width="700" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{formItem.id ? '编辑' : '新增'}}</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="名称" prop="name" >
                    <Input  style="width: 500px" v-model="formItem.name" placeholder="请输入优惠卷名称"/>
                </FormItem>
                <FormItem label="发行数量" prop="num" >
                    <InputNumber  :min="1" v-model="formItem.num"></InputNumber>
                </FormItem>
                <FormItem label="分包发布"  prop="type">
                    <RadioGroup v-model="formItem.type">
                        <Radio :label="0" >立即发布</Radio>
                        <Radio :label="1" >暂不发布</Radio>
                        <Radio :label="2" >自开发</Radio>
                    </RadioGroup>
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
                    vm.formItem.name = currentRow.name;
                    vm.formItem.num = currentRow.num;
                    vm.formItem.range = currentRow.range;
                    if(currentRow.rule.full !== undefined){
                        vm.formItem.full = currentRow.rule.full;
                    }
                    if(currentRow.rule.reduce !== undefined){
                        vm.formItem.reduce = currentRow.rule.reduce;
                    }
                    vm.formItem.add_time = currentRow.add_time;
                    vm.formItem.end_time = currentRow.end_time;
                    vm.formItem.status = currentRow.status;
                    vm.formItem.type = currentRow.type;

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
                    axios.post('Receipt/del', {
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
                        title: '合同编号',
                        align: 'center',
                        width: 180,
                        key: 'no',
                    },
                    {
                        title: '项目名称',
                        align: 'center',
                        key: 'name',
                    },
                    {
                        title: '终端类型',
                        align: 'center',
                        key: '',
                    },
                    {
                        title: '分包技能、语言',
                        align: 'center',
                        width: 300,
                        key: 'dev_name',

                    },
                    {
                        title: '项目功能描述',
                        align: 'center',
                        key: 'con',

                    },
                    {
                        title: '接单人账号',
                        align: 'center',
                        key: 'phone',

                    },
                    {
                        title: '系统评分',
                        align: 'center',
                        key: 'available',

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
                            target = 'Receipt/add';
                        } else {
                            target = 'Receipt/upd';
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
                this.formItem.name = '';
                this.formItem.num = 1;
                this.formItem.add_time = '';
                this.formItem.end_time = '';
                this.formItem.range = 0;
                this.formItem.full = 1;
                this.formItem.reduce = 1;
                this.formItem.status = 1;
                this.formItem.type = '';
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
                axios.get('Receipt/index', {
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
