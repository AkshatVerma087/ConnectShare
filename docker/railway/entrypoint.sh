#!/bin/sh
set -e

# ──────────────────────────────────────────────
# ConnectShare — Railway Container Entrypoint
# Runs first-boot tasks before handing off to CMD
# ──────────────────────────────────────────────

echo "🚀 ConnectShare Railway entrypoint starting…"

# ── Inject Railway's PORT into Nginx config ──
# Railway sets PORT dynamically; we replace ${PORT} in the Nginx template
export PORT="${PORT:-8080}"
envsubst '${PORT}' < /etc/nginx/http.d/default.conf > /tmp/nginx.conf
mv /tmp/nginx.conf /etc/nginx/http.d/default.conf
echo "📡 Nginx will listen on port ${PORT}"

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

# Hand off to the original CMD (supervisord)
exec "$@"
