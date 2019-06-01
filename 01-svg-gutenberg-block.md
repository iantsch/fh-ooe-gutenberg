## SVGs im Gutenberg

Das FH OÖ SVG soll in einem Beitrag angezeigt werden können.

### Ziel

* Der User kann den Inhalt/Code eines SVGs eingeben.
* Das SVG wird als SVG Tag ausgegeben.

Folgende Funktionen werden zur Umsetzung benötigt:
* [wp_enqueue_script](https://developer.wordpress.org/reference/functions/wp_enqueue_script/) 
* **Block API** [registerBlockType](https://developer.wordpress.org/block-editor/developers/block-api/block-registration/)
