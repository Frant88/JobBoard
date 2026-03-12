# JobBoard - Francesco Casaluce Portfolio Project

**JobBoard** è una piattaforma web dinamica per l'incontro tra domanda e offerta di lavoro, sviluppata con **Laravel 11** e potenziata con **JavaScript Vanilla**. Il progetto gestisce l'intero ciclo di vita di un annuncio: dalla pubblicazione da parte delle aziende alla ricerca e candidatura dei professionisti, con un sistema di gestione stati in tempo reale.

## Stack Tecnologico
* **Backend:** Laravel 11 (PHP 8.4.6)
* **Frontend:** Blade Templating, Bootstrap 5, **Vanilla JavaScript** (ES6+)
* **Database:** MySQL / PostgreSQL
* **API:** RESTful endpoints integrati per la gestione dinamica dei dati


### Dinamismo con Vanilla JS
Per garantire velocità e leggerezza, ho implementato le logiche client-side in puro JavaScript, evitando l'uso di framework pesanti:
* **Smart Search & Suggestions:** I campi di ricerca per *Località* (negli annunci) e *Categoria* (nel form di creazione) utilizzano la `Fetch API` per interrogare gli endpoint API, offrendo suggerimenti dinamici e filtri univoci basati sui dati reali.
* **Interactive Application Management:** Nella dashboard Employer, ho implementato un sistema di filtraggio istantaneo delle candidature (Accettate/Rifiutate/Pendenti) che agisce direttamente sul DOM per una gestione rapida senza ricaricamento della pagina.
* **UX & UI:** Gestione dei feedback utente tramite messaggi di sessione e manipolazione dinamica degli elementi della tabella (es. click-to-row navigation).

### Architettura & Logica di Business
* **Auth Multi-Ruolo:** Sistema differenziato tra **Candidati** (caricamento CV, gestione profilo Bio/GitHub) e **Aziende** (Ragione Sociale, Partita IVA).
* **Middleware Custom:** Protezione delle rotte tramite i middleware `RoleCandidate` e `RoleEmployer` per garantire la sicurezza dei dati e delle azioni autorizzate.
* **Email Verification:** Implementata tramite code (**Queues**) per ottimizzare i tempi di risposta del server durante la registrazione.
* **Performance:** Utilizzo sistematico di *Eager Loading* (`with()`) e gestione intelligente della paginazione con mantenimento del "seed" casuale degli annunci per una UX coerente.

## Struttura del Database
1.  **Users:** Gestione credenziali e identificazione ruolo (`is_employer`).
2.  **Profiles:** Dati specifici come CV path, loghi aziendali e P.IVA.
3.  **Listings:** Gli annunci di lavoro con slug SEO-friendly e metadati sulla modalità (remote, hybrid, onsite).
4.  **Applications:** Tabella pivot con tracking degli stati (`pending`, `accepted`, `rejected`).
5.  **Categories & Skills:** Organizzazione e classificazione granulare dei contenuti.

## Installazione Rapida

1.  **Clonazione e dipendenze:**
    ```
    git clone [https://github.com/Frant88/JobBoard.git](https://github.com/Frant88/JobBoard.git)
    cd JobBoard
    composer install && npm install
    ```
2.  **Configurazione:**
    ```
    cp .env.example .env
    php artisan key:generate
    ```
3.  **Database & Asset:**
    ```
    php artisan migrate --seed
    php artisan storage:link
    npm run dev
    ```

---

## Sviluppato da
**Francesco Casaluce**
* **Focus:** Full-Stack Development | Laravel Specialist
* **PHP Version:** 8.4.6