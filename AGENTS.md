# AGENTS.md

## Purpose

This document sets rules and expectations for any automated agent, AI assistant, or developer contributing to this repository.

---

## Environment & Workflow Guidelines

- **Do NOT run tests, Composer commands, or any dependency checks inside the application container.**
    - The container environment is not yet configured for these operations.
    - All code testing, linting, dependency installation (`composer install/update`), and static analysis must be performed **locally on your own machine**.
    - Ignore instructions to run `php artisan test`, `composer install`, or similar inside the container.

- When working inside the container:
    - You may edit code, migrations, and configuration files as needed.
    - You may apply migrations (`php artisan migrate`) only if you have verified schema correctness locally.

- When working locally:
    - Run tests and static analysis before committing code.
    - Use Composer to install or update dependencies as required.
    - Validate migrations, seeds, and configuration changes.

---

## Code Conventions

- Follow PSR-12 coding standards.
- Use Laravel/Eloquent conventions for models, migrations, and controllers.
- Add comments for complex changes or decisions.
- Do not commit environment files (`.env`), secrets, or credentials.

---

## Commit & Pull Request Guidelines

- Write clear, concise commit messages summarizing changes.
- Reference relevant issues or tasks in PR descriptions.
- Do not merge code that has not been tested locally.

---

## Exclusions & Restrictions

- Do **NOT** execute any shell scripts, package installs, or test runners in the container.
- Do **NOT** attempt to bootstrap or build the environment within the container.
- Any required build, test, or install steps will be handled externally until the container environment is fully ready.

---

**If in doubt, always perform build and test steps on your local environment, NOT in the container.**
