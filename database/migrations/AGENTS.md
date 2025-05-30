# AGENTS.md

## Introduction

Focus on maintaining **database integrity**.  
You are allowed to **redesign migrations from scratch**.  
Current migrations do **not** need to be compatible with production data—backward compatibility is not a concern right now.

---

## Goal

- **Rewrite, optimize, and refactor all migrations** in this project.
- Ensure the new migrations define the intended database structure cleanly and idiomatically.
- Fix or avoid previous mistakes, redundancies, and poor practices.
- Favor clarity, maintainability, and correctness over legacy structure.

---

## Means

- Create **new entity/table definitions** that are best-practice for Laravel (e.g., use proper foreign keys, timestamps, index conventions).
- Use Eloquent naming conventions (snake_case table names, singular model names, etc.).
- Feel free to **remove or rename tables/columns** as needed.
- Remove any legacy artifacts or unnecessary columns.
- Document complex changes as comments inside migration files.

---

## Migration Conventions

- Use Laravel’s built-in types and helpers (e.g., `$table->foreignId()->constrained()`).
- Add `softDeletes()` and `timestamps()` unless there’s a specific reason not to.
- Always define **foreign key constraints** for relationships.
- Index columns used for searching, filtering, or foreign keys.
- Use appropriate field types for data (e.g., `text` for large strings, `json` for structured data, `unsignedBigInteger` for IDs).
- For enums, use Laravel’s `enum()` type or create dedicated tables if necessary.

---

## Workflow

- Rewrite migration files in a logical order (`202x_xx_xx_000000_create_users_table.php`, etc.).
- Test the entire migration chain with `php artisan migrate:fresh` to ensure schema builds cleanly.
- No need to preserve previous migration history or compatibility—focus on correctness now.
- If you make a breaking change or delete an entity, add a comment explaining the decision.

---

## Exclusions / Cautions

- Do **not** add test or demo data (no `DB::table()->insert()` in migrations).
- Do **not** introduce dependencies on third-party packages unless specified.
- No changes outside the `database/migrations/` directory unless otherwise instructed.

---

## Documentation

- Add comments for any non-obvious design decisions in migration files.
- Update this AGENTS.md if conventions change.

---

**You are empowered to create the cleanest, most maintainable migration set for this Laravel application.**
