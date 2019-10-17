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
      </Card>
      </Col>
    </Row>
    <Modal v-model="modalSetting.show" width="1000" :styles="{top: '30px'}" @on-visible-change="doCancel">
      <p slot="header" style="color:#2d8cf0;">
        <Icon type="md-information-circle"></Icon>
        <span>{{'更新'}}</span>
      </p>
      <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
        <FormItem label="内容" prop="con">
          <div id="wangeditor" v-model="formItem.con"></div>
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
          con: ''
        },
        ruleValidate: {
          con: [{
            required: true,
            message: '请填写内容',
            trigger: 'blur'
          }]
        },
        html: ''
      };
    },
    created() {
      this.init();
      this.getList();
    },
    methods: {
      init() {
        let vm = this;
        axios.get('About/profitInfo').then(function(response) {
          let res = response.data;
          if (res.code === 1) {
            vm.formItem.con = res.data.info.con;
            vm.editor.txt.html(res.data.info.con);
            vm.html = res.data.info.con;
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
            let target = 'About/profitUpd';
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
    }
  };
</script>
