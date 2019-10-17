const user = {
    mutations: {
        logout () {
            sessionStorage.clear();
            // 恢复默认样式
            let themeLink = document.querySelector('link[name="theme"]');
            themeLink.setAttribute('href', '');
            // 清空打开的页面等数据，但是保存主题数据
            let theme = '';
            if (localStorage.theme) {
                theme = localStorage.theme;
            }
            localStorage.clear();
            if (theme) {
                localStorage.theme = theme;
            }
        },
        login (state, data) {
            sessionStorage.setItem('access', data.access);
            sessionStorage.setItem('user', data.nickname);
            sessionStorage.setItem('headImg', data.headImg);
            sessionStorage.setItem('apiAuth', data.apiAuth);
            sessionStorage.setItem('userInfo', JSON.stringify(data));
        }
    }
};

export default user;
