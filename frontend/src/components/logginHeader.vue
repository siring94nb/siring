<template>
    <div class="box">
        <div>
            <!-- <i class="el-icon-edit"></i>
         <span>控制中心</span>
         <span>&gt;</span>
         <span>控制台</span> -->
         <slot></slot>
        </div>
         
    </div>    
</template>
<script>
export default {
    name:"logginHeader"
}
</script>
<style lang="scss" scoped>
    .box{
        a{
            position: relative;
            z-index: 55;
        }
        margin-left: 20px;
        background: rgb(255, 255, 255);
        div:nth-of-type(1){
            padding: 10px;
            i{ 
                padding-right:15px;
                color: rgb(201,0,0);
            }
        }
    }
</style>