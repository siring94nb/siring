let util = {};

util.title = function (title) {
    title = title || 'ApiAdmin';
    window.document.title = title;
};

util.inOf = function (arr, targetArr) {
    let res = true;
    arr.forEach(item => {
        if (targetArr.indexOf(item) < 0) {
            res = false;
        }
    });
    return res;
};

/**
 * 判断数组中是否包含某个元素（in_array）
 * @param ele
 * @param targetArr
 * @returns {boolean}
 */
util.oneOf = function (ele, targetArr) {
    if (targetArr.indexOf(ele) >= 0) {
        return true;
    } else {
        return false;
    }
};

util.showThisRoute = function (currentAccess, itAccess) {
    if (typeof itAccess === 'object' && Array.isArray(itAccess)) {
        return util.oneOf(currentAccess, itAccess);
    } else {
        return itAccess === currentAccess;
    }
};

util.getRouterObjByName = function (routers, name) {
    if (!name || !routers || !routers.length) {
        return null;
    }
    // debugger;
    let routerObj = null;
    for (let item of routers) {
        if (item.name === name) {
            return item;
        }
        routerObj = util.getRouterObjByName(item.children, name);
        if (routerObj) {
            return routerObj;
        }
    }
    return null;
};

util.handleTitle = function (vm, item) {
    if (typeof item.title === 'object') {
        return vm.$t(item.title.i18n);
    } else {
        return item.title;
    }
};

