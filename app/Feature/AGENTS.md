# AGENTS.md

- Each subfolder is a self-contained feature (Identity, Revisions, Appointments, etc.).
- Keep all models, actions, policies, and logic for a feature inside its own subfolder.
- Use Laravel best practices for all code: naming, Eloquent, validation, and controllers.
- Prefer code reuse and clarity; don’t repeat logic across features.
- Minimize dependencies between features—features should be loosely coupled.
- Comment any domain rules, FHIR requirements, or complex workflows inside the relevant feature.

