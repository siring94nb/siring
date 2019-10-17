<style lang="less">
    @import '../styles/unlock.less';
</style>

<template>
    <transition name="show-unlock">
        <div class="unlock-body-con" v-if="showUnlock" @keydown.enter="handleUnlock">
            <div @click="handleClickHeadImg" class="unlock-avator-con" :style="{marginLeft: avatorLeft}">
                <img class="unlock-avator-img" :src="headImgPath">
                <div  class="unlock-avator-cover">
                    <span><Icon type="md-unlock" :size="30"></Icon></span>
                    <p>解锁</p>
                </div>
            </div>
            <div class="unlock-avator-under-back" :style="{marginLeft: avatorLeft}"></div>
            <div class="unlock-input-con">
                <div class="unlock-input-overflow-con">
                    <div class="unlock-overflow-body" :style="{right: inputLeft}">
                        <input ref="inputEle" v-model="password" class="unlock-input" type="password" placeholder="密码同登录密码" />
                        <button ref="unlockBtn" @mousedown="unlockMousedown" @mouseup="unlockMouseup" @click="handleUnlock" class="unlock-btn"><Icon color="white" type="md-power"></Icon></button>
                    </div>
                </div>
            </div>
            <div class="unlock-locking-tip-con">已锁定</div>
        </div>
    </transition>
</template>

<script>
import axios from 'axios';
export default {
    name: 'Unlock',
    data () {
        return {
            avatorLeft: '0px',
            inputLeft: '400px',
            check: null
        };
    },
    props: {
        showUnlock: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        headImgPath () {
            return sessionStorage.headImg ? sessionStorage.headImg : require('../../../../images/defaultImg.jpg');
        }
    },
    methods: {
        handleClickHeadImg () {
            this.avatorLeft = '-180px';
            this.inputLeft = '0px';
            this.$refs.inputEle.focus();
        },
        handleUnlock () {
            let vObj = this;
            let userInfo = JSON.parse(sessionStorage.getItem('userInfo'));
            axios.post('Login/index', {
                username: userInfo.username,
                password: vObj.password
            }).then(function (response) {
                if (response.data.code === 1) {
                    vObj.avatorLeft = '0px';
                    vObj.inputLeft = '400px';
                    sessionStorage.setItem('locking', '0');
                    vObj.$emit('on-unlock');
                    vObj.$store.commit('setUserToken', response.data.data.userToken);
                } else {
                    vObj.$Message.error('密码错误,请重新输入。');
                }
            });
        },
        unlockMousedown () {
            this.$refs.unlockBtn.className = 'unlock-btn click-unlock-btn';
        },
        unlockMouseup () {
            this.$refs.unlockBtn.className = 'unlock-btn';
        }
    }
};
</script>
