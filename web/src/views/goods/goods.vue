<style lang="less" scoped>

</style>
<template>
    <div>
        <Row>
            <Col span="24">
            <Card style="margin-bottom: 10px">
                <Form inline>
                    <FormItem style="margin-bottom: 0">
                        <Input v-model="searchConf.title" placeholder="请输入要搜索的内容"></Input>
                    </FormItem>
                    <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.start_time" placeholder="请输入开始时间" style="width: 200px"></DatePicker>
                        </FormItem>
                        <FormItem style="margin-bottom: 0">
                            <DatePicker type="datetime" v-model="searchConf.end_time" placeholder="请输入结束时间" style="width: 200px"></DatePicker>
                        </FormItem>
                    <FormItem style="margin-bottom: 0">
                        <Button type="primary" @click="search">立即搜索</Button>
                    </FormItem>
                </Form>
            </Card>
            </Col>
        </Row>
        <Row>
            <Col span="24">
            <Card>
                <p slot="title" style="height: 32px">
                    <Button type="primary" @click="alertAdd" icon="md-add">添加商品</Button>
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
        <Modal v-model="modalSetting.show" width="998" :styles="{top: '30px'}">
            <p slot="header">
                <Icon type='md-add'></Icon>
                <span>添加商品</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="150">
                <FormItem label="商品名称" prop="name">
                    <Input v-model="formItem.name" placeholder="请输入" ></Input>
                </FormItem>
                <FormItem label="商品编号" prop="name">
                    <Input v-model="formItem.name" placeholder="请输入" ></Input>
                </FormItem>
                <FormItem label="归属分类" prop="fid">
                    <Select v-model="formItem.fid" >
                        <Option :value="0">顶级菜单</Option>
                        <Option v-for="item in tableData" :value="item.id" :key="item.id">{{ item.showName }}</Option>
                    </Select>
                </FormItem>
                <FormItem label="标记" prop="fid">
                    <RadioGroup v-model="formItem.radio">
                        <Radio label="促销">促销</Radio>
                        <Radio label="hot">hot</Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem label="SEO设置关键字" prop="name">
                    <Input v-model="formItem.name" placeholder="请输入" ></Input>
                </FormItem>
                <FormItem label="终端版本">
                    <Button></Button>
                </FormItem>
            </Form>
        </Modal>
    </div>
</template>
<script>
    import axios from 'axios';
    import config from '../../../build/config';

    const addCommentButton = ( vm , h , currentRow , index) => {
        return h( 'Button' , {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    vm.modalSetting.show = true;
                }
            }
        }, '添加评论' );
    };
    const copyButton = ( vm , h , currentRow , index) => {
        return h( 'Button' , {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {}
            }
        }, '复制' );
    };
    const editButton = ( vm , h , currentRow , index) => {
        return h( 'Button' , {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {}
            }
        }, '编辑' );
    };
    const deleteButton = ( vm , h , currentRow , index ) => {
        return h( 'Poptip' , {
            props: {
                confirm: true,
                title: '您确定要删除这条数据吗? ',
                transfer: true
            },
            on: { 
                'on-ok': () => {}
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
                        title: '商品名称',
                        align: 'center',
                        key: 'name'
                    },
                    {
                        title: '缩略图',
                        align: 'center',
                        key: 'img',
                         render: ( h , param ) => {
                            return h('img',{
                                attrs: {
                                    src: param.row.img
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
                        title: '商品编号',
                        align: 'center',
                        key: 'goods_num'
                    },
                    {
                        title: '商品分类',
                        align: 'center',
                        key: 'goods_type'
                    },
                    {
                        title: '终端版本',
                        align: 'center',
                        key: 'terminal_version'
                    },
                    {
                        title: '开发周期',
                        align: 'center',
                        key: 'develop_cycle'
                    },
                    {
                        title: '价格',
                        align: 'center',
                        key: 'price'
                    },
                    {
                        title: '排序',
                        align: 'center',
                        key: 'rank'
                    },
                    {
                        title: '状态',
                        align: 'center',
                        key: 'status',
                        width: 100
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        width: 200,
                        handle: ['comments', 'copy', 'edit', 'delete']
                    }
                ],
                tableData: [],
                tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                searchConf: {
                    title:'',
                    keywords: '',
                    status: '',
                    start_time: '',
                    end_time: '',
                },
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                formItem:{
                    img : '',
                },
            }
        },
        created () {
            this.init();
        },
        methods: {q
            init () {
                let vm = this;
                this.columnsList.forEach(item => {
                    if(item.handle) {
                        item.render = (h, param) => {
                            let currentRowData = vm.tableData[param.index];
                            return h('div', [
                                editButton(vm, h, currentRowData, param.index),
                                deleteButton(vm, h, currentRowData, param.index),
                                addCommentButton(vm, h, currentRowData, param.index),
                                copyButton(vm, h, currentRowData, param.index)
                            ])
                        }
                    }
                })
            },
            alertAdd () {
                let vm = this;
                // axios.get('Auth/getRuleList').then(function (response) { 
                //     let res = response.data;
                //     if (res.code === 1) {
                //         vm.ruleList = res.data.list;
                //     } else {
                //         if (res.code === -14) {
                //             vm.$store.commit('logout', vm);
                //             vm.$router.push({
                //                 name: 'login'
                //             });
                //         } else {
                //             vm.$Message.error(res.msg);
                //         }
                //     }
                // });
                this.modalSetting.show = true;
            },
         }
    }
</script>
