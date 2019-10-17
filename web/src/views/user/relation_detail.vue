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
                    }
                ],
                tableData: [],
                    tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                formItem:{
                    avatar: '',
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
                var detail_id = vm.$route.params.detail_id
                axios.get('Relation/detail', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        keywords: vm.searchConf.keywords,
                        status: vm.searchConf.status,
                        detail_id: detail_id
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
