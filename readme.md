# Project1 实验报告

###### 17300290033 高祥兴

##### 仓库地址：https://github.com/CharlesGao04/Web_PJ1/tree/master

##### 主页地址：https://charlesgao04.github.io/Web_PJ1/



## 具体内容

#### 1.主页：Home

导航栏有条目，点击可跳转，鼠标移动到下拉菜单，通过cursor实现移动到导航栏上会变小手，通当前页面条目背景高亮，MyAccount实现下拉菜单，菜单条目可跳转至对应页面，鼠标移动至条目上背景高亮，图标使用Font Awesome中的矢量图标

整体风格简约，多用纯黑背景+白字，图片展示区域框起来6张，布局合理，内容齐全，并且点击可以跳转到详情页，页脚内容完整，刷新和返回图标通过position:fixed和z-index固定在页面右下角上层，刷新用alert响应，并且和返回都用href=‘#’来刷新界面

#### 2.浏览：Browse

搜索栏能输入文字，点击search会有alert响应，左侧有三种热门内容，点击同样有alert响应，筛选栏完整，通过js实现二级联动，图片布局4*4，通过设置width和height实现合理布局，点击图片可跳转到详情页

#### 3.搜索：Search

搜索按钮可选择，点击filter有alert响应，搜索结果整体排版合理，左边图片，右边Title和Details，通过-webkit-box和ellipsis实现多行溢出显示省略号，点击图片，可跳转到详情页

#### 4.上传：Upload

通过file类型实现上传，通过js实现具体的图片上传显示，并且实现在上传前显示文字，上传后文字隐去，标题、描述、国家、城市均可输入，提交有响应并进入我的照片页面

#### 5.我的照片：Myphoto和我的收藏：Myfavor

与搜索页图片展示类似，新增modify和delete按钮，点击有alert响应

#### 6.详情：Photodetails

图片、图片标题、拍摄者、图片描述、 主题、拍摄国家、拍摄城市均完整展示，并且排版合理，显示Like Number，点击Collect按钮有alert响应

#### 7.登录：index和注册：register

界面风格简约，登录表单可填用户名、密码，注册表单可填用户名、邮箱、密码、确认密码，通过password类型实现不显示明文，登录下方有注册引导信息，并可以跳转到注册表单



### Bonus

1.全部使用自由板式排版图片，全部通过适当的weight和height将设置图片大小并且合理排布

2.关于响应式布局，在每个页面head中添加以下代码部分实现

```
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no" />
```

3.界面美观，整体风格一致，简约风偏暗色调，页面各元素间间隔合理，无乱码无布局不合理情况