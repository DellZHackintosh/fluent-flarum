# 设计指南（实验性功能）

Fluent 主题通过通过一系列可导入的组件，来方便进行自定义 CSS/Less 设计时快速地标准化自定义元素的外观。此主题还公开一些可使用的 Less 变量以便进行进一步的设计。

### 在开始之前

在开始前，建议阅读以下文档，以便了解 Fluent 的设计要领。

- [Windows 11 签名体验](https://learn.microsoft.com/zh-cn/windows/apps/design/signature-experiences/signature-experiences)

- [Fluent 2 Design System](https://fluent2.microsoft.design/) 的 Design language 栏目下的所有内容

### 可用的组件

***每一个组件都使用一些关键 CSS 来确定外观。进行自定义时请确保没有覆盖它们。***

#### Fluent 按钮

使元素具有按钮外观。请确保元素具有按钮的作用。

##### 用法

```less
.example-button {
    .fluent-button(true or false);
}
```

若指定的参数为`true`，则按钮具有主题色按钮的外观。指定`false`则不带主题色。

**请注意：** 若您要使用主题色按钮外观，则必须确保已设定按钮的颜色。此组件不会设定按钮的颜色。您需要设置以下变量：

```less
// 内容仅为示例
--button-bg: var(--button-primary-bg);
--button-bg-hover: var(--button-primary-bg-hover);
--button-bg-active: var(--button-primary-bg-active);
--button-bg-disabled: var(--button-primary-bg-disabled);
```

##### 关键 CSS

`background`、`border`、`border-radius`和`border-color`。

#### Fluent 层

使元素成为一个层以产生分层。

##### 用法

```less
.example-layer {
    .fluent-layer();
}
```

##### 关键 CSS

`background-color`、`box-shadow`和`border-radius`。

#### Fluent 菜单

使元素成为一个上下文菜单。

##### 用法

```less
.example-menu {
    .fluent-menu();
}
```

**请注意：** 需搭配 Fluent 菜单对象使用并指定背景。

##### 关键 CSS

`box-shadow`和`border-radius`。

#### Fluent 菜单对象

使元素成为一个上下文菜单的可点击对象（往往是按钮）。

##### 用法

```less
.example-menu {
    .fluent-menu();
    & > .example-menu-item {
        .fluent-menu-item();
    }
}
```

**请注意：** 需搭配 Fluent 菜单使用并指定文本颜色。

##### 关键 CSS

`margin`、`background`和`border-radius`。

#### Fluent Acrylic 材料

为元素提供 Acrylic 材料。

##### 用法

```less
.example-div {
    .fluent-acrylic();
}
```

**请注意：** 目前尚不能应用材料，仅提供不可用时回退的颜色。未来此组件可能会更改或删除，取决于此功能是否可以实现。

##### 关键 CSS

`background-color`、`background-image`和`background-attachment`。

#### Fluent 卡片

使元素成为一个卡片。

##### 用法

```less
.example-card {
    .fluent-card();
}
```

##### 关键 CSS

`background-color`、`box-shadow`和`border-radius`。

### 可用的变量

**注意：** 未在此处列出的 Less 变量也可使用，但未经标准化且随时可能不可用。

#### 阴影提升

为元素添加阴影以在视觉上增加高度。支持提升至以下高度：

```
2, 4, 8, 16（使用低提升阴影）
28, 64（使用高提升阴影）
```

如果您已阅读 Microsoft 设计文档且已经确定了合适的提升高度，接下来需要做的是导入对应的阴影。

##### 低提升阴影

```less
.example-low-shadow {
    .shadowN(); //“N”代表你需要提升的高度值
    box-shadow: @low-elevation-ramp;
}
```

##### 高提升阴影

```less
.example-high-shadow {
    .shadowN(); //“N”代表你需要提升的高度值
    box-shadow: @high-elevation-ramp;
}
```

#### 边框

为元素添加边框以提高边界区分度。你需要确定元素属于什么。

##### 普通类型

```less
.example-normal {
    box-shadow: @shadow-outline-normal;
}
```

##### 模态窗口类型

```less
.example-modal-window{
    box-shadow: @shadow-outline-window;
}
```

**注意：** 请灵活变通。例如，帖子编辑窗口及标题栏底边框都使用了模态窗口类型的边框。

#### 层/卡片背景

**提示：** 强烈建议使用 Fluent 层和 Fluent 卡片（见上文）。

层：`@LayerFillColorDefault`

卡片：`@CardBackgroundFillColorDefault`

#### PureMica 和 PureMicaAlt

使用这些变量可为元素进行背景着色。

PureMica：`@body-bg`

PureMicaAlt：

```less
// 内容仅为示例
// PureMicaAlt 在彩色标题栏打开时不可用。
// 因此必须进行可用性检测。
.example-usage {
    & when (@config-colored-header = false) {
        background-color: @titlebar-bg;
    }
    & when (@config-colored-header = true) {
        // 不可用时，需要其它东西来取代。
        background-color: #202020;
    }
}
```
