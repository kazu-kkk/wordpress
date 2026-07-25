<aside id="custom-side-nav" class="widget-area">
    <?php if ( is_front_page() || is_page_template('page-templates/page-top-preview.php') ) : ?>
    <!-- プロフィールカード -->
    <div class="profile-card">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/yuny_logo.png"
            alt="プロフィール画像" class="profile-avatar">
        <h2 class="profile-name">Yuny</h2>
        <p class="profile-bio">UX / UI/グラフィックデザイナー<br>モーションや写真、映像や3Dも時々触ります</p>
    </div>
    <?php endif; ?>

    <!-- 記事検索 -->
    <div class="search-widget">
        <h2 class="widget-title">SEARCH</h2>
        <div class="search-container">
            <input type="text" id="article-search-input" placeholder="キーワード検索..." autocomplete="off">
            <ul id="search-suggestions" class="search-suggestions"></ul>
        </div>
    </div>

    <!-- カテゴリ一覧 -->
    <h2 class="widget-title">CATEGORY</h2>
    <ul class="side-nav-category-list">
        <?php
        $categories = get_categories(array(
            'orderby' => 'name',
            'order'   => 'ASC',
            'hide_empty' => true,
        ));
        foreach ($categories as $cat) {
            if ($cat->name === '記事') continue;
            echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
        }
        ?>
    </ul>

    <!-- 人気タグ -->
    <div class="popular-tag">
        <h2 class="widget-title">人気のタグ</h2>
        <ul class="popular-tag-list">
            <?php
            // 「記事」カテゴリ（実際の記事）に属する投稿のみを取得
            $real_posts_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'name',
                        'terms'    => '記事',
                    ),
                ),
            ));

            $tag_counts = array();

            if ($real_posts_query->have_posts()) {
                while ($real_posts_query->have_posts()) {
                    $real_posts_query->the_post();
                    $post_tags = get_the_tags();
                    if (!empty($post_tags)) {
                        foreach ($post_tags as $tag) {
                            // "pickup"タグは内部ロジック用のため除外
                            if (strtolower($tag->name) === 'pickup') {
                                continue;
                            }
                            
                            if (!isset($tag_counts[$tag->term_id])) {
                                $tag_counts[$tag->term_id] = array(
                                    'term_id' => $tag->term_id,
                                    'name'    => $tag->name,
                                    'count'   => 0,
                                );
                            }
                            $tag_counts[$tag->term_id]['count']++;
                        }
                    }
                }
                wp_reset_postdata();
            }

            // カウント数で降順にソート
            usort($tag_counts, function($a, $b) {
                return $b['count'] - $a['count'];
            });

            // 上位10件を取得
            $top_tags = array_slice($tag_counts, 0, 10);

            if (!empty($top_tags)) {
                foreach ($top_tags as $t) {
                    echo '<li><a href="' . esc_url(get_tag_link($t['term_id'])) . '" class="tag">' . esc_html($t['name']) . ' <span style="font-size: 0.9em; opacity: 0.8; font-weight: normal;">(' . intval($t['count']) . ')</span></a></li>';
                }
            } else {
                echo '<li>タグがありません</li>';
            }
            ?>
        </ul>
    </div>

    <?php if ( is_front_page() || is_page_template('page-templates/page-top-preview.php') ) : ?>
    <!-- デザイントレンド -->
    <div class="trend-word-widget">
        <h2 class="widget-title">今日のトレンドワード</h2>
        <?php
        // トレンド用語データの配列（必要に応じて追加・編集してください）
        $trend_words = array(
            // ==========================================
            // UIデザイン・Webデザイン系 (既存)
            // ==========================================
            array(
                'word' => 'グラスモーフィズム (Glassmorphism)',
                'desc' => 'すりガラスのような半透明の背景と背景ぼかし(backdrop-filter)を活用したUIデザイン手法。奥行き感とモダンな印象を与えます。',
                'url'  => ''
            ),
            array(
                'word' => 'ニューモフィズム (Neumorphism)',
                'desc' => '要素が背景と一体化し、光と影の表現だけで凸凹を作り出すUI手法。立体的でソフトな質感が特徴です。',
                'url'  => ''
            ),
            array(
                'word' => ' Bento UI (弁当箱UI)',
                'desc' => '画面をグリッド状に分割し、各区画に異なる情報や機能のコンポーネントを配置するレイアウト手法。Appleのサイト等でよく見られます。',
                'url'  => ''
            ),
            array(
                'word' => 'ダークモード (Dark Mode)',
                'desc' => '暗い背景色に明るいテキストを配置するカラースキーム。視覚的な疲労軽減やバッテリー節約効果があり、現在では標準的な機能として求められます。',
                'url'  => ''
            ),
            array(
                'word' => 'マイクロインタラクション',
                'desc' => 'ボタンのホバーや「いいね」のアニメーションなど、ユーザーの細かな操作に対して視覚的なフィードバックを返す小さな演出のこと。',
                'url'  => ''
            ),

            // ==========================================
            // クリエイティブ系 (20単語) - 企画・コンセプト・UX・映像など
            // ==========================================
            array(
                'word' => 'インタラクティブ・ストーリーテリング',
                'desc' => 'ユーザーの選択や操作によって物語の展開が変化する手法。Webサイトを「読む」から「体験する」ものへと進化させます。',
                'url'  => ''
            ),
            array(
                'word' => 'スペーシャル・コンピューティング',
                'desc' => '現実空間とデジタル空間を融合させる技術（XR）。Apple Vision Proなどの登場により、UIデザインは平面から空間へと拡張しています。',
                'url'  => ''
            ),
            array(
                'word' => 'トランスメディア・ストーリーテリング',
                'desc' => 'Web、SNS、動画、リアルイベントなど複数のメディアを横断して一つの大きな世界観や物語を展開する手法。',
                'url'  => ''
            ),
            array(
                'word' => 'パーソナライズド・ビデオ',
                'desc' => 'ユーザーの属性や行動履歴に合わせて、リアルタイムで内容が変化・最適化される動画コンテンツ。',
                'url'  => ''
            ),
            array(
                'word' => 'ダイナミック・アイデンティティ',
                'desc' => 'ロゴやブランドカラーを固定せず、媒体や状況、ユーザーに応じて柔軟に変化し続けるブランドデザイン手法。',
                'url'  => ''
            ),
            array(
                'word' => 'インクルーシブ・デザイン',
                'desc' => '年齢、性別、国籍、障害の有無などに関わらず、多様な人々が利用できることを初期段階から想定して設計するアプローチ。',
                'url'  => ''
            ),
            array(
                'word' => 'データビジュアライゼーション',
                'desc' => '複雑なデータや数値を、視覚的にわかりやすく美しいグラフやインフォグラフィックに変換して伝えるクリエイティブ手法。',
                'url'  => ''
            ),
            array(
                'word' => 'シネマグラフ',
                'desc' => '写真の一部だけがループして動いている表現。静止画と動画の中間のような性質で、視線を惹きつける強い効果があります。',
                'url'  => ''
            ),
            array(
                'word' => 'イマーシブ・オーディオ (没入型音声)',
                'desc' => '立体音響技術を活用し、空間的な広がりや奥行きを感じさせる音声体験。Webやアプリでの没入感を高めます。',
                'url'  => ''
            ),
            array(
                'word' => 'ゲーミフィケーション',
                'desc' => 'ゲーム以外のサービスに「ポイント」「バッジ」「レベルアップ」などゲームの要素を取り入れ、ユーザーのモチベーションを高める手法。',
                'url'  => ''
            ),
            array(
                'word' => 'エフェメラル・コンテンツ',
                'desc' => 'Instagramのストーリーズのように、一定時間が経過すると消滅するコンテンツ。FOMO（見逃しへの恐怖）を刺激しエンゲージメントを高めます。',
                'url'  => ''
            ),
            array(
                'word' => 'アダプティブ・ブランディング',
                'desc' => '環境やデバイス、ユーザーの好みに応じてブランドの視覚要素が自動的に適応・変化する新しいブランディング手法。',
                'url'  => ''
            ),
            array(
                'word' => 'ライブ・コマース・デザイン',
                'desc' => 'ライブ配信とオンラインショッピングを融合させたUX / UI設計。視聴者の熱量をそのまま購買行動へと繋げる導線が重要です。',
                'url'  => ''
            ),
            array(
                'word' => 'ソーシャル・ファースト',
                'desc' => 'コンテンツを制作する際、最初からSNS（TikTokやInstagram）での視聴体験やシェアされることを前提として設計する手法。',
                'url'  => ''
            ),
            array(
                'word' => 'マイクロドキュメンタリー',
                'desc' => '1〜3分程度の短尺で、ブランドの背景や商品開発の裏側などをリアルに伝える動画表現。共感を生む手法として重宝されます。',
                'url'  => ''
            ),
            array(
                'word' => 'ノーコード/ローコード・クリエイティブ',
                'desc' => 'プログラミング不要でWebサイトやアプリを構築できるツールを活用し、デザイナーが直接実装まで行う迅速な制作プロセス。',
                'url'  => ''
            ),
            array(
                'word' => 'UGC (ユーザー生成コンテンツ)',
                'desc' => '企業ではなく一般ユーザーが制作したコンテンツ。これらを公式のクリエイティブに組み込むことで、信頼感や親近感を高めます。',
                'url'  => ''
            ),
            array(
                'word' => 'モーション・アイデンティティ',
                'desc' => 'ブランドロゴが「どのように動くか」までを含めてブランドのアイデンティティとして規定・デザインするアプローチ。',
                'url'  => ''
            ),
            array(
                'word' => 'エモーショナル・デザイン',
                'desc' => '使いやすさだけでなく、ユーザーの「喜び」や「驚き」といった感情に直接訴えかけることを目的としたデザイン手法。',
                'url'  => ''
            ),
            array(
                'word' => 'サステナブル・Webデザイン',
                'desc' => 'データ転送量を減らすことでサーバーの消費電力を抑え、環境負荷の軽減を目指すWebデザインのアプローチ。',
                'url'  => ''
            ),

            // ==========================================
            // グラフィック系 (20単語) - 視覚表現
            // ==========================================
            array(
                'word' => 'Y2Kリバイバル',
                'desc' => '2000年代初頭のポップでサイバー、少しチープでキラキラした美的感覚を現代風にアップデートしたグラフィックスタイル。',
                'url'  => ''
            ),
            array(
                'word' => 'ネオ・ブルータリズム',
                'desc' => '装飾を排除した無骨なブルータリズムに、ビビッドな色使いや太い黒の境界線を組み合わせた、現代的でポップなスタイル。',
                'url'  => ''
            ),
            array(
                'word' => 'アシッド・グラフィックス (Acid Graphics)',
                'desc' => '90年代のレイブカルチャーやサイケデリックな要素を取り入れ、歪んだ文字やネオンカラーを用いた刺激的なスタイル。',
                'url'  => ''
            ),
            array(
                'word' => 'オーロラ・グラデーション',
                'desc' => 'メッシュグラデーションとも呼ばれ、複数の色が複雑に溶け合うような、オーロラのように流動的で美しいグラデーション表現。',
                'url'  => ''
            ),
            array(
                'word' => 'カスタム・タイポグラフィ',
                'desc' => '既存のフォントを使わず、ブランドやプロジェクトのために独自に設計・変形された文字デザイン。',
                'url'  => ''
            ),
            array(
                'word' => 'マキシマリズム',
                'desc' => '「Less is more（少ないほど豊か）」の逆で、大胆な色使い、複雑なパターン、多数の要素を詰め込みエネルギッシュに魅せる手法。',
                'url'  => ''
            ),
            array(
                'word' => 'ミニマリズム 2.0 (ウォーム・ミニマリズム)',
                'desc' => '冷たい印象の無機質なミニマリズムから進化し、暖色系の色合いや自然素材のテクスチャを取り入れた温かみのあるスタイル。',
                'url'  => ''
            ),
            array(
                'word' => 'アブストラクト・3Dシェイプ',
                'desc' => '用途を持たない抽象的で有機的な3Dオブジェクトを画面のアクセントとして配置し、空間の広がりや先進性を演出する手法。',
                'url'  => ''
            ),
            array(
                'word' => 'グレイン・ノイズ・テクスチャ',
                'desc' => '写真のフィルムノイズや砂嵐のようなザラザラした質感を重ねることで、フラットなデザインに深みやアナログ感を与える手法。',
                'url'  => ''
            ),
            array(
                'word' => 'グリッドブレイク (非対称レイアウト)',
                'desc' => 'あえて整然としたグリッド（格子）を壊し、要素をずらして配置することでダイナミックな動きや緊張感を生み出す手法。',
                'url'  => ''
            ),
            array(
                'word' => 'ダブルエキスポージャー (多重露光)',
                'desc' => '人物のシルエットの中に風景を重ねるなど、複数の画像を重ね合わせて幻想的でストーリー性のある一枚を作る表現。',
                'url'  => ''
            ),
            array(
                'word' => 'アイソメトリック・イラスト',
                'desc' => '斜め上から見下ろしたような等角投影図法で描かれたイラスト。立体感があり、空間や仕組みをわかりやすく説明するのに適しています。',
                'url'  => ''
            ),
            array(
                'word' => 'ラスター・エフェクト',
                'desc' => 'あえて解像度を下げたピクセルアート風や、低画質のドット感を意図的に取り入れるレトロフューチャーな表現。',
                'url'  => ''
            ),
            array(
                'word' => 'サイケデリック・デザイン',
                'desc' => '60年代のヒッピーカルチャーにインスパイアされた、歪曲した文字や幻覚的なパターン、鮮やかな原色を組み合わせたスタイル。',
                'url'  => ''
            ),
            array(
                'word' => 'エコ・マテリアル・テクスチャ',
                'desc' => '再生紙、ダンボール、未加工の木材などを模した質感を使い、環境への配慮（サステナビリティ）を視覚的に訴えかけるデザイン。',
                'url'  => ''
            ),
            array(
                'word' => 'キネティック・タイポグラフィ',
                'desc' => '文字そのものに動き（アニメーション）を持たせ、視覚的なインパクトやメッセージの感情をダイナミックに表現する手法。',
                'url'  => ''
            ),
            array(
                'word' => 'リソグラフ風 (Risograph Effect)',
                'desc' => 'アナログ印刷機特有の「かすれ」や「版ズレ」「網点」をデジタル上で再現し、温かみやレトロ感を演出するグラフィック手法。',
                'url'  => ''
            ),
            array(
                'word' => '3Dタイポグラフィ',
                'desc' => '立体的な文字表現。近年のWeb技術（WebGLなど）の向上により、サイト上でインタラクティブに動かせる3D文字も増えています。',
                'url'  => ''
            ),
            array(
                'word' => 'ハンドクラフト・エステティクス',
                'desc' => 'AI生成による均質な画像に対する反動として、手書き感やあえての「不完全さ」を取り入れ、人間らしさをアピールするデザイン手法。',
                'url'  => ''
            ),
            array(
                'word' => 'ホログラフィック・デザイン',
                'desc' => '光の当たり方で虹色に変化するホログラムのようなテクスチャを用いた表現。サイバーで未来的な印象を与えます。',
                'url'  => ''
            ),

            // ==========================================
            // AI系 (20単語) - 生成AI関連技術・用語
            // ==========================================
            array(
                'word' => 'RAG (検索拡張生成)',
                'desc' => '大規模言語モデル（LLM）に、社内データや最新のWeb情報を検索して参照させることで、事実に基づいた正確な回答を生成させる技術。',
                'url'  => ''
            ),
            array(
                'word' => 'プロンプト・エンジニアリング',
                'desc' => 'AIから望む結果（テキストや画像）を引き出すために、入力する指示文（プロンプト）の構造や言葉選びを最適化する技術。',
                'url'  => ''
            ),
            array(
                'word' => 'Text-to-Video (テキストからの動画生成)',
                'desc' => 'テキストの指示（プロンプト）から直接、高精細で滑らかな動画を生成するAI技術。Soraなどのモデルが代表的です。',
                'url'  => ''
            ),
            array(
                'word' => 'Text-to-3D (テキストからの3D生成)',
                'desc' => 'テキストのプロンプトを入力するだけで、ゲーム開発や映像制作に使える3Dモデル（メッシュとテクスチャ）を自動生成する技術。',
                'url'  => ''
            ),
            array(
                'word' => 'ファインチューニング (微調整)',
                'desc' => '既存のAIモデルに対して、特定のブランドガイドラインや専門知識のデータを追加学習させ、自社専用のモデルに最適化すること。',
                'url'  => ''
            ),
            array(
                'word' => 'AIハルシネーション (幻覚)',
                'desc' => 'AIが、学習データに基づき「もっともらしいが、事実とは全く異なる嘘の情報」を自信満々に生成・出力してしまう現象。',
                'url'  => ''
            ),
            array(
                'word' => 'シンセティック・データ (合成データ)',
                'desc' => 'AIの学習精度を高めるため、プライバシーリスクを回避しつつ、本物のデータと同じ統計的特徴を持つようAI自身が生成した架空のデータ。',
                'url'  => ''
            ),
            array(
                'word' => 'ゼロショット学習 (Zero-shot Learning)',
                'desc' => 'AIが過去に一度も学習したことがない未知のタスクやカテゴリについて、事前の汎用的な知識だけを使って推論・解答する能力。',
                'url'  => ''
            ),
            array(
                'word' => 'コンピュテーショナル・デザイン',
                'desc' => 'デザイナーが手作業で形を作るのではなく、ルールやアルゴリズムを設定し、コンピューター（AI）の計算によってデザインを自動生成する手法。',
                'url'  => ''
            ),
            array(
                'word' => 'リアルタイム画像生成',
                'desc' => 'ユーザーが文字をタイピングしたり、ラフを描いたりしているのと「同時」に、瞬時に高画質な画像を生成し続ける技術。',
                'url'  => ''
            ),
            array(
                'word' => 'AIアバター (デジタルヒューマン)',
                'desc' => 'AIによって自動生成・制御される、人間のように話し、表情を変える仮想のキャラクター。カスタマーサポート等で活用されます。',
                'url'  => ''
            ),
            array(
                'word' => 'ボイス・クローニング',
                'desc' => 'わずかな音声データから、本人の声質や話し方の癖を再現した音声をAIで合成する技術。',
                'url'  => ''
            ),
            array(
                'word' => 'ニューラル・レンダリング (NeRFなど)',
                'desc' => '数枚の2D画像から、AIが空間の立体構造を推測し、任意の視点から見た写真のようにリアルな3D映像を生成する技術。',
                'url'  => ''
            ),
            array(
                'word' => 'エッジAI',
                'desc' => 'クラウド（サーバー）ではなく、スマホやPCなどの端末側（エッジ）で直接AIの計算処理を行う仕組み。高速でプライバシーが守られます。',
                'url'  => ''
            ),
            array(
                'word' => 'ジェネレーティブ・フィル (生成塗りつぶし)',
                'desc' => '画像の一部を選択し、プロンプトを入力するだけで、AIが周囲の文脈を理解して自然に画像を足したり消したりする画像編集機能。',
                'url'  => ''
            ),
            array(
                'word' => 'コパイロット (Copilot)',
                'desc' => '「副操縦士」を意味し、人間の作業を奪うのではなく、常に横にいて提案や下書き作成などのサポートを行うアシスタント型AIの総称。',
                'url'  => ''
            ),
            array(
                'word' => 'AIエージェント (Agentic AI)',
                'desc' => '単一の指示で動くジェネレーターとは異なり、ユーザーの目標を理解し、自律的にタスクを分解して実行・完了させる次世代のAI。',
                'url'  => ''
            ),
            array(
                'word' => 'ジェネレーティブUI (Generative UI)',
                'desc' => 'ユーザーの状況や過去の行動に合わせて、AIがリアルタイムで最適なUIレイアウトや構成を自動生成して提供する手法。',
                'url'  => ''
            ),
            array(
                'word' => 'コンテキストエンジニアリング',
                'desc' => 'AIに対してプロンプト（指示）を出すだけでなく、背景や文脈（コンテキスト）を適切に設計・提供することで精度の高い出力を引き出す手法。',
                'url'  => ''
            ),
            array(
                'word' => 'マルチモーダルAI (Multimodal AI)',
                'desc' => 'テキストだけでなく、画像、音声、動画など複数の異なる種類のデータを同時に処理・理解し、統合的な出力を可能にするAI技術。',
                'url'  => ''
            )
        );
        $random_trend = $trend_words[array_rand($trend_words)];
        ?>
        <div class="trend-word-card">
            <h3 class="trend-word-title"><?php echo esc_html($random_trend['word']); ?></h3>
            <p class="trend-word-desc"><?php echo esc_html($random_trend['desc']); ?></p>
            <?php if ( !empty($random_trend['url']) ) : ?>
                <a href="<?php echo esc_url($random_trend['url']); ?>" class="trend-word-link">この記事を読む</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- 広告エリア -->
    <div class="ad-widget" style="margin-top: 30px; text-align: center;">
        <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
        <?php if ( wp_is_mobile() ) : ?>
        <div id="im-1eae1085f45c43698d0a456571986d00">
            <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
            <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1937823,type:"banner",display:"inline",elementid:"im-1eae1085f45c43698d0a456571986d00"})</script>
        </div>
        <?php else : ?>
        <div id="im-91b0abf8dd8043e3a85b798346681f1d">
            <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
            <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1937816,type:"banner",display:"inline",elementid:"im-91b0abf8dd8043e3a85b798346681f1d"})</script>
        </div>
        <?php endif; ?>
    </div>
</aside>