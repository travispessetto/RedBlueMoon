<?php
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if(file_exists("lang/$lang.php"))
    {
        require "lang/$lang.php";
    }
    else
    {
        require "lang/en.php";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Red Blue Moon - <?php echo $message['subtitle']; ?></title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <header>
        <h1><i class="fa fa-moon"></i>&nbsp;Red Blue Moon - <?php echo $message['subtitle']; ?></h1>
    </header>
    <div id="form">
        <div id="stripe">
            <h2><?php echo $message['setup']; ?></h2>
        </div>
            <div id="fields">

            <div>
                <label><?php echo $message['url']; ?></label>
            </div>
            <div>
                <input name="url" placeholder="<?php echo $message['url_placeholder']; ?>" />
            </div>

            <div>
                <label><?php echo $message['database_server']; ?></label>
            </div>
            <div>
                <input name="database_server" placeholder="<?php echo $message['database_server_placeholder']; ?>" />
            </div>

            <div>
                <label><?php echo $message['database']; ?></label>
            </div>
            <div>
                <input name="database" placeholder="<?php echo $message['database_placeholder']; ?>" />
            </div>

            <div>
                <label><?php echo $message['database_user']; ?></label>
            </div>
            <div>
                <input name="database_user" placeholder="<?php echo $message['database_user_placeholder']; ?>" />
            </div>

            <div>
                <label><?php echo $message['database_password']; ?></label>
            </div>
            <div>
                <input name="database_password" placeholder="<?php echo $message['database_password_placeholder']; ?>" type="password" />
            </div>
            <div id="button-container">
                <button type="submit"><?php echo $message['submit']; ?></button>
            </div>
        </div>
    </div>
    <div id="overlay">
        <div id="status">
            <div>
                <span id="folder-writability" class="todo"><i class="fas fa-circle-notch fa-spin"></i></span>&nbsp;<?php echo $message['folder_writablity']; ?>
            </div>
            <div>
                <span id="database-import" class="todo"><i class="fas fa-circle-notch fa-spin"></i></span>&nbsp;<?php echo $message['database_import']; ?>
            </div>
            <div>
                <span id="url-changed" class="todo"><i class="fas fa-circle-notch fa-spin"></i></span>&nbsp;<?php echo $message['url_changed']; ?>
            </div>
            <div>
                <span id="files-extracted" class="todo"><i class="fas fa-circle-notch fa-spin"></i></span>&nbsp;<?php echo $message['files_extracted']; ?>
            </div>
        </div>
    </div>
</body>
</html>