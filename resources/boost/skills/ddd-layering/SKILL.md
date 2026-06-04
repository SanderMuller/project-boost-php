---
name: ddd-layering
description: Apply Domain-Driven-Design layering in PHP applications. Domain / Application / Infrastructure / Presentation responsibilities, and what NOT to put where.
---

# DDD layering

## When to apply

- Adding new business logic to an application with `src/Domain/`, `src/Application/`, etc.
- Asked "where should I put this?"
- Reviewing a PR that creates a new class or service

## The four layers

| Layer | May | May not |
|---|---|---|
| **Domain** | Business rules, validations, entity config, value objects, domain events | DB queries, HTTP calls, framework deps |
| **Application** | Orchestrate use cases, transaction boundaries, dispatch events | UI/presentation logic, framework-specific binding |
| **Infrastructure** | DB access, external services, file I/O, message queues | Business rules |
| **Presentation** | User-facing messages, formatting, HTTP request handling | Business logic, persistence |

## Decision rules

**"Where does X go?"** Ask: would the rule still apply if we swapped the
DB? The framework? The UI? If yes → Domain. If only the DB → Infrastructure.
If only the UI → Presentation. If only the orchestration of use cases →
Application.

## Common mistakes

- **EntiteitenConfig in Infrastructure.** Entity configuration is business
  rules about the domain → belongs in Domain. Infrastructure only knows
  how to persist what Domain defines.
- **Hardcoded frontend behavior in Vue/JS instead of serving from backend.**
  Presentation should reflect Domain decisions, not duplicate them.
- **Application layer becoming a thin pass-through to Infrastructure.**
  Application owns the use case shape. If your application service is
  just `$repo->save($model)`, the use case probably belongs deeper.
- **Domain importing from Infrastructure.** Inverted dependency. Domain
  defines interfaces; Infrastructure implements them.

## Anti-patterns

- Putting validations in form requests (Presentation) instead of value
  objects (Domain)
- Service Locator in Domain (couples to framework)
- "Entity" classes that are just Doctrine annotations + getters/setters —
  those are anemic models, not Domain entities

## See also

- `repository-pattern` for the Infrastructure-implements-Domain-interface shape
- `dependency-injection` for layer wiring
