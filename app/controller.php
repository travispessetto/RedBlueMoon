<?php
//Phar::mount('outside','./');
Phar::mount('database.sql','./database.sql');
Phar::mount('wordpress.zip','./wordpress.zip');
header('Content-Type: application/json');
$action = $_GET['action'];

if($action == 'checkFolder')
{
    if(is_writable('./outside'))
    {
        echo json_encode(array('writable'=>'true'));
    }
    else
    {
        echo json_encode(array('writable'=>'false'));
    }
}

if($action == 'importDatabase')
{
    if(!file_exists('database.sql'))
    {
        echo json_encode(array('imported'=>false,'message'=>'database.sql does not exist'));
    }
    else
    {
        $query = '';
        $database = $_POST['database'];
        $server = $_POST['databaseServer'];
        $username = $_POST['databaseUser'];
        $password = $_POST['databasePassword'];
        $oldUrl = $_POST['oldUrl'];
        $newUrl = $_POST['newUrl'];
        $conn = new mysqli($server, $username, $password);
        $conn->select_db($database);
        $lines = file('database.sql');
        if ($conn->connect_error) 
        {
            echo json_encode(array('imported'=>false,'message'=>$conn->connect_error));
        }
        else
        {
            foreach ($lines as $line)
            {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;

                // Add this line to the current segment
                $line = str_replace($oldUrl,$newUrl,$line);
                $query .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    // Perform the query
                    if($conn->query($query) === FALSE)
                    {
                        echo json_encode(array('imported'=>false,'message'=>$conn->error));
                        exit();
                    } 
                    $query = '';
                }
            }
            echo json_encode(array('imported'=>true));
        }
    }
}

if($action == 'extract')
{
    if(!file_exists('wordpress.zip'))
    {
        echo json_encode(array('extracted'=>false,'message'=>'wordpress.zip does not exist'));
    }
    else
    {
        $database = $_POST['database'];
        $server = $_POST['databaseServer'];
        $username = $_POST['databaseUser'];
        $password = $_POST['databasePassword'];
        $zip = new ZipArchive;
        $zip->open('wordpress.zip');
        if($zip === false)
        {
            echo json_encode(array('extracted'=>false,'message'=>'wordpress.zip could not be opened'));
        }
        else
        {
            $zip->extractTo('./');
            $zip->close();
            Phar::mount('wp-config-sample.php','wp-config-sample.php');
            Phar::mount('wp-config.php','wp-config.php');
            unlink();
            $configContent = file_get_contents('wp-config-sample.php');
            $configContent = str_replace('username_here',$username,$configContent);
            $configContent = str_replace('password_here',$password,$configContent);
            $configContent = str_replace('localhost',$server,$configContent);
            $configContent = str_replace('database_name_here',$configContent);
            file_put_contents('wp-config.php',$configContent);
            echo json_encode(array('extracted'=>true));
        }
    }
}