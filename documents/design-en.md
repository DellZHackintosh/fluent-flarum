# Design Guide (Experimental)

The Fluent theme standardizes the appearance of custom elements quickly when customizing CSS/Less design through a series of importable components. This theme also extends some usable Less variables for further design.

### Before You Start

Before you start, it is recommended to read the following documents to understand the design essentials of Fluent.

- [Windows 11 Signature Experience](https://learn.microsoft.com/en-us/windows/apps/design/signature-experiences/signature-experiences)

- All content under the Design language column of [Fluent 2 Design System](https://fluent2.microsoft.design/)

### Available Components

***Each component uses some key CSS to determine the appearance. Please make sure they are not overridden when customizing.***

#### Fluent Button

Make the element have a button appearance. Please make sure the element has the function of a button.

##### Usage

```less
.example-button {
    .fluent-button(true or false);
}
```

If the specified parameter is `true`, the button has the appearance of a theme color button. Specify `false` without theme color.

**Please note:** If you want to use the theme color button appearance, you must make sure that the color of the button has been set. This component will not set the color of the button. You need to set the following variables:

```less
// Content is for example only
--button-bg: var(--button-primary-bg);
--button-bg-hover: var(--button-primary-bg-hover);
--button-bg-active: var(--button-primary-bg-active);
--button-bg-disabled: var(--button-primary-bg-disabled);
```

##### Key CSS

`background`, `border`, `border-radius` and `border-color`.

#### Fluent Layer

Make the component a layer to produce stratification.

##### Usage

```less
.example-layer {
    .fluent-layer();
}
```

##### Key CSS

`background-color`, `box-shadow` and `border-radius`.

#### Fluent Menu

Make the element a context menu.

##### Usage

```less
.example-menu {
    .fluent-menu();
}
```

**Please note:** It needs to be used with Fluent menu objects and specify the background.

##### Key CSS

`box-shadow` and `border-radius`.

#### Fluent Menu Item

Make the element a clickable item of a context menu (often a button).

##### Usage

```less
.example-menu {
    .fluent-menu();
    & > .example-menu-item {
        .fluent-menu-item();
    }
}
```

**Please note:** It needs to be used with Fluent menu and specify the text color.

##### Key CSS

`margin`, `background` and `border-radius`.

#### Fluent Acrylic Material

Provide Acrylic material for the element.

##### Usage

```less
.example-div {
    .fluent-acrylic();
}
```

**Please note:** The material cannot be applied at present, and only provides fallback colors when not available. This component may be changed or deleted in the future, depending on whether this feature can be implemented.

##### Key CSS

`background-color`, `background-image` and `background-attachment`.

#### Fluent Card

Make the element a card.

##### Usage

```less
.example-card {
    .fluent-card();
}
```

### Available Variables

**Note:** Less variables not listed here can also be used, but they are not standardized and may become unavailable at any time.

#### Shadow Elevation

Add shadows to elements to visually increase height. Support for elevation to the following heights:

```
2, 4, 8, 16 (using low elevation shadows)
28, 64 (using high elevation shadows)
```

If you have read the Microsoft design documents and have determined the appropriate elevation height, the next thing to do is to import the corresponding shadows.

##### Low Elevation Shadows

```less
.example-low-shadow {
    .shadowN(); // "N" represents the height value you need to elevate
    box-shadow: @low-elevation-ramp;
}
```

##### High Elevation Shadows

```less
.example-high-shadow {
    .shadowN(); // "N" represents the height value you need to elevate
    box-shadow: @high-elevation-ramp;
}
```

#### Border

Add borders to elements to enhance boundary distinction. You need to determine what the element belongs to.

##### Normal Type

```less
.example-normal {
    box-shadow: @shadow-outline-normal;
}
```

##### Modal Window Type

```less
.example-modal-window{
    box-shadow: @shadow-outline-window;
}
```

**Note:** Please be flexible. For example, the post editing window and the bottom border of titlebar both use the border of the modal window type.

#### Layer/Card Background

**Tip:** It is strongly recommended to use Fluent Layer and Fluent Card (see above).

Layer: `@LayerFillColorDefault`

Card: `@CardBackgroundFillColorDefault`

#### PureMica and PureMicaAlt

Use these variables to color the background of elements.

PureMica: `@body-bg`

PureMicaAlt:

```less
// Content is for example only
// PureMicaAlt is not available when the flarum is colored titlebar.
// Therefore, availability testing must be done.
.example-usage {
    & when (@config-colored-header = false) {
        background-color: @titlebar-bg;
    }
    & when (@config-colored-header = true) {
        // When not available, something else needs to replace it.
        background-color: #202020;
    }
}
```
