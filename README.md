# コンタクトフォームアプリ

## 概要
お問い合わせフォーム機能と管理画面を備えたLaravelアプリケーション

## 機能一覧

### ユーザー向け
- お問い合わせフォーム入力
- 確認ページ表示
- 送信完了画面
- タグ選択機能

### 管理者向け
- 管理者登録・ログイン
- お問い合わせ一覧表示
- タグ管理

## 使用技術
- Laravel 10.50.2
- PHP 8.5.5
- MySQL
- Fortify（認証）
- Tailwind CSS

## インストール手順

### 1. Laravelプロジェクトの作成（Laravel 10.x）

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer create-project laravel/laravel:^10.0 contact-form-app
```

### 2. Laravel Sailのインストール

```bash
cd contact-form-app

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer require laravel/sail --dev

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    php artisan sail:install --with=mysql
```

**M1/M2/M3 Mac（Apple Silicon）をお使いの場合：**
`compose.yaml` を開き、mysql サービスに以下を追加：
```yaml
mysql:
    image: 'mysql/mysql-server:8.0'
    platform: 'linux/amd64'
```

### 3. .env ファイルの設定

`.env` ファイルを開き、以下の設定を確認：
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
APP_LOCALE=ja

**重要:** `DB_HOST` は `localhost` ではなく `mysql` を指定してください。

### 4. phpMyAdmin の追加

`compose.yaml` を開き、mysql サービスの後に以下を追加：

```yaml
phpmyadmin:
    image: 'phpmyadmin:latest'
    ports:
        - '${FORWARD_PHPMYADMIN_PORT:-8080}:80'
    environment:
        PMA_HOST: mysql
        PMA_USER: '${DB_USERNAME}'
        PMA_PASSWORD: '${DB_PASSWORD}'
    networks:
        - sail
    depends_on:
        - mysql
```

### 5. Sailの起動とエイリアス設定

```bash
./vendor/bin/sail up -d

echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.zshrc
# または bash の場合
# echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.bashrc

exec $SHELL
```

### 6. フロントエンドのセットアップ（Vite & Tailwind CSS）

```bash
sail npm install

sail npm install -D tailwindcss@^3.4.0 postcss autoprefixer
sail npm install alpinejs

sail npx tailwindcss init -p
```

`tailwind.config.js` を開き、以下のように設定：

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

提供リポジトリの resources ディレクトリで置き換え：

```bash
git clone https://github.com/coachtech-prepared-file/Preparedblade-ConfirmationTest-ContactForm.git

# resources フォルダを入れ替え（ファイラーで操作するか、以下のコマンドで実行）
rm -rf resources
cp -r Preparedblade-ConfirmationTest-ContactForm/resources .
```

### 7. Vite開発サーバーの起動

```bash
sail npm run dev
```

**注意:** `sail npm run dev` は実行したままにしておいてください。

### 8. アプリケーションキーの生成

```bash
sail artisan key:generate
```

### 9. データベースマイグレーション

```bash
sail artisan migrate:fresh --seed
```

## アプリケーションへのアクセス

- **アプリケーション:** http://localhost
- **phpMyAdmin:** http://localhost:8080

## 使用方法

1. ホームページ（/）からお問い合わせを入力
2. 確認ページで内容を確認して送信
3. サンクスページが表示される
4. 管理画面にログイン（/login）
5. テストアカウント：
   - Email: test@example.com
   - Password: password
6. お問い合わせ一覧を確認

## よく使うコマンド

```bash
# Sailの起動・停止
sail up -d
sail down

# データベースのリセット
sail artisan migrate:fresh --seed

# キャッシュのクリア
sail artisan config:clear
sail artisan cache:clear

# ログの確認
tail -f storage/logs/laravel.log
```

## トラブルシューティング

### キャッシュの問題
```bash
sail artisan config:clear
sail artisan cache:clear
```

### データベースをリセットしたい
```bash
sail artisan migrate:fresh --seed