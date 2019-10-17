<style lang="less" scoped>
    @import './list.less';
</style>

<template>
    <div>
        <Row>
            <Col span="24">
                <Card>
                    <p slot="title" style="height: 32px">
                        <Button type="primary" @click="alertAdd" icon="md-add">新增</Button>
                    </p>
                    <div>
                        <Table :loading="tableLoading" :columns="columnsList" :data="tableData" border disabled-hover></Table>
                    </div>
                </Card>
            </Col>
        </Row>
        <Modal v-model="modalSetting.show" width="668" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{formItem.id ? '编辑' : '新增'}}标签</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="标签名称" prop="name">
                    <Input v-model="formItem.name" placeholder="请输入标签名称"></Input>
                </FormItem>
                <FormItem label="父级标签" prop="fid">
                    <Select v-model="formItem.fid">
                        <Option :value="0">顶级标签</Option>
                        <Option v-for="item in tableData" :value="item.id" :key="item.id">{{ item.showName }}</Option>
                    </Select>
                </FormItem>
                <FormItem label="标签排序" prop="sort">
                    <InputNumber :min="0" v-model="formItem.sort"></InputNumber>
                    <Tag color="error" style="margin-left:5px">数字越小越靠前</Tag>
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
                    vm.formItem.fid = currentRow.fid;
                    vm.formItem.sort = currentRow.sort;
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
                    axios.get('label/del', {
                        params: {
                            id: currentRow.id
                        }
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
        name: 'system_label',
        data () {
            return {
                columnsList: [
                    {
                        title: '序号',
                        type: 'index',
                        width: 65,
                        align: 'center'
                    },
                    {
                        title: '标签名称',
                        align: 'center',
                        key: 'showName',
                    },
                    {
                        title: '排序',
                        align: 'center',
                        key: 'sort',
                        width: 400
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                       
                        handle: ['edit', 'delete']
                    }
                ],
                tableLoading: false,
                tableData: [],
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                formItem: {
                    name: '',
                    fid: 0,
                    sort: 0,
                    id: 0
                },
                ruleValidate: {
                    name: [
                        { required: true, message: '标签名称不能为空', trigger: 'blur' }
                    ]
                }
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
                            target = 'label/add';
                        } else {
                            target = 'label/edit';
                        }
                        axios.post(target, this.formItem).then(function (response) {
                            if (response.data.code === 1) {
                                self.$Message.success(response.data.msg);
                            } else {
                                self.$Message.error(response.data.msg);
                            }
                            self.getList();
                            self.cancel();
                        });
                    }
                });
            },
            cancel () {
                this.modalSetting.show = false;
            },
            doCancel (data) {
                if (!data) {
                    this.formItem.id = 0;
                    this.$refs['myForm'].resetFields();
                    this.modalSetting.loading = false;
                    this.modalSetting.index = 0;
                }
            },
            getList () {
                let vm = this;
                vm.tableLoading = true;
                axios.get('label/index').then(function (response) {
                    let res = response.data;
                    vm.tableLoading = false;
                    if (res.code === 1) {
                        vm.tableData = res.data.list;
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
        }
    };
</script>
