# AGENTS.md

- Handles creation and validation of blind indexes for sensitive fields.
- Keep hashing, salting, and index lookup logic isolated in this feature.
- Do not log or expose secrets or key material.
- Document which models/fields use blind indexing and why.
