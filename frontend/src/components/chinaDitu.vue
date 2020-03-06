<template>
  <div>
    <div class="box">
      <div style="background: #ffffff;padding: 10px 20px;margin-left:20px;">
        <div class="title">
          <span style="padding-left:10px;">推广邀请好友分布</span>
        </div>
        <div class="xuanzhe">
          <div>
            <el-date-picker
              v-model="value1"
              type="daterange"
              align="right"
              unlink-panels
              range-separator="至"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
              :picker-options="pickerOptions"
            ></el-date-picker>
          </div>
          <div>按省份对比</div>
        </div>
      </div>
      <div>
        <div id="chart_example"></div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      data: [
        {
          name: "江苏省",
          value: 300
        },
        {
          name: "北京市",
          value: 556
        },
        {
          name: "上海",
          value: 456156
        },
        {
          name: "重庆",
          value: 54
        },
        {
          name: "河北",
          value: 45678
        },
        {
          name: "河南",
          value: 236451
        },
        {
          name: "云南",
          value: 25823
        },
        {
          name: "辽宁",
          value: 300
        },
        {
          name: "黑龙江",
          value: 1413489
        },
        {
          name: "湖南",
          value: 24587
        },
        {
          name: "安徽",
          value: 3178
        },
        {
          name: "山东",
          value: 3178
        },
        {
          name: "新疆",
          value: 3178
        },
        {
          name: "江苏",
          value: 3178
        },
        {
          name: "浙江",
          value: 3178
        },
        {
          name: "江西",
          value: 3178
        },
        {
          name: "湖北",
          value: 3178
        },
        {
          name: "广西",
          value: 3178
        },
        {
          name: "甘肃",
          value: 3178
        },
        {
          name: "山西",
          value: 3178
        },
        {
          name: "内蒙古",
          value: 3178
        },
        {
          name: "陕西",
          value: 3178
        },
        {
          name: "吉林",
          value: 3178
        },
        {
          name: "福建",
          value: 2.8
        },
        {
          name: "贵州",
          value: 1.8
        },
        {
          name: "广东",
          value: 3.7
        },
        {
          name: "青海",
          value: 0.6
        },
        {
          name: "西藏",
          value: 0.4
        },
        {
          name: "四川",
          value: 3.3
        },
        {
          name: "宁夏",
          value: 0.8
        },
        {
          name: "海南",
          value: 1.9
        },
        {
          name: "台湾",
          value: 0.1
        },
        {
          name: "香港",
          value: 0.1
        },
        {
          name: "澳门",
          value: 0.1
        }
      ],
      yData: [],
      barData: [],
      // 时间选择器
      pickerOptions: {
        shortcuts: [
          {
            text: "最近一周",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit("pick", [start, end]);
            }
          },
          {
            text: "最近一个月",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit("pick", [start, end]);
            }
          },
          {
            text: "最近三个月",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit("pick", [start, end]);
            }
          }
        ]
      },
      value1: ""
    };
  },
  mounted() {
    let this_ = this;
    let myChart = this.$echarts.init(document.getElementById("chart_example"));
    for (var i = 0; i < 10; i++) {
      this.barData.push(this.data[i]);
      this.yData.push(i + this.data[i].name);
    }

    var option = {
      title: [
        {
          show: true,
          text: "分布情况",
          textStyle: {
            color: "#2D3E53",
            fontSize: 18
          },
          right: 180,
          top: 100
        }
      ],
      tooltip: {
        show: true,
        formatter: function(params) {
          return params.name + "：" + params.data["value"] + "人";
        }
      },
      // 下方高低指示框
      visualMap: {
        type: "continuous",
        orient: "horizontal",
        itemWidth: 10,
        itemHeight: 80,
        text: ["高", "低"],
        showLabel: true,
        seriesIndex: [0],
        min: 0,
        max: 2,
        inRange: {
          color: ["#6FCF6A", "#FFFD64", "#FF5000"]
        },
        textStyle: {
          color: "#7B93A7"
        },
        bottom: 100,
        left: "left"
      },
      // 柱状图位置
      grid: {
        right: -20,
        top: 135,
        bottom: 100,
        width: "20%"
      },
      // 控制柱状图
      xAxis: {
        show: false
      },

      yAxis: {
        type: "category",
        inverse: true,
        nameGap: 16,
        axisLine: {
          show: false,
          lineStyle: {
            color: "#ddd"
          }
        },
        axisTick: {
          show: false,
          lineStyle: {
            color: "#ddd"
          }
        },
        axisLabel: {
          interval: 0,
          margin: 85,
          textStyle: {
            color: "#455A74",
            align: "left",
            fontSize: 14
          },
          rich: {
            a: {
              color: "#fff",
              backgroundColor: "#FAAA39",
              width: 20,
              height: 20,
              align: "center",
              borderRadius: 2
            },
            b: {
              color: "#fff",
              backgroundColor: "#4197FD",
              width: 20,
              height: 20,
              align: "center",
              borderRadius: 2
            }
          },
          formatter: function(params) {
            if (parseInt(params.slice(0, 1)) < 3) {
              return [
                "{a|" +
                  (parseInt(params.slice(0, 1)) + 1) +
                  "}" +
                  "  " +
                  params.slice(1)
              ].join("\n");
            } else {
              return [
                "{b|" +
                  (parseInt(params.slice(0, 1)) + 1) +
                  "}" +
                  "  " +
                  params.slice(1)
              ].join("\n");
            }
          }
        },
        data: this.yData
      },
      geo: {
        // roam: true,
        map: "china",
        left: "left",
        right: "300",
        // layoutSize: '80%',
        label: {
          emphasis: {
            show: false
          }
        },
        itemStyle: {
          emphasis: {
            areaColor: "#fff464"
          }
        }
      },
      series: [
        {
          name: "mapSer",
          type: "map",
          roam: false,
          geoIndex: 0,
          label: {
            show: false
          },
          data: this.data
        },
        {
          name: "barSer",
          type: "bar",
          roam: false,
          visualMap: false,
          zlevel: 2,
          barMaxWidth: 8,
          barGap: 0,
          itemStyle: {
            normal: {
              color: function(params) {
                // build a color map as your need.
                var colorList = [
                  {
                    colorStops: [
                      {
                        offset: 0,
                        color: "#FFD119" // 0% 处的颜色
                      },
                      {
                        offset: 1,
                        color: "#FFAC4C" // 100% 处的颜色
                      }
                    ]
                  },
                  {
                    colorStops: [
                      {
                        offset: 0,
                        color: "#00C0FA" // 0% 处的颜色
                      },
                      {
                        offset: 1,
                        color: "#2F95FA" // 100% 处的颜色
                      }
                    ]
                  }
                ];
                if (params.dataIndex < 3) {
                  return colorList[0];
                } else {
                  return colorList[1];
                }
              },
              barBorderRadius: 15
            }
          },
          data: this.barData
        }
      ]
    };
    myChart.setOption(option);
    // window.addEventListener("resize", function() {
    //   myChart.resize();
    // });
  }
};
</script>
<style lang="scss" scoped>
.box {
  .xuanzhe {
    background: rgb(242, 247, 250);
    padding: 5px 15px;
    margin: 20px 0;
    font-size: 13px;
    color: #333333;
    display: flex;
    justify-content: space-between;
    align-items: center;
    >div{
      &:nth-of-type(2){
        background: rgb(0,153,255);
        color: #ffffff;
        padding: 5px 10px;
        height: 15px;
        border-radius: 5px;
      }
    }
  }
}
.title {
  border-left: 4px solid rgb(0, 149, 138);
  background: #ffffff;
  padding: 5px 0;
  font-weight: 700;
}
#chart_example {
  margin-left: 20px;
  width: 65%;
  height: 630px;
  // border: 1px solid red;
  // margin: 0 auto;
  display: flex;
  justify-content: center;
  background: #ffffff;
  padding: 0 16.8%;
}
</style>