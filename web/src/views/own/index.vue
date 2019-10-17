<style lang="less">
    @import 'index.less';
</style>

<template>
    <div>
        <Card>
            <p slot="title">
                <Icon type="md-person"></Icon>
                个人信息
            </p>
            <div>
                <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                    <FormItem label="用户账号" prop="username">
                        <div style="display:inline-block;width:300px;">
                            <Input v-model="username" disabled></Input>
                        </div>
                    </FormItem>
                    <FormItem label="用户昵称" prop="nickname">
                        <div style="display:inline-block;width:300px;">
                            <Input v-model="formItem.nickname"></Input>
                        </div>
                    </FormItem>
                    <FormItem label="用户头像" prop="headImg">
                        <div class="demo-upload-list" v-if="formItem.headImg">
                            <img :src="formItem.headImg">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click.native="handleImgRemove()"></Icon>
                            </div>
                        </div>
                        <input v-if="formItem.headImg" v-model="formItem.headImg" type="hidden" name="image">
                        <Upload type="drag"
                                :action="uploadUrl"
                                :headers="uploadHeader"
                                v-if="!formItem.headImg"
                                :format="['jpg','jpeg','png']"
                                :max-size="5120"
                                :on-success="handleImgSuccess"
                                :on-format-error="handleImgFormatError"
                                :on-exceeded-size="handleImgMaxSize"
                                style="display: inline-block;width:58px;">
                            <div style="width: 58px;height:58px;line-height: 58px;">
                                <Icon type="ios-camera" size="20"></Icon>
                            </div>
                        </Upload>
                    </FormItem>
                    <FormItem label="原密码" prop="oldPassword">
                        <div style="display:inline-block;width:300px;">
                            <Input type="password" v-model="formItem.oldPassword" placeholder="请输入现在使用的密码，如需修改密码则必填"></Input>
                        </div>
                    </FormItem>
                    <FormItem label="新密码" prop="password">
                        <div style="display:inline-block;width:300px;">
                            <Input type="password" v-model="formItem.password" placeholder="请输入新密码，至少6位字符"></Input>
                        </div>
                    </FormItem>
                    <FormItem label="确认新密码" prop="rePassword">
                        <div style="display:inline-block;width:300px;">
                            <Input type="password" v-model="rePassword" placeholder="请再次输入新密码"></Input>
                        </div>
                    </FormItem>
                    <div>
                        <Button type="text" style="width: 100px;" @click="cancel">取消</Button>
                        <Button type="primary" style="width: 100px;" :loading="saveLoading" @click="confirmSubmit">保存</Button>
                    </div>
                </Form>
            </div>
        </Card>
        <Modal v-model="confirmSub" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="md-information-circle"></Icon>
                <span>确定要提交么</span>
            </p>
            <div style="text-align:center">
                <p>个人信息修改后，将会退出系统重新登录，请明确后修改！</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long @click="submit">确定修改</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
    import config from '../../../build/config';
    import axios from 'axios';

    export default {
        name: 'own_index',
        data () {
            const checkPassword = (rule, value, callback) => {
                let password = this.formItem.password;
                if (password !== this.rePassword) {
                    callback(new Error('两次输入密码不一致'));
                } else {
                    callback();
                }
            };
            const checkOldPassword = (rule, value, callback) => {
                let password = this.formItem.password;
                if (password) {
                    if (!this.formItem.oldPassword) {
                        callback(new Error('初始密码不得为空'));
                    } else {
                        callback();
                    }
                } else {
                    callback();
                }
            };
            return {
                confirmSub: false,
                uploadUrl: '',
                uploadHeader: {},
                saveLoading: false,
                rePassword: '',
                username: '',
                formItem: {
                    nickname: '',
                    headImg: '',
                    oldPassword: '',
                    password: ''
                },
                ruleValidate: {
                    nickname: [
                        {required: true, message: '请输入姓名', trigger: 'blur'}
                    ],
                    password: [
                        {min: 6, message: '请至少输入6个字符', trigger: 'blur'},
                        {max: 32, message: '最多输入32个字符', trigger: 'blur'}
                    ],
                    rePassword: [
                        {validator: checkPassword, trigger: 'blur'}
                    ],
                    oldPassword: [
                        {validator: checkOldPassword, trigger: 'blur'}
                    ]
                }
            };
        },
        methods: {
            cancel () {
                this.$store.commit('removeTag', 'own_index');
                localStorage.pageOpenedList = JSON.stringify(this.$store.state.app.pageOpenedList);
                let lastPageName = '';
                if (this.$store.state.app.pageOpenedList.length > 1) {
                    lastPageName = this.$store.state.app.pageOpenedList[1].name;
                } else {
                    lastPageName = this.$store.state.app.pageOpenedList[0].name;
                }
                this.$router.push({
                    name: lastPageName
                });
            },
            confirmSubmit () {
                this.confirmSub = true;
            },
            submit () {
                let vm = this;
                this.$refs['myForm'].validate((valid) => {
                    if (valid) {
                        vm.saveLoading = true;
                        axios.post('User/own', vm.formItem).then(function (response) {
                            if (response.data.code === 1) {
                                vm.$Message.success(response.data.msg);
                                vm.$store.commit('logout', vm);
                                vm.$router.push({
                                    name: 'login'
                                });
                            } else {
                                if (response.data.code === -14) {
                                    vm.$store.commit('logout', vm);
                                    vm.$router.push({
                                        name: 'login'
                                    });
                                } else {
                                    vm.$Message.error(response.data.msg);
                                }
                            }
                            vm.saveLoading = false;
                        });
                    }
                });
            },
            init () {
                let userInfo = JSON.parse(sessionStorage.getItem('userInfo'));
                this.username = userInfo.username;
                this.formItem.nickname = userInfo.nickname;
                this.formItem.headImg = userInfo.headImg;
                this.uploadUrl = config.front_url + 'api/upload';
                // this.uploadHeader = {'ApiAuth': sessionStorage.getItem('apiAuth')};
            },
            handleImgFormatError (file) {
                this.$Notice.warning({
                    title: '文件类型不合法',
                    desc: file.name + '的文件类型不正确，请上传jpg或者png图片。'
                });
            },
            handleImgRemove () {
                this.formItem.headImg = '';
            },
            handleImgSuccess (response) {
                if (response.code === 1) {
                    this.$Message.success(response.msg);
                    this.formItem.headImg = response.data;
                } else {
                    this.$Message.error(response.msg);
                }
            },
            handleImgMaxSize (file) {
                this.$Notice.warning({
                    title: '文件大小不合法',
                    desc: file.name + '太大啦请上传小于5M的文件。'
                });
            }
        },
        mounted () {
            this.init();
        }
    };
</script>
