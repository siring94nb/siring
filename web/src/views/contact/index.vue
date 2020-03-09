<style lang="less" scoped>

</style>
<template>
    <div>
        <Row>
            <Col span="24">
                <Card>
                    <p slot="title" style="height: 32px">
                        <Button type="primary" @click="alertAdd" icon="md-refresh">更新</Button>
                    </p>
                    <div>{{'邮箱：'}}{{html1}}</div>
                    <div>{{'地址：'}}{{html2}}</div>
                    <div>{{'座机：'}}{{html3}}</div>
                    <div>{{'专家顾问直线：'}}{{html4}}</div>
                </Card>
            </Col>
        </Row>
        <Modal v-model="modalSetting.show" width="600" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{'更新'}}</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="邮箱" prop="con_a">
                    <Input v-model="formItem.con_a" placeholder="请输入邮箱"></Input>
                </FormItem>
                <FormItem label="地址" prop="con_b">
                    <Input v-model="formItem.con_b" placeholder="请输入地址"></Input>
                </FormItem>
                <FormItem label="座机" prop="con_c">
                    <Input v-model="formItem.con_c" placeholder="请输入座机号"></Input>
                </FormItem>
                <FormItem label="专家热线" prop="con_d">
                    <Input v-model="formItem.con_d" placeholder="请输入热线号"></Input>
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
        name: 'system_user',
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
                    con_a:'',
                    con_b:'',
                    con_c:'',
                    con_d:'',
                },
                ruleValidate: {

                },
                html1:'0',
                html2:'0',
                html3:'0',
                html4:'0',
            };
        },
        created () {
            this.init();
            this.getList();
        },
        methods: {
            init () {
                let vm = this;
                axios.get('Contact/signInfo').then(function (response) {
                    let res = response.data;
                    if (res.code === 1) {
                        vm.formItem.con_a = res.data.con.email;
                        vm.formItem.con_b = res.data.con.address;
                        vm.formItem.con_c = res.data.con.tel;
                        vm.formItem.con_d = res.data.con.phone;
                        vm.html1 = res.data.con.email;
                        vm.html2 = res.data.con.address;
                        vm.html3 = res.data.con.tel;
                        vm.html4 = res.data.con.phone;
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
                        let target = 'Contact/signUpd';
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
