# Использование ACTIVE_RECORD в шаблонах MACRO
Эта страница была создана в противовес к странице [«Использование ACTIVE_RECORD в шаблонах WACT»](./in_wact_templates.md). Дело в том, что опыт использования WACT-а привел нас к выводу, что не стоит усложнять то, что усложнять не нужно, поэтому:

1) MACRO работает так, что считает все данные массивами. Это отлично вписывается в функциональность пакета ACTIVE_RECORD, так как lmbActiveRecord реализует интерфейс ArrayAccess, а данных из find() методов возвращают итераторы, которые поддерживают интерфейс Iterator. см. также [Как MACRO-шаблон получает данные для вывода?](../../../../macro/docs/ru/macro/data_sources.md).

2) Так как все данные в MACRO — это простые переменные и никаких контекстов нет, необходимости в тегах аналогичных <iterator:transfer> из WACT-а для MACRO нет.

3) Все коллекции, которые можно получить из ACTIVE_RECORD (или при помощи DBAL-пакета), поддерживают chaining, например:

    $data = lmbActiveRecord :: find('Lecture')->sort(array('title' => 'DESC'))->paginate(0, 5);

4) Из-за этого многочисленные прецеденты использования тегов <fetch> стали ненужными и мы пришли к выводу, что их аналогов в MACRO вообще не будет. Поэтому для pull-операций прямо в шаблонах MACRO мы рекомендуем использовать обычные php-вставки.

5) В конце концов мы пришли также к выводу, что и группа классов, которая называется fetcher-ы, для Limb3 — лишний уровень абстракции, который легко заменяется на любое другое решение, которое нравится разработчику. fetcher-ы какое-то время останутся в Limb3 чтобы не нарушать BC для тех, кто пользуется WACT-ом

6) Для лимитирования списков или разбиения данных на постраничные списки в MACRO применяется тег [paginate](../../../../macro/docs/ru/macro/tags/pager_tags/paginate_tag.md).
