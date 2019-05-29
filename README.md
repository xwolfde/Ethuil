# Ethuil

Experimental WordPress Theme  ``do not use for productive websites``


## Download 

GITHub-Repo: https://github.com/xwolf.de/Ethuil


## Autor 
xwolf, https://www.xwolf.de

## Copryright

GNU General Public License (GPL) Version 2 


## Verwendete Libraries und Sourcen

* Bootstrap 4.3.1, http://getbootstrap.com/



## Feedback

Please use github for submitting new features or bugs:
 https://github.com/xwolfde/Ethuil


## Entwickler-Hinweise

### SASS-Compiler

Die CSS Anweisungen werden mittels SASS erzeugt. Hierzu werden im Verzeichnis 
```/css/sass/``` alle notwendigen SASS und SCSS Dateien abgelegt.
Die zentrale CSS-Datei style.css wird bei der SASS-Compilierung im  
Hauptverzeichnis des Themes abgelegt. Die CSS-Datei für das Backend wird 
dagegen im Unterverzeichnis ```/css``` abfelegt.

#### SASS-Watcher:

1. Basis Stylesheet
    Eingabequelle:   ```/css/sass/base.scss```   
    Ausgabeort:  ```/style.css```

2. Sonstiges Styles
    Eingabequelle:  ```/css/sass/```  
    Ausgabeort:     ```/css```

Mit Compiler-Option soll im prdokutiven Betrieb die erzeigte CSS-Datei kompimiert 
sein. Außerdem sind Source-Map Dateien nicht benötigt. Die dafür notwendige 
Compiler-Argumente sind daher ```--style compressed  --sourcemap=none```


 


