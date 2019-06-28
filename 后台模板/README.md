# Light Year Admin Using Iframe 光年后台模板的iframe版本

#### 演示网址
[http://lyear.itshubao.com/iframe](http://lyear.itshubao.com/iframe)

[猛戳这里去Light Year Admin项目](https://gitee.com/yinqi/Light-Year-Admin-Template)

#### 交流群
703726776

#### 介绍
![light year admin](https://images.gitee.com/uploads/images/2019/0314/224956_3eb2a29a_82992.png "未命名-1.png")

该项目是光年后台管理模板(Light Year Admin)的ifame版本。

#### 说明
项目在Light Year Admin的基础上整理修改而来，用到了开源项目[Bootstrap-Multitabs](https://gitee.com/edwinhuish/multi-tabs)来实现多标签页，稍微做了一些修改。在这感谢该开源项目的小伙伴。

- 相对于Light Year Admin的项目，去掉了暗黑和半透明的两个主题
- 所有需要的链接加上`class="multitabs"`
- 因为插件做了一些修改，在顶部的下拉菜单(dropdown-menu)中，不要把链接写在href里面，放到data-url里
- 插件用到了HTML5的会话存储，因此在修改了init里的默认地址后，可以再浏览器控制台执行下sessionStorage.clear(); // cache配置为true时

#### 特别感谢
- Bootstrap(去掉了自带的字体图标)
- JQuery
- bootstrap-colorpicker
- bootstrap-datepicker
- bootstrap-datetimepicker
- ion-rangeslider
- jquery-confirm
- jquery-tags-input
- bootstrap-notify
- Chart.js
- chosen.jquery.js
- perfect-scrollbar
- Bootstrap-Multitabs

### 更新记录
2019.06.27
表格插件页面新增treegrid使用示例

2019.06.26
调整tabs高度，替换size()方法
新增右键菜单刷新和关闭功能

2019.05.13
略微调整单选框和复选框的样式
新增表格插件(bootstrap-table)简单示例页面

2019.05.05
修改Bootstrap-Multitabs插件js，新增缓存配置cache，默认为false，如果需要缓存，可以在index.min.js增加配置cache : true

2019.04.24
新增文档示例页面增加多图上传样式（只有样式），调整标签插件样式和js的默认提示
新增步骤条样式和向导插件，修改消息方法（新增自定义消失时间），增加错误页面(404)，增加通知消息页面说明，调整设置页样式

#### 截图
![示例截图一](https://images.gitee.com/uploads/images/2019/0403/213459_1dd52161_82992.png "首页 - 光年(Light Year Admin)后台管理系统模板4.png")
![示例截图二](https://images.gitee.com/uploads/images/2019/0403/213521_8939b9bc_82992.png "首页 - 光年(Light Year Admin)后台管理系统模板3.png")