---
trigger: always_on
glob: "*"
description: wordpress-specific and project UI update rules
---

# UIパーツ変更時の運用ルール
今後、サイトのUIパーツ（SCSSやコンポーネントデザイン）に修正や新規追加を行った場合は、必ず以下のドキュメント・検証ページもセットで更新をかけて同期を保ってください。

1. **設計書**: [[design.md](file:///Users/hirose/Documents/task/Site/inspiro-child/design.md)] の仕様記述・HTMLサンプルコードの更新
2. **実物検証ページ**: [[page-components.php](file:///Users/hirose/Documents/task/Site/inspiro-child/page-templates/page-components.php)] のプレビュー用HTMLおよびコピペ用コードの更新

# ホバー挙動に関するルール
スマートフォンやタブレット等のタッチデバイス操作時における「タップ時の意図しないホバー状態の残留（背景色の変化や画像の拡大など）」を防ぐため、今後ホバー（`:hover`）挙動を追加・修正する際は、必ず **`@media (hover: hover)` メディアクエリ**で囲み、マウス等のポインティングデバイスが利用可能な環境でのみ適用されるように制御してください。

