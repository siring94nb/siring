<style lang="less" scoped>
@import "./goods.less";
</style>
<style scoped>
.region >>> .ivu-col-span-8:first-of-type {
  padding-left: 0 !important;
}
.region >>> .ivu-col-span-8 {
  width: 15%;
}
</style>
<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="searchConf.title" placeholder="请输入名称"></Input>
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
      width="1000"
      :styles="{top: '30px'}"
      @on-visible-change="doCancel"
    >
      <p slot="header" style="color:#2d8cf0;">
        <Icon type="md-information-circle"></Icon>
        <span>{{formItem.id ? '编辑' : '新增'}}</span>
      </p>
      <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="100">
        <FormItem label="活动主体" prop="title">
          <Input style="width: 500px" v-model="formItem.title" placeholder="请输入活动主体" />
        </FormItem>
        <FormItem label="活动地址" prop="region">
          <al-selector
            @on-change="regionChange"
            class="region"
            level="2"
            data-type="name"
            v-model="res_s"
          />
        </FormItem>
        <FormItem label="详细地址" prop="address">
          <Input style="width: 500px" v-model="formItem.address" placeholder="请输入详细地址" />
        </FormItem>
        <FormItem label="开始时间" prop="add_time">
          <DatePicker
            type="datetime"
            v-model="formItem.add_time"
            placeholder="请输入开始时间"
            style="width: 200px"
          ></DatePicker>
        </FormItem>
        <FormItem label="结束时间" prop="end_time">
          <DatePicker
            type="datetime"
            v-model="formItem.end_time"
            placeholder="请输入结束时间"
            style="width: 200px"
          ></DatePicker>
        </FormItem>
        <FormItem label="活动上限人数" prop="upper_num">
          <InputNumber :min="1" v-model="formItem.upper_num"></InputNumber>
        </FormItem>
        <FormItem label="会务费用" prop="cost">
          <Input style="width: 150px" v-model="formItem.cost" placeholder="元" />
        </FormItem>
        <FormItem label="会务场地图" prop="img">
          <div class="demo-upload-list" v-for="(item, index) in uploadList" :key="index">
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
            :multiple="true"
            style="display: inline-block;width:58px;"
          >
            <div style="width: 58px;height:58px;line-height: 58px;">
              <Icon type="ios-camera" size="20"></Icon>
            </div>
          </Upload>
        </FormItem>
        <FormItem label="状态" prop="status">
          <RadioGroup v-model="formItem.status">
            <Radio :label="0">暂不发布</Radio>
            <Radio :label="1">立即发布</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="回顾单图">
          <div class="demo-upload-list" v-for="(item, index) in uploadListSlt" :key="index">
            <template v-if="item.status === 'finished'">
              <img :src="item.url" />
              <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click.native="handleRemoveSlt(item)"></Icon>
              </div>
            </template>
            <template v-else>
              <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
            </template>
          </div>
          <Upload
            ref="uploads"
            :show-upload-list="false"
            :default-file-list="iconListSlt"
            :on-success="handleSuccessSlt"
            :format="['jpg','jpeg','png']"
            :max-size="10240"
            :on-format-error="handleFormatErrorSlt"
            :on-exceeded-size="handleMaxSizeSlt"
            :before-upload="handleBeforeUploadSlt"
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
        <FormItem label="活动排序" prop="sort">
          <InputNumber :min="1" v-model="formItem.sort"></InputNumber>
        </FormItem>
        <FormItem label="活动回顾" prop="con">
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
import axios from "axios";
import config from "../../../build/config";
import wangEditor from "wangeditor";
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
          vm.formItem.region = currentRow.region;
          vm.formItem.address = currentRow.address;
          vm.formItem.add_time = currentRow.add_time;
          vm.formItem.end_time = currentRow.end_time;
          vm.formItem.upper_num = currentRow.upper_num;
          vm.formItem.sort = currentRow.sort;
          vm.formItem.status = currentRow.status;
          vm.formItem.cost = currentRow.cost;
          vm.formItem.con = currentRow.con;
          vm.formItem.field_img = currentRow.field_img;
          vm.formItem.img = currentRow.img;
          vm.editor.txt.html(vm.formItem.con);
          vm.html = vm.formItem.con;
          //图片
          if (currentRow.field_img != "" && currentRow.field_img != null) {
            var str = currentRow.field_img.split(",");
            for (let i = 0; i < str.length; i++) {
              if (str[i] != "") {
                vm.iconList.push({ name: "", url: str[i] });
              }
            }
          }
          //单图片
          if (currentRow.img != "" && currentRow.img != null) {
            vm.iconListSlt = [{ name: "", url: currentRow.img }];
          }
          vm.$nextTick(() => {
            vm.uploadList = vm.$refs.upload.fileList;
            vm.uploadListSlt = vm.$refs.uploads.fileList;
          });
          vm.modalSetting.show = true;
          vm.modalSetting.index = index;
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
            .post("Schedule/del", {
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
  name: "system_user",
  data() {
    return {
      uploadList: [],
      uploadListSlt: [],
      iconList: [],
      iconListSlt: [],
      typeList: [],
      UploadAction: "",
      visible: false,
      res_s: [],
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "活动主题",
          align: "center",
          key: "title"
        },
        {
          title: "会务场地图片",
          align: "center",
          key: "field_img",
          render: (h, param) => {
            let model_image;
            //图片
            if (param.row.field_img != "" && param.row.field_img != null) {
              var str = param.row.field_img.split(",");
              model_image = str[0];
            }
            return h("img", {
              attrs: {
                src: model_image
              },
              style: {
                width: "100px",
                height: "80px"
              }
            });
          }
        },
        {
          title: "活动回顾单图",
          align: "center",
          key: "img",
          render: (h, param) => {
            let model_image = param.row.img;
            return h("img", {
              attrs: {
                src: model_image
              },
              style: {
                width: "100px",
                height: "80px"
              }
            });
          }
        },
        {
          title: "活动地址",
          align: "center",
          key: "region_address"
        },
        {
          title: "上限人数",
          align: "center",
          key: "upper_num"
        },
        {
          title: "活动时间",
          align: "center",
          key: "activity_time",
          width: 150
        },
        {
          title: "回顾页面推荐",
          align: "center",
          key: "is_rec",
          render: (h, param) => {
            if (param.row.is_rec == 1) {
              return h("div", ["推荐"]);
            } else {
              return h("div", ["不推荐"]);
            }
          }
        },
        {
          title: "排序",
          align: "center",
          key: "sort"
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 260,
          handle: ["edit", "delete"]
        }
      ],
      tableData: [],
      groupList: [],
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
      },
      searchConf: {
        title: ""
      },
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      },
      formItem: {
        id: 0,
        title: "",
        upper_num: 1,
        sort: 1,
        cost: 1,
        status: 1,
        region: "",
        field_img: ""
      },
      ruleValidate: {
        name: [{ required: true, message: "请输入名称", trigger: "blur" }]
        // add_time: [
        //     { required: true, message: '请选择开始时间', trigger: 'blur' }
        // ],
        // end_time: [
        //     { required: true, message: '请选择结束时间', trigger: 'blur' }
        // ],
        // type: [
        //     { required: true, message: '请选择范围', trigger: 'change' }
        // ],
      }
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
    regionChange(data) {
      // console.log(data);
      this.formItem.region = data.join(",");
    },
    alertAdd() {
      //图片
      this.$nextTick(() => {
        this.uploadList = this.$refs.upload.fileList;
        this.uploadListSlt = this.$refs.uploads.fileList;
      });
      this.modalSetting.show = true;
    },
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList;
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      var str = this.formItem.field_img.split(","),arr=[];
      this.formItem.field_img = "";
      for (let i = 0; i < str.length; i++) {
        if(str[i] != file) {
          i < 1 ? this.formItem.field_img = "" : (this.formItem.field_img == ""
        ? (this.formItem.field_img += str[i])
        : (this.formItem.field_img += "," + str[i]))
        }
      }
      // this.formItem.field_img = "";
    },
    handleSuccess(res, file) {
      file.url = res.data.filePath; //获取图片路径
      this.formItem.field_img == ""
        ? (this.formItem.field_img += res.data.filePath)
        : (this.formItem.field_img += "," + res.data.filePath);
    },
    handleFormatError(file) {
      this.$Message.error("文件格式不正确, 请选择jpg或者png.");
    },
    handleMaxSize(file) {
      this.$Message.error("文件大小不能超过10M");
    },
    handleBeforeUpload() {
      const check = this.uploadList.length < 5;
      if (!check) {
        this.$Message.error("只能上传四张品牌图");
      }
      return check;
    },

    //单图
    handleRemoveSlt(file) {
      const fileList = this.$refs.uploads.fileList;
      this.$refs.uploads.fileList.splice(fileList.indexOf(file), 1);
      this.formItem.img = "";
    },
    handleSuccessSlt(res, file) {
      file.url = res.data.filePath; //获取图片路径
      this.formItem.img = res.data.filePath;
    },
    handleFormatErrorSlt(file) {
      this.$Message.error("文件格式不正确, 请选择jpg或者png.");
    },
    handleMaxSizeSlt(file) {
      this.$Message.error("文件大小不能超过10M");
    },
    handleBeforeUploadSlt() {
      const check = this.uploadListSlt.length < 1;
      if (!check) {
        this.$Message.error("只能上传一张品牌图");
      }
      return check;
    },
    submit() {
      console.log(this.formItem);
      let self = this;
      this.$refs["myForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (this.formItem.id === 0) {
            target = "Schedule/add";
          } else {
            target = "Schedule/upd";
          }
          axios.post(target, this.formItem).then(function(response) {
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
      this.modalSetting.show = false;
      this.formItem.id = 0;
      this.formItem.title = "";
      this.formItem.region = "";
      this.formItem.add_time = "";
      this.formItem.end_time = "";
      this.formItem.upper_num = 0;
      this.formItem.sort = 1;
      this.formItem.cost = "";
      this.formItem.con = "";
      this.formItem.field_img = "";
      this.formItem.img = "";
      this.editor.txt.html("");
      this.formItem.status = 1;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      for (var i = 0; i < this.uploadListSlt.length; i++) {
        this.handleRemoveSlt(this.uploadListSlt[i]);
      }
      this.iconList = [];
      this.iconListSlt = [];
    },
    doCancel(data) {
      if (!data) {
        this.formItem.id = 0;
        this.$refs["myForm"].resetFields();
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
      let vm = this;
      axios
        .get("Schedule/index", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.pageSize,
            title: vm.searchConf.title
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
    }
  },
  mounted() {
    let vm = this;
    this.UploadAction = config.front_url + "file/qn_upload";
    this.uploadList = this.$refs.upload.fileList;
    this.uploadListSlt = this.$refs.uploads.fileList;

    this.editor = new wangEditor("#wangeditor");
    this.editor.customConfig.uploadFileName = "image";
    this.editor.customConfig.uploadImgMaxLength = 1;
    this.editor.customConfig.uploadImgServer =
      config.front_url + "file/qn_upload";
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
