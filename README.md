# Laravel To-Do App

Eine To Do Webanwendung mit Benutzerauthentifizierung, strikter Trennung der Aufgaben nach Benutzer user_id, interaktiver Aufgabenliste über Livewire und E-Mail-Benachrichtigungen beim Anlegen neuer Aufgaben.

## Funktionen

- **Benutzerverwaltung & Datentrennung:** Registrierung, Login und Logout, jeder Benutzer sieht und bearbeitet ausschließlich seine eigenen Aufgaben.
- **Interaktive Aufgabenliste Livewire:** Aufgaben ohne Neuladen der Seite als erledigt markieren Done / Return und löschen Delete, inklusive live aktualisierter Zähler.
- **Suche & Filter:** Suche nach Titel oder Beschreibung sowie Filter für alle All, offene Open und erledigte Completed Aufgaben.
- **E-Mail-Benachrichtigung:** Automatische Benachrichtigung beim Erstellen einer neuen Aufgabe
- **Automatisierte Tests:** Feature-Tests mit Pest für Validierung, Berechtigungen, Livewire-Aktionen und E-Mail-Versand.



## Installation & Start

**Repository klonen und in das Projektverzeichnis wechseln:**
  
   git clone https://github.com/yonshii/ToDoList.git
   cd ToDoList
HP- und Frontend-Abhängigkeiten installieren:

composer install
npm install
Umgebungsdatei anlegen und App-Key generieren:

Bash
cp .env.example .env
php artisan key:generate
SQLite-Datenbank erstellen und Migrationen ausführen:

Bash
touch database/database.sqlite
php artisan migrate
Frontend-Assets bauen und Anwendung starten:

Bash
npm run build
php artisan serve
