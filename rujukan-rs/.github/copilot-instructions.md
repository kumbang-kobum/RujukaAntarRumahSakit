# AI Coding Agent Instructions for Rujukan-RS

## Project Overview
Hospital referral system ("rujukan-rs") built with Laravel 12 + Inertia.js + Vue 3 + Tailwind CSS. Manages multi-hospital patient visits, examinations, and medical records.

## Architecture
- **Backend**: Laravel controllers, Eloquent models with hospital-scoped data, services for business logic.
- **Frontend**: Inertia.js Vue 3 SPA with server-side rendering.
- **Data Flow**: Controllers eager-load relationships, pass data to `Inertia::render()` for Vue pages.
- **Key Models**: `Patient` (UUID), `Visit` (with generated `no_rawat`), `Examination`, `VitalSign`, `SoapNote`, `ExamProcedure`.
- **Relationships**: Visits belong to patients/departments, have many examinations; examinations have one vital sign/SOAP note, many procedures.

## Critical Workflows
- **Setup**: `composer run setup` (install deps, copy env, migrate, build assets).
- **Development**: `composer run dev` (runs server, queue listener, logs, Vite concurrently).
- **Testing**: `vendor/bin/phpunit` (standard Laravel tests).
- **Database**: Migrations with foreign keys; use transactions for data integrity (e.g., visit creation with participants).

## Conventions & Patterns
- **Multi-Hospital**: All data scoped by `hospital_id`; users belong to hospitals.
- **No Rawat Generation**: Daily sequential numbers per hospital via `GenerateNoRawatService` (format: YYYY/MM/DD/000001).
- **Visit Statuses**: `registered` → `in_exam` → `done_exam` → `referred`/`billing` → `paid` → `closed`.
- **Eager Loading**: Always load relationships in `show()` methods (e.g., `visit->load('patient')`).
- **Controllers**: Use `DB::transaction()` for multi-table inserts; validate with `request->validate()`.
- **Routes**: Resource routes under `auth` middleware; custom POST routes for nested resources.
- **Frontend**: Vue components in `resources/js/Pages/`, use Ziggy for Laravel routes in JS.

## Integration Points
- **Database**: MySQL/PostgreSQL with cascading deletes.
- **Queues**: Background jobs via Laravel queues (e.g., for async processing).
- **Authentication**: Laravel Sanctum for API; Breeze for UI auth.

## Examples
- Creating a visit: Validate patient/department, generate no_rawat, insert visit + participants in transaction.
- Examination flow: Create examination, add vital signs, SOAP note, procedures via separate POST endpoints.
- Referencing models: Use `auth()->user()->hospital_id` for scoping queries.

Reference: [VisitController.php](app/Http/Controllers/VisitController.php) for controller patterns, [GenerateNoRawatService.php](app/Services/GenerateNoRawatService.php) for business logic.