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
                            <Option :value="0">会员</Option>
                            <Option :value="1">店主</Option>
                            <Option :value="2">代理</Option>
                        </Select>
                    </FormItem>
                    <FormItem style="margin-bottom: 0">
                        <Input v-model="searchConf.keywords" placeholder="请输入手机号"></Input>
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
            <Card>
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

    const detailButton = ( vm , h , currentRow , index) => {
        return h( 'Button' , {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    let detail_id = currentRow.id;
                    vm.$router.push({
                        name: 'relation_detail',
                        params: {
                            detail_id : detail_id
                        }
                    });
                }
            }
        }, '详情' );
    };

    export default {
        name: 'vip_list',
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
                        title: '头像',
                        align: 'center',
                        key: 'avatar',
                        width: 150,
                        render: ( h , param ) => {
                            return h('img',{
                                attrs: {
                                    src: param.row.avatar
                                },
                                style: {
                                    width: '80px',
                                    height: '80px',
                                    padding: '5px 0 0 0'
                                }
                            })
                        }
                    },
                    {
                        title: '昵称',
                        align: 'center',
                        key: 'nickname'
                    },
                    {
                        title: '等级',
                        align: 'center',
                        key: 'grade_name'
                    },
                    {
                        title: '电话',
                        align: 'center',
                        key: 'phone'
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        width: 100,
                        handle: ['detail']
                    }
                ],
                tableData: [],
                    tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                formItem:{
                    avatar : '',
                    grade : 0,
                    phone : '',
                    nickname: '',
                },
                searchConf: {
                    keywords: '',
                    status: ''
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
                        item.render = (h, param ) => {
                            let currentRowData = vm.tableData[param.index];
                            return h('div', [
                                detailButton(vm, h, currentRowData, param.index)
                            ]);
                        };
                    }
                });
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
                axios.get('Relation/relation_list', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        keywords: vm.searchConf.keywords,
                        status: vm.searchConf.status
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
        },
    };
</script>
