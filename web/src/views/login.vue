<style lang="less">
    @import './login.less';
</style>

<template>
    <div class="login" @keydown.enter="handleSubmit">
        <div class="login-con">
            <Card :bordered="false">
                <p slot="title">
                    <Icon type="md-log-in"></Icon>
                    欢迎登录思锐后台管理系统
                </p>
                <div class="form-con">
                    <Form ref="loginForm" :model="form" :rules="rules">
                        <FormItem prop="username">
                            <Input v-model="form.username" placeholder="请输入用户名">
                            <span slot="prepend">
                                    <Icon :size="16" type="ios-person"></Icon>
                                </span>
                            </Input>
                        </FormItem>
                        <FormItem prop="password">
                            <Input type="password" v-model="form.password" placeholder="请输入密码">
                            <span slot="prepend">
                                <Icon :size="16" type="md-lock" />
                            </span>
                            </Input>
                        </FormItem>
                        <FormItem>
                            <Button @click="handleSubmit" type="primary" long>登录</Button>
                        </FormItem>
                    </Form>
                </div>
             <!--   <div style="padding-top:10px;font-size: 11px;border-top: 1px solid #e9eaec;">
                    <span style="vertical-align:middle;">其他登录：</span>
                    <img style="vertical-align:middle;" src="../../src/images/qq_login.png" alt="">
                    <img style="vertical-align:middle;" src="../../src/images/wx_login.png" alt="">
                </div>-->
            </Card>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data () {
            return {
                form: {
                    username: '',
                    password: ''
                },
                rules: {
                    username: [
                        {required: true, message: '账号不能为空', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '密码不能为空', trigger: 'blur'}
                    ]
                }
            };
        },
        methods: {
            handleSubmit () {
                this.$refs.loginForm.validate((valid) => {
                    if (valid) {
                        let vm = this;
                        axios.post('Login/index', {
                            username: this.form.username,
                            password: this.form.password
                        }).then(function (response) {
                            if (response.data.code === 1) {
                                vm.$store.commit('login', response.data.data);
                                vm.$Message.success(response.data.msg);
                                vm.$router.push({
                                    name: 'home_index'
                                });
                            } else {
                                vm.$Message.error(response.data.msg);
                            }
                        });
                    }
                });
            }
        }
    };
</script>

<style>

</style>
