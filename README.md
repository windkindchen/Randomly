# Randomly - Random Threads auf der Startseite

## Allgemeines:
### Kurzbeschreibung
Ein MyBB-Plugin, mit dem sich zufällig ausgelesene Inhalte zwischen zwei Kategorien (oder neben einer Kategorie) anzeigen lassen.

### Anmerkung
Bitte lest die ReadMe aufmerksam, damit es bei der Installation und bei den Einstellungen des Plugins nicht zu Problem kommt.
Macht bitte ein Backup vor der Installation.

### Eingebundene Plugins
Das Plugin <a href="http://mybbhacks.zingaburga.com/showthread.php?tid=288" target=_blank>xThreads</a> von <a href="http://mybbhacks.zingaburga.com/member.php?action=profile&uid=1" target=_blank>ZiNgA BuRgA</a> kann eingebunden werden, muss dies jedoch nicht.


## Beschreibung
Mit dem Plugin **Randomly** für das MyBB kannst du zufällig ausgewählte Threads auf der Startseite für bestimmte Gruppen auf der Startseite an einer Kategorie ausgeben lassen. Mit CSS und HTML kann bestimmt werden, ob dies vor, hinter oder neben einer Kategorie sein soll. 
Beispiele für die Anwendung sind: zufälliges Partnerforum, zufälliges Gesuch - oder für User ein zufälliger Thread aus dem Inplay. Die Einstellungen erlauben variable Einsätze von bis zu drei verschiedenen Randominhalten, die auch unterschiedlich formatierbar sind.

**Beispiel**
<img src="https://i.postimg.cc/Pr77rPY9/beispiel-partner.png" border="0" />



## Installation
1. Herunterladen der Dateien und auf dem PC entpacken.
2. Hochladen der Datei randomly.php in den Ordner inc/plugins des Forums
3. Im AdminCP unter Plugins auf "Installieren & aktivieren" klicken. Das Plugin ist nun einsatzbereit.
4. Unter "Konfiguration" - "Einstellungen" - "Randomly Index" alle Einstellungen treffen.
5. Templates und CSS anpassen.


## Veränderungen / Neue Dateien
### Datenbankänderungen:
- keine neuen Tabellen, nur Einfügen neuer Settings (s. nächster Punkt)

### Neue Settings:
- Settingsgroup **Randomly Index**
- mit 24 neuen Settings für das Plugin

### Templateänderungen:
Folgende Änderungen gibt es:
- Neue Templategruppe **Random Threads auf dem Index** in jedem Templateset
- 8 **neue** Templates: randomly_single_index, randomly_single_bit; randomly_v1_index, randomly_v1_bit; randomly_v2_index, randomly_v2_bit; randomly_v3_index, randomly_v3_bit
- 1 **geändertes** Template: forumbit_depth1_cat

### Variablen:
- in der forumbit_depth1_cat: {$forum['randomly_index']} {$forum['randomly_index2']} {$forum['randomly_index3']}
- Wenn Veränderungen z.B. mit xThreads (neues Templateset für die Kategorie) gemacht wurden, müssen die Variablen ggf. händisch eingefügt werden.



## Funktionsweise
### Einstellungen
Die Einstellungen sind in vier Blöcke unterteilt: Allgemein, Random 1, Random 2, Random 3.

#### Allgemein
- **[Allgemein] xThreads**: Auswahl, ob das Plugin installiert ist. Dies erlaubt den späteren Rückgriff auf die Threadfields über den Key des Feldes (s. unten)
- **[Allgemein] Anzahl der Randoms**: Ihr könnt an bis zu drei Stellen auf der Startseite die Randoms anzeigen lassen. Wählt hier aus, an wie vielen ihr dies haben wollt. Standardeinstellung ist "1", bei "0" ist das Plugin deaktiviert. Das Plugin ist aktuell für bis zu drei Randoms ausgelegt. Sollten mehr Randoms gewünscht sein, bitte melden.
- **[Allgemein] Verschiedene Templates**: Ihr könnt wählen, ob bei mehreren Randoms verschiedene Templates genutzt werden sollen. Wählt ihr "Nein", sind Templateänderungen in den Templates **randomly_single_index** und **randomly_single_bit** erforderlich. Andernfalls in den anderen Templates (die Nummer im Templatenamen entspricht der Reihenfolge in den Einstellungen).

#### Random 1, Random 2 und Random 3
Die verschiedenen Randoms können mit eigenständigen Einstellungen durchgeführt werden.
- **Anzeigekategorie**: An welcher Kategorie sollen die Inhalte angezeigt werden? (Durch Einstellungen mit der CSS und Verschiebung der Variablen im Template forenbit_depth1_cat kann bestimmt werden, ob dies vor, hinter oder neben der Kategorie angezeigt werden soll).
- **Foren für Randominhalte**: Auswahl der Foren, z.B. bei Partnern aus den Unterforen nach Genres, bei Gesuchen die Unterforen, in denen die verschiedenen Gesuchsarten stehen.
- **Anzeige für folgende Gruppen**: Welche Gruppen dürfen diesen Random sehen? 
- **Anzahl der Threads**: Wie viele Threads sollen zufällig ausgelesen werden? 
- **Key des Bildfeldes (xThreads)**: Wird xThreads verwendet und es gibt ein Feld für Bilder (z.B. Buttons der Partner), könnt ihr hier den Key eingeben.
- **Ersatzbild**: Wenn es kein entsprechendes Feld gibt, kann hier ein Ersatzbild eingetragen werden, das auch Gästen angezeigt wird.
- **xThread-Felder**: Wenn xThreads verwendet wird, können hier die Keys der Felder, die mit ausgegeben werden sollen, angegeben werden. Die Felder können in den dem "bit" endenden Templates als Variablen genutzt werden: Ein Feld mit dem Key **partner_url** kann als **{$partner_url}** im Template verwendet werden.


### Templates & CSS
Die Templates und das CSS wurden Basic gelassen (danke an ...) und sind vollkommen frei gestaltbar. Vorgegebene Variablen beginnen mit $roi_ - Dies beinhaltet die Variablen für den Thementitel mit Link, das Bild und den Usernamen mit Link. Sollte dies nicht benötigt werden, bitte weiterlesen. 
