<style lang="less" scoped>
@import "./goods.less";
</style>
<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form ref="myForm" :model="searchConf" inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="searchConf.title" placeholder="请输入商品名称" />
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <span>商品分类</span>

              <Select v-model="searchConf.category_id" style="width: 200px;">
                <Option :value="-1">全部</Option>
                <Option
                  v-for="(item, index) in sortList"
                  :value="item.id"
                  :key="index"
                >{{ item.category_name }}</Option>
              </Select>
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <span>商品状态</span>
              <Select v-model="searchConf.status" style="width: 200px;">
                <Option :value="1">推荐</Option>
                <Option :value="2">不推荐</Option>
              </Select>
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
            <Button type="primary" @click="alertAdd" icon="md-add">添加商品</Button>
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
      <Tabs value="name1">
        <TabPane label="添加评论" name="name1">
          <Form ref="comments" :model="comment">
            <FormItem label="马甲会员账号">
              <Input v-model="comment.number" placeholder="请输入" style="width: 500px;" />
            </FormItem>
            <FormItem label="会员头像" prop="img">
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
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <span>会员等级</span>
              <Select v-model="comment.grade" style="width: 400px;">
                <Option
                  v-for="(item, index) in sortList"
                  :value="item.id"
                  :key="index"
                >{{ item.category_name }}</Option>
              </Select>
            </FormItem>
            <FormItem label="会员评论" porp>
              <Input
                v-model="comment.menber_comment"
                type="textarea"
                :autosize="{minRows: 4,maxRows: 8}"
                style="width:1000px;"
              />
            </FormItem>
            <FormItem >
                <DatePicker type="datetime" v-model="comment.start_time" placeholder="请选择时间" style="width: 200px"></DatePicker>
            </FormItem>
            <FormItem label="官方回复" porp>
              <Input
                v-model="comment.reply"
                type="textarea"
                :autosize="{minRows: 4,maxRows: 8}"
                style="width:1000px;"
              />
            </FormItem>
            <FormItem >
                <DatePicker type="datetime" v-model="comment.end_time" placeholder="请选择时间" style="width: 200px"></DatePicker>
            </FormItem>
          </Form>
          <div slot="footer">
            <Button type="text" @click="cancel" style="margin-right: 8px">取消</Button>
            <Button type="primary" @click="submit" :loading="modalSetting.loading">确定</Button>
          </div>
        </TabPane>
        <TabPane label="历史评论" name="name2">标签二的内容</TabPane>
      </Tabs>
    </Modal>
  </div>
</template>
<script>
import axios from "axios";
import config from "../../../build/config";
import wangEditor from "wangeditor";

const addCommentButton = (vm, h, currentRow, index) => {
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
          vm.modalSetting.show = true;
        }
      }
    },
    "添加评论"
  );
};
const copyButton = (vm, h, currentRow, index) => {
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
        click: () => {}
      }
    },
    "复制"
  );
};
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
          vm.$router.push({
            name: "goods_add",
            params: {
              goods_id: currentRow.id
            }
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
            .post("Goods/del", {
              id: currentRow.id
            })
            .then(function(response) {
              console.log(response);
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
      theme1: "light",
      UploadHeader: "",
      DefaultList: [],
      // 图片
      UploadAction: "",
      visible: false,
      uploadList: [],
      iconList: [],
      sortList: [],
      // 图片
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "商品名称",
          align: "center",
          key: "goods_name"
        },
        {
          title: "缩略图",
          align: "center",
          key: "goods_images",
          width: 150,
          render: (h, param) => {
            return h("img", {
              attrs: {
                src: param.row.goods_images
              },
              style: {
                width: "100px",
                height: "90px",
                padding: "5px 0 0 0"
              }
            });
          }
        },
        {
          title: "商品编号",
          align: "center",
          key: "goods_number"
        },
        {
          title: "商品分类",
          align: "center",
          key: "category_id"
        },
        {
          title: "终端版本",
          align: "center",
          key: "attr_title"
        },
        {
          title: "开发周期",
          align: "center",
          key: "cycle_time"
        },
        {
          title: "价格",
          align: "center",
          key: "price"
        },
        {
          title: "排序",
          align: "center",
          key: "goods_sort"
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
          width: 400,
          handle: ["comments", "copy", "edit", "delete"]
        }
      ],
      comment: {
        number: '',
        grade: '',
        menber_comment: '',
        start_time: '',
        reply: '',
        end_time: '',
      },
      tableData: [],
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
      },
      searchConf: {
        title: "",
        status: "",
        category_id: -1
      },
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      }
    };
  },
  created() {
    this.init();
    this.getList();
    this.getSort();
  },
  methods: {
    init() {
      let vm = this;
      this.columnsList.forEach(item => {
        if (item.handle) {
          item.render = (h, param) => {
            let currentRowData = vm.tableData[param.index];
            return h("div", [
              addCommentButton(vm, h, currentRowData, param.index),
              copyButton(vm, h, currentRowData, param.index),
              editButton(vm, h, currentRowData, param.index),
              deleteButton(vm, h, currentRowData, param.index)
            ]);
          };
        }
      });
    },
    cancel() {
      // 移除图片
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.iconList = [];

      this.modalSetting.show = false;
    },
    onMenuSelect(name) {
      // console.log(name);
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
    handleAdd() {
      // this.index++;
      this.formItem.special.push({
        attr_title: "",
        price: "",
        bottom_price: "",
        cycle_time: ""
      });
    },
    tableRemove(index) {
      this.formItem.special.splice(index, 1);
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
    alertAdd() {
      let vm = this;
      vm.$router.push({
        name: "goods_add",
        params: {
          goods_id: 0
        }
      });
    },
    submit() {
      let self = this;
      this.$refs["myForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (this.formItem.id) {
            target = "Goods/add";
          } else {
            target = "Goods/add";
          }
          // data.formItem = this.formItem;
          // data.special = this.special;
          axios.post(target, this.formItem).then(function(response) {
            self.modalSetting.loading = false;
            console.log(response);
            if (response.data.code === 1) {
              self.$Message.success(response.data.msg);
              self.getList();
              self.cancel();
            } else {
              self.$Message.error(response.data.msg);
            }
          });
        }
      });
    },
    getList() {
      let vm = this;
      axios
        .get("Goods/index", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.pageSize,
            goods_name: vm.searchConf.title,
            category_id: vm.searchConf.category_id,
            status: vm.searchConf.status
          }
        })
        .then(function(response) {
          let res = response.data;
          if (res.code === 1) {
            for (let i = 0; i < res.data.list.length; i++) {
              var str = res.data.list[i].goods_images.split(",");
              res.data.list[i].goods_images = str[0];
            }
            vm.tableData = res.data.list;
            vm.tableShow.listCount = res.data.count;
          } else {
          }
        });
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
    // 图片上传
    handleView(file) {
      this.visible = true;
    },
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList;
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      this.formItem.data.goods_images = "";
    },
    handleSuccess(res, file) {
      // file.url = res.data;
      // this.formItem.img = res.data.substr( res.data.indexOf( 'upload' ) );
      file.url = res.data.filePath; //获取图片路径
      this.formItem.data.goods_images = res.data.filePath;
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
        this.$Message.error("只能上传一张品牌图");
      }
      return check;
    }
  },
  mounted() {
    // this.UploadAction = config.front_url+'api/upload';
    // this.uploadList = this.$refs.upload.fileList;
    this.UploadAction = config.front_url + "file/qn_upload";
    this.uploadList = this.$refs.upload.fileList;
  }
};
</script>
