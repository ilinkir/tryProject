#!/usr/bin/env bash
set -e
role=${CONTAINER_ROLE:-app}
#env=${APP_ENV:-production}
#if [ "$env" != "local" ]; then
#    echo "Caching configuration..."
#    (cd /var/www/html && php artisan config:cache && php artisan route:cache && php artisan view:cache)
#fi
if [ "$role" = "app" ]; then
    (cd /var/www/ && php artisan octane:start --server=swoole --host=0.0.0.0 --port=80 --workers=auto --task-workers=auto --max-requests=500 --watch)
elif [ "$role" = "queue" ]; then
    echo "Running the queue..."
    exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.queue.conf #TODO: Сделать вотчер для restart queue при измении кода в /var/www
elif [ "$role" = "websocket" ]; then
    echo "Running the websocket..."
    exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.websocket.conf
elif [ "$role" = "scheduler" ]; then
    echo "Scheduler role"
#        while [ true ]
#        do
#          php /var/www/artisan schedule:run --verbose --no-interaction &
#          sleep 60
#        done
    exit 1
else
    echo "Could not match the container role \"$role\""
    exit 1
fi
