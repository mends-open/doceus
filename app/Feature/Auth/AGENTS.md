# AGENTS.md

- All authentication and authorization logic lives here.
- Use Laravel’s built-in Auth features and guards unless absolutely necessary to extend.
- Store policies, guards, middleware, and related utilities in this feature.
- Avoid putting user management or identity (profile) logic here—keep that in Identity.
