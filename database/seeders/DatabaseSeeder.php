<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchStock;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Damage;
use App\Models\Expense;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Shift;
use App\Models\StaffAttendance;
use App\Models\StaffSalary;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use App\Models\Supplier;
use App\Models\SupportTicket;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Admin (Global Platform Administrator)
        $superAdmin = User::create([
            'name' => 'Platform Super Admin',
            'email' => 'admin@eduka.co.tz',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'phone' => '+255 700 000 001',
            'status' => 'active',
        ]);

        // 2. Tenant 1: Retailer (Mangi Supermarket Ltd)
        $retailTenant = Tenant::create([
            'name' => 'Mangi Supermarket Ltd',
            'slug' => 'mangi-supermarket',
            'business_type' => 'retailer',
            'status' => 'active',
            'phone' => '+255 754 112 233',
            'email' => 'info@mangisupermarket.co.tz',
            'address' => 'Sinza Mori, Dar es Salaam',
            'tin_number' => '102-458-991',
            'currency' => 'TZS',
            'settings' => [
                'tax_rate' => 18,
                'allow_credit_sales' => true,
                'max_credit_limit' => 2000000,
            ],
        ]);

        // Branches for Retailer
        $mainBranch = Branch::create([
            'tenant_id' => $retailTenant->id,
            'name' => 'Main Branch (HQ)',
            'code' => 'HQ-01',
            'phone' => '+255 754 112 233',
            'address' => 'Sinza Mori, Dar es Salaam',
            'is_main' => true,
            'is_active' => true,
        ]);

        $arushaBranch = Branch::create([
            'tenant_id' => $retailTenant->id,
            'name' => 'Arusha Branch',
            'code' => 'AR-02',
            'phone' => '+255 754 888 111',
            'address' => 'Clock Tower, Arusha',
            'is_main' => false,
            'is_active' => true,
        ]);

        $mwanzaBranch = Branch::create([
            'tenant_id' => $retailTenant->id,
            'name' => 'Mwanza Branch',
            'code' => 'MW-03',
            'phone' => '+255 754 777 222',
            'address' => 'Nyamagana, Mwanza',
            'is_main' => false,
            'is_active' => true,
        ]);

        // Retailer Staff Users
        $manager = User::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'name' => 'Store Manager',
            'email' => 'manager@eduka.co.tz',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '+255 712 345 678',
            'status' => 'active',
        ]);

        $cashier = User::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'name' => 'Amina Cashier',
            'email' => 'cashier@eduka.co.tz',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'phone' => '+255 788 123 456',
            'status' => 'active',
        ]);

        $storekeeper = User::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'name' => 'Juma Storekeeper',
            'email' => 'storekeeper@eduka.co.tz',
            'password' => Hash::make('password'),
            'role' => 'storekeeper',
            'phone' => '+255 766 987 654',
            'status' => 'active',
        ]);

        // Categories
        $catGroceries = Category::create(['tenant_id' => $retailTenant->id, 'name' => 'Vyakula & Nafaka', 'code' => 'VYA', 'description' => 'Mchele, Unga, Sukari, n.k.']);
        $catDrinks = Category::create(['tenant_id' => $retailTenant->id, 'name' => 'Vinywaji & Maji', 'code' => 'VIN', 'description' => 'Maji ya chupa, soda na juisi']);
        $catHygiene = Category::create(['tenant_id' => $retailTenant->id, 'name' => 'Dawa & Usafi', 'code' => 'USA', 'description' => 'Sabuni, dawa ya meno, n.k.']);
        $catOils = Category::create(['tenant_id' => $retailTenant->id, 'name' => 'Mafuta & Viungo', 'code' => 'MAF', 'description' => 'Mafuta ya kupikia na viungo vya chakula']);

        // Retail Products
        $productsData = [
            ['name' => 'Mchele wa Kyela Super 5kg', 'cat' => $catGroceries->id, 'barcode' => '61640001001', 'sku' => 'MCH-05K', 'cost' => 14000, 'selling' => 17500, 'unit' => 'pcs', 'stock_hq' => 120, 'stock_ar' => 45],
            ['name' => 'Unga wa Sembe Azam 2kg', 'cat' => $catGroceries->id, 'barcode' => '61640001002', 'sku' => 'UNG-02K', 'cost' => 3800, 'selling' => 4600, 'unit' => 'pcs', 'stock_hq' => 200, 'stock_ar' => 80],
            ['name' => 'Sukari ya Kilombero 1kg', 'cat' => $catGroceries->id, 'barcode' => '61640001003', 'sku' => 'SUK-01K', 'cost' => 2800, 'selling' => 3200, 'unit' => 'kg', 'stock_hq' => 350, 'stock_ar' => 110],
            ['name' => 'Mafuta ya Kupikia Korie 3L', 'cat' => $catOils->id, 'barcode' => '61640001004', 'sku' => 'MAF-03L', 'cost' => 18500, 'selling' => 22000, 'unit' => 'litre', 'stock_hq' => 85, 'stock_ar' => 30],
            ['name' => 'Maji ya Uhai 1.5L (Box la 6)', 'cat' => $catDrinks->id, 'barcode' => '61640001005', 'sku' => 'MAJ-15B', 'cost' => 5000, 'selling' => 6500, 'unit' => 'box', 'stock_hq' => 140, 'stock_ar' => 60],
            ['name' => 'Sabuni ya Omo Multiactive 1kg', 'cat' => $catHygiene->id, 'barcode' => '61640001006', 'sku' => 'SAB-01K', 'cost' => 6200, 'selling' => 7800, 'unit' => 'pcs', 'stock_hq' => 90, 'stock_ar' => 40],
            ['name' => 'Chai ya Chai Bora 250g', 'cat' => $catGroceries->id, 'barcode' => '61640001007', 'sku' => 'CHA-250', 'cost' => 2100, 'selling' => 2800, 'unit' => 'pcs', 'stock_hq' => 160, 'stock_ar' => 50],
            ['name' => 'Maziwa ya Asas Fresh 500ml', 'cat' => $catDrinks->id, 'barcode' => '61640001008', 'sku' => 'MAZ-500', 'cost' => 1400, 'selling' => 1800, 'unit' => 'pcs', 'stock_hq' => 75, 'stock_ar' => 25],
        ];

        $createdProducts = [];
        foreach ($productsData as $item) {
            $p = Product::create([
                'tenant_id' => $retailTenant->id,
                'category_id' => $item['cat'],
                'name' => $item['name'],
                'barcode' => $item['barcode'],
                'sku' => $item['sku'],
                'cost_price' => $item['cost'],
                'selling_price' => $item['selling'],
                'wholesale_price' => $item['selling'] * 0.9,
                'min_alert_qty' => 10,
                'unit' => $item['unit'],
                'tax_rate' => 18.00,
                'is_active' => true,
            ]);

            // Branch stocks
            BranchStock::create(['tenant_id' => $retailTenant->id, 'branch_id' => $mainBranch->id, 'product_id' => $p->id, 'quantity' => $item['stock_hq'], 'shelf_location' => 'Shelf A-01']);
            BranchStock::create(['tenant_id' => $retailTenant->id, 'branch_id' => $arushaBranch->id, 'product_id' => $p->id, 'quantity' => $item['stock_ar'], 'shelf_location' => 'Shelf B-02']);
            BranchStock::create(['tenant_id' => $retailTenant->id, 'branch_id' => $mwanzaBranch->id, 'product_id' => $p->id, 'quantity' => intval($item['stock_hq'] * 0.4), 'shelf_location' => 'Shelf C-01']);

            $createdProducts[] = $p;
        }

        // Product Sub-units (Vipimo Vidogo vya Rejareja: Kilo 1, Nusu Kilo, Robo Kilo, Kibaba, Glasi, n.k.)
        // 1. Mchele wa Kyela Super 5kg ($createdProducts[0])
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[0]->id, 'unit_name' => 'Mfuko Mzima (5kg)', 'short_code' => '5kg', 'quantity_ratio' => 1.0000, 'cost_price' => 14000, 'selling_price' => 17500, 'barcode' => '61640001001-5K', 'is_default' => true]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[0]->id, 'unit_name' => 'Kilo 1', 'short_code' => '1kg', 'quantity_ratio' => 0.2000, 'cost_price' => 2800, 'selling_price' => 3800, 'barcode' => '61640001001-1K', 'is_default' => false]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[0]->id, 'unit_name' => 'Nusu Kilo (500g)', 'short_code' => '500g', 'quantity_ratio' => 0.1000, 'cost_price' => 1400, 'selling_price' => 1950, 'barcode' => '61640001001-05K', 'is_default' => false]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[0]->id, 'unit_name' => 'Robo Kilo (250g)', 'short_code' => '250g', 'quantity_ratio' => 0.0500, 'cost_price' => 700, 'selling_price' => 1000, 'barcode' => '61640001001-025K', 'is_default' => false]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[0]->id, 'unit_name' => 'Kibaba cha Mchele', 'short_code' => 'kibaba', 'quantity_ratio' => 0.1400, 'cost_price' => 1960, 'selling_price' => 2700, 'barcode' => '61640001001-KIB', 'is_default' => false]);

        // 2. Sukari ya Kilombero 1kg ($createdProducts[2])
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[2]->id, 'unit_name' => 'Kilo 1 Kamili', 'short_code' => '1kg', 'quantity_ratio' => 1.0000, 'cost_price' => 2800, 'selling_price' => 3200, 'barcode' => '61640001003-1K', 'is_default' => true]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[2]->id, 'unit_name' => 'Nusu Kilo (500g)', 'short_code' => '500g', 'quantity_ratio' => 0.5000, 'cost_price' => 1400, 'selling_price' => 1650, 'barcode' => '61640001003-05K', 'is_default' => false]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[2]->id, 'unit_name' => 'Robo Kilo (250g)', 'short_code' => '250g', 'quantity_ratio' => 0.2500, 'cost_price' => 700, 'selling_price' => 850, 'barcode' => '61640001003-025K', 'is_default' => false]);

        // 3. Mafuta ya Kupikia Korie 3L ($createdProducts[3])
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[3]->id, 'unit_name' => 'Dumu Zima (3L)', 'short_code' => '3L', 'quantity_ratio' => 1.0000, 'cost_price' => 18500, 'selling_price' => 22000, 'barcode' => '61640001004-3L', 'is_default' => true]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[3]->id, 'unit_name' => 'Lita 1 (1L)', 'short_code' => '1L', 'quantity_ratio' => 0.3333, 'cost_price' => 6167, 'selling_price' => 7800, 'barcode' => '61640001004-1L', 'is_default' => false]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[3]->id, 'unit_name' => 'Nusu Lita (500ml)', 'short_code' => '500ml', 'quantity_ratio' => 0.1667, 'cost_price' => 3083, 'selling_price' => 4000, 'barcode' => '61640001004-500ML', 'is_default' => false]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[3]->id, 'unit_name' => 'Robo Lita (250ml)', 'short_code' => '250ml', 'quantity_ratio' => 0.0833, 'cost_price' => 1542, 'selling_price' => 2100, 'barcode' => '61640001004-250ML', 'is_default' => false]);
        ProductUnit::create(['tenant_id' => $retailTenant->id, 'product_id' => $createdProducts[3]->id, 'unit_name' => 'Kibaba cha Mafuta (Glasi)', 'short_code' => 'glasi', 'quantity_ratio' => 0.0500, 'cost_price' => 925, 'selling_price' => 1300, 'barcode' => '61640001004-GLS', 'is_default' => false]);

        // Retail Customers
        $customer1 = Customer::create([
            'tenant_id' => $retailTenant->id,
            'name' => 'Rashid Mussa (Kipanya Cafe)',
            'phone' => '+255 713 001 002',
            'email' => 'rashid@kipanya.co.tz',
            'customer_type' => 'wholesale',
            'loyalty_points' => 340,
            'credit_limit' => 1500000,
            'balance_due' => 240000,
        ]);

        $customer2 = Customer::create([
            'tenant_id' => $retailTenant->id,
            'name' => 'Mama Salma Retail',
            'phone' => '+255 784 990 011',
            'email' => 'salma@gmail.com',
            'customer_type' => 'retail',
            'loyalty_points' => 120,
            'credit_limit' => 300000,
            'balance_due' => 0,
        ]);

        // Suppliers
        $supAzam = Supplier::create([
            'tenant_id' => $retailTenant->id,
            'name' => 'Said Salim Bakhresa & Co Ltd',
            'company_name' => 'Azam Group',
            'phone' => '+255 22 286 1120',
            'email' => 'sales@azam-group.com',
            'tin_number' => '100-200-300',
            'address' => 'Vingunguti Industrial Area, Dar es Salaam',
            'outstanding_balance' => 0,
        ]);

        $supKorie = Supplier::create([
            'tenant_id' => $retailTenant->id,
            'name' => 'Murzah Wilmar East Africa',
            'company_name' => 'Korie Edible Oils',
            'phone' => '+255 22 286 5432',
            'email' => 'orders@murzah.co.tz',
            'tin_number' => '100-400-500',
            'address' => 'Nyerere Road, Dar es Salaam',
            'outstanding_balance' => 450000,
        ]);

        // Cashier Shift & Sales
        $shift = Shift::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'user_id' => $cashier->id,
            'shift_code' => 'SHF-2026-0924-01',
            'opening_float' => 50000,
            'cash_sales' => 385000,
            'digital_sales' => 245000,
            'difference' => 0,
            'status' => 'open',
            'opened_at' => now()->subHours(5),
        ]);

        // Sample POS Sale 1
        $sale1 = Sale::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'shift_id' => $shift->id,
            'cashier_id' => $cashier->id,
            'customer_id' => $customer2->id,
            'invoice_no' => 'INV-2026-00101',
            'subtotal' => 35000,
            'discount' => 1000,
            'tax' => 5186,
            'grand_total' => 34000,
            'paid_amount' => 40000,
            'change_amount' => 6000,
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'status' => 'completed',
            'notes' => 'Counter sale - receipt issued',
        ]);

        SaleItem::create(['sale_id' => $sale1->id, 'product_id' => $createdProducts[0]->id, 'quantity' => 2, 'unit_price' => 17500, 'cost_price' => 14000, 'discount' => 1000, 'subtotal' => 34000]);

        // Sample POS Sale 2 (M-Pesa)
        $sale2 = Sale::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'shift_id' => $shift->id,
            'cashier_id' => $cashier->id,
            'customer_id' => $customer1->id,
            'invoice_no' => 'INV-2026-00102',
            'subtotal' => 44000,
            'discount' => 0,
            'tax' => 6711,
            'grand_total' => 44000,
            'paid_amount' => 44000,
            'change_amount' => 0,
            'payment_method' => 'mpesa',
            'payment_status' => 'paid',
            'status' => 'completed',
            'notes' => 'M-Pesa Ref: QK789012XZ',
        ]);

        SaleItem::create(['sale_id' => $sale2->id, 'product_id' => $createdProducts[3]->id, 'quantity' => 2, 'unit_price' => 22000, 'cost_price' => 18500, 'discount' => 0, 'subtotal' => 44000]);

        // Stock Transfer
        $transfer = StockTransfer::create([
            'tenant_id' => $retailTenant->id,
            'transfer_no' => 'TRF-2026-001',
            'from_branch_id' => $mainBranch->id,
            'to_branch_id' => $arushaBranch->id,
            'status' => 'completed',
            'initiated_by' => $storekeeper->id,
            'approved_by' => $manager->id,
            'notes' => 'Restock for Arusha Branch end of week',
        ]);

        StockTransferItem::create(['stock_transfer_id' => $transfer->id, 'product_id' => $createdProducts[1]->id, 'quantity_sent' => 50, 'quantity_received' => 50]);

        // Expenses
        Expense::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'category' => 'utility',
            'title' => 'TANESCO LUKU Electricity - Main Meter',
            'amount' => 150000,
            'payment_method' => 'mpesa',
            'recorded_by' => $manager->id,
            'expense_date' => now()->toDateString(),
            'notes' => 'Token: 2445-6677-8899',
        ]);

        Expense::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'category' => 'transport',
            'title' => 'Usafirishaji wa Mzigo kutoka Kariakoo',
            'amount' => 45000,
            'payment_method' => 'cash',
            'recorded_by' => $storekeeper->id,
            'expense_date' => now()->subDay()->toDateString(),
        ]);

        // Damages
        Damage::create([
            'tenant_id' => $retailTenant->id,
            'branch_id' => $mainBranch->id,
            'product_id' => $createdProducts[4]->id,
            'quantity' => 2,
            'reason' => 'broken',
            'recorded_by' => $storekeeper->id,
            'total_loss' => 10000,
            'notes' => 'Chupa 2 zilianguka wakati wa kupanga stoo',
        ]);

        // Staff Attendance & Salary
        StaffAttendance::create(['tenant_id' => $retailTenant->id, 'branch_id' => $mainBranch->id, 'user_id' => $cashier->id, 'date' => now()->toDateString(), 'check_in' => '07:45:00', 'status' => 'present', 'remarks' => 'Akafika mapema']);
        StaffAttendance::create(['tenant_id' => $retailTenant->id, 'branch_id' => $mainBranch->id, 'user_id' => $storekeeper->id, 'date' => now()->toDateString(), 'check_in' => '07:55:00', 'status' => 'present']);

        StaffSalary::create([
            'tenant_id' => $retailTenant->id,
            'user_id' => $cashier->id,
            'month' => 9,
            'year' => 2026,
            'base_salary' => 450000,
            'allowances' => 50000,
            'deductions' => 10000,
            'net_salary' => 490000,
            'payment_status' => 'paid',
            'payment_method' => 'NMB Bank',
            'payment_date' => now()->toDateString(),
        ]);

        // ========================================================
        // 3. Tenant 2: Wholesaler / Supplier (Kariakoo Wholesale Distributors)
        // ========================================================
        $supplierTenant = Tenant::create([
            'name' => 'Kariakoo Wholesale Distributors Ltd',
            'slug' => 'kariakoo-wholesalers',
            'business_type' => 'supplier',
            'status' => 'active',
            'phone' => '+255 765 889 900',
            'email' => 'sales@kariakoowholesale.co.tz',
            'address' => 'Swahili / Msimbazi St, Kariakoo, Dar es Salaam',
            'tin_number' => '104-555-888',
            'currency' => 'TZS',
            'settings' => [
                'min_order_amount' => 500000,
                'offer_credit_terms' => true,
                'default_credit_days' => 30,
            ],
        ]);

        $depotBranch = Branch::create([
            'tenant_id' => $supplierTenant->id,
            'name' => 'Kariakoo Central Store',
            'code' => 'KKO-01',
            'phone' => '+255 765 889 900',
            'address' => 'Plot 45, Swahili Street, Kariakoo',
            'is_main' => true,
            'is_active' => true,
        ]);

        $wholesaleManager = User::create([
            'tenant_id' => $supplierTenant->id,
            'branch_id' => $depotBranch->id,
            'name' => 'Haji Wholesale Manager',
            'email' => 'wholesale@eduka.co.tz',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '+255 765 889 901',
            'status' => 'active',
        ]);

        $wholesaleCashier = User::create([
            'tenant_id' => $supplierTenant->id,
            'branch_id' => $depotBranch->id,
            'name' => 'Kariakoo Wholesale Cashier',
            'email' => 'wholesale_cashier@eduka.co.tz',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'phone' => '+255 765 889 902',
            'status' => 'active',
        ]);

        $wholesaleStorekeeper = User::create([
            'tenant_id' => $supplierTenant->id,
            'branch_id' => $depotBranch->id,
            'name' => 'Kariakoo Wholesale Storekeeper',
            'email' => 'wholesale_store@eduka.co.tz',
            'password' => Hash::make('password'),
            'role' => 'storekeeper',
            'phone' => '+255 765 889 903',
            'status' => 'active',
        ]);

        // Supplier Bulk Wholesale Catalog (Standard Category & Products)
        $bulkCat = Category::create(['tenant_id' => $supplierTenant->id, 'name' => 'Mizigo ya Jumla (Bulk)', 'code' => 'BLK', 'description' => 'Mikatoni na magunia kwa ajili ya maduka ya rejareja']);

        $bulkProduct1 = Product::create([
            'tenant_id' => $supplierTenant->id,
            'category_id' => $bulkCat->id,
            'name' => 'Katoni ya Unga wa Azam Sembe (2kg x 12 Pcs)',
            'barcode' => '61690001001',
            'sku' => 'BLK-UNG-12',
            'cost_price' => 40000,
            'selling_price' => 45000,
            'wholesale_price' => 43500,
            'min_alert_qty' => 50,
            'unit' => 'carton',
            'tax_rate' => 18.00,
            'is_active' => true,
        ]);

        $bulkProduct2 = Product::create([
            'tenant_id' => $supplierTenant->id,
            'category_id' => $bulkCat->id,
            'name' => 'Gunia la Sukari Kilombero 50kg',
            'barcode' => '61690001002',
            'sku' => 'BLK-SUK-50',
            'cost_price' => 125000,
            'selling_price' => 140000,
            'wholesale_price' => 137000,
            'min_alert_qty' => 20,
            'unit' => 'bag',
            'tax_rate' => 18.00,
            'is_active' => true,
        ]);

        BranchStock::create(['tenant_id' => $supplierTenant->id, 'branch_id' => $depotBranch->id, 'product_id' => $bulkProduct1->id, 'quantity' => 850, 'shelf_location' => 'Depot Bay-01']);
        BranchStock::create(['tenant_id' => $supplierTenant->id, 'branch_id' => $depotBranch->id, 'product_id' => $bulkProduct2->id, 'quantity' => 320, 'shelf_location' => 'Depot Bay-02']);

        // 4. Additional SaaS Tenants for Platform Overview
        $pharmacyTenant = Tenant::create([
            'name' => 'Afya Pharmacy & Healthcare Center',
            'slug' => 'afya-pharmacy',
            'business_type' => 'retailer',
            'status' => 'active',
            'phone' => '+255 713 555 777',
            'email' => 'admin@afyapharmacy.co.tz',
            'address' => 'Morogoro Road, Ubungo, Dar es Salaam',
            'tin_number' => '104-998-332',
            'currency' => 'TZS',
            'settings' => ['tax_rate' => 18, 'allow_credit_sales' => false],
        ]);

        $pharmacyBranch = Branch::create([
            'tenant_id' => $pharmacyTenant->id,
            'name' => 'Ubungo Plaza Dispensary',
            'code' => 'UB-01',
            'phone' => '+255 713 555 777',
            'address' => 'Ubungo Plaza, Ground Floor',
            'is_main' => true,
            'is_active' => true,
        ]);

        User::create([
            'tenant_id' => $pharmacyTenant->id,
            'branch_id' => $pharmacyBranch->id,
            'name' => 'Dr. Kelvin Mndeme',
            'email' => 'kelvin@afyapharmacy.co.tz',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '+255 713 555 777',
            'status' => 'active',
        ]);

        $hardwareTenant = Tenant::create([
            'name' => 'Dar Hardware & Building Materials Ltd',
            'slug' => 'dar-hardware',
            'business_type' => 'hybrid',
            'status' => 'trial',
            'phone' => '+255 784 444 888',
            'email' => 'sales@darhardware.co.tz',
            'address' => 'Nyerere Road, Gerezani, Dar es Salaam',
            'tin_number' => '109-771-445',
            'currency' => 'TZS',
            'settings' => ['tax_rate' => 18, 'allow_credit_sales' => true],
        ]);

        Branch::create([
            'tenant_id' => $hardwareTenant->id,
            'name' => 'Gerezani Main Yard',
            'code' => 'GZ-01',
            'phone' => '+255 784 444 888',
            'address' => 'Gerezani, Ilala',
            'is_main' => true,
            'is_active' => true,
        ]);

        // 5. SaaS Contracts & Store Leases
        Contract::create([
            'tenant_id' => $retailTenant->id,
            'contract_number' => 'CNT-2026-001',
            'title' => 'Annual Multi-Branch SaaS Lease Agreement',
            'type' => 'lease',
            'billing_cycle' => 'annually',
            'amount' => 1800000,
            'currency' => 'TZS',
            'start_date' => now()->startOfYear(),
            'end_date' => now()->endOfYear(),
            'status' => 'active',
            'payment_status' => 'paid',
            'sla_terms' => '99.9% uptime SLA, 3 Branch licenses, Daily automated backups, Dedicated customer support.',
            'notes' => 'Contract renewed successfully for 2026 calendar year.',
        ]);

        Contract::create([
            'tenant_id' => $supplierTenant->id,
            'contract_number' => 'CNT-2026-002',
            'title' => 'Enterprise Supply Chain & POS License',
            'type' => 'subscription',
            'billing_cycle' => 'annually',
            'amount' => 3600000,
            'currency' => 'TZS',
            'start_date' => now()->subMonths(2),
            'end_date' => now()->addMonths(10),
            'status' => 'active',
            'payment_status' => 'paid',
            'sla_terms' => 'B2B Wholesale portal, Unlimited branch transfers, EFD fiscal integration, 24/7 priority SLA.',
            'notes' => 'Bulk distributor custom enterprise tier.',
        ]);

        Contract::create([
            'tenant_id' => $pharmacyTenant->id,
            'contract_number' => 'CNT-2026-003',
            'title' => 'Pharmacy Retail Cloud POS Lease',
            'type' => 'lease',
            'billing_cycle' => 'monthly',
            'amount' => 150000,
            'currency' => 'TZS',
            'start_date' => now()->subMonths(3),
            'end_date' => now()->addMonths(9),
            'status' => 'active',
            'payment_status' => 'paid',
            'sla_terms' => 'Standard cloud uptime, single terminal branch, expiry date alerts.',
            'notes' => 'Monthly billing paid via Mobile Money automatically.',
        ]);

        Contract::create([
            'tenant_id' => $hardwareTenant->id,
            'contract_number' => 'CNT-2026-004',
            'title' => 'Hardware Store 3-Month Trial Lease',
            'type' => 'lease',
            'billing_cycle' => 'monthly',
            'amount' => 180000,
            'currency' => 'TZS',
            'start_date' => now()->subDays(20),
            'end_date' => now()->addDays(10),
            'status' => 'grace_period',
            'payment_status' => 'pending',
            'sla_terms' => 'Trial license period with 2 terminals support.',
            'notes' => 'Tenant considering upgrade to annual plan before expiry.',
        ]);

        // 6. SaaS Customer Support Tickets
        SupportTicket::create([
            'tenant_id' => $retailTenant->id,
            'user_id' => $manager->id,
            'ticket_number' => 'TCK-2026-001',
            'subject' => 'Uunganishaji wa mashine ya risiti ya Bluetooth kwenye tawi la Arusha',
            'description' => 'Meneja wa tawi la Arusha anaomba msaada wa kusanidi kichapishi cha risiti (POS Bluetooth Thermal Printer) kiweze kuchapisha risiti moja kwa moja kutoka kwenye kivinjari cha simu.',
            'category' => 'pos_hardware',
            'priority' => 'high',
            'status' => 'in_progress',
            'assigned_to' => $superAdmin->id,
        ]);

        SupportTicket::create([
            'tenant_id' => $supplierTenant->id,
            'user_id' => $wholesaleManager->id,
            'ticket_number' => 'TCK-2026-002',
            'subject' => 'Maombi ya kuweka punguzo maalum la bei ya jumla kwa wateja wa mikoani',
            'description' => 'Tunaomba kuboreshewa kipengele cha orodha ya bei (Tiered Wholesale Price Matrix) ili kuwezesha wateja wetu wanaonunua zaidi ya katoni 50 kupata bei ya TSh 41,000 badala ya TSh 43,500.',
            'category' => 'feature_request',
            'priority' => 'medium',
            'status' => 'resolved',
            'assigned_to' => $superAdmin->id,
            'resolution_notes' => 'Kipengele cha bei za daraja (Tiered Pricing) kimewashwa kwenye moduli ya bidhaa za jumla.',
            'resolved_at' => now()->subDays(1),
        ]);

        SupportTicket::create([
            'tenant_id' => $pharmacyTenant->id,
            'ticket_number' => 'TCK-2026-003',
            'subject' => 'Swali kuhusu ripoti ya kodi (TRA VAT) na utoaji wa EFD token',
            'description' => 'Tunaomba mwongozo wa kuunganisha token ya VFD/EFD ili risiti zetu ziwe na msimbo wa QR wa Mamlaka ya Mapato (TRA).',
            'category' => 'billing',
            'priority' => 'urgent',
            'status' => 'open',
        ]);

        SupportTicket::create([
            'tenant_id' => $hardwareTenant->id,
            'ticket_number' => 'TCK-2026-004',
            'subject' => 'Msaada wa mafunzo ya watunza stoo kwa ajili ya hesabu ya mwisho wa robo mwaka',
            'description' => 'Tunahitaji kipindi kifupi cha mafunzo kwa mtunza stoo mkuu kuhusu jinsi ya kufanya ukaguzi wa stoo (Stock Audit) na kuandika bidhaa zilizoharibika (Damages).',
            'category' => 'training',
            'priority' => 'low',
            'status' => 'open',
        ]);
    }
}
