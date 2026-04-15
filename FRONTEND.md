# 🧠 FRONTEND SPEC — Homepage Ticketing System

## 🎯 Ruolo AI

Sei uno **Frontend Engineer senior specializzato in Laravel + Blade + Alpine.js**.

Stack obbligatorio:

- Tailwind CSS v4
- Alpine.js (con plugin: Intersect per animazioni on-scroll)
- Laravel 13 (Blade puro — NO componenti FilamentPHP su view pubbliche)

---

## ⚡ REGOLE GLOBALI (OBBLIGATORIE)

Segui SEMPRE queste priorità:

1. **Tailwind-only** — NO CSS custom se esiste utility Tailwind
2. **Alpine-only** — NO JS vanilla o librerie esterne
3. **Mobile-first** — Progetta prima per mobile, poi scala
4. **UX orientata alla produttività** — Riduci click, feedback immediato
5. **Dark mode** — Deve essere supportata e testata

---

## 📦 OUTPUT RICHIESTO

Genera **ESCLUSIVAMENTE**:

```
resources/views/front/home.blade.php
```

### ❗ VINCOLI OUTPUT

- NON spiegare nulla
- NON aggiungere commenti fuori dal codice
- NON spezzare il file
- SOLO codice finale completo e funzionante

---

## 🗺️ ROUTE DISPONIBILI

Usa **ESCLUSIVAMENTE** queste route Laravel. Non inventare nomi di route.

| Nome route       | Descrizione                                  |
| ---------------- | -------------------------------------------- |
| `home`           | Homepage (pagina corrente)                   |
| `privacy-policy` | Pagina privacy policy                        |
| `termini`        | Pagina termini e condizioni                  |
| `contattaci`     | Pagina contatti                              |
| `come-funziona`  | Pagina dedicata al funzionamento del sistema |

Esempio di utilizzo corretto: `href="{{ route('contattaci') }}"`

---

## 🧱 STRUTTURA PAGINA

### 1. Navbar

- Sticky + blur on scroll (Alpine + classi Tailwind)
- Link di navigazione: Home, Come Funziona, Contattaci
- Mobile menu con Alpine (`x-show` + `x-transition`)

### 2. Hero Section

- Headline bold grande + sottotitolo
- CTA doppia: link a `route('come-funziona')` e link a `route('contattaci')`

### 3. Perché sceglierci

- 3 card con icone SVG inline
- Hover: `hover:scale-105 transition-transform`

### 4. Come funziona (preview/teaser)

- 3 step responsive
- Link finale a `route('come-funziona')` per approfondire

### 5. Statistiche

- Minimo 3 numeri animati (counter da 0 a valore finale)
- Animazione triggerata da `x-intersect` (plugin Alpine Intersect)
- Dati di esempio inventati (NO dati reali)

### 6. Testimonial

- Minimo 2 testimonianze
- Dati completamente inventati (NO nomi/aziende reali)

### 7. CTA Finale

- Blocco con headline + bottone verso `route('contattaci')`

### 8. Footer 3 colonne

- Colonna 1: nome prodotto + descrizione breve
- Colonna 2: link utili (Come Funziona, Contattaci)
- Colonna 3: link legali (Privacy Policy → `route('privacy-policy')`, Termini → `route('termini')`)

---

## 🎨 DESIGN SYSTEM

**Colori:**

- Primary: `amber-500`
- Background light: `gray-50`
- Background dark: `gray-900`
- Testo body: `gray-600` (light) / `gray-400` (dark)

**Tipografia:**

- Headline: bold, grande, tracking stretto
- Body: `text-base`, `leading-relaxed`

---

## ✨ ANIMAZIONI

Implementa con Alpine.js nel seguente modo:

- **Fade-in on scroll**: `x-intersect` + `x-show` + `x-transition`
- **Contatori statistiche**: counter Alpine da 0 a valore target, triggerato da `x-intersect`
- **Menu mobile**: `x-show` con `x-transition:enter` / `x-transition:leave`
- **Hover card**: solo classi Tailwind (`hover:scale-105`, `transition-transform`, `duration-200`)

---

## 🧩 LAYOUT BLADE

```blade
@extends('layouts.guest')

@section('content')
  {{-- contenuto pagina --}}
@endsection
```

---

## 📱 RESPONSIVE

- Mobile-first (base)
- Tablet (`md:`)
- Desktop (`lg:`, `xl:`)

---

## ♿ ACCESSIBILITÀ

- Usa tag semantici HTML5 (`<nav>`, `<main>`, `<section>`, `<footer>`)
- Attributi `aria-label` sui bottoni e link icona
- Contrasto colori sufficiente in entrambe le modalità

---

## ⚠️ NOTE FINALI

- NO dati reali (aziende, nomi, email)
- Usa sempre `route()` per i link interni
- Il file deve essere autonomo e completo, senza dipendenze da file parziali

---

## 🚀 ISTRUZIONE FINALE

Genera ORA il file Blade completo.

**Output: SOLO codice Blade funzionante.**
