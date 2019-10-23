<style lang="less" scoped>
    @import './list.less';
</style>
<template>
    <div>
        <Row>
            <Col span="24">
                <Card style="margin-bottom: 10px">
                    <Form inline>
                        <FormItem style="margin-bottom: 0">
                            <Input v-model="searchConf.title" placeholder="banner名"></Input>
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
        <Modal v-model="modalSetting.show" width="668" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{formItem.id ? '编辑' : '新增'}}品牌名</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="名称" prop="title">
                    <Input v-model="formItem.title" placeholder="请输入名称" style="width: 300px;"></Input>
                </FormItem>
                <FormItem label="名称图" prop="img">
                    <p style="color:red">(建议分辨率1920*1080)</p>
                    <div class="demo-upload-list" v-for="item in uploadList" :key="item.id">
                        <template v-if="item.status === 'finished'">
                            <img :src="item.url">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
                            </div>
                        </template>
                        <template v-else>
                            <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
                        </template>
                    </div>
                    <Upload
                            ref="upload"
                            :show-upload-list="false"
                            :default-file-list="iconList"
                            :on-success="handleSuccess"
                            :format="['jpg','jpeg','png']"
                            :max-size="10240"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            :before-upload="handleBeforeUpload"
                            type="drag"
                            name="image"
                            :action="UploadAction"
                            style="display: inline-block;width:58px;">
                        <div style="width: 58px;height:58px;line-height: 58px;">
                            <Icon type="ios-camera" size="20"></Icon>
                        </div>
                    </Upload>
                </FormItem>
                <FormItem label="URL" prop="url">
                    <Input v-model="formItem.url" placeholder="请输入外链地址" style="width: 300px;"></Input>
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
                    vm.formItem.img = currentRow.img;
                    vm.formItem.title = currentRow.title;
                    vm.formItem.url = currentRow.url;
                    vm.modalSetting.show = true;
                    vm.modalSetting.index = index;

                    //图片
                    if(currentRow.img != ''){
                        vm.iconList = [{name:'',url:currentRow.img}];
                    }
                    vm.$nextTick(() => {
                        vm.uploadList = vm.$refs.upload.fileList;
                    });

                }
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
                'on-ok': () => {
                    axios.post('Banner/Del', {
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
        name: 'brand_list',
        data () {
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
                        title: '名称',
                        align: 'center',
                        key: 'title'
                    },
                    {
                        title: 'logo图',
                        align: 'center',
                        key: 'img',
                        //width: 150,
                        render: ( h , param ) => {
                            return h('img',{
                                attrs: {
                                    src: param.row.img
                                },
                                style: {
                                    width: '220px',
                                    height: '90px',
                                    padding: '5px 0 0 0'
                                }
                            })
                        }
                    },
                    {
                        title: '外链',
                        align: 'center',
                        key: 'url'
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        //width: 400,
                        handle: ['edit', 'delete']
                    }
                ],
                tableData: [],
                tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                formItem:{
                    img : '',
                },
                searchConf: {
                    title: '',
                    status: ''
                },
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                ruleValidate: {
                    name: [
                        {required: true, message: '品牌不能为空', trigger: 'blur'}
                    ],
                },
                // 图片
                UploadAction: '',
                visible: false,
                uploadList: [],
                iconList: [],
                // 图片
            };
        },
        created () {
            this.init();
            this.getList();
        },
        methods: {
            init () {
                //上传
                //this.UploadAction = config.front_url+'api/upload';
                // this.UploadHeader = {'ApiAuth': sessionStorage.getItem('apiAuth')};
                let vm = this;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param ) => {
                            let currentRowData = vm.tableData[param.index];
                            return h('div', [
                                editButton(vm, h, currentRowData, param.index),
                                deleteButton(vm, h, currentRowData, param.index),
                            ]);
                        };
                    }
                });
            },
            alertAdd () {
                //图片
                this.$nextTick(() => {
                    this.uploadList = this.$refs.upload.fileList;
                });

                this.modalSetting.show = true;
            },
            submit () {
                let self = this;
                this.$refs['myForm'].validate((valid) => {
                    if (valid) {
                        self.modalSetting.loading = true;
                        let target = '';
                        if (this.formItem.id ) {
                            target = 'Banner/Edit';
                        } else {
                            target = 'Banner/Add';
                        }
                        axios.post(target, self.formItem).then(function (response) {
                            self.modalSetting.loading = false;
                            if (response.data.code === 1) {
                                self.$Message.success(response.data.msg);
                                self.getList();
                                self.cancel();
                            } else {
                                self.$Message.error(response.data.msg);
                            }
                        });
                    }
                });
            },
            cancel () {
                this.formItem = {title:'',img:'',url:'',id: 0};

                // 移除图片
                this.visible = false;
                for(var i = 0; i < this.uploadList.length; i++){
                    this.handleRemove(this.uploadList[i]);
                }
                this.iconList = [];

                this.modalSetting.show = false;
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
                axios.get('Banner/index', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        title: vm.searchConf.title,
                        url: vm.searchConf.url
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
                });1
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
            // 图片上传
            handleView (file) {
                this.visible = true;
            },
            handleRemove (file) {
                const fileList = this.$refs.upload.fileList;
                this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
                this.formItem.img = '';
            },
            handleSuccess (res, file) {
                // file.url = res.data;
                // this.formItem.img = res.data.substr( res.data.indexOf( 'upload' ) );
                file.url = res.data.filePath;//获取图片路径
                this.formItem.img = res.data.filePath;
            },
            handleFormatError (file) {
                this.$Message.error('文件格式不正确, 请选择jpg或者png.');
            },
            handleMaxSize (file) {
                this.$Message.error('文件大小不能超过10M');
            },
            handleBeforeUpload () {
                const check = this.uploadList.length < 1;
                if (!check) {
                    this.$Message.error('只能上传一张品牌图');
                }
                return check;
            }
        },
        mounted () {
            // this.UploadAction = config.front_url+'api/upload';
            // this.uploadList = this.$refs.upload.fileList;
            this.UploadAction = config.front_url+'file/qn_upload';
            this.uploadList = this.$refs.upload.fileList;
        }
    };
</script>
