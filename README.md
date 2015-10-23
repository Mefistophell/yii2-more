# yii2-more Widget

**Описание:**

Добавляет кнопку "Показать еще"

работает вместо постраничной навигации с GridView, ListView и прочими виджетами.

Инструкция
----------

Добавьте виджет в файл представления:

`use mefistophell\widgets\More;`

GridView/ListView следует пометсить внутрь контенера с атрибутом **rel="#more"**.

Непосредственно перед GridView/ListView нужно вывести старт виджета 

`<?= More::$start; ?>`. 

А сразу после - метод вызввающий виджет, и передать ему текущий номер старницы:

`<?= More::widget(Yii::$app->request->get('page')); ?>`

Восле вызова метода и непосредственго перед закрывающим тегом контейнера нужно поместить: 

`<?= More::$end; ?>`

Пример
------

```
<div class="left main_content" rel="#more">
  <span class="box_title"><?= yii::t('ru', 'Events') ?></span>
  <?= More::$start; ?>
  <?= GridView::widget([
  ...
  ]);
  <?= More::widget(Yii::$app->request->get('page')); ?>
  <?= More::$end; ?>
</div>
```
