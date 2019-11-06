<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form ref="myForm" :model="tableShow" inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="tableShow.project_name" placeholder="请输入需求名称" />
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <Button type="primary" @click="search">立即搜索</Button>
            </FormItem>
          </Form>
        </Card>
      </Col>
    </Row>
    <Row>
      <Col span="24">
        <Card>
          <p slot="title" style="height: 32px">
            <Button type="primary" @click="alertAdd" icon="md-add">添加案例</Button>
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

    <Modal v-model="modalSetting.show" width="998" :styles="{top: '30px'}">
      <Form ref="addOredit" :model="formValidate" :rules="ruleValidate" :label-width="100">
        <FormItem label="需求名称" prop="project_name">
          <Input v-model="formValidate.project_name" placeholder="请输入" style="width: 450px;" />
        </FormItem>
        <FormItem label="需求类型" prop="category_id">
          <Select v-model="formValidate.category_id" style="width: 450px;">
            <Option value="1">智能硬件</Option>
            <Option value="2">电子商务</Option>
            <Option value="3">生活娱乐</Option>
            <Option value="4">金融</Option>
            <Option value="5">媒体</Option>
            <Option value="6">企业服务</Option>
            <Option value="7">政府服务</Option>
          </Select>
        </FormItem>
        <FormItem label="需求预算" prop="project_price_up">
          <Input v-model="formValidate.project_price_up" placeholder="请输入" style="width: 200px;" />元 ~
          <Input v-model="formValidate.project_price_down" placeholder="请输入" style="width: 200px;" />元
        </FormItem>
        <FormItem label="开发终端" prop="develop">
          <CheckboxGroup v-model="formValidate.develop">
            <Checkbox label="PC">
              <Icon type="ios-desktop-outline" size="23" />PC
            </Checkbox>
            <Checkbox label="APP安卓">
              <Icon type="logo-android" size="23" />APP安卓
            </Checkbox>
            <Checkbox label="APP苹果">
              <Icon type="logo-apple" size="23" />APP苹果
            </Checkbox>
            <Checkbox label="公众号">
              <Icon type="ios-chatbubbles" size="23" />公众号
            </Checkbox>
            <Checkbox label="小程序">
              <Icon type="ios-code" size="23" />小程序
            </Checkbox>
            <Checkbox label="H5">
              <Icon type="logo-html5" size="23" />H5
            </Checkbox>
            <!-- <Checkbox label="其他"></Checkbox>
            <Input v-model="formValidate.project_price_up" placeholder="说明，不超过10个字" style="width: 200px;" />-->
          </CheckboxGroup>
        </FormItem>
        <FormItem label="需求描述" prop="project_detail">
          <Input
            v-model="formValidate.project_detail"
            type="textarea"
            :autosize="{minRows: 4,maxRows: 8}"
            style="width:500px;"
          />
        </FormItem>
        <FormItem label="商品主图" prop="img">
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
            multiple
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
          <p>添加5张，建议尺寸：464*764像素，实现轮播效果</p>
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
            console.log(currentRow)
             //图片
          if (currentRow.goods_images != "") {
            var str = currentRow.goods_images.split(",");
            for (let i = 0; i < str.length; i++) {
              if (str[i] != "") {
                vm.iconList.push({ name: "", url: str[i] });
              }
            }
            // vm.iconList = [{ name: "", url: res.data.data.goods_images }];
          }
          vm.$nextTick(() => {
            vm.uploadList = vm.$refs.upload.fileList;
          });
          vm.formValidate = currentRow;
          vm.modalSetting.show = true;
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
            .post("Goods/made_del", {
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
  data() {
    return {
      tableData: [],
      uploadList: [],
      iconList: [],
      typeList: [],
      sortList: [],
      UploadAction: "",
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0,
        project_name: ""
      },
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      },
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "需求名称",
          align: "center",
          key: "project_name"
        },
        {
          title: "商品分类",
          align: "center",
          key: "category_id",
          render: (h, param) => {
            for(let i = 0; i < this.sortList.length; i ++ ) {
              var category_id;
              if(Number(param.row.category_id) == Number(this.sortList[i].id)) {
                category_id = this.sortList[i].category_name;
              }
            }
            return h("div", [category_id]);
          }
        },
        {
          title: "终端选择",
          align: "center",
          key: "develop"
        },
        {
          title: "需求描述",
          align: "center",
          key: "project_detail"
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 300,
          handle: ["edit", "delete"]
        }
      ],
      formValidate: {
        id: 0,
        project_name: "",
        category_id: "",
        project_price_up: "",
        project_price_down: "",
        develop: [],
        project_detail: "",
        goods_images: ""
      },
      ruleValidate: {
        project_name: [
          {
            required: true,
            message: "需求名称不能为空",
            trigger: "blur"
          }
        ],
        category_id: [
          {
            required: true,
            message: "需求类型不能为空",
            trigger: "blur"
          }
        ],
        project_price_up: [
          {
            required: true,
            message: "需求预算不能为空",
            trigger: "blur"
          }
        ],
        develop: [
          {
            required: true,
            type: "array",
            min: 1,
            message: "开发终端至少选一个",
            trigger: "change"
          }
        ],
        project_detail: [
          {
            required: true,
            message: "需求描述不能为空",
            trigger: "blur"
          }
        ]
      }
    };
  },
  created() {
    this.init();
    this.getSort();
    this.getMade(this.tableShow);
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
    cancel() {
      this.formValidate = {
        id: 0,
        project_name: "",
        category_id: "",
        project_price_up: "",
        project_price_down: "",
        develop: [],
        project_detail: "",
        goods_images: ""
      };
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.iconList = [];
      this.modalSetting.show = false;
    },
    submit() {
      let self = this;
      this.$refs["addOredit"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (self.formValidate.id == 0) {
            target = "Goods/made_add";
          } else {
            target = "Goods/made_edit";
          }
          axios.post(target, self.formValidate).then(function(response) {
            self.modalSetting.loading = false;
            if (response.data.code === 1) {
              self.$Message.success(response.data.msg);
              self.cancel();
              self.getMade(self.tableShow);
            } else {
              self.$Message.error(response.data.msg);
            }
          });
        }
      });
    },
    //分类
    getSort() {
      let vm = this;
      axios.post("Goods/category_index", {}).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          vm.sortList = res.data.list;
        }
      });
    },
    //主列表
    getMade(data) {
      let vm = this;
      axios.post("Goods/made", data).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          vm.tableData = res.data.list.data;
          vm.tableShow.listCount = res.data.listCount;
        }
      });
    },
    changePage(page) {
      this.tableShow.currentPage = page;
      this.getMade(this.tableShow);
    },
    changeSize(size) {
      this.tableShow.pageSize = size;
      this.getMade(this.tableShow);
    },
    search() {
      this.tableShow.currentPage = 1;
      this.getMade(this.tableShow);
    },
    alertAdd() {
      this.modalSetting.show = true;
    },
    // 图片上传
    handleView(file) {
      this.visible = true;
    },
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList;
      // console.log(this.$refs.upload.fileList.splice(fileList.indexOf(file)));
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      this.formValidate.goods_images = "";
    },
    handleSuccess(res, file) {
      // file.url = res.data;
      // this.formItem.img = res.data.substr( res.data.indexOf( 'upload' ) );
      file.url = res.data.filePath; //获取图片路径
      this.formValidate.goods_images += res.data.filePath + ",";
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
        this.$Message.error("只能上传五张品牌图");
      }
      return check;
    }
  },
  mounted() {
    let vm = this;
    this.UploadAction = config.front_url + "file/qn_upload";
    this.uploadList = this.$refs.upload.fileList;
  }
};
</script>

<style lang="less" scoped>
@import "./goods.less";
</style>