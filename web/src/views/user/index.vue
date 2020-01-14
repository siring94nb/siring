<style lang="less" scoped>
@import "./vip.less";
</style>
<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="searchConf.title" placeholder="请输入账号或者姓名"></Input>
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <DatePicker
                type="datetime"
                v-model="searchConf.start_time"
                placeholder="请输入开始时间"
                style="width: 200px"
              ></DatePicker>
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <DatePicker
                type="datetime"
                v-model="searchConf.end_time"
                placeholder="请输入结束时间"
                style="width: 200px"
              ></DatePicker>
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
      <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
        <FormItem label="姓名" prop="realname">
          <Input v-model="formItem.realname" placeholder="请输入姓名" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="头像" prop="img">
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
        <FormItem label="电话" prop="phone">
          <Input v-model="formItem.phone" placeholder="请输入电话号码" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="性别"  prop="sex">
          <RadioGroup v-model="formItem.sex">
            <Radio :label="0" >隐藏</Radio>
            <Radio :label="1" >男</Radio>
            <Radio :label="2" >女</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="备注" prop="remark">
          <Input style="width: 300px" v-model="formItem.remark" placeholder="请输入备注"></Input>
        </FormItem>
        <FormItem label="密码" prop="password">
          <Tooltip
            :content="formItem.id ? '为空时默认不修改密码' : '为空时默认密码是123456'"
            placement="bottom-start"
          >
            <Input
              v-model="formItem.password"
              placeholder="请输入密码"
              style="width: 300px;"
              type="password"
            ></Input>
          </Tooltip>
        </FormItem>
        <FormItem label="确认密码" prop="con_password">
          <Input
            v-model="formItem.con_password"
            placeholder="请输入确认密码"
            style="width: 300px;"
            type="password"
          ></Input>
        </FormItem>

        <FormItem label="会员等级" prop="grade">
          <Select v-model="formItem.grade" style="width:200px">
            <Option :value="0" :key="0">{{'普通会员'}}</Option>
            <Option :value="1" :key="1">{{'金牌会员'}}</Option>
            <Option :value="2" :key="2">{{'钻石会员'}}</Option>
            <Option :value="3" :key="3">{{'皇冠会员'}}</Option>
          </Select>
        </FormItem>
        <FormItem label="会员身份"  prop="vest">
          <RadioGroup v-model="formItem.vest">
            <Radio :label="1" >正常身份</Radio>
            <Radio :label="2" >马甲会员</Radio>
          </RadioGroup>
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
          vm.formItem.realname = currentRow.realname;
          vm.formItem.img = currentRow.img;
          vm.formItem.sex = currentRow.sex;
          vm.formItem.remark = currentRow.remark;
          vm.formItem.type = currentRow.type;
          vm.formItem.phone = currentRow.phone;
          vm.formItem.vest = currentRow.vest;
          vm.formItem.grade = currentRow.grade;
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
            .post("UserManage/Delete", {
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
    const validatePhone = (rule, value, callback) => {
      var reg = /^1\d{10}$/;
      if (!reg.test(value)) {
        callback(new Error("手机号码格式不正确"));
      }
      callback();
    };
    return {
      UploadAction: "",
      UploadHeader: "",
      uploadList: [],
      DefaultList: [],
      confirmRefresh: false,
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "邀请码",
          align: "center",
          key: "invitation"
        },
        {
          title: "用户账号",
          align: "center",
          key: "phone",
            width: 120,

        },
        {
          title: "上级邀请码",
          align: "center",
          key: "other_code"
        },
        {
          title: "上级账号",
          align: "center",
          key: "other_code"
        },
        {
          title: "用户昵称",
          align: "center",
          key: "realname"
        },
        {
          title: "头像",
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
          title: "性别",
          align: "center",
          key: "sex",
          render: (h, param) => {
            if (param.row.sex == "1") {
              return h("div", "男");
            } else if (param.row.sex == "2") {
              return h("div", "女");
            } else {
              return h("div", "未知");
            }
          }
        },
        {
          title: "地址",
          align: "center",
          key: "address"
        },
        {
          title: "会员等级",
          align: "center",
          key: "grade",
            render: (h, param) => {
                if (param.row.grade == "0") {
                    return h("div", "普通会员");
                } else if (param.row.grade == "1") {
                    return h("div", "金牌会员");
                }else if (param.row.grade == "2") {
                    return h("div", "钻石会员");
                }else if (param.row.grade == "3") {
                    return h("div", "皇冠会员");
                }
            }
        },
          {
              title: "会员身份",
              align: "center",
              key: "vest",
              render: (h, param) => {
                  if (param.row.vest == "1") {
                      return h("div", "正常");
                  } else if (param.row.vest == "2") {
                      return h("div", "马甲");
                  }
              }
          },
        {
          title: "加入时间",
          align: "center",
          key: "created_at",
          width: 150
        },
        {
          title: "到期时间",
          align: "center",
          key: "end_time",
          width: 150
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
          img: "",
          sex:0,
          grade:0,
          vest:1,
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
        realname: [
          { required: true, message: "姓名不能为空", trigger: "blur" }
        ],
        phone: [
          { required: true, message: "手机号码不能为空", trigger: "blur" },
          { validator: validatePhone, trigger: "blur" }
        ]
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
            target = "UserManage/Edit";
          } else {
            target = "UserManage/Add";
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
        .get("UserManage/index", {
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
