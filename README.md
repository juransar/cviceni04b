# BI-ZNF

## Cvičení 4

Varianta B projektu pro čtvrté cvičení předmětu BI-ZNF.


1. Použijte Vaši předchozí úlohu nebo si naklonujte a nainstalujte (příkaz "composer install") projekt 04b do vašeho lokálního adresáře.

2. Vytvořte si databázovou strukturu (MySQL) podle přítomného **SQL scriptu** a nastavte přístup k dané databázi v konfiguračním souboru ("app/config/config.local.neon")

3. V továrně "EmployerFormFactory" upravte následující
  * přidejte validaci příjmení tak, aby připouštěla jen písmena (první velké, ostatní malá).
  * přidejte validaci jména tak, aby připouštěla jen písmena (první velké, ostatní malá).
  * přidejte validaci plat tak, aby připouštěla jen kladná celá čísla s minimem 100 a maximem 100000.
  
4. V továrně "CompanyFormFactory" upravte následující
  * přidejte validaci telefonu tak, aby připouštěla 9 čísel.
  * přidejte celočíselnou položku daňové číslo (upravte i model a DB)
  * přidejte validaci daňového čísla tak, aby připouštěla 6 čísel a položka byla povinná pokud je zaškrtnuto je plátce DPH?

5. V továrně "PidFormFactory" upravte následující
  * přidejte validaci rodného čísla. 
  
6. Změňte vzhled formuláře "Employer" pomocí úpravy wrappers (použijte tagy dl, dd a dt)  

7. Změňte vzhled formuláře "Company" pomocí manuálního vykreslování.  

8. (Pokud nestihnete na cvičení) Naformátujte všechny formuláře ;->