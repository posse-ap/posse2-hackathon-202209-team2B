## ハッカソン202209

### ビルド

ディレクトリに移動して以下のコマンドを実行してください

```bash
docker-compose build --no-cache
docker-compose up -d
```

### 動作確認

ブラウザで `http://localhost` にアクセスして、正しく画面が表示されているか確認してください

### メール送信サンプルについて

メール送信
ブラウザで `http://localhost/mailtest.php` にアクセスしてください、テストメールが送信されます

メール受信
ブラウザで `http://localhost:8025/` にアクセスしてください、メールボックスが表示されます

github連携
ブラウザで `http://localhost/auth/login/github.php` にアクセスしてください、githubの認証画面に飛びます

slack連携
ブラウザで `http://localhost/slackParticipant.php` にアクセスしてください、slackに送られます
