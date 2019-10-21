<template>
  <div>
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
            <Page
              :total="tableShow.listCount"
              :current="tableShow.currentPage"
              :page-size="tableShow.pageSize"
              @on-change="changePage"
              @on-page-size-change="changeSize"
              show-elevator
              show-sizer
              show-total
            ></Page>
          </div>
        </Card>
      </Col>
    </Row>
    <Modal
      v-model="modalSetting.show"
      width="668"
      :styles="{top: '30px'}"
      @on-visible-change="doCancel"
    >
      <p slot="header" style="color:#2d8cf0;">
        <Icon type="md-information-circle"></Icon>
        <span>{{formItem.id ? '编辑' : '新增'}}用户</span>
      </p>
      <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="120">
        <FormItem label="会员等级" prop="title">
          <Input v-model="formItem.title" placeholder="请输入会员等级" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="等级图标" prop="img">
          <div class="demo-upload-list" v-for="item in uploadList" :key="item.id">
            <template v-if="item.status === 'finished'">
              <img :src="item.url" />
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
            style="display: inline-block;width:58px;"
          >
            <div style="width: 58px;height:58px;line-height: 58px;">
              <Icon type="ios-camera" size="20"></Icon>
            </div>
          </Upload>
        </FormItem>
        <FormItem label="有效期" prop="term">
          <Select v-model="formItem.term" style="width: 300px;">
            <Option :value="0" :key="0">{{'永久'}}</Option>
            <Option :value="1" :key="1">{{'1年'}}</Option>
            <Option :value="2" :key="2">{{'2年'}}</Option>
          </Select>
        </FormItem>
        <FormItem label="会员费（元/年）">
          <Input v-model="formItem.money"></Input>
        </FormItem>
        <FormItem label="等级政策描述" prop="policy">
          <Input
            v-model="formItem.policy"
            type="textarea"
            :autosize="{minRows: 2,maxRows: 5}"
            placeholder="请输入等级政策描述"
          ></Input>
        </FormItem>
        <FormItem label="消费折扣（0~99%）" prop="discount">
          <InputNumber :min="1" v-model="formItem.discount"></InputNumber>
        </FormItem>
        <FormItem label="从下级业绩提成（0~99%）" prop="royalty">
          <InputNumber :min="1" v-model="formItem.royalty"></InputNumber>
          <div>*下级任何实际消费都算业绩，包括缴纳城市合伙人费用</div>
        </FormItem>
        <FormItem label="是否介绍隐藏">
          <i-switch v-model="formItem.is_hide" size="large">
            <span slot="open">ON</span>
            <span slot="close">OFF</span>
          </i-switch>
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
import axios from "axios";
import config from "../../../build/config";

