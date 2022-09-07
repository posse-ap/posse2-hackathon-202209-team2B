<?php
require("dbconnect.php");
require(realpath("models/users.php"));
if ($_POST) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $admin = $_POST['admin'];
  userCreate($db, $name, $email, $password, $admin);
  header('Location: adminTop.php');
}
require(realpath("header.php"));

?>
<main class="bg-gray-100 flex justify-center h-screen w-screen">
  <div class="w-full text-center">
    <h1 class="text-2xl font-bold mt-5">ユーザー追加、編集画面</h1>
    <form action="addMember.php" method="post" enctype="multipart/form-data">

      <p class="mt-3 text-left ml-12 mb-2">名前</p>
      <input name="name" type="text" placeholder="歩瀬太郎" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">メールアドレス</p>
      <input name="email" type="email" placeholder="メールアドレス" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">パスワード</p>
      <p class="mt-3 text-left ml-12 mb-2">初期値にパスワードpasswordが入っています</p>
      <input name="password" type="password" placeholder="パスワード" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" value="password" required>
      <p class="mt-3 text-left ml-12 mb-2">パスワード確認</p>
      <input name="confirm" type="password" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg ">
      <div class="flex justify-center" mr-50>
        <!-- <label class="ECM_CheckboxInput"> -->
        <label>
          <input type="radio" value="1" name="admin"  checked>
          管理者</label>
        <label>
          <input type="radio" value="0" name="admin" >
          ユーザー</label>
        <!-- <span class="ECM_CheckboxInput-DummyInput"></span><span class="ECM_CheckboxInput-LabelText">私は管理者です</span></label> -->
      </div>
      <div class="flex justify-center">
        <div class="mt-3 text-center w-3/4 h-10 bg-gradient-to-r from-blue-500 to-blue-200 rounded-full">
          <input type="submit" class="text-white font-bold leading-10" value="サインアップ">
        </div>
      </div>
    </form>
  </div>
</main>
<?php include('footer.php') ?>