# setup 手順

上から順にコマンドを実行してください。

- `$ docker compose up -d`
- `$ cp .env.example .env`
- `$ docker compose run php composer install`
- `$ docker compose run php php artisan migrate`
- `$ docker compose run php composer test`

# build + コンテナ作成 + バックグラウンドで起動

`$ docker compose up -d`

# build + コンテナ作成 + 起動

`$ docker compose up`

# コンテナ起動

`$ docker compose start`

# 停止

`$ docker compose stop`

# 再起動

`$ docker compose restart`

# ビルド

`$ docker compose build`

# キャッシュを使わないビルド

`$ docker compose build --no-cache`

# コンテナ確認

`$ docker compose ps`

# コンテナログイン

`$ docker compose ${service} ps`

