# Office Stock Manager - Documentation Enhancement Plan

## 1. Purpose and Scope
This document defines a **documentation-only enhancement plan** for the Office Stock Manager application.  
No code implementation is included in this phase.

Primary goals:
- Expand documentation with clear, page-level functional requirements.
- Define bug-prevention and validation checks for each page/flow.
- Define a modern, consistent UI/UX direction before implementation.
- Provide acceptance criteria so implementation can be verified page by page.

## 2. Current Architecture Snapshot
- Stack: PHP, jQuery, AdminLTE, Bootstrap, DataTables.
- Entry point: `index.php`.
- Page routing: `index.php?page=<page_name>` loads `pages/<page_name>.php`.
- Shared shell: `inc/header.php`, `inc/sidebar.php`, `inc/footer.php`.
- Core data layer: PDO/Turso wrapper from `app/database/connection.php`.
- Actions: `app/action/*.php` (form submission endpoints).
- Ajax/data providers: `app/ajax/*.php`.

## 3. Enhancement Principles
- Functional correctness first, visual polish second.
- Every form must have both client-side and server-side validation.
- Every data write must be transactional when multi-table changes occur.
- Every list page must handle empty state, loading state, and error state.
- Every financial calculation (subtotal, discount, due, return) must have deterministic formulas documented.
- No silent failure: all action endpoints should return structured success/error feedback.

## 4. Modernistic UI/UX Direction (Documentation Spec)
Design direction for all pages:
- Visual style: clean enterprise UI with strong spacing rhythm (8px scale), soft elevation, and reduced visual noise.
- Colors:
  - Primary: `#0B5FFF`
  - Success: `#15803D`
  - Warning: `#B45309`
  - Danger: `#B91C1C`
  - Surface: `#F8FAFC`
  - Text: `#0F172A` / secondary `#475569`
- Typography:
  - Headings: `Poppins` or `Manrope`.
  - Body/UI text: `Inter` (fallback `Segoe UI`, `sans-serif`).
- Components:
  - Unified card headers with title + actions.
  - Sticky table header on long lists.
  - Standardized button hierarchy (Primary / Secondary / Danger).
  - Standardized form feedback (inline error + global alert).
- Interaction:
  - Replace blocking alert-heavy UX with toast notifications.
  - Use non-blocking loaders/skeletons for async table refresh.
  - Confirm dialog only for destructive actions.
- Responsive:
  - Mobile-first collapse for filter areas.
  - Data tables should support horizontal scroll with pinned key columns where possible.

## 5. Global Bug-Prevention Checklist (Applies to All Pages)
- Routing and access control:
  - Invalid page key loads `pages/error_page.php`.
  - Unauthenticated access redirects to `login.php`.
- Input safety:
  - Required field checks and type checks.
  - Positive numeric enforcement for quantities and amounts.
  - Date format normalized before DB write.
- Data integrity:
  - Foreign key existence check (customer/supplier/product/category).
  - Prevent negative stock.
  - Prevent over-return beyond sold/purchased quantity.
- Security:
  - Escape all rendered user-facing values.
  - Use prepared statements only.
  - Enforce role checks for admin-sensitive pages (backup, staff, user profile updates).
- Reliability:
  - Standard action response format: `{ status, message, data? }`.
  - Log server errors with context (endpoint + payload key fields).
  - Graceful failure messages in UI.

## 6. Page-by-Page Functional Documentation and QA Criteria

### 6.1 Authentication and Shell
1. `login.php`
- Functionality:
  - Authenticate user and create session.
  - Redirect to dashboard on success.
- Bug checks:
  - Incorrect credentials show error without revealing whether user exists.
  - Session fixation prevention after successful login.
  - Login rate limiting documented for future implementation.

2. `inc/header.php`, `inc/sidebar.php`, `inc/footer.php`
- Functionality:
  - Shared layout, navigation, current user identity, page shell assets.
- Bug checks:
  - Active sidebar state correct for all known routes.
  - No hardcoded user name.
  - Missing avatar fallback behavior defined.

### 6.2 Dashboard
1. `pages/dashboard.php`
- Functionality:
  - KPI cards: sales, purchases, due, stock status.
  - Charts: trend and stock distribution.
  - Recent sales and low-stock panels.
- Bug checks:
  - Date range aggregation uses existing schema columns.
  - Null-safe aggregation returns `0`, not errors.
  - Chart labels and datasets remain aligned when a month has no data.

