<style lang="less" scoped>
    .ivu-card-body{
        div{
            line-height: 4;
            margin-left: 20px;
        }
    }
</style>
<template>
    <div>
        <Row>
            <Col span="24">
                <Card>
                    <p slot="title" style="height: 32px">
                        <Button type="primary" @click="alertAdd" icon="md-refresh">更新</Button>
                    </p>
                    <div>{{'网站名称：'}}{{html1}}</div>
                    <div>{{'网站短名称：'}}{{html2}}</div>
                    <div>{{'网站关键词：'}}{{html3}}</div>
                    <div>{{'网站描述：'}}{{html4}}</div>
                    <div>{{'版权信息：'}}{{html5}}</div>
                </Card>
            </Col>
        </Row>
        <Modal v-model="modalSetting.show" width="800" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{'更新'}}</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="网站名称" prop="name">
                    <Input v-model="formItem.name" placeholder="请输入网站名称"></Input>
                </FormItem>
                <FormItem label="网站短名称" prop="title">
                    <Input v-model="formItem.title" placeholder="请输入网站短名称"></Input>
                </FormItem>
                <FormItem label="网站关键词" prop="tag">
                    <Input v-model="formItem.tag" placeholder="请输入网站关键词"></Input>
                </FormItem>
                <FormItem label="网站描述" prop="con" style="clear: both">
                    <Input type="textarea" :autosize="{minRows: 3,maxRows: 5}"  v-model="formItem.con" />
                </FormItem>
                <FormItem label="版权信息" prop="copyright">
                    <Input v-model="formItem.copyright" placeholder="请输入版权信息"></Input>
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

    export default {
        name: 'system_seo',
        data () {
            return {
                tableData: [],
                groupList: [],
                tableShow: {
                    currentPage: 1,
                    pageSize: 10,
                    listCount: 0
                },
                searchConf: {

                },
                modalSetting: {
                    show: false,
                    loading: false,
                    index: 0
                },
                formItem: {
                    name:'',
                    title:'',
                    tag:'',
                    con:'',
                    copyright:'',
                },
                ruleValidate: {

                },
                html1:'0',
                html2:'0',
                html3:'0',
                html4:'0',
                html5:'0'
            };
        },
        created () {
            this.init();
            this.getList();
        },
        methods: {
            init () {
                let vm = this;
                axios.get('Seo/index').then(function (response) {
                    let res = response.data;
                    if (res.code === 1) {
                        vm.formItem.name = res.data.con.name;
                        vm.formItem.title = res.data.con.title;
                        vm.formItem.tag = res.data.con.tag;
                        vm.formItem.con = res.data.con.con;
                        vm.formItem.copyright = res.data.con.copyright;
                        vm.html1 = res.data.con.name;
                        vm.html2 = res.data.con.title;
                        vm.html3 = res.data.con.tag;
                        vm.html4 = res.data.con.con;
                        vm.html5 = res.data.con.copyright;
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
            alertAdd () {
                this.modalSetting.show = true;
            },
            submit () {
                let self = this;
                this.$refs['myForm'].validate((valid) => {
                    if (valid) {
                        self.modalSetting.loading = true;
                        let target = 'Seo/Upd';
                        axios.post(target, this.formItem).then(function (response) {
                            if (response.data.code === 1) {
                                self.$Message.success(response.data.msg);
                                self.init();
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
            },
            doCancel (data) {
                if (!data) {
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

            }
        },
        mounted(){
            let vm = this;
        }
    };
</script>
