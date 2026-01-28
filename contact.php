<?php
// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. データの取得と安全対策（サニタイズ）
    $name    = isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : '未入力';
    $email   = isset($_POST['email'])    ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8')    : '未入力';
    $message = isset($_POST['message'])  ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8')  : '未入力';
    $date    = date("Y/m/d H:i:s");

    // 改行コードが含まれるとCSVが崩れるため置換
    $message = str_replace(array("\r", "\n"), " ", $message);

    // 2. 保存するデータの配列
    $data = [$date, $name, $email, $message];

    // 3. CSVファイルに書き込み ('a'は追記モード)
    $file = fopen('contact_data.csv', 'a');
    fputcsv($file, $data);
    fclose($file);
} else {
    // 直接アクセスされた場合はトップへリダイレクト
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信完了 | Jec Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0a0a0a; color: #e0e0e0; display: flex; align-items: center; justify-content: center; height: 100vh; text-align: center; }
        .success-card { background: #161616; padding: 40px; border-radius: 20px; border: 1px solid #00d4ff; }
        .btn-primary { background-color: #00d4ff; border: none; color: #000; font-weight: 700; border-radius: 50px; padding: 10px 30px; }
    </style>
</head>
<body>
    <div class="success-card shadow-lg">
        <h2 class="mb-4" style="color: #00d4ff;">THANK YOU!</h2>
        <p>お問い合わせを受け付けました。<br>内容は正常に保存されました。</p>
        <a href="index.html" class="btn btn-primary mt-3">トップページに戻る</a>
    </div>
</body>
</html>