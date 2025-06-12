# AGENTS.md

**One page, all rules.**

## Structure

- `app/Feature/<Feature>` – domain logic (models, actions, policies).
- `app/Filament/Clusters/<Feature>` – admin UI for that feature.
- `database/migrations` – one migration per change; always add FKs, indexes, `timestamps()`, `softDeletes()`.
- `laravel-docs/` – **git submodule** with official Laravel docs. Edit or update docs only inside this folder.

## Guidelines

1. Stick to Laravel + PSR‑12 conventions.
2. Organize everything by feature; avoid cross‑feature coupling.
3. Aim for FHIR‑friendly schemas, but never fight core Laravel features.
4. No PHI, secrets, or `.env` files in the repo.
5. Run Composer, tests, and static analysis **locally** before pushing.
6. Comment any non‑obvious medical or FHIR logic right in the code.

That’s it—keep it clean, secure, and maintainable.
