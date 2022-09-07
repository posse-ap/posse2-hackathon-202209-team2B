<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
</head>
<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5 bg-gray-100">
      <div class="h-full">
        <img src="img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>
  <main class="bg-gray-100 h-screen">
  <div class="w-full mx-auto p-5">
    <div class="font-bold text-base mt-4 mb-3">ログイン</div>
    <input type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3 ">
        <input type="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3">
        <label class="inline-block mb-6">
          <input type="checkbox" checked>
          <span class="text-sm">ログイン状態を保持する</span>
        </label>
    </div>
    <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="/">パスワードを忘れた方はこちら</a>
      </div>
  </div>
  </main>
  <footer>

  </footer>
</body>
