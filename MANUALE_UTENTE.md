# Manuale Utente — Sistema di Ticketing

> Versione 1.0 — Aggiornato ad aprile 2026

---

## Indice

1. [Accesso al sistema](#1-accesso-al-sistema)
2. [Administrator](#2-administrator)
3. [Supervisor](#3-supervisor)
4. [Operator](#4-operator)
5. [Client](#5-client)
6. [Funzionalità comuni](#6-funzionalità-comuni)
7. [Domande frequenti](#7-domande-frequenti)

---

## 1. Accesso al sistema

### Come accedere

1. Apri il browser e vai all'indirizzo del pannello di gestione (es. `https://tuodominio.it/admin`)
2. Inserisci la tua **email** e **password**
3. Clicca su **Accedi**

> ⚠️ Non esiste la registrazione pubblica. Il tuo account viene creato dall'Administrator e le credenziali ti vengono comunicate direttamente.

### Password dimenticata

Nella schermata di login è presente il link **"Password dimenticata?"**. Inserisci la tua email e riceverai le istruzioni per il ripristino.

### Modifica del profilo

Una volta entrato, clicca sull'icona del tuo **profilo in alto a destra** per:
- Modificare nome ed email
- Cambiare la password
- Caricare una foto profilo

---

## 2. Administrator

L'Administrator ha accesso completo a tutte le funzionalità del sistema.

### 2.1 Dashboard

All'accesso visualizzi una panoramica completa:

| Widget | Descrizione |
|--------|-------------|
| Contatori stato ticket | Aperti, In lavorazione, In attesa cliente, Risolti, Chiusi |
| Minuti residui per azienda | Avviso visivo se una company ha meno del 20% dei minuti |
| Ticket senza operatore | Lista dei ticket aperti non ancora assegnati |
| Ultimi 5 ticket creati | Accesso rapido ai ticket più recenti |

### 2.2 Gestione Utenti

**Percorso:** Menu laterale → Utenti

#### Creare un nuovo utente
1. Clicca **Nuovo Utente**
2. Compila i campi:
   - **Nome** e **Email** (obbligatori)
   - **Password** iniziale (comunicarla all'utente)
   - **Ruolo**: Administrator / Supervisor / Operator / Client
   - **Azienda**: obbligatorio per i Client, facoltativo per gli altri ruoli
   - **Può vedere tutti i ticket dell'azienda**: solo per i Client — se attivo, il Client vede tutti i ticket della propria azienda; se disattivo, vede solo i propri
3. Clicca **Salva**

#### Modificare un utente
1. Nella lista utenti, clicca sull'utente
2. Clicca **Modifica**
3. Aggiorna i dati e salva

#### Disattivare un utente
1. Nella lista utenti, clicca sull'utente
2. Clicca **Elimina** (soft delete — l'utente non viene cancellato fisicamente)
3. L'utente non potrà più accedere al sistema

#### Ripristinare un utente disattivato
1. Nella lista utenti, attiva il filtro **Cestino** in alto a destra
2. Trova l'utente e clicca **Ripristina**

### 2.3 Gestione Aziende

**Percorso:** Menu laterale → Aziende

#### Creare una nuova azienda
1. Clicca **Nuova Azienda**
2. Compila:
   - **Nome** (obbligatorio)
   - **Partita IVA**, **Email**, **Telefono**
   - **Logo** (opzionale — verrà mostrato agli utenti dell'azienda)
3. Clicca **Salva**

#### Assegnare utenti a un'azienda
L'associazione avviene dalla scheda Utente (campo "Azienda"), non dalla scheda Azienda.

### 2.4 Gestione Reparti

**Percorso:** Menu laterale → Reparti

I reparti servono per smistare i ticket (es. Supporto, Sviluppo, Amministrazione).

1. Clicca **Nuovo Reparto**
2. Inserisci il nome
3. Salva

I reparti sono selezionabili durante la creazione o modifica di un ticket.

### 2.5 Gestione Piani

**Percorso:** Menu laterale → Piani

Un Piano definisce il pacchetto di minuti venduto a un'azienda.

| Campo | Descrizione |
|-------|-------------|
| Nome | Es. "Piano Base", "Piano Premium" |
| Minuti totali | Totale minuti inclusi nel piano |
| Giorni di validità | Durata del piano in giorni dalla data di inizio |
| Prezzo | Valore economico del piano (opzionale) |

### 2.6 Gestione Abbonamenti

**Percorso:** Menu laterale → Abbonamenti

Un Abbonamento associa un'azienda a un piano per un determinato periodo.

#### Creare un abbonamento
1. Clicca **Nuovo Abbonamento**
2. Seleziona l'**Azienda** e il **Piano**
3. Imposta **Data inizio** e **Data scadenza**
4. Il campo **Minuti residui** viene pre-compilato con i minuti totali del piano — puoi modificarlo
5. Salva

> ⚠️ Una company può avere una sola subscription attiva alla volta.

#### Monitorare i minuti
- I minuti residui si scalano automaticamente ogni volta che uno staff inserisce una Time Entry
- I minuti possono andare in **negativo** (lavoro extra non coperto dal contratto)
- Quando i minuti scendono sotto il **20%** del totale, ricevi una notifica automatica

### 2.7 Gestione Ticket

L'Administrator vede e può gestire **tutti i ticket** di tutte le aziende.

Vedi la sezione [Funzionalità comuni → Ticket](#ticket) per il dettaglio completo.

**Azioni esclusive dell'Administrator:**
- Eliminare un ticket (soft delete)
- Ripristinare un ticket eliminato
- Assegnare il ticket a qualsiasi operatore

### 2.8 Export CSV

**Dove:** All'interno di ogni lista (Ticket, Utenti, Aziende, Abbonamenti, Time Entry)

1. Applica eventuali filtri per restringere i dati
2. Clicca il pulsante **Esporta** in alto a destra
3. Il file CSV viene generato e scaricato automaticamente

> Il CSV è compatibile con Excel italiano (separatore `,`, encoding UTF-8 BOM).

L'Administrator può esportare: **tutti i ticket, tutte le time entry, tutti gli utenti, tutte le aziende, tutti gli abbonamenti**.

### 2.9 Notifiche

Le notifiche appaiono nel **campanello** in alto a destra. L'Administrator riceve notifiche per:
- Nuovo ticket creato
- Ticket assegnato
- Nuova risposta su un ticket
- Ticket risolto
- Ticket riaperto
- **Abbonamento con minuti sotto il 20%** (notifica esclusiva)

---

## 3. Supervisor

Il Supervisor gestisce il flusso operativo dei ticket e coordina gli operatori.

### 3.1 Dashboard

| Widget | Descrizione |
|--------|-------------|
| Contatori stato ticket | Aperti, In lavorazione, In attesa cliente |
| Ticket senza operatore | Lista dei ticket da assegnare |
| Ultimi 5 ticket creati | Accesso rapido |

### 3.2 Cosa può fare il Supervisor

| Funzionalità | Può farlo? |
|---|---|
| Vedere tutti i ticket | ✅ |
| Creare ticket | ✅ |
| Assegnare ticket a qualsiasi operatore | ✅ |
| Rispondere ai ticket | ✅ |
| Chiudere / Risolvere ticket | ✅ |
| Riaprire ticket | ✅ |
| Inserire time entry | ✅ |
| Allegare file | ✅ |
| Vedere e modificare utenti | ✅ (solo visualizzazione e modifica, non crea/elimina) |
| Vedere reparti | ✅ |
| Gestire aziende / piani / abbonamenti | ❌ |
| Eliminare ticket | ❌ |

### 3.3 Gestione Ticket

Il Supervisor ha piena visibilità e controllo sul flusso dei ticket.

**Prendere in carico un ticket:**
1. Apri il ticket con stato **Aperto**
2. Clicca **Prendi in carico**
3. Seleziona l'operatore da assegnare (o lascia a te stesso)
4. Il ticket passa in stato **In lavorazione**

**Cambiare stato manualmente:**
- **In attesa cliente** → il ticket è in attesa di risposta dal cliente
- **Risolto** → il lavoro è completato
- **Chiudi** → il ticket viene archiviato

### 3.4 Export CSV

Il Supervisor può esportare:
- **Ticket**: tutti i ticket visibili
- **Time Entry**: tutte le time entry
- **Utenti**: tutti gli utenti

---

## 4. Operator

L'Operator gestisce i ticket assegnati a lui e registra il tempo lavorato.

### 4.1 Dashboard

| Widget | Descrizione |
|--------|-------------|
| I miei ticket per stato | Panoramica dei propri ticket |
| Ticket aperti non assegnati | Ticket disponibili da prendere in carico |
| Ultimi 5 ticket assegnati a me | Accesso rapido |

### 4.2 Cosa può fare l'Operator

| Funzionalità | Può farlo? |
|---|---|
| Vedere tutti i ticket | ✅ |
| Creare ticket | ✅ |
| Prendere in carico un ticket (assegnare a sé stesso) | ✅ |
| Assegnare ad altri operatori | ❌ |
| Rispondere ai ticket | ✅ |
| Chiudere / Risolvere ticket | ✅ |
| Riaprire ticket | ✅ |
| Inserire time entry | ✅ (solo proprie) |
| Allegare file | ✅ |
| Vedere utenti / reparti | ❌ |
| Gestire aziende / piani / abbonamenti | ❌ |

### 4.3 Prendere in carico un ticket

1. Dalla lista ticket o dalla dashboard, individua un ticket **Aperto** non assegnato
2. Aprilo e clicca **Prendi in carico**
3. Il ticket viene assegnato automaticamente a te e passa in stato **In lavorazione**

> L'Operator può assegnare solo a sé stesso. Per riassegnare a un altro operatore, contatta il Supervisor.

### 4.4 Rispondere a un ticket

1. Apri il ticket
2. Clicca **Aggiungi risposta**
3. Scrivi il messaggio nell'editor (supporta formattazione rich text: grassetto, elenchi, link, ecc.)
4. (Opzionale) Inserisci i **minuti lavorati** — verranno scalati dall'abbonamento dell'azienda
5. (Opzionale) Allega uno o più file
6. Clicca **Salva**

### 4.5 Inserire Time Entry

Le time entry registrano il tempo lavorato su un ticket e scalano i minuti dall'abbonamento dell'azienda.

**Metodo rapido** (contestuale alla risposta):
- Compila il campo "Minuti lavorati" direttamente nel form di risposta

**Metodo diretto:**
1. Vai su Menu laterale → Time Entry
2. Clicca **Nuova Time Entry**
3. Seleziona il ticket, inserisci i minuti e una nota opzionale
4. Salva

> ⚠️ L'Operator può vedere e modificare solo le proprie time entry, non quelle degli altri.

### 4.6 Gestire gli allegati

**Caricare un allegato:**
- Durante la risposta: usa il campo "Allegati" nel form di risposta
- Formato accettati: JPG, PNG, GIF, WEBP, PDF, DOC, DOCX, XLS, XLSX, TXT, ZIP
- Dimensione massima: **10 MB per file**
- Limite: **10 allegati totali per ticket** (somma di ticket + tutte le sue risposte)

**Scaricare un allegato:**
- Nella pagina del ticket, sezione "Conversazione" o "Allegati"
- Clicca sul nome del file per scaricarlo

### 4.7 Export CSV

L'Operator può esportare:
- **Ticket**: tutti i ticket visibili
- **Time Entry**: solo le proprie

---

## 5. Client

Il Client apre ticket di supporto, segue le conversazioni e allega documenti.

### 5.1 Dashboard

| Widget | Descrizione |
|--------|-------------|
| I miei ticket aperti | Panoramica dei ticket attivi |
| Stato abbonamento | Minuti residui e data di scadenza |
| Ultimi 5 ticket aggiornati | Accesso rapido alle conversazioni recenti |

### 5.2 Cosa può fare il Client

| Funzionalità | Può farlo? |
|---|---|
| Aprire nuovi ticket | ✅ (solo se abbonamento attivo con minuti > 0) |
| Rispondere ai ticket | ✅ |
| Riaprire ticket risolti/chiusi | ✅ |
| Allegare file | ✅ |
| Vedere tutti i ticket dell'azienda | ✅ (solo se abilitato dall'Admin) |
| Vedere time entry | ❌ |
| Inserire time entry | ❌ |
| Chiudere / Risolvere ticket | ❌ |
| Accedere ad altri menu | ❌ |

### 5.3 Aprire un nuovo ticket

1. Vai su Menu laterale → Ticket
2. Clicca **Nuovo Ticket**
3. Compila i campi:
   - **Titolo**: descrizione breve del problema (obbligatorio)
   - **Descrizione**: dettaglio completo del problema (obbligatorio)
   - **Priorità**: Bassa / Media / Alta / Urgente
   - **Reparto**: seleziona il reparto più appropriato (opzionale)
   - **Allegati**: carica file di supporto se necessario
4. Clicca **Salva**

> ❌ Se vedi il messaggio *"Il tuo abbonamento è esaurito o non attivo"*, non puoi aprire nuovi ticket. Contatta il tuo referente per rinnovare o acquistare minuti extra.

### 5.4 Rispondere a un ticket

1. Apri il ticket dalla lista o dalla dashboard
2. Clicca **Aggiungi risposta**
3. Scrivi il messaggio — puoi usare la formattazione (grassetto, elenchi, ecc.)
4. (Opzionale) Allega file
5. Clicca **Salva**

> Quando rispondi a un ticket in stato "In attesa cliente", lo stato torna automaticamente in **In lavorazione**, segnalando all'operatore che hai risposto.

### 5.5 Seguire lo stato del ticket

Ogni ticket ha uno stato che indica a che punto è la lavorazione:

| Stato | Significato |
|-------|-------------|
| 🔵 Aperto | Il ticket è stato creato, non ancora preso in carico |
| 🟡 In lavorazione | Un operatore sta lavorando |
| ⚪ In attesa cliente | L'operatore ha risposto e attende una tua risposta |
| 🟢 Risolto | Il problema è stato risolto — puoi riaprirlo se necessario |
| 🔴 Chiuso | Il ticket è archiviato |

### 5.6 Riaprire un ticket

Se il problema si ripresenta o la soluzione non è soddisfacente:
1. Apri il ticket risolto o chiuso
2. Clicca **Riapri**
3. Il ticket torna in stato **Aperto**

### 5.7 Abbonamento e minuti

Nella dashboard puoi vedere:
- **Minuti residui**: quanti minuti hai ancora disponibili
- **Data di scadenza**: fino a quando l'abbonamento è valido

Ogni risposta dello staff a un ticket scala i minuti residui del tuo abbonamento. Quando i minuti si esauriscono, non puoi aprire nuovi ticket ma i ticket già aperti continuano normalmente.

### 5.8 Export CSV

Il Client può esportare i propri ticket:
- Se "Può vedere tutti i ticket dell'azienda" è attivo → esporta tutti i ticket dell'azienda
- Altrimenti → esporta solo i propri ticket

---

## 6. Funzionalità comuni

### Ticket

#### Workflow degli stati

```
Aperto → In lavorazione → In attesa cliente → Risolto → Chiuso
                                                    ↘ Aperto (riapertura)
```

#### Priorità

| Priorità | Quando usarla |
|----------|---------------|
| 🔘 Bassa | Problema non urgente, non blocca il lavoro |
| 🔵 Media | Problema ordinario (default) |
| 🟡 Alta | Problema che rallenta il lavoro |
| 🔴 Urgente | Sistema bloccato, impatto critico |

#### Ricerca e filtri

Nella lista ticket puoi:
- **Cercare** per titolo o descrizione (barra di ricerca in alto)
- **Filtrare** per stato, priorità, reparto, operatore assegnato, azienda
- **Ordinare** per data di creazione (più recenti prima)

### Notifiche

Il **campanello** in alto a destra mostra le notifiche non lette. Clicca su una notifica per essere portato direttamente al ticket correlato.

Ricevi notifiche quando:
- Viene aperto un ticket (staff)
- Ti viene assegnato un ticket (operatori)
- Arriva una nuova risposta su un ticket a cui partecipi
- Il tuo ticket viene risolto (client)
- Un ticket viene riaperto (supervisor/admin)

### Allegati

- **Formati accettati**: JPG, PNG, GIF, WEBP, PDF, DOC, DOCX, XLS, XLSX, TXT, ZIP
- **Dimensione massima**: 10 MB per singolo file
- **Limite**: 10 allegati totali per ticket (ticket + tutte le risposte)
- **Download**: clicca sul nome del file — il download è protetto e accessibile solo agli utenti autorizzati

---

## 7. Domande frequenti

**D: Ho dimenticato la password, cosa faccio?**
Usa il link "Password dimenticata?" nella schermata di login.

**D: Non riesco ad aprire un nuovo ticket.**
Il tuo abbonamento è esaurito o scaduto. Contatta il tuo referente commerciale.

**D: Ho risposto a un ticket ma non vedo la risposta.**
Aggiorna la pagina. Se il problema persiste, verifica di aver cliccato "Salva".

**D: Vedo solo i miei ticket e non quelli dei colleghi.**
L'Administrator non ha attivato la visualizzazione condivisa per il tuo account. Contatta il tuo Administrator.

**D: Voglio cambiare la mia password.**
Clicca sul tuo nome/avatar in alto a destra → Profilo → modifica la password.

**D: Un allegato non si carica.**
Verifica che il file non superi 10 MB e che il formato sia tra quelli accettati.

**D: I minuti del mio abbonamento sono a zero ma ho un ticket aperto.**
Puoi continuare a rispondere ai ticket già aperti normalmente. Solo l'apertura di nuovi ticket è bloccata.

**D: Come faccio a sapere quanti minuti ho ancora?**
Guarda la dashboard (widget "Stato abbonamento") oppure apri un ticket — i minuti residui sono visibili nella barra laterale.

---

*Sistema di Ticketing — Manuale Utente v1.0*
