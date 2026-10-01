<!-- EFD Thermal Receipt Modal (TRA Compliant) -->
<div class="modal-overlay" id="receiptModal" role="dialog" aria-modal="true" aria-labelledby="receiptModalTitle">
    <div class="modal-box" style="max-width: 440px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);">
        <!-- Modal Header -->
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom no-print" style="background: #ffffff;">
            <span id="receiptModalTitle" style="font-size:0.88rem; font-weight:700; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                <i class="bi bi-receipt-cutoff text-primary" style="font-size: 1.1rem;"></i> Resiti Halisi ya EFD (TRA Compliant)
            </span>
            <button type="button" class="btn-close" id="btnCloseReceiptModal" aria-label="Funga Resiti"></button>
        </div>
        
        <!-- Thermal Receipt Paper Box (Matches Screenshot 100%) -->
        <div id="printReceiptArea" class="thermal-receipt-paper" style="background:#ffffff; color:#000000; padding:22px 18px; font-family:'Courier New', Courier, monospace; font-size:12px; line-height:1.35; max-height:68vh; overflow-y:auto;">
            <!-- Store Header -->
            <div class="text-center mb-3">
                <h5 id="receiptStoreName" style="margin:0; font-weight:800; font-size:15px; letter-spacing:0.5px; color:#000000;">
                    {{ session('tenant_name') ? strtoupper(session('tenant_name')) : 'MERCANTO SUPERMARKET & WHOLESALE' }}
                </h5>
                <div id="receiptBranchAddress" style="font-size:11px;">
                    {{ session('branch_name') ? session('branch_name') . ', ' : 'Kariakoo Branch, ' }}Msimbazi Street
                </div>
                <div style="font-size:11px;">Dar es Salaam, Tanzania</div>
                <div style="font-size:11px;">Simu: +255 754 123 456</div>
                <div style="border-top:1px dashed #000; margin:6px 0;"></div>
                <div style="font-size:11px; font-weight:700;">TIN: 142-998-310 | VRN: 40019283-Z</div>
                <div style="font-size:11px;">EFD Serial: TZ-EFD-88219</div>
            </div>

            <!-- Receipt Meta Information -->
            <div style="font-size:11px; margin-bottom:6px;">
                <div class="d-flex justify-content-between">
                    <span>Resiti No: <strong id="receiptModalNumber">#EDK-20498</strong></span>
                    <span id="receiptModalDateTime">27/09/2026 09:56 PM</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Mhudumu: <strong id="receiptModalCashier">{{ session('user_name', 'Asha Mwamba') }}</strong></span>
                    <span>Terminal: <strong id="receiptModalTerminal">POS-01</strong></span>
                </div>
                <div>Mteja: <strong id="receiptModalCustomer">Walk-in Retail</strong></div>
            </div>

            <!-- Table Header -->
            <div style="border-top:1px dashed #000; border-bottom:1px dashed #000; padding:4px 0; margin-bottom:6px;">
                <div class="d-flex justify-content-between" style="font-weight:700; font-size:10px;">
                    <span style="width:48%;">BIDHAA</span>
                    <span style="width:24%; text-align:center;">IDADI</span>
                    <span style="width:28%; text-align:right;">JUMLA</span>
                </div>
            </div>

            <!-- Items List (Dynamically Injected) -->
            <div id="receiptModalItems" style="font-size:11px;">
                <div class="d-flex justify-content-between mb-1">
                    <span style="width:48%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Coca-Cola 500ml</span>
                    <span style="width:24%; text-align:center;">4 &times; 1,500</span>
                    <span style="width:28%; text-align:right;" class="font-monospace">6,000</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="width:48%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Milk Packet 1L</span>
                    <span style="width:24%; text-align:center;">5 &times; 3,200</span>
                    <span style="width:28%; text-align:right;" class="font-monospace">16,000</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="width:48%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Dishwashing Liquid</span>
                    <span style="width:24%; text-align:center;">10 &times; 4,800</span>
                    <span style="width:28%; text-align:right;" class="font-monospace">48,000</span>
                </div>
            </div>

            <!-- Subtotals & Taxes -->
            <div style="border-top:1px dashed #000; margin-top:6px; padding-top:4px; font-size:11px;">
                <div class="d-flex justify-content-between">
                    <span>Jumla Ndogo (Subtotal):</span>
                    <span id="receiptModalSubtotal" class="font-monospace">TSh 70,000</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>VAT (18% Imelipwa):</span>
                    <span id="receiptModalTax" class="font-monospace">TSh 4,200</span>
                </div>
                <div class="d-flex justify-content-between" id="receiptFeeRow">
                    <span>Ada ya Huduma:</span>
                    <span id="receiptModalFee" class="font-monospace">TSh 10,000</span>
                </div>
                <div class="d-flex justify-content-between" style="font-size:13px; font-weight:800; border-top:1px solid #000; margin-top:4px; padding-top:4px;">
                    <span>JUMLA KUU:</span>
                    <span id="receiptModalTotal" class="font-monospace">TSh 80,000</span>
                </div>
            </div>

            <!-- Payment Details -->
            <div style="border-top:1px dashed #000; margin-top:6px; padding-top:4px; font-size:11px;">
                <div class="d-flex justify-content-between">
                    <span>Njia ya Malipo:</span>
                    <strong id="receiptModalPaymentMode">Card</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Pesa Iliyotolewa:</span>
                    <span id="receiptModalTendered" class="font-monospace">TSh 80,000</span>
                </div>
                <div class="d-flex justify-content-between" style="font-weight:700;">
                    <span>Chenji:</span>
                    <span id="receiptModalChange" class="font-monospace" style="color:#059669;">TSh 0</span>
                </div>
            </div>

            <!-- TRA Verification Footer & Barcode -->
            <div class="text-center mt-3 pt-2" style="border-top:1px dashed #000; font-size:10px;">
                <div style="font-weight:700; margin-bottom:2px;">KODI YA ONGEZEKO LA THAMANI (TRA EFD VERIFIED)</div>
                <div>Uthibitisho: <span id="receiptModalFiscalCode">9A48-E71B-33C9-92F1</span></div>
                <div style="margin:4px 0; letter-spacing:1.5px; font-size:9px; font-family:monospace; font-weight:bold;">[ ||||||||||||||||||||||||||||||||||||||||||| ]</div>
                <div style="font-weight:700; font-size:11px; margin-top:3px;">*** ASANTE NA KARIBU TENA! ***</div>
            </div>
        </div>

        <!-- Modal Action Footer (No-print) -->
        <div class="d-flex gap-2 p-3 border-top no-print" style="background:#f8fafc;">
            <button type="button" class="btn btn-outline-secondary flex-fill btn-sm py-2 fw-semibold" id="btnReceiptNewSale" style="border-radius:10px; font-size:0.85rem;">
                <i class="bi bi-arrow-repeat me-1"></i> Mauzo Mapya
            </button>
            <button type="button" class="btn btn-primary flex-fill btn-sm py-2 fw-semibold" id="btnPrintReceipt" style="border-radius:10px; font-size:0.85rem; background:#0d6efd; border-color:#0d6efd;">
                <i class="bi bi-printer me-1"></i> Chapisha Resiti
            </button>
        </div>
    </div>