### 6.3 Category and Product Management
1. `pages/category.php`, `pages/catagory_edit.php`
- Functionality:
  - List/add/edit/delete categories.
- Bug checks:
  - Duplicate category names blocked (case-insensitive).
  - Category in use cannot be deleted without dependency handling.

2. `pages/add_product.php`, `pages/product_list.php`, `pages/product_edit.php`
- Functionality:
  - Product create/list/edit/delete and stock metadata.
- Bug checks:
  - Sell price cannot be lower than buy price unless explicitly allowed.
  - Quantity and alert quantity are non-negative integers.
  - Product delete guarded if referenced in invoice/purchase history.

3. `pages/add_other_product.php`, `pages/other_product_list.php`, `pages/factoryProduct_edit.php`
- Functionality:
  - Manage factory/other product source lifecycle.
- Bug checks:
  - Source-specific price fields validated consistently.
  - Stock sync rules with main product inventory documented before implementation.

### 6.4 Customer and Supplier Management
1. `pages/member.php`, `pages/member_edit.php`
- Functionality:
  - Customer CRUD and balance tracking.
- Bug checks:
  - Total buy/paid/due consistency check formula: `due = buy - paid`.
  - Phone number format normalization.

2. `pages/suppliar.php`, `pages/suppliar_edit.php`
- Functionality:
  - Supplier CRUD and payable tracking.
- Bug checks:
  - Supplier totals reconcile against purchase ledger.
  - Prevent deleting supplier with linked purchase rows.

3. `pages/customers_report.php`, `pages/suppliar_report.php`
- Functionality:
  - Balance reports for receivable/payable visibility.
- Bug checks:
  - Report totals match source master tables.
  - Export/read model excludes soft-deleted entities (if introduced later).

### 6.5 Sales Flow
1. `pages/quick_sell.php`
- Functionality:
  - Create invoice with multiple line items, discount, paid/due split.
- Bug checks:
  - Customer + payment method required.
  - Quantity sold cannot exceed available stock.
  - Line total and invoice net total formula consistency documented.

2. `pages/sell_list.php`
- Functionality:
  - Sales listing with payment and return indicators.
- Bug checks:
  - Sum cards (net/paid/due) match table dataset under same filter.

3. `pages/edit_sell.php`
- Functionality:
  - Update existing sales invoice.
- Bug checks:
  - Editing must correctly reverse prior stock impact before applying new values.
  - Payment delta updates customer due accurately.

4. `pages/view_sell.php`
- Functionality:
  - Invoice details and payment history view.
- Bug checks:
  - View handles missing/invalid `view_id` safely.
  - Payment rows sorted and summed accurately.

5. `pages/return_sell.php`, `pages/sell_return_list.php`
- Functionality:
  - Sales return creation and return history.
- Bug checks:
  - Return quantity cannot exceed sold quantity minus previous returns.
  - Refund amount formula and stock restoration documented.

6. `pages/sell_pay.php`, `pages/sell_pay_report.php`
- Functionality:
  - Record customer payments and report them.
- Bug checks:
  - Payment cannot exceed outstanding due.
  - Payment date and type required.

### 6.6 Purchase Flow
1. `pages/buy_product.php`
- Functionality:
  - Create purchase record and stock increment.
- Bug checks:
  - Supplier + product + quantity + purchase date required.
  - Purchase paid cannot exceed purchase net total.

2. `pages/buy_list.php`
- Functionality:
  - Purchase listing with totals.
- Bug checks:
  - Table totals and summary cards reconcile.

3. `pages/purchase_edit.php`
- Functionality:
  - Edit existing purchase row(s).
- Bug checks:
  - Stock recalculation performed atomically to prevent drift.

4. `pages/purchase_view.php`
- Functionality:
  - Purchase details and supplier payment history.
- Bug checks:
  - Invalid purchase ID handled with error state.

5. `pages/purchase_return.php`, `pages/buy_refund_list.php`
- Functionality:
  - Purchase return and return history.
- Bug checks:
  - Return quantity limited by purchased quantity minus previous returns.
  - Supplier due recalculated correctly.

6. `pages/purchase_pay.php`, `pages/purchase_pay_report.php`
- Functionality:
  - Record supplier payments and payment reporting.
- Bug checks:
  - Payment amount > 0 and <= outstanding due.

### 6.7 Expense and Staff
1. `pages/add_expense_catagory.php`, `pages/expense_catagory_list.php`
- Functionality:
  - Expense category create/list/delete.
