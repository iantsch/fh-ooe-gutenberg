## SVGs im Gutenberg

Das FH OÖ Logo soll in einem Beitrag angezeigt werden können. Optional als JPG/PNG oder SVG

### Ziel

* Der User kann aus der Mediathek ein Bild (JPG, PNG oder SVG) auswählen.
* Das SVG wird als `<img>` oder `<svg>` Tag ausgegeben.

Folgender **action** Hook wird zur Umsetzung benötigt:
* [render_block](https://developer.wordpress.org/reference/hooks/render_block/)

Folgende WordPress Komponenten werden benötigt:
* [MediaUpload](https://github.com/WordPress/gutenberg/tree/master/packages/block-editor/src/components/media-upload)
* [Button](https://developer.wordpress.org/block-editor/components/button/)