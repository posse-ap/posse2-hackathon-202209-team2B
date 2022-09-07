<?php include('head.php')?>
<body>
<?php include('header.php')?>
  <main class="bg-gray-100 flex justify-center h-screen w-screen">
    <div class="w-full text-center">
      <h1 class="text-2xl font-bold mt-5">ユーザー追加、編集画面</h1>
      <p class="mt-3 text-left ml-12 mb-2">名前</p>
      <input type="text" placeholder="歩瀬太郎" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">メールアドレス</p>
      <input type="email" placeholder="メールアドレス" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">パスワード</p>
      <p class="mt-3 text-left ml-12 mb-2">初期値にパスワードpasswordが入っています</p>
      <input type="password" placeholder="パスワード" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" value="password" required>
      <p class="mt-3 text-left ml-12 mb-2">パスワード確認</p>
      <input type="password" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg ">
      <div class="flex justify-center" mr-50>
      <label class="ECM_CheckboxInput"><input class="ECM_CheckboxInput-Input" type="checkbox" value="admin" required>
      <span class="ECM_CheckboxInput-DummyInput"></span><span class="ECM_CheckboxInput-LabelText">私は管理者です</span></label>
      </div>
      <div class="flex justify-center">
      <div class="mt-3 text-center w-3/4 h-10 bg-gradient-to-r from-blue-500 to-blue-200 rounded-full">
        <p class="text-white font-bold leading-10">サインアップ</p>
      </div>
      </div>
    </div>
  </main>
</body>