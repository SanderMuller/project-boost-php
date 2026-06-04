---
name: domain-modeling
description: Build domain models in PHP. Entities vs value objects vs aggregates. When each fits.
---

# Domain modeling

## When to apply

- Adding a new business concept to the domain
- Reviewing a PR that introduces a class with `id`, getters, setters
- Asked "should this be an entity or a value object?"

## Value objects

Identity = value. Equality = field equality. Always immutable.

```php
final readonly class EmailAddress
{
    public function __construct(public string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Not an email: {$value}");
        }
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
```

Examples: `Money`, `EmailAddress`, `OrderStatus` (enum), `DateRange`,
`UserId`.

## Entities

Identity = ID. Equality = ID equality. Lifecycle: created → mutated →
deleted. Holds state that changes over time.

```php
final class Order
{
    public function __construct(
        private readonly OrderId $id,
        private OrderStatus $status,
        private array $lines,
    ) {}

    public function id(): OrderId { return $this->id; }

    public function cancel(): void
    {
        if ($this->status === OrderStatus::Shipped) {
            throw new CannotCancelShippedOrder($this->id);
        }
        $this->status = OrderStatus::Cancelled;
    }
}
```

Public methods that mutate state must enforce invariants. No naked setters.

## Aggregates

An aggregate is an entity (the root) plus zero or more entities/value
objects that change together. Transactional consistency boundary.

Rule: external code only references the aggregate root by ID. Internal
entities are accessed through the root.

`Order` (root) with `OrderLine[]` (entities) and `ShippingAddress`
(value object) is one aggregate. Changes to an OrderLine go through the
Order: `$order->addLine($line)`, not `$line->setQuantity()`.

## When to skip the ceremony

- A small app with no real domain complexity — just use anemic models
  with Doctrine annotations. Ceremony has a cost.
- Read-only views — use DTOs, not domain entities.
- Configuration data — value objects, not entities.

## Anti-patterns

- **Anemic domain model:** all getters/setters, no behavior. Push the
  behavior into the class instead of orchestrating it in a service.
- **Naked setters:** `setStatus(string $status)` allows any invalid
  transition. Replace with verb methods: `cancel()`, `ship()`, `complete()`.
- **Aggregate-to-aggregate hard references:** `$user->orders[0]` couples
  two aggregates. Use IDs and a query.
- **Public mutable properties:** state changes must go through behavior.

## See also

- `ddd-layering` for which layer hosts these
- `repository-pattern` for persistence of aggregates
