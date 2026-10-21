<?php
require_once 'assets/functions.php';
require_once 'assets/sessioncheck.php';
session_start();

$editFormAction = $_SERVER['PHP_SELF'];

if ((isset($_POST["MM_insert"])) 
    && ($_POST["MM_insert"] == "nypost") 
&& (isset($_POST["username"])) 
&& ($_POST["username"] != "") 
&& (isset($_POST["msg"])) 
&& ($_POST["msg"] != "")) {

    if (insertForumpost($_POST['username'], $_POST['msg'])) {
        $insertGoTo = "index.php";

        $_POST["MM_insert"] = "";
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$records = getForumPosts();

if($records->rowCount() >0){
$row_Recordset1=$records->fetch(PDO::FETCH_ASSOC);    
}
?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title>Forum test</title>
        <link href="css/forum.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <h1>Ett enkelt forum.</h1>
        <p><a href="loggain.php">Logga ut</a></p>
                <p><a href="profil.php">Min profil</a></p>
        <form name="nypost" method="POST" action="<?php echo $editFormAction; ?>">
            <table>
                <tr>
                    <td>Namn</td>
                    <td><label for="namn"></label>
                        <input class="textFiled" name="username" type="text" id="namn"
                        value="<?php echo $_SESSION['username']; ?>"
                        readonly></td>


                        ></td>
                </tr>
                <tr>
                    <td>Meddelande</td>
                    <td><label for="msg"></label>
                        <textarea class="textFiled" name="msg"  rows="8" id="msg"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="skicka" id="skicka" value="Skicka"></td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="nypost">
        </form>
        <table id="dbres">
            <tr>
                <th>Namn</th>
                <th>Meddelande</th>
                <th>Datum</th>
            </tr>
<?php do { ?>
                <tr>
                    <td><?php echo $row_Recordset1['username']; ?></td>
                    <td><?php echo nl2br($row_Recordset1['message']); ?></td>
                    <td><?php echo $row_Recordset1['time']; ?></td>
                </tr>
<?php } while ($row_Recordset1=$records->fetch(PDO::FETCH_ASSOC)); ?>
        </table>
    </body>
</html>
            <?php
            $forum = null;
            ?>

  