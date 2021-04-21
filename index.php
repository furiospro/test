<?php
session_start();
require_once ($_SERVER["DOCUMENT_ROOT"]."/In.php");

$a = In::getInstance($_SERVER["DOCUMENT_ROOT"].'/local/templates/blog/test.csv');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	switch($_POST['pageAjax']){
		case 'check':

			if(isset($_SESSION['date_change']) && $_SESSION['date_change'] == $a->filemt){
				$_SESSION['change'] =false;
			}else{
				$_SESSION['change'] = true;
			}
			echo json_encode($_SESSION['change']);
			return;
	}
}
$a->init();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?><div class="container">

	<div class="inp">
		<button class="btn btn-success" onclick="sendAjax('check');">Проверить</button>
	</div>
		<?php
		$a->render();
		$APPLICATION->IncludeComponent("bitrix:catalog", "template1", ["ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
			"ADD_ELEMENT_CHAIN" => "N",    // Включать название элемента в цепочку навигации
			"ADD_PICT_PROP" => "-",    // Дополнительная картинка основного товара
			"ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
			"ADD_SECTIONS_CHAIN" => "Y",    // Включать раздел в цепочку навигации
			"AJAX_MODE" => "N",    // Включить режим AJAX
			"AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
			"AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
			"AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
			"AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
			"BASKET_URL" => "/personal/basket.php",    // URL, ведущий на страницу с корзиной покупателя
			"BIG_DATA_RCM_TYPE" => "personal",    // Тип рекомендации
			"CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
			"CACHE_GROUPS" => "Y",    // Учитывать права доступа
			"CACHE_TIME" => "36000000",    // Время кеширования (сек.)
			"CACHE_TYPE" => "A",    // Тип кеширования
			"COMMON_ADD_TO_BASKET_ACTION" => "ADD",    // Показывать кнопку добавления в корзину или покупки
			"COMMON_SHOW_CLOSE_POPUP" => "N",    // Показывать кнопку продолжения покупок во всплывающих окнах
			"COMPATIBLE_MODE" => "Y",    // Включить режим совместимости
			"CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
			"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",    // Добавлять детальную картинку в слайдер
			"DETAIL_ADD_TO_BASKET_ACTION" => [    // Показывать кнопки добавления в корзину и покупки на детальной странице товара
				0 => "BUY",], "DETAIL_ADD_TO_BASKET_ACTION_PRIMARY" => [    // Выделять кнопки добавления в корзину и покупки на детальной странице товара
				0 => "BUY",], "DETAIL_BACKGROUND_IMAGE" => "-",    // Установить фоновую картинку для шаблона из свойства
			"DETAIL_BRAND_USE" => "N",    // Использовать компонент "Бренды"
			"DETAIL_BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства
			"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",    // Использовать код группы из переменной, если не задан раздел элемента
			"DETAIL_DETAIL_PICTURE_MODE" => [    // Режим показа детальной картинки
				0 => "POPUP", 1 => "MAGNIFIER",], "DETAIL_DISPLAY_NAME" => "Y",    // Выводить название элемента
			"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",    // Показ описания для анонса на детальной странице
			"DETAIL_IMAGE_RESOLUTION" => "16by9",    // Соотношение сторон изображения товара
			"DETAIL_META_DESCRIPTION" => "DESCRIPTION",    // Установить описание страницы из свойства
			"DETAIL_META_KEYWORDS" => "NAME",    // Установить ключевые слова страницы из свойства
			"DETAIL_PRODUCT_INFO_BLOCK_ORDER" => "sku,props",    // Порядок отображения блоков информации о товаре
			"DETAIL_PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",    // Порядок отображения блоков покупки товара
			"DETAIL_SET_CANONICAL_URL" => "N",    // Устанавливать канонический URL
			"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",    // Включить сохранение информации о просмотре товара на детальной странице для старых шаблонов
			"DETAIL_SHOW_POPULAR" => "Y",    // Показывать блок "Популярное в разделе"
			"DETAIL_SHOW_SLIDER" => "N",    // Показывать слайдер для товаров
			"DETAIL_SHOW_VIEWED" => "Y",    // Показывать блок "Просматривали"
			"DETAIL_STRICT_SECTION_CHECK" => "N",    // Строгая проверка раздела для детального показа элемента
			"DETAIL_USE_COMMENTS" => "N",    // Включить отзывы о товаре
			"DETAIL_USE_VOTE_RATING" => "N",    // Включить рейтинг товара
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",    // Не подключать js-библиотеки в компоненте
			"DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
			"DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
			"ELEMENT_SORT_FIELD" => "sort",    // По какому полю сортируем товары в разделе
			"ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки товаров в разделе
			"ELEMENT_SORT_ORDER" => "asc",    // Порядок сортировки товаров в разделе
			"ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки товаров в разделе
			"FILTER_HIDE_ON_MOBILE" => "N",    // Скрывать умный фильтр на мобильных устройствах
			"FILTER_VIEW_MODE" => "VERTICAL",    // Вид отображения умного фильтра
			"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",    // Текст заголовка "Подарки" в детальном просмотре
			"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",    // Скрыть заголовок "Подарки" в детальном просмотре
			"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",    // Количество элементов в блоке "Подарки" в строке в детальном просмотре
			"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",    // Текст метки "Подарка" в детальном просмотре
			"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",    // Текст заголовка "Товары к подарку"
			"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",    // Скрыть заголовок "Товары к подарку" в детальном просмотре
			"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",    // Количество элементов в блоке "Товары к подарку" в строке в детальном просмотре
			"GIFTS_MESS_BTN_BUY" => "Выбрать",    // Текст кнопки "Выбрать"
			"GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",    // Текст заголовка "Подарки" в списке
			"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",    // Скрыть заголовок "Подарки" в списке
			"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "4",    // Количество элементов в блоке "Подарки" строке в списке
			"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",    // Текст метки "Подарка" в списке
			"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",    // Показывать процент скидки
			"GIFTS_SHOW_IMAGE" => "Y",    // Показывать изображение
			"GIFTS_SHOW_NAME" => "Y",    // Показывать название
			"GIFTS_SHOW_OLD_PRICE" => "Y",    // Показывать старую цену
			"HIDE_NOT_AVAILABLE" => "N",    // Недоступные товары
			"HIDE_NOT_AVAILABLE_OFFERS" => "N",    // Недоступные торговые предложения
			"IBLOCK_ID" => "2",    // Инфоблок
			"IBLOCK_TYPE" => "catalog",    // Тип инфоблока
			"INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
			"INSTANT_RELOAD" => "N",    // Мгновенная фильтрация при включенном AJAX
			"LABEL_PROP" => "",    // Свойство меток товара
			"LAZY_LOAD" => "N",    // Показать кнопку ленивой загрузки Lazy Load
			"LINE_ELEMENT_COUNT" => "3",    // Количество элементов, выводимых в одной строке таблицы
			"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",    // URL на страницу, где будет показан список связанных элементов
			"LINK_IBLOCK_ID" => "",    // ID инфоблока, элементы которого связаны с текущим элементом
			"LINK_IBLOCK_TYPE" => "",    // Тип инфоблока, элементы которого связаны с текущим элементом
			"LINK_PROPERTY_SID" => "",    // Свойство, в котором хранится связь
			"LIST_BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства раздела
			"LIST_ENLARGE_PRODUCT" => "STRICT",    // Выделять товары в списке
			"LIST_META_DESCRIPTION" => "-",    // Установить описание страницы из свойства раздела
			"LIST_META_KEYWORDS" => "-",    // Установить ключевые слова страницы из свойства раздела
			"LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",    // Порядок отображения блоков товара
			"LIST_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",    // Вариант отображения товаров
			"LIST_SHOW_SLIDER" => "Y",    // Показывать слайдер для товаров
			"LIST_SLIDER_INTERVAL" => "3000",    // Интервал смены слайдов, мс
			"LIST_SLIDER_PROGRESS" => "N",    // Показывать полосу прогресса
			"LOAD_ON_SCROLL" => "N",    // Подгружать товары при прокрутке до конца
			"MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
			"MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
			"MESS_BTN_COMPARE" => "Сравнение",    // Текст кнопки "Сравнение"
			"MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
			"MESS_BTN_SUBSCRIBE" => "Подписаться",    // Текст кнопки "Уведомить о поступлении"
			"MESS_COMMENTS_TAB" => "Комментарии",    // Текст вкладки "Комментарии"
			"MESS_DESCRIPTION_TAB" => "Описание",    // Текст вкладки "Описание"
			"MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
			"MESS_PRICE_RANGES_TITLE" => "Цены",    // Название блока c расширенными ценами
			"MESS_PROPERTIES_TAB" => "Характеристики",    // Текст вкладки "Характеристики"
			//"OFFER_TREE_PROPS" =>["ID","PREVIEW_TEXT","DETAIL_TEXT","PROP1","PROP2"],
			//"OFFERS_PROPERTY_CODE" =>["ID","PREVIEW_TEXT","DETAIL_TEXT","PROP1","PROP2"],
			"PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
			"PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
			"PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
			"PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
			"PAGER_TEMPLATE" => ".default",    // Шаблон постраничной навигации
			"PAGER_TITLE" => "Товары",    // Название категорий
			"PAGE_ELEMENT_COUNT" => "30",    // Количество элементов на странице
			"PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
			"PRICE_CODE" => "",    // Тип цены
			"PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
			"PRICE_VAT_SHOW_VALUE" => "N",    // Отображать значение НДС
			"PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
			//"PRODUCT_PROPERTIES" => ["ID","PREVIEW_TEXT","DETAIL_TEXT","PROP1","PROP2"],
			"PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",    // Название переменной, в которой передается количество товара
			"PRODUCT_SUBSCRIPTION" => "Y",    // Разрешить оповещения для отсутствующих товаров
			//"PROPERTY_CODE" => ["ID","PREVIEW_TEXT","DETAIL_TEXT","PROP1","PROP2"],
			"SEARCH_CHECK_DATES" => "Y",    // Искать только в активных по дате документах
			"SEARCH_NO_WORD_LOGIC" => "Y",    // Отключить обработку слов как логических операторов
			"SEARCH_PAGE_RESULT_COUNT" => "50",    // Количество результатов на странице
			"SEARCH_RESTART" => "N",    // Искать без учета морфологии (при отсутствии результата поиска)
			"SEARCH_USE_LANGUAGE_GUESS" => "Y",    // Включить автоопределение раскладки клавиатуры
			"SECTIONS_SHOW_PARENT_NAME" => "Y",    // Показывать название раздела
			"SECTIONS_VIEW_MODE" => "LIST",    // Вид списка подразделов
			"SECTION_ADD_TO_BASKET_ACTION" => "ADD",    // Показывать кнопку добавления в корзину или покупки на странице списка товаров
			"SECTION_BACKGROUND_IMAGE" => "-",    // Установить фоновую картинку для шаблона из свойства
			"SECTION_COUNT_ELEMENTS" => "Y",    // Показывать количество элементов в разделе
			"SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
			"SECTION_TOP_DEPTH" => "2",    // Максимальная отображаемая глубина разделов
			"SEF_MODE" => "N",    // Включить поддержку ЧПУ
			"SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
			"SET_STATUS_404" => "N",    // Устанавливать статус 404
			"SET_TITLE" => "Y",    // Устанавливать заголовок страницы
			"SHOW_404" => "N",    // Показ специальной страницы
			"SHOW_DEACTIVATED" => "N",    // Показывать деактивированные товары
			"SHOW_DISCOUNT_PERCENT" => "N",    // Показывать процент скидки
			"SHOW_MAX_QUANTITY" => "N",    // Показывать остаток товара
			"SHOW_OLD_PRICE" => "N",    // Показывать старую цену
			"SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
			"SHOW_TOP_ELEMENTS" => "Y",    // Выводить топ элементов
			"SIDEBAR_DETAIL_SHOW" => "N",    // Показывать правый блок на детальной странице
			"SIDEBAR_PATH" => "",    // Путь к включаемой области для вывода информации в правом блоке
			"SIDEBAR_SECTION_SHOW" => "Y",    // Показывать правый блок в списке товаров
			"TEMPLATE_THEME" => "blue",    // Цветовая тема
			"TOP_ADD_TO_BASKET_ACTION" => "ADD",    // Показывать кнопку добавления в корзину или покупки на странице с top'ом товаров
			"TOP_ELEMENT_COUNT" => "9",    // Количество выводимых элементов
			"TOP_ELEMENT_SORT_FIELD" => "sort",    // По какому полю сортируем товары в разделе
			"TOP_ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки товаров в разделе
			"TOP_ELEMENT_SORT_ORDER" => "asc",    // Порядок сортировки товаров в разделе
			"TOP_ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки товаров в разделе
			"TOP_LINE_ELEMENT_COUNT" => "3",    // Количество элементов, выводимых в одной строке таблицы
			"TOP_PROPERTY_CODE" => ["ID", "ID", "DETAIL_TEXT", "PREVIEW_TEXT", "PROP1", "PROP2"], "TOP_VIEW_MODE" => "SECTION",    // Показ элементов top'а
			"USER_CONSENT" => "N",    // Запрашивать согласие
			"USER_CONSENT_ID" => "0",    // Соглашение
			"USER_CONSENT_IS_CHECKED" => "Y",    // Галка по умолчанию проставлена
			"USER_CONSENT_IS_LOADED" => "N",    // Загружать текст сразу
			"USE_BIG_DATA" => "Y",    // Показывать персональные рекомендации
			"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",    // Одинаковые настройки показа кнопок добавления в корзину или покупки на всех страницах
			"USE_COMPARE" => "N",    // Разрешить сравнение товаров
			"USE_ELEMENT_COUNTER" => "Y",    // Использовать счетчик просмотров
			"USE_ENHANCED_ECOMMERCE" => "N",    // Включить отправку данных в электронную торговлю
			"USE_FILTER" => "N",    // Показывать фильтр
			"USE_GIFTS_DETAIL" => "Y",    // Показывать блок "Подарки" в детальном просмотре
			"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",    // Показывать блок "Товары к подарку" в детальном просмотре
			"USE_GIFTS_SECTION" => "Y",    // Показывать блок "Подарки" в списке
			"USE_MAIN_ELEMENT_SECTION" => "N",    // Использовать основной раздел для показа элемента
			"USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
			"USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
			"USE_REVIEW" => "N",    // Разрешить отзывы
			"USE_SALE_BESTSELLERS" => "Y",    // Показывать список лидеров продаж
			"USE_STORE" => "N",    // Показывать блок "Количество товара на складе"
			"COMPONENT_TEMPLATE" => ".default", "TOP_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",    // Порядок отображения блоков товара
			"TOP_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",    // Вариант отображения товаров
			"TOP_ENLARGE_PRODUCT" => "STRICT",    // Выделять товары в списке
			"TOP_SHOW_SLIDER" => "Y",    // Показывать слайдер для товаров
			"TOP_SLIDER_INTERVAL" => "3000",    // Интервал смены слайдов, мс
			"TOP_SLIDER_PROGRESS" => "N",    // Показывать полосу прогресса
			"VARIABLE_ALIASES" => ["ELEMENT_ID" => "ELEMENT_ID", "SECTION_ID" => "SECTION_ID",]], false);?><br>

</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>