util.setCurrentPath = function (vm, name) {
    let title = '';
    let isOtherRouter = false;
    vm.$store.state.app.routers.forEach(item => {
        if (item.children.length === 1) {
            if (item.children[0].name === name) {
                title = util.handleTitle(vm, item);
                if (item.name === 'otherRouter') {
                    isOtherRouter = true;
                }
            }
        } else {
            item.children.forEach(child => {
                if (child.name === name) {
                    title = util.handleTitle(vm, child);
                    if (item.name === 'otherRouter') {
                        isOtherRouter = true;
                    }
                }
            });
        }
    });
    let currentPathArr = [];
    //去首页
    if (name === 'home_index') {
        currentPathArr = [
            {
                title: util.handleTitle(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'home_index')),
                path: '',
                name: 'home_index'
            }
        ];
    }
    //去导航菜单一级页面或者OtherRouter路由中的页面
    else if ((name.indexOf('_index') >= 0 || isOtherRouter) && name !== 'home_index') {
        currentPathArr = [
            {
                title: util.handleTitle(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'home_index')),
                path: '/home',
                name: 'home_index'
            },
            {
                title: title,
                path: '',
                name: name
            }
        ];
    }
    //去导航菜单二级页面或三级页面
    else {
        let currentPathObj = vm.$store.state.app.routers.filter(item => {

            var hasMenu;
            if (item.children.length <= 1) {
                hasMenu = item.children[0].name === name;
                return hasMenu;
            } else {
                let i = 0;
                let childArr = item.children;
                let len = childArr.length;
                while (i < len) {
                    //如果是三级页面按钮，则在二级按钮数组中找不到这个按钮名称
                    //需要二级页面下可能出现三级子菜单的情况逻辑加入
                    if (childArr[i].name === name) {
                        hasMenu = true;
                        return hasMenu;
                    }
                    i++;
                }
                //如果一级，二级菜单下都没有此按钮名称，则遍历三级菜单
                if (!hasMenu) {
                    for (let m = 0; m < childArr.length; m++) {
                        if (!childArr[m].children) continue;
                        let sonArr = childArr[m].children;
                        for (let n = 0; n < sonArr.length; n++) {
                            if (sonArr[n].name === name) {
                                hasMenu = true;
                                return hasMenu;
                            }
                        }
                    }
                }
                return false;
            }
        })[0];

        if (currentPathObj.children.length <= 1 && currentPathObj.name === 'home') {
            currentPathArr = [
                {
                    title: '首页',
                    path: '',
                    name: 'home_index'
                }
            ];
        } else if (currentPathObj.children.length <= 1 && currentPathObj.name !== 'home') {
            currentPathArr = [
                {
                    title: '首页',
                    path: '/home',
                    name: 'home_index'
                },
                {
                    title: currentPathObj.title,
                    path: '',
                    name: name
                }
            ];
        } else {
            //如果是三级页面按钮，则在二级按钮数组中找不到这个按钮名称
            //需要二级页面下可能出现三级子菜单的情况逻辑加入
            let childObj = currentPathObj.children.filter((child) => {
                return child.name === name;
            })[0];

            // let thirdLevelObj =
            // console.log(childObj)
            //二级页面
            if (childObj) {
                currentPathArr = [
                    {
                        title: '首页',
                        path: '/home',
                        name: 'home_index'
                    },
                    {
                        title: currentPathObj.title,
                        path: '',
                        name: currentPathObj.name
                    },
                    {
                        title: childObj.title,
                        path: currentPathObj.path + '/' + childObj.path,
                        name: name
                    }
                ];
            }
            //childobj为undefined，再从三级页面中遍历
            else {
                let thirdObj;
                let childObj = currentPathObj.children.filter((child) => {
                    let hasChildren;
                    hasChildren = child.name === name;
                    if (hasChildren) return hasChildren

                    if (child.children) {
                        let sonArr = child.children;
                        for (let n = 0; n < sonArr.length; n++) {
                            if (sonArr[n].name === name) {
                                thirdObj = sonArr[n];
                                hasChildren = true;
                                return hasChildren;
                            }
                        }
                    }
                    return hasChildren
                })[0];

                if (thirdObj && childObj) {
                    currentPathArr = [
                        {
                            title: '首页',
                            path: '/home',
                            name: 'home_index'
                        },
                        {
                            title: currentPathObj.title,
                            path: '',
                            name: currentPathObj.name
                        },
                        {
                            title: childObj.title,
                            path: '',    //设为空是因为此二级菜单没有实际页面且用于面包屑组件显示，path为空的将不可单击
                            name: childObj.name
                        },
                        {
                            title: thirdObj.title,
                            path: currentPathObj.path + '/' + childObj.path + '/' + thirdObj.path,
                            name: thirdObj.name
                        }
                    ];
                }

            }

        }
    }

    vm.$store.commit('setCurrentPath', currentPathArr);
    return currentPathArr;
};
// function (vm, name) {
//     let title = '';
//     let isOtherRouter = false;
//     vm.$store.state.app.routers.forEach(item => {
//         if (item.children.length === 1) {
//             if (item.children[0].name === name) {
//                 title = util.handleTitle(vm, item);
//                 if (item.name === 'otherRouter') {
//                     isOtherRouter = true;
//                 }
//             }
//         } else {
//             item.children.forEach(child => {
//                 if (child.name === name) {
//                     title = util.handleTitle(vm, child);
//                     if (item.name === 'otherRouter') {
//                         isOtherRouter = true;
//                     }
//                 }
//             });
//         }
//     });
//     let currentPathArr = [];
//     if (name === 'home_index') {
//         currentPathArr = [
//             {
//                 title: util.handleTitle(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'home_index')),
//                 path: '',
//                 name: 'home_index'
//             }
//         ];
//     } else if ((name.indexOf('_index') >= 0 || isOtherRouter) && name !== 'home_index') {
//         currentPathArr = [
//             {
//                 title: util.handleTitle(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'home_index')),
//                 path: '/home',
//                 name: 'home_index'
//             },
//             {
//                 title: title,
//                 path: '',
//                 name: name
//             }
//         ];
//     } else {
//         let currentPathObj = vm.$store.state.app.routers.filter(item => {
//             if (item.children.length <= 1) {
//                 return item.children[0].name === name;
//             } else {
//                 let i = 0;
//                 let childArr = item.children;
//                 let len = childArr.length;
//                 while (i < len) {
//                     if (childArr[i].name === name) {
//                         return true;
//                     }
//                     i++;
//                 }
//                 return false;
//             }
//         })[0];
//         if (currentPathObj.children.length <= 1 && currentPathObj.name === 'home') {
//             currentPathArr = [
//                 {
//                     title: '首页',
//                     path: '',
//                     name: 'home_index'
//                 }
//             ];
//         } else if (currentPathObj.children.length <= 1 && currentPathObj.name !== 'home') {
//             currentPathArr = [
//                 {
//                     title: '首页',
//                     path: '/home',
//                     name: 'home_index'
//                 },
//                 {
//                     title: currentPathObj.title,
//                     path: '',
//                     name: name
//                 }
//             ];
//         } else {
//             let childObj = currentPathObj.children.filter((child) => {
//                 return child.name === name;
//             })[0];
//             currentPathArr = [
//                 {
//                     title: '首页',
//                     path: '/home',
//                     name: 'home_index'
//                 },
//                 {
//                     title: currentPathObj.title,
//                     path: '',
//                     name: currentPathObj.name
//                 },
//                 {
//                     title: childObj.title,
//                     path: currentPathObj.path + '/' + childObj.path,
//                     name: name
//                 }
//             ];
//         }
//     }
//     vm.$store.commit('setCurrentPath', currentPathArr);

