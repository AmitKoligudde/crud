<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tester";

$id       = $fullname = $emailid  = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


try
{
    $conn = mysqli_connect($host, $user, $pass, $db);
} catch( Exception $ex )
{

    echo 'Error';
}

function getPosts()
{
    $posts    = array();
    $posts[0] = $_POST['id'];
    $posts[1] = $_POST['fullname'];
    $posts[2] = $_POST['emailid'];
    return $posts;
}

// Search


if( isset($_POST['search']) )
{



    $data         = getPosts();
    $search_Query = "SELECT * FROM  userss WHERE id = '$data[0]'";

    $search_Results = mysqli_query($conn, $search_Query);

    if( $search_Results )
    {
        if( mysqli_num_rows($search_Results) )
        {
            while( $row = mysqli_fetch_array($search_Results) )
            {
                $id       = $row['id'];
                $fullname = $row['fullname'];
                $emailid  = $row['emailid'];
            }
        }
        else
        {
            echo 'No Data for this id';
        }
    }
    else
    {
        echo 'Result Error';
    }
}


//insert data



if( isset($_POST['insert']) && !empty($_POST['fullname']) && !empty($_POST['emailid']) )
{
    $data = getPosts();

    $insert = "INSERT INTO `userss`(`fullname`, `emailid`) VALUES ('$data[1]','$data[2]')";
    try
    {

        $insert_result = mysqli_query($conn, $insert);

        if( $insert_result )
        {
            if( mysqli_affected_rows($conn) > 0 )
            {
                echo 'Data inserted';
            }
            else
            {
                echo 'Data not inserted';
            }
        }
    } catch( Exception $ex )
    {
        echo 'Error_insert' . $ex->getMessage();
    }
}

//delete data



if( isset($_POST['delete']) )
{
    $data = getPosts();

    $delete = "DELETE FROM `userss` WHERE `id`= $data[0]";
    try
    {

        $delete_result = mysqli_query($conn, $delete);

        if( $delete_result )
        {
            if( mysqli_affected_rows($conn) > 0 )
            {
                echo 'Data deleted';
            }
            else
            {
                echo 'Data not deleted';
            }
        }
    } catch( Exception $ex )
    {
        echo 'Error_delete' . $ex->getMessage();
    }
}


//update data



if( isset($_POST['update']) && !empty($_POST['fullname']) && !empty($_POST['emailid']) )
{
    $data = getPosts();

    $update = "UPDATE  `userss` SET  `fullname`='$data[1]',`emailid`='$data[2]' WHERE `id` ='$data[0]'";
    try
    {

        $update_result = mysqli_query($conn, $update);

        if( $update_result )
        {
            if( mysqli_affected_rows($conn) > 0 )
            {
                echo 'Data updated';
            }
            else
            {
                echo 'Data not updated';
            }
        }
    } catch( Exception $ex )
    {
        echo 'Error_update' . $ex->getMessage();
    }
    $p = $_POST['userss'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>ADMIN PANEL</h2>
        <form action="index.php" method="POST">
            <select name = 'userss'>
                <?php
                $search_Query = "SELECT * FROM  userss";

                $search_Results = mysqli_query($conn, $search_Query);

                while( $row = mysqli_fetch_array($search_Results) )
                {
                    echo '<option value = "' . $row['id'] . '">' . $row['fullname'] . '</option>';
                }
                ?>
            </select>
            Select ID : <input type="number"  name="id" placeholder="Id" value="<?php echo $id; ?>"><br><br>
            Full Name :<input type="text"  name="fullname" placeholder="FullName" value="<?php echo $fullname; ?>"><br><br>
            Email : <input type="text"  name="emailid" placeholder="EmailId" value="<?php echo $emailid; ?>"><br><br>

            <div>
                <input type="submit" name="insert" value="Add">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete">
                <input type="submit" name="search" value="Find">
            </div>


        </form>
    </body>
</html>



<!--<script type="text/javascript">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<scri     pt>    
    $('#dbType').on('change',func         tion(){
    var selection = $(this)        .val();
    switch(sele        ction){
    case "        other":
    $("#otherType")       .show()
    break;
    d        efault:
    $("#otherType")        .hide(    )
    }
    });
</script>-->
