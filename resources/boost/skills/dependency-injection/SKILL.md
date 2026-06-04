---
name: dependency-injection
description: Use dependency injection cleanly in PHP applications. Constructor injection, avoiding service locators, what to put in the container.
---

# Dependency injection

## When to apply

- Adding a new class with collaborators
- Reviewing PR that introduces a `new SomeService()` deep in a method
- Asked "should this go in the container?"

## Constructor injection by default

```php
final class CreateOrder
{
    public function __construct(
        private readonly OrderRepository $orders,
        private readonly EventDispatcher $events,
        private readonly Clock $clock,
    ) {}
}
```

Promoted constructor params (PHP 8.0+). Readonly (PHP 8.1+). Typed
against interfaces, not concrete classes (testability).

## What goes in the container

- **Stateless services** with collaborators
- **Repositories, mailers, HTTP clients, event dispatchers**
- **Configuration values** (via env-bound bindings)

## What does NOT go in the container

- **Value objects** — construct directly with `new`. `new EmailAddress($input)`.
- **Entities** — produced by factories or repositories, not the container.
- **Per-request state** — use a scoped binding or a context object, not
  singletons.

## Service Locator is a code smell

```php
// AVOID
public function handle(): void
{
    $service = app(SomeService::class); // service locator
    // ...
}

// PREFER
public function __construct(private readonly SomeService $service) {}
public function handle(): void
{
    $this->service->doIt();
}
```

The only legitimate use of a service locator is at the framework boundary
(routing, command dispatch). Below that line: constructor injection.

## Anti-patterns

- Six+ constructor params → break the class apart (SRP)
- `new SomeService()` inside business logic → not testable in isolation
- Container binding that calls another binding which calls another →
  flatten the graph
- Singletons that hold per-request state → race conditions

## Testing

Constructor injection makes test fakes trivial:

```php
$cmd = new CreateOrder(
    orders: new InMemoryOrderRepository(),
    events: new RecordingDispatcher(),
    clock: new FrozenClock('2026-01-15'),
);
```

No container, no mocks, no magic.

## See also

- `ddd-layering` for which layer owns the container wiring
- `repository-pattern` for how repositories get injected
