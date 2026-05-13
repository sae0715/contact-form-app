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

## インストール方法

```bash
git clone <リポジトリURL>
cd contact-form-app
sail up -d
sail artisan migrate:fresh --seed
```

## 使用方法

1. ホームページ（/）からお問い合わせを入力
2. 確認ページで内容を確認して送信
3. 管理画面にログイン（test@example.com / password）
4. お問い合わせ一覧を確認

## テストアカウント
- Email: test@example.com
- Password: password