//     return currentPathArr;
// };

util.openNewPage = function (vm, name, argu, query) {
    let pageOpenedList = vm.$store.state.app.pageOpenedList;
    let openedPageLen = pageOpenedList.length;
    let i = 0;
    let tagHasOpened = false;
    while (i < openedPageLen) {
        if (name === pageOpenedList[i].name) { // 页面已经打开
            vm.$store.commit('pageOpenedList', {
                index: i,
                argu: argu,
                query: query
            });
            tagHasOpened = true;
            break;
        }
        i++;
    }
    if (!tagHasOpened) {
        let tag = vm.$store.state.app.tagsList.filter((item) => {
            if (item.children) {
                return name === item.children[0].name;
            } else {
                return name === item.name;
            }
        });
        tag = tag[0];
        if (tag) {
            tag = tag.children ? tag.children[0] : tag;
            if (argu) {
                tag.argu = argu;
            }
            if (query) {
                tag.query = query;
            }
            vm.$store.commit('increateTag', tag);
        }
    }
    vm.$store.commit('setCurrentPageName', name);
};

util.toDefaultPage = function (routers, name, route, next) {
    let len = routers.length;
    let i = 0;
    let notHandle = true;
    while (i < len) {
        if (routers[i].name === name && routers[i].children && routers[i].redirect === undefined) {
            route.replace({
                name: routers[i].children[0].name
            });
            notHandle = false;
            next();
            break;
        }
        i++;
    }
    if (notHandle) {
        next();
    }
};

util.fullscreenEvent = function (vm) {
    vm.$store.commit('initCachePage');
    // 权限菜单过滤相关
    vm.$store.commit('updateMenuList');
    // 全屏相关
};

/**
 * 格式化时间戳
 * @param date
 * @param fmt
 * @returns {*}
 */
util.formatDate = function (date, fmt) {
    date = parseInt(date) * 1000;
    if (!fmt) {
        fmt = 'yyyy-MM-dd hh:mm:ss';
    }
    date = new Date(date);
    if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length));
    }
    let o = {
        'M+': date.getMonth() + 1,
        'd+': date.getDate(),
        'h+': date.getHours(),
        'm+': date.getMinutes(),
        's+': date.getSeconds()
    };
    for (let k in o) {
        if (new RegExp(`(${k})`).test(fmt)) {
            let str = o[k] + '';
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? str : ('00' + str).substr(str.length));
        }
    }
    return fmt;
};

export default util;
