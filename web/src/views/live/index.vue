<style lang="less" scoped>
   
</style>
<template>
    <div>
        <Row>
            <Col span="24">
            <Card style="margin-bottom: 10px">
                <Form inline>
                    <FormItem style="margin-bottom: 0">
                        <Input v-model="searchConf.nickname" placeholder="请输入昵称"></Input>
                    </FormItem>
                    <FormItem style="margin-bottom: 0">
                        <DatePicker type="datetime" v-model="searchConf.start_time" placeholder="请输入开始时间" style="width: 200px"></DatePicker>
                    </FormItem>
                    <FormItem style="margin-bottom: 0">
                        <DatePicker type="datetime" v-model="searchConf.end_time" placeholder="请输入结束时间" style="width: 200px"></DatePicker>
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
                <Card><!-- tableData视图加载页面 -->
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
        <Modal v-model="modalSetting.show" width="600" :styles="{top: '30px'}" @on-visible-change="doCancel">
            <p slot="header" style="color:#2d8cf0;">
                <Icon type="md-information-circle"></Icon>
                <span>{{formItem.id ? '审核' : '新增'}}</span>
            </p>
            <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
                <FormItem label="上传凭证" prop="img" v-if="formItem.cash_mode == 2">
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
                            :action="UploadAction"
                            style="display: inline-block;width:58px;">
                            <div style="width: 58px;height:58px;line-height: 58px;">
                                <Icon type="ios-camera" size="20"></Icon>
                            </div>
                    </Upload>
                </FormItem>
                <FormItem label="审核状态" prop="is_examine">
                    <Select v-model="formItem.is_examine" style="width:200px">
                        <Option :value="2" >{{'审核成功'}}</Option>
                        <Option :value="3" >{{'审核失败'}}</Option>
                    </Select>
                    <span style="color: red;">(状态,一旦操作不可修改)</span>
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
                    vm.formItem.cash_mode = currentRow.cash_mode;
                    vm.formItem.is_examine = currentRow.is_examine;
                    vm.formItem.img = currentRow.img;
                    //console.log(vm.formItem.cash_mode);
                    //图片
                    if(currentRow.img != ''){
                        vm.iconList = [{name:'',url:currentRow.img}];
                    }
                    vm.$nextTick(() => {
                        vm.uploadList = vm.$refs.upload.fileList;
                    });
                    vm.modalSetting.show = true;
                    vm.modalSetting.index = index;
                }
            }
        }, '审核' );
    };
    export default {
        name: 'cash_list',
      data () {
          return {
               UploadAction: '',
                UploadHeader: '',
                uploadList: [],
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
                      title: '用户',
                      align: 'center',
                      key: 'realname'
                  },
                  {
                      title: '类型',
                      align: 'center',
                      key: 'grade'
                  },
                  {
                      title: '活动名称',
                      align: 'center',
                      key: 'titile'
                  },
                  {
                      title: '计划开始时间',
                      align: 'center',
                      key: 'add_time'
                  },
                  {
                      title: '计划结束时间',
                      align: 'center',
                      key: 'end_time'
                  },
                  {
                      title: '状态',
                      align: 'center',
                      key: 'examine'
                  },
                  {
                      title: '申请时间',
                      align: 'center',
                      key: 'created_at'
                  },
                  /* {
                      title: '处理时间',
                      align: 'center',
                      key: 'updated_at'
                  }, */
                    {
                        title: '操作',
                        align: 'center',
                        key: 'handle',
                        handle: ['edit']
                    }
            ],
            tableData: [],//视图加载tableData
                tableShow: {
                currentPage: 1,
                    pageSize: 10,
                    listCount: 0
            },
            formItem:{
                is_examine : '',
                img : '',
                cash_mode:''
            },
            searchConf: {
                nickname: '',
                start_time:'',
                end_time:''
            },
            modalSetting: {
                show: false,
                loading: false,
                index: 0
            },
            ruleValidate: {
                money: [
                    {required: true, message: '余额不能为空', trigger: 'blur'}
                ]
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
                let vm = this;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param ) => {
                            let currentRowData = vm.tableData[param.index];//tableData视图加载页面
                            return h('div', [
                               // stickButton(vm, h, currentRowData, param.index)// stickButton定义操作控件
                                editButton(vm, h, currentRowData, param.index),
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
                        if (this.formItem.id === 0) {
                            target = 'Examine/add';
                        } else {
                            target = 'Examine/upd';
                        }
                        axios.post(target, this.formItem).then(function (response) {
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
                this.formItem.id = 0;
                this.formItem.img = '';
                // 移除图片
                this.visible = false;
                for(var i = 0; i < this.uploadList.length; i++){
                    this.handleRemove(this.uploadList[i]);
                }
                this.iconList = [];
                this.getList();
                
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
                axios.get('Examine/index', {
                    params: {
                        page: vm.tableShow.currentPage,
                        size: vm.tableShow.pageSize,
                        nickname: vm.searchConf.nickname,
                        start_time: vm.searchConf.start_time,
                        end_time: vm.searchConf.end_time
                       // is_examine: vm.searchConf.status
                    }
                }).then(function (response) {
                    let res = response.data;
                    if (res.code === 1) {
                        vm.tableData = res.data.list;//视图加载tableData
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
                    this.formItem.id = 0;
                    this.$refs['myForm'].resetFields();
                    this.modalSetting.loading = false;
                    this.modalSetting.index = 0;
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
                file.url = res.data;
                this.formItem.img = res.data.substr( res.data.indexOf( 'upload' ) );
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
                    this.$Message.error('只能上传一张照片');
                }
                return check;
            },

        },
        mounted () {
            //照片
            this.UploadAction = config.front_url+'api/upload';
            this.uploadList = this.$refs.upload.fileList;
        },
    };
</script>

