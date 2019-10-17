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
                    <div v-html="html"></div>
                    <div v-html="html1"></div>
                    <div v-html="html2"></div>
                </Card>
            </Col>
        </Row>
        <Modal v-model="modalSetting.show" width="1100" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{'更新'}}</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="120">
                <FormItem label="城市合伙人协议：" prop="con_a">
                    <div id="wangeditor" v-model="formItem.con_a"></div>
                </FormItem>
                <FormItem label="等级会员协议：" prop="con_b">
                    <div id="wangeditor1" v-model="formItem.con_b"></div>
                </FormItem>
                <FormItem label="分包商协议：" prop="con_c">
                    <div id="wangeditor2" v-model="formItem.con_c"></div>
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
    import wangEditor from 'wangeditor';

    export default {
        name: 'system_user',
        data() {
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
                    con_a: '',
                    con_b: '',
                    con_c: ''
                },
                ruleValidate: {
                    con: [{
                        required: true,
                        message: '请填写内容',
                        trigger: 'blur'
                    }]
                },
                html: '',
                html1: '',
                html2: ''
            };
        },
        created() {
            this.init();
            this.getList();
        },
        methods: {
            init() {
                let vm = this;
                axios.get('Treaty/index').then(function(response) {
                    let res = response.data;
                    if (res.code === 1) {
                        vm.formItem.con_a = res.data.con_a.con;
                        vm.formItem.con_b = res.data.con_b.con;
                        vm.formItem.con_c = res.data.con_c.con;
                        vm.editor.txt.html(res.data.con_a.con);
                        vm.html = res.data.con_a.con;
                        vm.editor.txt.html1(res.data.con_b.con);
                        vm.html1 = res.data.con_b.con;
                        vm.editor.txt.html2(res.data.con_c.con);
                        vm.html2 = res.data.con_c.con;
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
            alertAdd() {
                this.modalSetting.show = true;
            },
            submit() {
                let self = this;
                this.$refs['myForm'].validate((valid) => {
                    if (valid) {
                        self.modalSetting.loading = true;
                        let target = 'Treaty/Upd';
                        axios.post(target, this.formItem).then(function(response) {
                            if (response.data.code === 1) {
                                self.$Message.success(response.data.msg);
                                self.getList();
                                self.cancel();
                                self.init();
                            } else {
                                self.modalSetting.loading = false;
                                self.$Message.error(response.data.msg);
                            }
                        });
                    }
                });
            },
            cancel() {
                this.modalSetting.show = false;
            },
            doCancel(data) {
                if (!data) {
                    this.modalSetting.loading = false;
                    this.modalSetting.index = 0;
                    this.cancel();
                }
            },
            changePage(page) {
                this.tableShow.currentPage = page;
                this.getList();
            },
            changeSize(size) {
                this.tableShow.pageSize = size;
                this.getList();
            },
            search() {
                this.tableShow.currentPage = 1;
                this.getList();
            },
            getList() {

            }
        },
        mounted() {
            let vm = this;
            this.editor = new wangEditor('#wangeditor');
            this.editor.customConfig.uploadFileName = 'image';
            this.editor.customConfig.uploadImgMaxLength = 1;
            this.editor.customConfig.uploadImgServer = config.front_url + 'file/qn_upload';
            this.editor.customConfig.uploadImgHooks = {
                customInsert: function(insertImg, result, editor) {
                    if (result.code == 1) {
                        insertImg(result.data.filePath);
                    }
                }
            };
            this.editor.customConfig.onchange = function(html) {
                vm.formItem.con = html;
            };
            this.editor.create();

            let self = this;
            this.editor = new wangEditor('#wangeditor1');
            this.editor.customConfig.uploadFileName = 'image';
            this.editor.customConfig.uploadImgMaxLength = 1;
            this.editor.customConfig.uploadImgServer = config.front_url + 'file/qn_upload';
            this.editor.customConfig.uploadImgHooks = {
                customInsert: function(insertImg, result, editor) {
                    if (result.code == 1) {
                        insertImg(result.data.filePath);
                    }
                }
            };
            this.editor.customConfig.onchange = function(html1) {
                self.formItem.con = html1;
            };
            this.editor.create();

            let res = this;
            this.editor = new wangEditor('#wangeditor2');
            this.editor.customConfig.uploadFileName = 'image';
            this.editor.customConfig.uploadImgMaxLength = 1;
            this.editor.customConfig.uploadImgServer = config.front_url + 'file/qn_upload';
            this.editor.customConfig.uploadImgHooks = {
                customInsert: function(insertImg, result, editor) {
                    if (result.code == 1) {
                        insertImg(result.data.filePath);
                    }
                }
            };
            this.editor.customConfig.onchange = function(html2) {
                res.formItem.con = html2;
            };
            this.editor.create();
        }
    };
</script>