- Bug checks:
  - Category dependency check before delete.

2. `pages/add_expense.php`, `pages/exspense_list.php`, `pages/expense_edit.php`
- Functionality:
  - Expense create/list/edit/delete.
- Bug checks:
  - Amount must be positive decimal.
  - Expense date cannot be invalid/future if business rule disallows it.

3. `pages/add_stuff.php`, `pages/staff_list.php`, `pages/edit_staff.php`
- Functionality:
  - Staff record management.
- Bug checks:
  - Email uniqueness (if required).
  - Delete/edit permissions restricted to authorized roles.

### 6.8 Reports, Utility, and System
1. `pages/profit_loss.php`
- Functionality:
  - Profit-loss summary from sales, purchases, returns, and dues.
- Bug checks:
  - Single source of truth for formulas documented.
  - Prevent double-counting payments/returns.

2. `pages/sales_report.php`, `pages/purchase_report.php`, `pages/total_report.php`
- Functionality:
  - Time-bound report pages.
- Bug checks:
  - `total_report.php` currently appears empty and must receive full report specification.
  - All reports require filter defaults and clear empty-state messaging.

3. `pages/backup_database.php`
- Functionality:
  - Export database backup.
- Bug checks:
  - Access restricted to admin.
  - Backup file naming, size handling, and success/failure message documented.

4. `pages/profile.php`
- Functionality:
  - Password/profile update.
- Bug checks:
  - Current password verification required.
  - New password policy + confirmation matching.

5. `pages/sms.php`
- Functionality:
  - Send SMS to customer.
- Bug checks:
  - Number format validation.
  - API failure handling and retry guidance.

6. `pages/error_page.php`
- Functionality:
  - Fallback for unknown routes.
- Bug checks:
  - Should render with main app shell styling and link back to dashboard.

## 7. Action Endpoint Mapping (Documentation Baseline)
Planned documentation must include endpoint-flow pairing for traceability:
- Category: `add_catagory.php`, `edit_cat.php`, `delete_cat.php`
- Product: `add_product.php`, `edit_product.php`, `delete_product.php`
- Factory product: `add_factoryProduct.php`, `edit_factoryProduct.php`, `delete_factoryProduct.php`
- Customer: `add_member.php`, `edit_member.php`, `delete_member.php`
- Supplier: `add_suppliar.php`, `edit_suppliar.php`, `delete_suppliar.php`
- Sales: `sell.php`, `edit_sell.php`, `sell_payment.php`, `sell_return.php`
- Purchase: `buy_product.php`, `edit_purchase.php`, `purchase_payment.php`, `purchase_return.php`
- Expense: `addexpense_cat.php`, `add_expense.php`, `edit_expense.php`, `delete_exCaragroy.php`, `delete_expense.php`
- Staff/user: `add_staff.php`, `edit_staff.php`, `delete_staff.php`, `edit_update.php`, `logout.php`, `login.php`
- Communications: `send_sms.php`

## 8. Cross-Page Testing Matrix (Must Pass Before Release)
- Smoke tests:
  - Every page route opens without PHP warning/fatal error.
  - Every DataTable loads data or empty-state gracefully.
- CRUD cycle tests:
  - Create -> List -> Edit -> Delete for category, product, customer, supplier, expense, staff.
- Transaction tests:
  - Sale creation updates invoice, invoice_details, stock, customer balance.
  - Purchase creation updates purchase table, stock, supplier balance.
  - Returns adjust both financial and stock values correctly.
- Financial consistency tests:
  - Dashboard KPIs equal corresponding report totals for same date range.
- Security tests:
  - Unauthorized user cannot access protected actions via direct URL.
- UX tests:
  - Mobile and desktop layout remains usable for all core forms and tables.

## 9. Known Gaps to Resolve During Implementation Phase
- Naming consistency issues (`catagory`, `suppliar`, `stuff`, `exspense`) should be standardized in UI labels and internal identifiers.
- Some pages are currently hidden from sidebar but routable; navigation policy should be documented.
- `total_report.php` needs full feature definition.
- Several current flows rely on browser `alert()` and should be migrated to consistent notification components.

## 10. Implementation Readiness Definition
Implementation can start only after:
- This documentation is approved.
- Page ownership and priority order are confirmed.
- Test dataset and expected financial outputs are prepared.
- Endpoint response contract is agreed and versioned.

---
This file is the authoritative enhancement blueprint for the next implementation phase.
