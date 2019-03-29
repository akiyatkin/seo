# Использование
"seojsontpl":"-seo?path={crumb.query}"
Параметр нужно указывать как можно глубже, чтобы его изменение не парслио слой без надобности.

Для первого слоя достаточно
"seojsontpl":"-seo"

Если вложенной структуры на сайте нет досточно, смотря на каком уровне слой
"seojsontpl":"-seo?path={crumb.name}"
"seojsontpl":"-seo?path={crumb.child.name}"