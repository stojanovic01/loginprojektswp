# PHPMailer Installation und Konfiguration

## Schritt 1: PHPMailer herunterladen

1. Gehen Sie zu: https://github.com/PHPMailer/PHPMailer/releases
2. Laden Sie die neueste Version herunter (z.B. `PHPMailer-6.x.x.zip`)
3. Entpacken Sie die Datei in Ihr Projektverzeichnis

ODER verwenden Sie diesen direkten Link:
https://github.com/PHPMailer/PHPMailer/archive/refs/heads/master.zip

## Schritt 2: Dateien kopieren

Nach dem Download sollte Ihre Ordnerstruktur so aussehen:

```
d:\GRUS\2fa - fortsetzung von loginprojektswp\
├── PHPMailer/
│   ├── src/
│   │   ├── Exception.php
│   │   ├── PHPMailer.php
│   │   └── SMTP.php
│   └── ...
├── check_pwd.php
├── send_email.php
├── login.php
└── ...
```

## Schritt 3: Gmail App-Passwort erstellen

⚠️ **WICHTIG**: Sie können NICHT Ihr normales Gmail-Passwort verwenden!

### So erstellen Sie ein Gmail App-Passwort:

1. Gehen Sie zu Ihrem Google-Konto: https://myaccount.google.com/
2. Klicken Sie auf **Sicherheit** (links)
3. Unter "Bei Google anmelden" → aktivieren Sie **Bestätigung in zwei Schritten** (falls noch nicht aktiv)
4. Gehen Sie zurück zu **Sicherheit**
5. Suchen Sie nach **App-Passwörter**
6. Wählen Sie:
   - App: **E-Mail**
   - Gerät: **Windows-Computer** (oder anderes)
7. Klicken Sie auf **Erstellen**
8. Google zeigt Ihnen ein **16-stelliges Passwort** an
9. **Kopieren Sie dieses Passwort!**

## Schritt 4: App-Passwort in send_email.php eintragen

Öffnen Sie `send_email.php` und ersetzen Sie:

```php
$mail->Password   = 'IHR_APP_PASSWORT';
```

mit Ihrem 16-stelligen App-Passwort (ohne Leerzeichen):

```php
$mail->Password   = 'abcd efgh ijkl mnop';  // Beispiel, verwenden Sie Ihr eigenes!
```

## Schritt 5: Testen

Jetzt können Sie Ihr Login-System testen!

1. Öffnen Sie `login.php`
2. Geben Sie E-Mail und Passwort ein
3. Sie sollten eine E-Mail mit dem 2FA-Code erhalten
4. Geben Sie den Code ein
5. Erfolgreicher Login!

## Troubleshooting

**Problem: "SMTP Error: Could not authenticate"**
- Lösung: Überprüfen Sie Ihr App-Passwort

**Problem: "SMTP connect() failed"**
- Lösung: Überprüfen Sie Ihre Firewall-Einstellungen
- Port 587 muss offen sein

**Problem: Keine E-Mail erhalten**
- Lösung: Prüfen Sie den Spam-Ordner
- Aktivieren Sie "Weniger sichere Apps" in Gmail (nicht empfohlen)
- Verwenden Sie stattdessen App-Passwörter (empfohlen)

## Alternative: Composer Installation (wenn Composer installiert ist)

Falls Sie Composer haben:

```bash
composer require phpmailer/phpmailer
```

Dann ändern Sie in `send_email.php`:

```php
require 'vendor/autoload.php';
```

statt:

```php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
```
