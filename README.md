# Wwwision.Neos.ModuleComponents

Flow package with utilities and components to create Fusion based backend modules with the common [Neos](https://neos.io) look and feel

## Badge

A simple badge aka label, potentially with custom error level

<details open>

<summary>

### Example
</summary>

<a href="Docs/badge.png" target="_blank"><img align="right" hspace="10" alt="Badge" src="Docs/badge.png" width="20%"/></a>

```xml
<NeosBE:Badge>Default</NeosBE:Badge>
<NeosBE:Badge errorLevel="1">Error level 1 (success)</NeosBE:Badge>
<NeosBE:Badge errorLevel="2">Error level 2 (warning)</NeosBE:Badge>
<NeosBE:Badge errorLevel="3">Error level 3 (error)</NeosBE:Badge>
```

## Button

A button that can be used as

* Link to actions of the current module
* Link to other modules
* Trigger to show a modal
* Submit button for forms

<details open>

<summary>

### Example
</summary>
<a href="Docs/button.png" target="_blank"><img align="right" hspace="10" alt="Button" src="Docs/button.png" width="20%" /></a>

```xml
<NeosBE:Button>Default Button</NeosBE:Button>
<NeosBE:Button isPrimary={true}>Button (primary)</NeosBE:Button>
<NeosBE:Button isDangerous={true}>Button (dangerous)</NeosBE:Button>
<NeosBE:Button icon="arrow-left">Button with icon</NeosBE:Button>
<NeosBE:Button icon="save" isPrimary={true}>Primary button with icon</NeosBE:Button>
<NeosBE:Button icon="trash" isDangerous={true}>Dangerous button with icon</NeosBE:Button>
```

## FlashMessage

Renders and removes flash messages as unordered list

**Note:** This component is used by `NeosBE:Module` and usually does not have to be added manually

<details open>

<summary>

### Example
</summary>

<a href="Docs/flashmessages.png" target="_blank"><img align="right" hspace="10" alt="FlashMessages" src="Docs/flashmessages.png" width="20%"/></a>

```xml
<NeosBE:FlashMessages attributes.id="neos-notifications-inline" @children="content.itemRenderer">
    <li data-type={String.toLowerCase(flashMessage.severity)}>{flashMessage}</li>
</NeosBE:FlashMessages>
```

## Icon

Renders and removes flash messages as unordered list

**Note:** This component is used by `NeosBE:Module` and usually does not have to be added manually

<details open>

<summary>

### Example
</summary>

<a href="Docs/icon.png" target="_blank"><img align="right" hspace="10" alt="Icon" src="Docs/icon.png" width="20%"/></a>

```xml
<NeosBE:Icon icon="check-circle"/>
```

## Modal

Modal dialog that is hidden by default and can be shown via the `Button` component

**Note:** To display a form within a modal, use the [ModalForm](#modal-form) component

<details open>

<summary>

### Example
</summary>

<a href="Docs/modal.png" target="_blank"><img align="right" hspace="10" alt="Modal" src="Docs/modal.png" width="20%"/></a>

```xml
<NeosBE:Modal id="some-modal">
    <NeosBE:Modal.Header header="Some modal header">
        Some modal content
    </NeosBE:Modal.Header>
    <NeosBE:Modal.Footer cancelButtonText="Some cancel text"/>
</NeosBE:Modal>
// ...
<NeosBE:Button modal="some-modal">Show modal</NeosBE:Button>
```

## ModalForm

Modal dialog that is hidden by default and can be shown via the `Button` component

**Note:** To display a form within a modal, use the [ModalForm](ModalForm) component

<details open>

<summary>

### Example
</summary>

<a href="Docs/modalform.png" target="_blank"><img align="right" hspace="10" alt="ModalForm" src="Docs/modalform.png" width="20%"/></a>

```xml
<NeosBE:ModalForm id="some-form-modal" header="Some modal header" cancelButtonText="Cancel" submitButtonIcon="trash" submitButtonText="Delete record" isDangerous={true} form.target.action="delete" form.target.arguments={{id: someRecord.id}}>
    Are you sure you want to delete record "{someRecord.title}"?<br/>
    <br/>
    <Neos.Fusion.Form:Neos.BackendModule.FieldContainer field.name="form[comment]" label="Comment (optional):">
        <Neos.Fusion.Form:Textarea attributes.class="neos-span12" attributes.style="height: 5em; resize: vertical"/>
    </Neos.Fusion.Form:Neos.BackendModule.FieldContainer>
</NeosBE:ModalForm>
// ...
<NeosBE:Button modal="some-form-modal">Show modal</NeosBE:Button>
```

## Module

## ModuleLink

A link pointing to a different Neos Backend Module

<details open>

<summary>

### Example
</summary>

```xml
<NeosBE:ModuleLink module="administration/users" action="new">Add new user</NeosBE:ModuleLink>
<NeosBE:ModuleLink module="management/media" arguments.view="list" arguments.orderBy="Name" arguments.filter="Document">List documents</NeosBE:ModuleLink>
```

## Pagination

Page navigation usually combined with a `NeosBE:Table` component

<details open>

<summary>

### Example
</summary>:

```xml
<NeosBE:Pagination numberOrResults={records.count} />
```

## RelativeTime

A DateTime value that is rendered as relative time using `Intl.RelativeTimeFormat()` on the client side
See https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/RelativeTimeFormat

<details open>

<summary>

### Example
</summary>:

```
<NeosBE:RelativeTime dateTime={someDateTime} />
<NeosBE:RelativeTime dateTime={someDateTime} formatFallback="Y-m-d H:i" />
<NeosBE:RelativeTime dateTime={someDateTime} options.numeric="always" options.style="narrow" />
```

## Table

<details open>

<summary>

### Example
</summary>

## ToggleButton

<details open>

<summary>

### Example
</summary>

## Translate

<details open>

<summary>

### Example
</summary>
