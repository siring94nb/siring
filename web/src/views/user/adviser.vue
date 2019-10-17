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
                            <Option :value="0">VIP</Option>
                            <Option :value="1">店主</Option>
                            <Option :value="2">代理</Option>
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
                <span>{{formItem.id ? '编辑' : '新增'}}会员</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="昵称" prop="nickname">
                    <Input v-model="formItem.nickname" placeholder="请输入昵称" style="width: 300px;"></Input>
                </FormItem>
                <FormItem label="头像" prop="avatar">
                    <div class="demo-upload-list" v-for="item in uploadList">
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
                            :default-file-list="DefaultList"
                            :on-success="handleSuccess"
                            :format="['jpg','jpeg','png']"
                            :max-size="10240"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            :before-upload="handleBeforeUpload"
                            type="drag"
                            :action="UploadAction"
                            style="display: inline-block;width:58px;">
                            <div style="width: 58px;height:58px;line-height: 58px;">
                                <Icon type="ios-camera" size="20"></Icon>
                            </div>
                    </Upload>
                </FormItem>
                <FormItem label="性别" prop="sex" >
                    <Select v-model="formItem.sex" style="width:300px">
                        <Option :value="0" :key="0"> 未知 </Option>
                        <Option :value="1" :key="1"> 男 </Option>
                        <Option :value="2" :key="2"> 女 </Option>
                    </Select>
                </FormItem>
                <FormItem label="出生日期" prop="birth_at">
                    <DatePicker type="date" v-model="formItem.birth_at" :value="formItem.birth_at" placeholder="请选择出生日期" style="width: 300px"></DatePicker>
                </FormItem>
                <FormItem label="电话" prop="phone">
                    <Input v-model="formItem.phone" placeholder="请输入电话号码" style="width: 300px;"></Input>
                </FormItem>
                <FormItem label="密码" prop="password">
                    <Tooltip :content="formItem.id ? '为空时默认不修改密码' : '为空时默认密码是123456'" placement="bottom-start">
                        <Input v-model="formItem.password" placeholder="请输入密码" style="width: 300px;" type="password"></Input>
                    </Tooltip>
                </FormItem>
                <FormItem label="确认密码" prop="con_password">
                    <Input v-model="formItem.con_password" placeholder="请输入确认密码" style="width: 300px;" type="password"></Input>
                </FormItem>
                <FormItem label="邮箱" prop="mail">
                    <Input style="width: 300px"  v-model="formItem.mail" placeholder="请输入邮箱"></Input>
                </FormItem>
                <FormItem label="支付宝帐号" prop="alipay">
                    <Input style="width: 300px"  v-model="formItem.alipay" placeholder="请输入支付宝帐号"></Input>
                </FormItem>
                <FormItem label="等级" prop="grade" >
                    <Select v-model="formItem.grade" style="width:300px">
                        <Option :value="0" :key="0"> VIP </Option>
                        <Option :value="1" :key="1"> 店主 </Option>
                        <Option :value="2" :key="2"> 代理 </Option>
                    </Select>
                </FormItem>
                <FormItem label="星级" prop="star" v-if="formItem.grade == 2">
                    <Select v-model="formItem.star" style="width:300px">
                        <Option :value="1" :key="1"> 一级 </Option>
                        <Option :value="2" :key="2"> 二级 </Option>
                        <Option :value="3" :key="3"> 三级 </Option>
                        <Option :value="4" :key="4"> 四级 </Option>
                        <Option :value="5" :key="5"> 五级 </Option>
                    </Select>
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
                    vm.formItem.avatar = currentRow.avatar;
                    vm.formItem.nickname = currentRow.nickname;
                    vm.formItem.grade = currentRow.grade;
                    vm.formItem.sex = currentRow.sex;
                    vm.formItem.sex_name = currentRow.sex_name;
                    vm.formItem.grade_name = currentRow.grade_name;
                    vm.formItem.birth_at = currentRow.birth_at;
                    vm.formItem.phone = currentRow.phone;
                    vm.formItem.mail = currentRow.mail;
                    vm.formItem.alipay = currentRow.alipay;
                    vm.formItem.star = currentRow.star;
                    vm.modalSetting.show = true;
                    vm.modalSetting.index = index;

                    if( currentRow.avatar != '' ){
                        vm.DefaultList = [{ name :　'' , url : currentRow.avatar  }];
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
                    axios.post('UserManage/vipDelete', {
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
                        title: '头像',
                        align: 'center',
                        key: 'avatar',
                        width: 150,
                        render: ( h , param ) => {
                            if(param.row.avatar == ''){
                                return h('div','');
                            }else{
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
                        key: 'grade_name',
                        width: 150
                    },
                    {
                        title: '性别',
                        align: 'center',
                        key: 'sex_name',
                    },
                    {
                        title: '出生日期',
                        align: 'center',
                        key: 'birth_at',
                    },
                    {
                        title: '电话',
                        align: 'center',
                        key: 'phone',
                        width: 150
                    },
                    {
                        title: '邮箱',
                        align: 'center',
                        key: 'mail',
                        width: 150
                    },
                    {
                        title: '支付宝帐号',
                        align: 'center',
                        key: 'alipay',
                        width: 150
                    },
                    {
                        title: '星级',
                        align: 'center',
                        key: 'star',
                    },
                    {
                        title: '创建时间',
                        align: 'center',
                        key: 'created_at',
                        width: 150
                    },
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        width: 200,
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
                    
                },
                searchConf: {
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
                ruleValidate: {
                    nickname: [
                        {required: true, message: '昵称不能为空', trigger: 'blur'}
                    ],
                    phone:[
                        { required: true, message: '手机号码不能为空', trigger: 'blur'},
                        { validator : validatePhone , trigger: 'blur'},
                    ],
                    grade: [
                        {required: true, message: '请选择等级', trigger: 'blur',type:'number'}
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
                            target = 'UserManage/vipEdit';
                        } else {
                            target = 'UserManage/vipAdd';
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
                axios.get('UserManage/vip', {
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
            handleRemove (file) {
                const fileList = this.$refs.upload.fileList;
                this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
            },
            handleSuccess (res, file) {
                file.url = res.data;
                this.formItem.avatar = res.data.substr( res.data.indexOf( 'upload' ) );
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
                    this.$Message.error('只能上传一张头像');
                }
                return check;
            }
        },
        mounted () {
            this.uploadList = this.$refs.upload.fileList;
        }
    };
</script>
