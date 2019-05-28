# Hands on Gutenberg 

Der neue WordPress Frontend Editor

Das CMS WordPress steckt in rund 27% der Websites im World Wide Web. Mit Beginn 2019 wurde ein neues Zeitalter der 
Content-Eingabe der Open-Source Community vorgestellt: Der Gutenberg Editor. Ein Frontend-Editor auf Block-Basis soll 
den Bedürfnissen der breiten Basis nachkommen um flexibel und schnell Inhalte in das Web zu publizieren. Anhand eines 
konkreten Beispiels werden in 90 Minuten die Grenzen, Möglichkeiten und Herausforderungen des Gutenberg Editors, denen 
sich der Web Entwickler stellen muss, dargestellt.

## Ziele

* Einblick in WordPress mit Fokus auf den Gutenberg Editor
* Einblick in Web-Komponenten auf Basis von React/JSX
* Kennenlernen von WordPress Hooks
* Programmieren eines WordPress Plugins auf Basis dieses Repositories
* Modifizieren bestehender Gutenberg-Blocks (Higher Order Components)
* Ausblick auf Tools, die Entwicklungszeiten verkürzen.

## Mitmachen

Der Gastvortrag ist eine Chance zum aktiv Mitmachen und das aufgeschnappte Wissen gleich praktisch auszuprobieren.

### Voraussetzungen

* AMP Stack (https://ampps.com/download)
* WordPress (https://de.wordpress.org/download/)
* Git (https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
* Npm (https://www.npmjs.com/get-npm)
* Text-Editor (VS Code, Atom, Sublime, …)
* Browser

### Anleitung

**Dauer:** ca. 15-45 min

1. Git, Npm und AMP Stack (Apache, MySQL/MariaDB, PHP) installieren und deren Services starten.
2. Datenbank anlegen, zB `FH_OOE` und die Zugangsdaten für Schritt 5. bereithalten.
3. WordPress downloaden und im webroot, zB `~/amp/htdocs/` entpacken.
4. `~/amp/htdocs/wp-config-sample.php` zu `~/amp/htdocs/wp-config.php` umbenennen und mit dem Text-Editor bearbeiten.
5. Datenbank Zugangsdaten in den Konstanten `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST` definieren.
6. Mit einer Git-Shell/Terminal in das Plugin-Verzeichnis von WordPress wechseln und dieses Repo hineinklonen, 
   zB `$ cd ~/amp/htdocs/wp-content/plugins/ && git clone https://github.com/iantsch/fh-ooe-gutenberg.git`
7. Mit einer Node-Shell/Terminal in das geklonte Plugin wechseln und die Entwicklungs-Abhängigkeiten installieren und den Watcher starten, 
   zB `$ cd ~/amp/htdocs/wp-content/plugins/fh-ooe-gutenberg && npm i && npm run dev`
8. Im Browser die URL des Apache Servers aufrufen, zB `http://localhost` und die 3-Schritte Installation von WordPress 
   durchführen.
9. Ins WordPress Backend einloggen, zB `http://localhost/wp-admin/plugins.php` und das Plugin `FH OÖ Gastvortrag - Hands on Gutenberg` aktivieren.
10. In den Gastvortrag kommen und mitmachen.


### Über den Author

Christian Tschugg ist Senior [Web Developer](https://mbt.wien) der [MMCAGENTUR](https://www.MMCAGENTUR.at) in Mödling und hat über 12 Jahre WordPress Erfahrung. Seine 
Passion für JavaScript Frameworks haben den Wahl-Wiener tief in den Kern des Gutenberg-Editors eintauchen lassen.

* Twitter: [@iantsch](https://twitter.com/iantsch)
* Stackoverflow: [iantsch](https://wordpress.stackexchange.com/users/90220/iantsch)