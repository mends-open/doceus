# RFC: Schedule Builder

This document proposes moving practitioner schedules to a flexible JSON based format.

## Goals

- Support multiple schedule entry types (weekly, one‑time, blocking).
- Allow a practitioner to have one schedule per location.
- Keep compatibility with Filament builder UI.

## Implementation

- `schedules` table now stores an `entries` JSONB column and a `location_id` foreign key.
- Unique index on `practitioner_id` and `location_id` ensures one schedule per location.
- Builder form uses three block types for weekly, one‑time and blocking entries.

