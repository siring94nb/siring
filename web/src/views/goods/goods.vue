<style lang="less" scoped>
@import "./goods.less";
</style>
<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="searchConf.title" placeholder="请输入要搜索的内容"></Input>
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
      <p slot="header">
        <Icon type="md-add"></Icon>
        <span>添加商品</span>
      </p>
      <Form ref="myForm" :model="formItem" :label-width="120">
        <FormItem label="商品名称" prop="name">
          <Input v-model="formItem.data.goods_name" placeholder="请输入" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="商品编号" prop="name">
          <Input v-model="formItem.data.goods_number" placeholder="请输入" style="width: 300px;"></Input>
          <p>*模板化产品，规则按照MB+4位数字设定</p>
        </FormItem>
        <FormItem label="归属分类" prop="name">
          <Select v-model="formItem.data.category_id" style="width: 300px;">
            <Option :value="0">顶级菜单</Option>
            <Option v-for="item in tableData" :value="item.id" :key="item.id">{{ item.showName }}</Option>
          </Select>
          <p>*可添加、修改分类，也可删除分类，分类名称按照顺序显示在前端页面</p>
        </FormItem>
        <FormItem label="商品排序" prop="name">
          <InputNumber :min="1" v-model="formItem.data.goods_sort" style="width: 300px;"></InputNumber>
        </FormItem>
        <FormItem label="标记" prop="name">
          <RadioGroup v-model="formItem.data.sign">
            <Radio label="1">促销</Radio>
            <Radio label="2">hot</Radio>
          </RadioGroup>
          <p>*填写正整数，从大到小排序</p>
        </FormItem>
        <FormItem label="SEO设置关键字" prop="name">
          <Input v-model="formItem.data.seo" placeholder="请输入" style="width: 300px;"></Input>
          <p>*关键字中间用半角逗号,隔开</p>
        </FormItem>
        <FormItem v-for="(item, index) in formDynamic.items"
                :key="index"
                :label="'Item ' + item.index"
                :prop="'items.' + index + '.value'">
          <Input v-model="formItem.special.terminal_version" placeholder="请输入" style="width: 300px;"></Input>
          <Input v-model="formItem.special.pic" placeholder="请输入" style="width: 300px;"></Input>
          <Input v-model="formItem.special.h_pic" placeholder="请输入" style="width: 300px;"></Input>
          <Input v-model="formItem.special.develop_cycle" placeholder="请输入" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="">
          <Button type="primary">添加规格项</Button>
          <template>
            <Table border :columns="columns1" :data="formItem.special"></Table>
          </template>
          </FormItem>
        <FormItem label="商品主图" prop="name">
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
            :default-file-list="DefaultList"
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
          <p>*建议图片尺寸 260*170，主图链接到演示</p>
        </FormItem>
        <FormItem label="演示" prop="name">
          <div id="wangeditor" v-model="formItem.data.goods_detail"></div>
        </FormItem>
        <FormItem label="功能描述">
          <Input
            v-model="formItem.data.goods_des"
            type="textarea"
            :autosize="{minRows: 2,maxRows: 5}"
          ></Input>
        </FormItem>
        <FormItem label="推荐商品">
          <RadioGroup v-model="formItem.data.goods_recommend_status">
            <Radio label="1">推荐</Radio>
            <Radio label="0">不推荐</Radio>
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
        click: () => {}
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
        "on-ok": () => {}
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
      UploadHeader: "",
      DefaultList: [],
      // 图片
      UploadAction: "",
      visible: false,
      uploadList: [],
      iconList: [],
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
          key: "name"
        },
        {
          title: "缩略图",
          align: "center",
          key: "img",
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
          title: "商品编号",
          align: "center",
          key: "goods_num"
        },
        {
          title: "商品分类",
          align: "center",
          key: "goods_type"
        },
        {
          title: "终端版本",
          align: "center",
          key: "terminal_version"
        },
        {
          title: "开发周期",
          align: "center",
          key: "develop_cycle"
        },
        {
          title: "价格",
          align: "center",
          key: "price"
        },
        {
          title: "排序",
          align: "center",
          key: "rank"
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
          handle: ["comments", "copy", "edit", "delete"]
        }
      ],
      columns1: [
        {
          title: "终端版本",
          key: "name"
        },
        {
          title: "价格（元）",
          key: "age"
        },
        {
          title: "划线价",
          key: "address"
        },
        {
          title: "开发周期",
          key: "address"
        }
      ],
      tableData: [],
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
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
      formItem: {
        data: {
          goods_images: "",
          goods_number: "",
          category_id: "",
          goods_name: "",
          goods_sort: 0,
          category_id: "",
          seo: "",
          goods_recommend_status: "1",
          goods_detail: "",
          goods_des: "",
          sign: ""
        },
        special: [
          {
            terminal_version: "",
            pic: "",
            develop_cycle: "",
            h_pic: ""
          }
        ]
      },
      ruleValidate: {
        name: [{ required: true, message: "昵称不能为空", trigger: "blur" }]
      }
    };
  },
  created() {
    this.init();
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
              deleteButton(vm, h, currentRowData, param.index),
              addCommentButton(vm, h, currentRowData, param.index),
              copyButton(vm, h, currentRowData, param.index)
            ]);
          };
        }
      });
    },
    cancel() {
      this.formItem = {
        // id: 0,
        data: {
          goods_images: "",
          goods_number: "",
          goods_name: "",
          category_id: "",
          goods_sort: 0,
          category_id: "",
          seo: "",
          goods_recommend_status: "1",
          goods_detail: "",
          goods_des: "",
          sign: ""
        },
        special: {
          terminal_version: "",
          pic: "",
          develop_cycle: "",
          h_pic: ""
        }
      };
      // this.special = {terminal_version:"",pic:"",develop_cycle:"",h_pic:""}
      // 移除图片
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.iconList = [];

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
    alertAdd() {
      let vm = this;
      //图片
      this.$nextTick(() => {
        this.uploadList = this.$refs.upload.fileList;
      });
      // axios.get('Auth/getRuleList').then(function (response) {
      //     let res = response.data;
      //     if (res.code === 1) {
      //         vm.ruleList = res.data.list;
      //     } else {
      //         if (res.code === -14) {
      //             vm.$store.commit('logout', vm);
      //             vm.$router.push({
      //                 name: 'login'
      //             });
      //         } else {
      //             vm.$Message.error(res.msg);
      //         }
      //     }
      // });
      this.modalSetting.show = true;
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
            // if (response.data.code === 1) {
            //   self.$Message.success(response.data.msg);
            //   self.getList();
            //   self.cancel();
            // } else {
            //   self.$Message.error(response.data.msg);
            // }
          });
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
      console.log(this.$refs.upload.fileList.splice(fileList.indexOf(file)));
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
      const check = this.uploadList.length < 5;
      if (!check) {
        this.$Message.error("只能上传一张品牌图");
      }
      return check;
    }
  },
  mounted() {
    let vm = this;
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
      vm.formItem.data.goods_detail = html;
    };
    this.UploadAction = config.front_url + "file/qn_upload";
    this.uploadList = this.$refs.upload.fileList;
    this.editor.create();
  }
};
</script>
