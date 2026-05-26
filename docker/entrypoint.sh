#!/bin/sh
set -e

# ──────────────────────────────────────────────
# ConnectShare — Container Entrypoint
# Runs first-boot tasks before handing off to CMD
# ──────────────────────────────────────────────

echo "🚀 ConnectShare entrypoint starting…"

# ── Cache config, routes & views for performance ──
php artisan config:cache  2>/dev/null || true
php artisan route:cache   2>/dev/null || true
php artisan view:cache    2>/dev/null || true

# ── Create storage → public symlink if missing ──
php artisan storage:link  2>/dev/null || true

# ── Run pending migrations ──
echo "📦 Running database migrations…"
php artisan migrate --force --no-interaction 2>/dev/null || {
    echo "⚠️  Migrations failed (database may not be ready yet). Continuing…"
}

echo "✅ Entrypoint complete — handing off to: $*"

# Hand off to the original CMD (php-fpm, etc.)
exec "$@"
