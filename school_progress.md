# Project‑X — School Module Progress Checklist
_Last updated: 2025-10-08 18:47_

> **Scope**: Multi-tenant (UUID) with `tenant_id`, `branch_id`, `organization_id` everywhere. Filament v4, Laravel 12, Spatie Permissions (team-aware), Stancl Tenancy.

## 1) Core Entities & Migrations
- [x] Tenants / Organizations / Branches (base)
- [x] School
- [x] Classrooms (renamed and fixed plural)
- [x] Students
- [x] Teachers
- [x] Guardians (entity)
- [x] Enrollments
- [x] FeeItems
- [x] Invoices / InvoiceItems
- [x] Attendance (entity + relations basic)
- [ ] Final audit of `organization_id` on `tenants` (migration ordering + FK name cleanup)

## 2) Relationships & Pivots
- [x] Student ↔ Classroom (pivot + booted tenant fill)
- [x] Classroom ↔ Teacher
- [ ] Student ↔ Guardian (confirm pivot/cardinality)
- [ ] Attendance scope (per-student vs per-class final decision)

## 3) Filament Resources (Tenant Panel)
- [x] StudentsResource
- [x] ClassroomsResource
- [x] TeachersResource
- [x] InvoicesResource (actions fixed, EGP money)
- [ ] AttendanceResource (filters by class/student + export)
- [ ] FeeItemsResource (filters + export)
- [ ] EnrollmentsResource (improve create UX: classroom + student pickers)
- [ ] GuardiansResource (linking UI to students)

## 4) Filters & Exports
- [ ] Global Filters: by Branch, Classroom, Student
- [ ] CSV/Excel/PDF export on key tables (Students, Invoices, Attendance, FeeItems)

## 5) Policies & Permissions
- [x] Spatie Permissions (team-aware) baseline
- [ ] Enforce `canCreate/canEdit/canDelete` across all resources (only in Invoices done)
- [ ] Split central vs tenant policies review

## 6) Seeders & Test Data
- [x] TenantSeeder / SchoolSeeder
- [ ] FeeItemsSeeder (tuition/transport/uniforms…)
- [ ] InvoiceSeeder (richer scenarios: partial paid/overdue/discounts)
- [ ] Sample Attendance sets

## 7) Dashboard & Widgets
- [ ] RecentInvoices widget finalized (query/records)
- [ ] Stats: counts (students, unpaid invoices, overdue %), sparkline
- [ ] Attendance today (present/absent by classroom)

## 8) Scoping Traits
- [x] BranchScoped trait implemented
- [ ] Apply trait on Attendance, FeeItems, Enrollments, Guardians

---

### Notes
- Keep using `BranchScoped::injectTenantBranchHiddenFields($schema)` in forms and `BranchScoped::scopeTenantBranch($table)` in tables.
- Continue aligning column names: `tenant_id`, `branch_id`, `organization_id` exist on every tenant-scoped table.
- Exports and filters are the main gap before we "call School module MVP done".