</div>

<!-- Print Styles & Thermal Engine Script -->
<style>
    /* Standalone overlay styles for pages lacking built-in modal CSS */
    #receiptModal.modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        padding: 1rem;
    }
    #receiptModal.modal-overlay.show {
        display: flex !important;
    }
    #receiptModal .modal-box {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        position: relative;
        animation: receiptModalFadeIn 0.2s ease-out;
    }
    @keyframes receiptModalFadeIn {
        from { opacity: 0; transform: scale(0.96) translateY(8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* Thermal Print CSS for standard window.print() fallback */
    @media print {
        @page {
            size: 80mm auto;
            margin: 0;
        }
        body {
            background: #ffffff !important;
            color: #000000 !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        /* Hide everything on page except modal-box */
        body > *:not(.modal-overlay.show) {
            display: none !important;
        }
        .modal-overlay.show {
            position: static !important;
            display: block !important;
            background: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 78mm !important;
        }
        .modal-box {
            border: none !important;
            box-shadow: none !important;
            width: 78mm !important;
            max-width: 78mm !important;
            margin: 0 auto !important;
            padding: 0 !important;
            background: #ffffff !important;
        }
        .no-print, header, nav, aside, footer, .sidebar, .top-header {
            display: none !important;
        }
        .thermal-receipt-paper {
            width: 78mm !important;
            max-height: none !important;
            overflow: visible !important;
            padding: 6mm 3mm !important;
            margin: 0 auto !important;
            font-family: 'Courier New', Courier, monospace !important;
            color: #000000 !important;
            background: #ffffff !important;
            font-size: 11px !important;
        }
    }
</style>

<script>
    /**
     * Isolated Thermal Print Engine.
     * Injects the receipt into an isolated, clean invisible iframe with 80mm roll dimensions.
     * Prevents browser headers, blank pages, and styling collisions.
     */
    function printThermalReceiptDirect(targetId) {
        const element = document.getElementById(targetId || 'printReceiptArea');
        if (!element) return;

        let printFrame = document.getElementById('thermalReceiptFrame');
        if (!printFrame) {
            printFrame = document.createElement('iframe');
            printFrame.id = 'thermalReceiptFrame';
            printFrame.name = 'thermalReceiptFrame';
            printFrame.style.position = 'fixed';
            printFrame.style.right = '0';
            printFrame.style.bottom = '0';
            printFrame.style.width = '0';
            printFrame.style.height = '0';
            printFrame.style.border = '0';
            printFrame.style.visibility = 'hidden';
            document.body.appendChild(printFrame);
        }

        const receiptHtml = element.innerHTML;
        const frameDoc = printFrame.contentWindow.document;

        frameDoc.open();
        const styleRules = '@page{size:80mm auto;margin:0;}'
            + '@media print{html,body{width:78mm !important;margin:0 auto !important;padding:4mm 3mm !important;background:#ffffff !important;color:#000000 !important;}}'
            + 'body{margin:0 auto;padding:6px 3px;width:78mm;font-family:\'Courier New\',Courier,monospace;font-size:11px;line-height:1.35;color:#000000;background:#ffffff;box-sizing:border-box;-webkit-print-color-adjust:exact;print-color-adjust:exact;}'
            + '.text-center{text-align:center;}.d-flex{display:flex;}.justify-content-between{justify-content:space-between;}.align-items-center{align-items:center;}'
            + '.font-monospace{font-family:\'Courier New\',Courier,monospace;}strong{font-weight:700;}h5{margin:0;font-size:14px;font-weight:800;letter-spacing:0.5px;}div,span{box-sizing:border-box;}';

        frameDoc.write('<!DOCTYPE html><html><' + 'head><meta charset="utf-8"><title>Resiti - Mercanto EFD</title><style>' + styleRules + '</style></' + 'head><body>' + receiptHtml + '</body></html>');
        frameDoc.close();

        // Print iframe after render
        setTimeout(function() {
            try {
                printFrame.contentWindow.focus();
                printFrame.contentWindow.print();
            } catch (e) {
                console.warn('Iframe print failed, falling back to window.print():', e);
                window.print();
            }
        }, 220);
    }

    /**
     * Global helper to open and populate the official EFD receipt modal.
     */
    window.openEfdReceipt = function(data) {
        if (!data) data = {};
        
        if (data.receiptNumber) $('#receiptModalNumber').text(data.receiptNumber);
        if (data.dateTime) $('#receiptModalDateTime').text(data.dateTime);
        if (data.cashier) $('#receiptModalCashier').text(data.cashier);
        if (data.terminal) $('#receiptModalTerminal').text(data.terminal);
        if (data.customer) $('#receiptModalCustomer').text(data.customer);
        if (data.storeName) $('#receiptStoreName').text(data.storeName);
        if (data.branchAddress) $('#receiptBranchAddress').text(data.branchAddress);

        // Format items
        if (data.items && Array.isArray(data.items) && data.items.length > 0) {
            let html = '';
            data.items.forEach(function(item) {
                const qtyPrice = (item.qty || 1) + ' &times; ' + Number(item.price || 0).toLocaleString();
                html += `
                    <div class="d-flex justify-content-between mb-1">
                        <span style="width:48%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${item.name}</span>
                        <span style="width:24%; text-align:center;">${qtyPrice}</span>
                        <span style="width:28%; text-align:right;" class="font-monospace">${Number(item.total || 0).toLocaleString()}</span>
                    </div>
                `;
            });
            $('#receiptModalItems').html(html);
        }

        // Totals
        if (data.subtotal !== undefined) $('#receiptModalSubtotal').text('TSh ' + Number(data.subtotal).toLocaleString());
        if (data.tax !== undefined) $('#receiptModalTax').text('TSh ' + Number(data.tax).toLocaleString());
        if (data.fee !== undefined && Number(data.fee) > 0) {
            $('#receiptFeeRow').show();
            $('#receiptModalFee').text('TSh ' + Number(data.fee).toLocaleString());
        } else if (data.fee === 0 || data.fee === null) {
            $('#receiptFeeRow').hide();
        }
        if (data.total !== undefined) $('#receiptModalTotal').text('TSh ' + Number(data.total).toLocaleString());

        // Payments
        if (data.paymentMode) $('#receiptModalPaymentMode').text(data.paymentMode);
        if (data.tendered !== undefined) $('#receiptModalTendered').text('TSh ' + Number(data.tendered).toLocaleString());
        if (data.change !== undefined) $('#receiptModalChange').text('TSh ' + Number(data.change).toLocaleString());
        if (data.fiscalCode) $('#receiptModalFiscalCode').text(data.fiscalCode);

        // Action button behavior
        if (data.hideNewSale) {
            $('#btnReceiptNewSale').html('<i class="bi bi-x-circle me-1"></i> Funga').off('click').on('click', function() {
                $('#receiptModal').removeClass('show');
            });
        } else {
            $('#btnReceiptNewSale').html('<i class="bi bi-arrow-repeat me-1"></i> Mauzo Mapya').off('click').on('click', function() {
                $('#receiptModal').removeClass('show');
                if (typeof data.onNewSale === 'function') {
                    data.onNewSale();
                }
            });
        }

        // Show modal
        $('#receiptModal').addClass('show');
    };

    $(document).ready(function() {
        // Close modal handlers
        $('#btnCloseReceiptModal').on('click', function() {
            $('#receiptModal').removeClass('show');
        });

        // Click outside closes modal
        $('#receiptModal').on('click', function(e) {
            if ($(e.target).is('#receiptModal')) {
                $('#receiptModal').removeClass('show');
            }
        });

        // Print button click with visual feedback
        $('#btnPrintReceipt').off('click').on('click', function() {
            const $btn = $(this);
            const originalHtml = $btn.html();

            $btn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Inachapisha...
            `);

            // Execute isolated thermal print
            printThermalReceiptDirect('printReceiptArea');

            // Success feedback
            setTimeout(function() {
                $btn.html('<i class="bi bi-check-circle-fill me-1"></i> Imechapishwa!');
                setTimeout(function() {
                    $btn.prop('disabled', false).html(originalHtml);
                }, 2000);
            }, 800);
        });
    });
</script>
