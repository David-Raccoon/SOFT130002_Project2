# SOFT130002_Project2 说明文档

### By 王涵章 18307130214

#

## 项目基本内容完成情况

#

1、实现了文档中要求的所有内容：登录、注册、上传（修改）、收藏、浏览、搜索、查看详情等

2、前端代码位于/frontend，后端代码位于/backend，/travel-image用于存放图片

#

## Bunus完成情况

#

### 1、使用前端框架

本项目的前端使用Vue实现，使用心得如下：

1）Vue的双向绑定非常的便捷易用，几乎免去了所有繁琐的DOM文档的处理。尤其是在处理表单时，双向绑定可以直接、实时地更新页面数据，便于处理（例如注册页面的信息检测验证）

2）Vue的v-for循环语句在分页处理上表现出色，这里也不需要进行复杂的原生DOM语法。对于页面上的多幅图片，以及个数不确定的翻页按钮数量，只需要写出每一个元素的模板并使用v-for来进行循环即可完成。不仅省去了复制粘贴的麻烦，在需要修改时更是只需要修改一处

3）Vue的组件体系增强了代码复用。对于需要重复使用的组件如：导航栏、横幅、页脚，只需要一次编写便可在不同页面直接引入并使用，十分便捷

4）Vue的打包运行便于调试。开发者不需要手动去浏览器刷新便可看到修改后的页面情况

5）Vue的打包部署很方便也非常节省空间

#

### 2、服务器部署（访问地址114.115.151.236:8001）

部署说明：

1）前端

文件目录：/usr/local/nginx/html/whz-web-pj2/dist/

url：http://114.115.151.236:8001

配置文件：前端根目录/src/assets/config.js

步骤：安装nginx -> vue项目打包 npm run build，上传dist文件夹 -> 修改nginx配置文件增加节点 -> 修改前端配置文件 -> 重启nginx

2）后端

文件目录：/var/www/html/whz-web-pj2/backend/

url：http://114.115.151.236:8002/whz-web-pj2/backend/

配置文件：后端根目录/config.php

步骤：安装apache以及mysql扩展 -> 查看配置文件找到根目录 -> 上传文件夹到根目录 -> 修改后端配置文件 -> 重启apache

3）数据库

导入文件：new_travels.sql

配置文件：后端根目录/config.php

步骤：创建travel数据库，导入后更新配置文件mysql用户信息

4）图片存放目录

/var/www/html/whz-web-pj2/travel-images/

url：http://114.115.151.236:8002/whz-web-pj2/travel-images/

步骤：上传图片并更新前端和后端的配置文件，同时修改该目录的权限为777

#

### 意见和建议

#

希望课程安排可以更合理一些，本PJ依赖的所有知识在DDL前一周才全部讲完，实现起来会比较仓促