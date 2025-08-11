---
title: "TRPG支援ツールのAPI連携"
category: "dev"
tags: ["API", "連携", "自動化"]
publishedAt: 2024-03-15
---

# TRPG支援ツールのAPI連携

各種TRPGツールのAPI連携について解説します。

## BCDice API

### 概要
- RESTful API
- 多システム対応
- JSON形式のレスポンス

### 基本的な使用方法
```javascript
// ダイス判定の例
fetch('https://bcdice.onlinesession.app/v2/game_system/Cthulhu7th/roll?command=1d100')
  .then(response => response.json())
  .then(data => console.log(data));
```

## Discord API

### ボット開発
- Webhook連携
- スラッシュコマンド
- インタラクション

### 実装例
```javascript
// 基本的なボットの例
const { Client, GatewayIntentBits } = require('discord.js');
const client = new Client({ intents: [GatewayIntentBits.Guilds] });

client.on('ready', () => {
  console.log('Bot is ready!');
});
```

## キャラクターシート連携

### データ形式
- JSON
- XML
- CSV

### 自動化のメリット
- 入力ミスの削減
- 時間短縮
- データの一元管理

## セキュリティ考慮事項

### API キー管理
- 環境変数の使用
- 定期的な更新
- アクセス権限の制限

### データ保護
- 暗号化
- アクセスログ
- バックアップ

## 総評

API連携により、TRPG体験を大幅に向上させることができます。
