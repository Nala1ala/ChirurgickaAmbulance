# ChirurgickaAmbulance
Téma vychází z tématu využitého v předmětu DB1. Aplikace by měla simulovat systémy správy dat pro samostatnou chirurgickou ambulanci bez lůžkového oddělení.
 Bude umožňovat procházet seznam pacientů s historií jejich diagnóz a předpisů léčiv, přidávat nové diagnózy a předepisovat léčiva. Umožněno bude též procházet seznam léčiv, jejich léčivých látek a vzájemných interakcí a přidávat nové interakce nahlášené pacienty. Bude též možné přidat nového pacienta při první návštěvě a vystavovat pacientům neschopenky.

## Nasazení
Pro sestavení a spuštění aplikace pomocí Dockeru je nutné vytvořit soubor .env podle příkladu .env.example a mít zapnutý Docker engine. Následně je možno jednosuše setavvit a spustit Docker kontejnery pomocí scriptu start.bat pro operační systémy MS Windows, respektive start.sh pro unixové operační systémy. Po doběhnutí skriptu je do konzole vypsána adresa, na které je aplikace dostupná: http://localhost:8888.
