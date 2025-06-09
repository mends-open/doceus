# AGENTS.md

## Purpose

This file defines essential rules and expectations for anyone (AI or human) working in this codebase.

---

## General Guidelines

- Use Laravel conventions for all features, models, migrations, and controllers.
- Organize code by “Feature” (feature-based structure, not pure DDD).
- FHIR compatibility is a goal, but do not overcomplicate code or fight Laravel’s best practices.

---

## Feature Structure

- Each domain (e.g., Identity, Revisions, Appointments, FHIR Models) lives in its own `Features/<Name>` folder.
- Place all related models, actions, policies, and utilities together per feature.
- Minimize cross-feature dependencies.

---

## Data and Migrations

- Favor database integrity: use foreign keys, indexes, timestamps, and soft deletes.
- Migrations must be clean, clear, and self-contained.
- Use comments to explain any medical or FHIR-specific schema logic.

---

## Coding and Testing

- Use PSR-12 and Laravel standards.
- Write and update tests for important business logic.
- Don’t leak PHI or sensitive data in logs, tests, or seeds.
- Test and run Composer locally before pushing code.

---

## Documentation

- Comment all non-obvious code, especially FH
