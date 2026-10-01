# Mercanto 🛒

> **Mercanto** ni Mfumo wa Kisasa wa Mauzo (POS), Stoo, na Usimamizi wa Maduka ya Jumla na Rejareja wenye uwezo wa Multi-Tenant SaaS na Muundo wa Lugha Mbili (Kiswahili & English).
>
> *A modern, multi-tenant cloud-ready Point of Sale (POS), Inventory, and ERP Platform tailored for East African retail and wholesale operations.*

---

## 🌟 Sifa Kuu za Mfumo (Key Features)

### 1. 🏪 Multi-Tenant & Multi-Branch Architecture
- **Multi-Tenant SaaS HQ**: Usimamizi wa maduka tofauti (tenants) kwenye mfumo mmoja.
- **Matawi Mengi (Branches)**: Usimamizi wa matawi na vituo vya usambazaji (HQ Central Depot, Mwenge, Kariakoo, n.k.).
- **Uhamisho wa Stoo (Stock Transfers)**: Uhamisho wa bidhaa kutoka tawi moja kwenda jingine ukiwa na utoaji wa Dispatch Note / Waybill.

### 2. ⚡ POS Kaunta & Mauzo ya Haraka
- Kiolesura chepesi na cha kisasa kinachofanya kazi kwenye kompyuta, tablet, na simu za mkononi.
- Utafutaji wa haraka wa bidhaa kwa kutumia Barcode Scanner au Jina.
- Mfumo wa malipo mbalimbali: Pesa Taslimu (Cash), M-Pesa / TigoPesa / Airtel Money, Benki / CRDB / NMB, na Malipo ya Mikopo (Credit Ledger).
- Uchapishaji wa Risiti za EFD na Thermal (58mm / 80mm standard format).
- Kutuma risiti moja kwa moja kupitia WhatsApp kwa wateja.

### 3. 📦 Usimamizi wa Stoo & Ghala (Storekeeper & Inventory)
- Hesabu kamili ya bidhaa zilizopo (Stock In/Out) na viwango vya kutoa tahadhari (Low Stock Alerts).
- Upangaji wa bidhaa kwa Makundi (Categories) na Vitengo (Sub-Categories).
- Usimamizi wa Bechi (Batches) na Tarehe za Mwisho wa Matumizi (Expiry Tracking).
- Ukaguzi wa Bidhaa Zilizoharibika (Damages & Wastage) na Marejesho ya Wateja (Returns & Refunds).
- Upakuaji wa ripoti za hesabu na thamani ya stoo kwa mfumo wa CSV (Stock Valuation Export).

### 4. 👥 Usimamizi wa Wafanyakazi (Staff Management)
- Mgawanyo wa madaraka (Role-based permissions): Super Admin, Meneja wa Duka (Manager), Muuzaji (Cashier), na Mtunza Stoo (Storekeeper).
- Zamu na Mahudhurio ya Kila Siku (Shifts & Attendance).
- Mishahara na Posho za Wafanyakazi pamoja na utoaji wa hati za malipo (Payslips).

### 5. 💰 Fedha, Matumizi & Ripoti (Finance & Reports)
- Usimamizi wa Matumizi ya Kila Siku (Petty Cash & Expense Vouchers).
- Ripoti ya Kufunga Siku na Droo ya Pesa (Z-Report & Shift Reconciliation).
- Ufuatiliaji wa Madeni na Kumbukumbu za Wateja (Customer Credit Ledger) pamoja na vikumbusho vya SMS / WhatsApp.

### 6. 📱 Progressive Web App (PWA) & Upatikanaji Nje ya Mtandao
- Usakinishaji wa App moja kwa moja kwenye vifaa vya Android, iOS, Windows, na Mac (Add to Home Screen).
- Service Worker caching na ukurasa maalum wa hali ya nje ya mtandao (Offline fallback shell).
- Utambuzi wa kiotomatiki wa mtandao ukirejea.

### 7. 🌍 Mfumo wa Lugha Mbili (Bilingual Localization)
- Mfumo unaunga mkono lugha mbili: **Kiswahili 🇹🇿** na **English 🇬🇧**.
- Uwezo wa kubadili lugha papo hapo kupitia top bar au mipangilio ya mtumiaji.

---

## 🛠️ Teknolojia Zilizotumika (Tech Stack)

- **Backend Framework**: [Laravel 12+](https://laravel.com)
- **Language**: PHP 8.3+
- **Database**: MySQL 8.0+
- **Frontend / Styling**: Vanilla CSS, Bootstrap 5, Bootstrap Icons, Inter Typography
- **PWA**: Service Worker API, W3C Web App Manifest
- **Testing**: PHPUnit / Feature & Unit Test Suites (78 tests passing)

---

## 🚀 Jinsi ya Kuanza (Installation & Setup)

### 1. Pakua Mradi (Clone Repository)
```bash
git clone https://github.com/Sempaicassidy/mercanto.git
cd mercanto
```

### 2. Sakinisha Mahitaji (Install Dependencies)
```bash
composer install
npm install && npm run build
```

### 3. Sanidi Mazingira (.env Setup)
```bash
cp .env.example .env
php artisan key:generate
```

Hakikisha umeweka taarifa sahihi za database kwenye faili la `.env`:
```env
APP_NAME=Mercanto
APP_URL=http://localhost/e-duka/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e-duka
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Endesha Database Migrations & Seeders
```bash
php artisan migrate --seed
```

### 5. Fungua Mfumo (Run Development Server)
```bash
php artisan serve
```
Au fungua kupitia web server ya Apache/Nginx kwenye kivinjari:
`http://localhost/e-duka/public/login`

---

## 🔑 Akaunti za Kuingilia za Majaribio (Default Demo Accounts)

| Wadhifa (Role) | Jina la Mtumiaji / Barua Pepe | Nenosiri |
| :--- | :--- | :--- |
| **Super Admin (SaaS HQ)** | `admin@eduka.co.tz` | `password` |
| **Meneja wa Duka (Manager)** | `manager@eduka.co.tz` | `password` |
| **Muuzaji / Kaunta (Cashier)** | `cashier@eduka.co.tz` | `password` |
| **Mtunza Stoo (Storekeeper)** | `storekeeper@eduka.co.tz` | `password` |

---

## 🧪 Majaribio ya Mfumo (Automated Testing)

Kuendesha majaribio yote ya kiotomatiki:
```bash
php artisan test
```

---

## 📄 Leseni (License)

Mradi huu umesajiliwa chini ya leseni ya [MIT License](LICENSE).
