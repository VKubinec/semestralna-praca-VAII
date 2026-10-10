# Správa vozidiel

Vladimír Kubinec

5ZYI33

## Stručný opis projektu
Webová aplikácia určená majiteľom jedného alebo viacerých vozidiel. Umožní evidovať vozidlá, vykonaný servis auta, tankovania a súvisiace dokumenty na jednom mieste. Používateľ získa prehľad o prevádzkových nákladoch, servisnej histórii a blížiacich sa termínoch technických kontrol či plánovaného servisu.

## Role v projekte
Prihlásený používateľ: Spravuje vlastné vozidlá, servisné záznamy, tankovania a dokumenty. Sleduje prevádzkové náklady, servisnú históriu a nadchádzajúce termíny. Môže svoje údaje pridávať, zobrazovať, upravovať a mazať. Nemá prístup k údajom ostatných používateľov.
Administrátor: Má možnosti bežného používateľa a navyše spravuje používateľské účty. Môže zobrazovať zoznam účtov, upravovať ich údaje a aktivovať alebo deaktivovať účty.

## Prípady použitia podľa rolí
Používateľ: pridá, upraví alebo odstráni vozidlo, servisný záznam či tankovanie. Nahrá, stiahne alebo odstráni dokument, vyfiltruje záznamy a zobrazí náklady a nadchádzajúce termíny.
Administrátor: zobrazí používateľské účty, upraví ich údaje a aktivuje alebo deaktivuje účet.

## Plánované entity
Rola používateľa: PK: id; názov roly (admin, user).
Používateľ: PK: id; FK: rola_id → Rola používateľa; meno, priezvisko, e-mail, hash hesla, aktívny účet, dátum registrácie.
Vozidlo: PK: id; FK: pouzivatel_id → Používateľ; značka, model, rok výroby, EČV, VIN, druh paliva, aktuálny stav kilometrov, platnosť STK, platnosť EK, dátum plánovaného servisu.
Servisný záznam: PK: id; FK: vozidlo_id → Vozidlo; názov úkonu, opis vykonaných prác, dátum servisu, stav kilometrov pri servise, celková cena, názov servisu.
Tankovanie: PK: id; FK: vozidlo_id → Vozidlo; dátum tankovania, počet litrov, celková cena, stav kilometrov pri tankovaní, názov čerpacej stanice.
Dokument: PK: id; FK: vozidlo_id → Vozidlo; názov dokumentu, typ dokumentu (účtenka, faktúra, technický preukaz, poistka, iný), pôvodný názov súboru, cesta k uloženému súboru, dátum nahratia.

## Vzťahy medzi entitami
Rola používateľa – Používateľ (1:N): Jednu rolu môže mať viacero používateľov. Každý používateľ má jednu rolu.
Používateľ – Vozidlo (1:N): Používateľ môže evidovať viacero vozidiel. Každé vozidlo patrí jednému používateľovi.
Vozidlo – Servisný záznam (1:N): Vozidlo môže mať viacero servisných záznamov.
Vozidlo – Tankovanie (1:N): Vozidlo môže mať viacero záznamov o tankovaní.
Vozidlo – Dokument (1:N): Vozidlo môže mať viacero priložených dokumentov.

## Hlavné stránky aplikácie
Prehľad: Súhrn vozidiel, nákladov a nadchádzajúcich termínov.
Moje vozidlá: Zoznam, vyhľadávanie a správa vozidiel.
Detail vozidla: Údaje o vozidle, náklady a servisná história.
Servisná história: Správa a filtrovanie servisných záznamov.
Tankovania: Správa tankovaní a prehľad výdavkov na palivo.
Dokumenty: Nahrávanie, sťahovanie a mazanie súborov.
Administrácia: Správa používateľských účtov.

## Rozdelenie funkcionality
Základné funkcie:
- Registrácia, prihlásenie, roly a kontrola prístupu.
- Kompletné CRUD operácie nad vozidlami, servisnými záznamami a tankovaniami.
- Správa dokumentov, súhrn nákladov a zobrazenie termínov.
- AJAX filtrovanie záznamov a odosielanie formulára na pridanie servisu.
- Responzívny dizajn a validácia vstupov na klientovi aj serveri.
- Implementácia v PHP s frameworkom VAJKO, spustenie cez Docker s automatickým importom ukážkových dát.

Rozširujúce funkcie:
- Grafy mesačných nákladov.
- E-mailové upozornenia na blížiace sa termíny.
- Export servisnej histórie a nákladov do CSV.