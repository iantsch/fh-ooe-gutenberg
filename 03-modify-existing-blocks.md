## SVGs im Gutenberg

Das FH OÖ Logo soll in bestehenden Blöcken `core/image` und `core/media-text` angezeigt werden können. 
Optional als JPG/PNG oder SVG

### Ziel

* Der User kann aus der Mediathek ein Bild (JPG, PNG oder SVG) auswählen.
* Das SVG wird als `<img>` oder `<svg>` Tag ausgegeben.

Folgende individuelle **filter** Hooks müssen erstellt und umgesetzt werden:
* `Svg/<author>/<block>/attachmentId` gibt den Block spezifischen Attributnamen für die `attachmentId` zurück.
* `SvgControls.<author>.<block>.urlAttribute` gibt Block spezifischen Attributnamen für die `attachmentUrl` zurück.

Folgender **filter** Hook wird zur Umsetzung benötigt:
* [blocks.registerBlockType](https://developer.wordpress.org/block-editor/developers/filters/block-filters/#blocks-registerblocktype) erlaubt die Attribute der Blöcke zu erweitern
* [editor.BlockEdit](https://developer.wordpress.org/block-editor/developers/filters/block-filters/#editor-blockedit) Tauscht die BlockEdit Componente mit beliebiger HOC aus

Folgende WordPress Komponenten werden benötigt:
* [ToggleControl](https://developer.wordpress.org/block-editor/components/toggle-control/)
* [PanelBody](https://developer.wordpress.org/block-editor/components/panel/#panelbody)
* [Fragment](https://developer.wordpress.org/block-editor/packages/packages-element/#Fragment)
* [InspectorControls](https://developer.wordpress.org/block-editor/packages/packages-block-editor/#InspectorControls)
* [createHigherOrderComponent](https://developer.wordpress.org/block-editor/packages/packages-compose/#createHigherOrderComponent)
