<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiptPrintingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test POS Cashier page contains official EFD receipt modal and thermal print engine.
     */
    public function test_pos_page_contains_efd_receipt_modal_and_print_engine(): void
    {
        $response = $this->get('/pos');
        $response->assertStatus(200);

        // Official EFD Header & Fiscal Info matching user's reference
        $response->assertSee('Resiti Halisi ya EFD (TRA Compliant)');
        $response->assertSee('printReceiptArea');
        $response->assertSee('TIN: 142-998-310 | VRN: 40019283-Z');
        $response->assertSee('EFD Serial: TZ-EFD-88219');
        $response->assertSee('KODI YA ONGEZEKO LA THAMANI (TRA EFD VERIFIED)');
        $response->assertSee('ASANTE NA KARIBU TENA');

        // Thermal print engine & action buttons
        $response->assertSee('printThermalReceiptDirect');
        $response->assertSee('btnPrintReceipt');
        $response->assertSee('btnReceiptNewSale');
        $response->assertSee('Chapisha Resiti');
        $response->assertSee('Mauzo Mapya');

        // Receipts history modal
        $response->assertSee('receiptsHistoryModal');
        $response->assertSee('Historia ya Resiti za Leo');
    }

    /**
     * Test Manager Dashboard has receipt preview/print actions for recent transactions.
     */
    public function test_manager_dashboard_contains_efd_receipt_modal_and_view_actions(): void
    {
        $response = $this->get('/manager/dashboard');
        $response->assertStatus(200);

        // Has receipt view buttons and dataset
        $response->assertSee('view-dashboard-receipt-btn');
        $response->assertSee('recentSalesData');
        $response->assertSee('receiptModal');
        $response->assertSee('printThermalReceiptDirect');
        $response->assertSee('Resiti Halisi ya EFD (TRA Compliant)');
    }

    /**
     * Test Manager Shifts page has thermal Z-Report preview and direct thermal printing.
     */
    public function test_manager_shifts_contains_thermal_z_report_and_print_engine(): void
    {
        $response = $this->get('/manager/shifts');
        $response->assertStatus(200);

        // Z-report modal with thermal print driver
        $response->assertSee('zReportReceiptArea');
        $response->assertSee('btnPrintZReport');
        $response->assertSee('DAILY CLOSING Z-REPORT');
        $response->assertSee('printThermalReceiptDirect');
    }

    /**
     * Test Manager Returns page has thermal Credit Note / Voucher and direct thermal printing.
     */
    public function test_manager_returns_contains_thermal_credit_note_and_print_engine(): void
    {
        $response = $this->get('/manager/returns');
        $response->assertStatus(200);

        // Credit note / Voucher modal with thermal print driver
        $response->assertSee('voucherReceiptPrintArea');
        $response->assertSee('btnPrintVoucher');
        $response->assertSee('TRA CREDIT NOTE / STORE VOUCHER');
        $response->assertSee('printThermalReceiptDirect');
    }
}