const editButton = (vm, h, currentRow, index) => {
  return h(
    "Button",
    {
      props: {
        type: "primary"
      },
      style: {
        margin: "0 5px"
      },
      on: {
        click: () => {
          vm.formItem.id = currentRow.id;
          vm.formItem.title = currentRow.title;
          vm.formItem.img = currentRow.img;
          vm.formItem.term = currentRow.term;
          vm.formItem.money = currentRow.money;
          vm.formItem.policy = currentRow.policy;
          vm.formItem.discount = currentRow.discount;
          vm.formItem.royalty = currentRow.royalty;
          vm.formItem.is_hide = currentRow.is_hide;
          vm.modalSetting.show = true;
          vm.modalSetting.index = index;

          //图片
          if (currentRow.img != "") {
            vm.iconList = [{ name: "", url: currentRow.img }];
          }
          vm.$nextTick(() => {
            vm.uploadList = vm.$refs.upload.fileList;
          });
        }
      }
    },
    "编辑"
  );
};
const deleteButton = (vm, h, currentRow, index) => {
  return h(
    "Poptip",
    {
      props: {
        confirm: true,
        title: "您确定要删除这条数据吗? ",
        transfer: true
      },
      on: {
        "on-ok": () => {
          axios
            .post("RoleJoin/member_delete", {
              id: currentRow.id
            })
            .then(function(response) {
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
    },
    [
      h(
        "Button",
        {
          style: {
            margin: "0 5px"
          },
          props: {
            type: "error",
            placement: "top",
            loading: currentRow.isDeleting
          }
        },
        "删除"
      )
    ]
  );
};

export default {
  name: "UserManage_list",
  data() {
    return {
      UploadAction: "",
      UploadHeader: "",
      uploadList: [],
      DefaultList: [],
      confirmRefresh: false,
      columnsList: [
        {
          title: "等级名称",
          align: "center",
          key: "title"
        },
        {
          title: "等级图标",
          align: "center",
          key: "img",
          //width: 150,
          render: (h, param) => {
            return h("img", {
              attrs: {
                src: param.row.img
              },
              style: {
                width: "80px",
                height: "80px",
                padding: "5px 0 0 0"
              }
            });
          }
        },
        {
          title: "有效期（年）",
          align: "center",
          key: "term",
          render: (h, param) => {
            if (param.row.term == 0) {
              return h("div", ["永久"]);
            } else if (param.row.term == 1) {
              return h("div", ["1年"]);
            } else {
              return h("div", ["2年"]);
            }
          }
        },
        {
          title: "年度费用标准",
          align: "center",
          key: "money"
        },
        {
          title: "等级政策",
          align: "center",
          key: "policy"
        },
        {
          title: "状态",
          align: "center",
          key: "status",
          width: 100
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 200,
          handle: ["edit", "delete"]
        }
      ],
      tableData: [],
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
      },
      formItem: {
        id: 0,
        img: "",
        title: "",
        term: 0,
        money: 1,
        is_hide: 1,
        status: 1
      },
      searchConf: {
        title: "",
        keywords: "",
        status: "",
        start_time: "",
        end_time: ""
      },
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      },
      ruleValidate: {
        title: [
          { required: true, message: "等级名称不能为空", trigger: "blur" }
        ]
        // phone: [
        //   { required: true, message: "手机号码不能为空", trigger: "blur" },
        //   { validator: validatePhone, trigger: "blur" }
        // ]
      },
      // 图片
      UploadAction: "",
      visible: false,
      uploadList: [],
      iconList: []
      // 图片
    };
  },
  created() {
    this.init();
    this.getList();
  },
  methods: {
    init() {
      let vm = this;
      this.columnsList.forEach(item => {
        if (item.handle) {
          item.render = (h, param) => {
            let currentRowData = vm.tableData[param.index];
            return h("div", [
              editButton(vm, h, currentRowData, param.index),
              deleteButton(vm, h, currentRowData, param.index)
            ]);
          };
        }
      });
    },
    alertAdd() {
      //图片
      this.$nextTick(() => {
        this.uploadList = this.$refs.upload.fileList;
      });
      this.modalSetting.show = true;
    },
    submit() {
      let self = this;
      this.$refs["myForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (this.formItem.id) {
            target = "RoleJoin/member_save";
          } else {
            target = "RoleJoin/member_create";
          }
          axios.post(target, self.formItem).then(function(response) {
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
    cancel() {
      this.formItem.id = 0;
      this.formItem.name = "";
      this.formItem.num = 1;
      this.formItem.add_time = "";
      this.formItem.end_time = "";
      this.formItem.range = 0;
      this.formItem.full = 1;
      this.formItem.reduce = 1;
      this.formItem.status = 1;
      this.formItem.type = "";
      // 移除图片
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.modalSetting.show = false;
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
      let vm = this;
      axios
        .get("RoleJoin/member_index", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.pageSize,
            keywords: vm.searchConf.keywords,
            title: vm.searchConf.title,
            start_time: vm.searchConf.start_time,
            end_time: vm.searchConf.end_time
          }
        })
        .then(function(response) {
          let res = response.data;
          if (res.code === 1) {
            vm.tableData = res.data.list;
            vm.tableShow.listCount = res.data.count;
          } else {
            if (res.code === -14) {
              vm.$store.commit("logout", vm);
              vm.$router.push({
                name: "login"
              });
            } else {
              vm.$Message.error(res.msg);
            }
          }
        });
    },
    doCancel(data) {
      if (!data) {
        this.cancel();
        this.formItem.id = 0;
        this.$refs["myForm"].resetFields();
        this.modalSetting.loading = false;
        this.modalSetting.index = 0;
      }
    },
    // 图片上传
    handleView(file) {
      this.visible = true;
    },
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList;
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      this.formItem.img = "";
    },
    handleSuccess(res, file) {
      //file.url = config.front_url + 'uploads/img/' + res.data.fileName;//直接拼后缀
      file.url = res.data.filePath; //获取图片路径
      this.formItem.img = res.data.filePath;
    },
    handleFormatError(file) {
      this.$Message.error("文件格式不正确, 请选择jpg或者png.");
    },
    handleMaxSize(file) {
      this.$Message.error("文件大小不能超过10M");
    },
    handleBeforeUpload() {
      const check = this.uploadList.length < 1;
      if (!check) {
        this.$Message.error("只能上传一张照片");
      }
      return check;
    }
  },
  mounted() {
    //照片
    //this.UploadAction = config.front_url+'api/upload';
    this.UploadAction = config.front_url + "file/qn_upload";
    this.uploadList = this.$refs.upload.fileList;
  }
};
</script>
<style scoped lang="less">
.api-box {
  max-height: 300px;
  overflow: auto;
  border: 1px solid #dddee1;
  border-radius: 5px;
  padding: 10px;
}
.demo-upload-list {
  display: inline-block;
  width: 60px;
  height: 60px;
  text-align: center;
  line-height: 60px;
  border: 1px solid transparent;
  border-radius: 4px;
  overflow: hidden;
  background: #fff;
  position: relative;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  margin-right: 4px;

  img {
    width: 100%;
    height: 100%;
  }

  &-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
  }

  &:hover .demo-upload-list-cover {
    display: block;
  }

  &-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
  }
}
</style>
