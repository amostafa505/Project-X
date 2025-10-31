# Project‑X — Hospital Module Checklist (Kickoff)
_Last updated: 2025-10-08 18:47_

> **Scope**: Same stack & patterns. Everything tenant/branch/org scoped. Design for MVP then iterate.

## 0) Foundations (Reuse from Project‑X)
- [ ] Panels: central + tenant ready (reuse)
- [ ] Spatie Permissions: roles (owner, admin, doctor, nurse, receptionist, cashier, lab-tech, pharmacist, auditor)
- [ ] BranchScoped/Scoping middleware enabled on new resources
- [ ] Common enums: gender, blood_group, visit_type, payment_method, insurance_status

## 1) Core Entities & Migrations
### Master Data
- [ ] Department (ER, OPD, IPD, Surgery, ICU, Lab, Radiology, Pharmacy)
- [ ] Room / Bed (status: vacant/occupied/cleaning/maintenance)
- [ ] Service Catalog (consultation, procedure, lab test, imaging, bed-day, pharmacy item linkage)
- [ ] Insurance Payer / Plans

### People
- [ ] Patient (MRN, demographics, contacts, allergies, chronic conditions)
- [ ] Doctor (specialty, schedule slots)
- [ ] Staff (nurse, receptionist, lab, radiology, pharmacy)

### Clinical
- [ ] Encounter (visit) header (OPD/IPD/ER), triage, chief complaint
- [ ] Vitals (BP, HR, Temp, SpO2, Weight/Height, BMI)
- [ ] Orders: Labs / Imaging / Procedures
- [ ] Results: Lab results, Imaging report link
- [ ] Diagnoses (ICD-like simple list for MVP)
- [ ] Prescriptions (drug, dose, frequency, duration, route, notes)
- [ ] Medication Dispense (pharmacy issue, stock decrement)
- [ ] Nursing Notes / Progress Notes
- [ ] Discharge Summary

### Operations
- [ ] Appointments (doctor, slot, patient, status, reminders)
- [ ] Admissions (assign room/bed, transfer, discharge)
- [ ] Cashier & Billing (invoice, items, discounts, insurance coverage, co-pay, payments)
- [ ] Inventory (pharmacy stock, batches, expiry; simple for MVP)
- [ ] Attachments (files: lab PDFs, radiology DICOM ref, consents; stored securely)

## 2) Relationships
- [ ] Patient 1–N Encounters
- [ ] Encounter 1–N Orders (lab, imaging, procedures)
- [ ] Encounter 1–N Diagnoses
- [ ] Encounter 1–N Prescriptions
- [ ] Prescription 1–N Dispense lines
- [ ] Admission N–1 Bed; Admission history (transfers)
- [ ] Doctor 1–N Appointments; Doctor N–M Departments (if needed)

## 3) Filament Resources (Tenant Panel)
- [ ] PatientsResource
- [ ] DoctorsResource
- [ ] DepartmentsResource
- [ ] AppointmentsResource (calendar view)
- [ ] EncountersResource (OPD/ER quick-create from appointment)
- [ ] AdmissionsResource (bed assignment UI)
- [ ] OrdersResource (Lab/Imaging unified)
- [ ] LabsResource (catalog + results)
- [ ] RadiologyResource (catalog + reports + file link)
- [ ] PrescriptionsResource
- [ ] Pharmacy/InventoryResource (stock, dispensing)
- [ ] Billing/InvoicesResource (payer/plan/co-pay)
- [ ] PaymentsResource

## 4) Workflows (MVP)
- [ ] Reception: Register patient → Book appointment → Collect visit fee (optional)
- [ ] Doctor OPD: Start encounter → Notes → Vitals → Orders → Prescription → End visit
- [ ] Lab: Receive order → Enter result → Mark complete → Notify
- [ ] Radiology: Receive order → Report → Attach file → Notify
- [ ] IPD: Admit → Assign bed → Daily notes → Orders → Discharge summary
- [ ] Pharmacy: Receive Rx → Dispense → Deduct stock
- [ ] Billing: Build invoice from services/items → Apply insurance/co-pay → Record payment(s)

## 5) Filters, Actions & Exports
- [ ] Global filters: by branch, department, doctor, date
- [ ] Appointments: by status (booked, checked‑in, no‑show, completed)
- [ ] Encounters: by visit type (OPD/IPD/ER), doctor, date
- [ ] Labs/Imaging: by pending/complete
- [ ] Billing: due/overdue/paid; export CSV/Excel/PDF
- [ ] Inventory: near‑expiry, low‑stock

## 6) Policies & Permissions (Examples)
- [ ] Receptionist: manage patients/appointments only
- [ ] Doctor: encounters on own patients; read lab/imaging results
- [ ] Nurse: vitals/notes; read orders
- [ ] Lab/Radiology: manage own orders/results
- [ ] Pharmacist: prescriptions/dispense/inventory
- [ ] Cashier: invoices/payments
- [ ] Admin/Owner: all tenant resources

## 7) Seeders (Sample Data)
- [ ] Departments (ER, OPD, IPD, ICU, Lab, Radiology, Pharmacy)
- [ ] Doctors (5 specialties)
- [ ] Patients (fake data 100)
- [ ] Rooms/Beds (ICU/Private/General)
- [ ] Services catalog (consultation, bed-day, lab panels)
- [ ] Insurance payers/plans

## 8) Dashboards & Widgets
- [ ] Today’s Appointments (per doctor, per department)
- [ ] OPD queue (check‑in → in‑room → completed)
- [ ] Beds occupancy (by unit)
- [ ] Pending Labs / Imaging
- [ ] Billing snapshot (today revenue, AR, overdue)
- [ ] Inventory alerts

## 9) API (Future‑proof)
- [ ] Public/Partner API (appointments, results webhooks)
- [ ] Mobile‑ready endpoints for doctors (today’s list, quick notes)

## 10) Compliance & Security (Essentials)
- [ ] PHI storage: encrypt sensitive fields at rest
- [ ] Access logs (who viewed/changed records)
- [ ] File storage: private disk; signed URLs
- [ ] Backups & tenancy-safe restores

---

### Notes
- Keep all tenant-scoped tables with `tenant_id`, `branch_id`, `organization_id`.
- Start with OPD (outpatient) flow for MVP; add IPD after.
- Reuse Invoice/InvoiceItem patterns from School module to accelerate Billing.