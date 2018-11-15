<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<title>Friends Book</title>
    
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">




    </head>
    <body>

        <div class="jumbotron jumbotron-fluid text-center" style="background-color: #d9d9d9;margin-bottom:0">
          <br/><h1>Friends Book</h1>
        </div>
        
        <style>

            .card-custom {
                max-width: 200px;
            }

            .col-centered{
                margin: 0 auto;
                float: none;
            }

        </style>

        <?php $nameFilter = ''; ?>

        <div class="container text-center">

        <br>
        <br>

        <!-- FRIEND LIST CONTROL FORM - ADDING A FRIEND -->

        <form class="form-inline text-center" action="index.php" method="post">
        
            <p class="col-centered">

            <input type="text" class="form-control" name="name" style="margin-right: 10px;">
            
            <button type="submit" class="btn btn-primary">Add Friend</button>
            
            
            </p>

        </form>

        
        
        <?php


            $nameFilter = '';

            // In case the friends.txt file doesn't exit, we create it

            $file = fopen( "friends.txt", "a" );
            fclose($file);


            // If the user decides to delete a friend, we rewrite the friends.txt file
            // Without the friend he decided not to keep

            if(isset($_GET['deleteFriend'])){

                if(!empty($_GET['deleteFriend'])){


                    $file = fopen( "friends.txt", "r" );
            
                    if($file){
                    
                        $Names = array();
                    
                        while (!feof($file)) {
                            
                            array_push( $Names, fgets($file) );
                            
                        }

                        fclose($file);


                        unlink("friends.txt");

                        $file = fopen("friends.txt", "a");


                        for( $i = 0; $i < count($Names) - 1; $i++ ){

                            $name1 = $_GET['deleteFriend'];
                            $name2 = rtrim($Names[$i]);


                            if(strcmp($name1, $name2) != 0)
                                fwrite($file, $Names[$i]);

                        }
                        

                        fclose($file);


                    }
                }


            }


            // If the user used the form to add a friend
        
            if(isset($_POST['name'])){

                // We open the file...
            
                $file = fopen( "friends.txt", "a" );

                if(!empty($_POST['name'])){
                    
                    //... and we add the new friend to the list

                    fwrite( $file, $_POST['name'] );
                    fwrite( $file, "\n" );
                    fclose($file);

                }
            }

            // Now we have to display the list of friends from the friends.txt file

            $file = fopen( "friends.txt", "r" );
            
            if($file){
            
                $names = array();
            
                while (!feof($file)) {
                    
                    array_push( $names, fgets($file) );
                    
                }
                
                if(count($names) >= 2){

                    echo '<div class="row mt-5 justify-content-center">';

                    // If the name filter was used 

                    if (isset($_POST['nameFilter']) && !empty($_POST['nameFilter'])) {

                            $nameFilter = $_POST['nameFilter'];
                        
                            for( $i = 0; $i < count($names) - 2; $i++ ){
                                
                                // We display only the friends corresponding to the filter

                                if(strstr($names[$i],$_POST['nameFilter'])){

                                    echo '<div class="card card-custom mx-2 mb-3" style="width:200px">';
                                    echo '<img class="card-img-top" src="img_avatar1.png" alt="Card image">';
                                    echo '<div class="card-body">';
                                    echo '<h6 class="card-title">' . $names[$i] . '</h6>';
                                    
                                    echo '<p class="card-text">Some example text.</p>';
                                    echo '<a href="index.php?deleteFriend=' . $names[$i] .'" class="btn btn-primary">Delete</a>';
                                    echo '</div>';
                                    echo '</div>';

                                    
                                }

                                
                            }

                            if(strstr($names[$i],$_POST['nameFilter'])){

                                echo '<div class="card card-custom mx-2 mb-3" style="width:200px">';
                                echo '<img class="card-img-top" src="img_avatar1.png" alt="Card image">';
                                echo '<div class="card-body">';

                                echo '<h6 class="card-title">' . $names[count($names) - 2] . '</h6>';
                                
                                echo '<p class="card-text">Some example text.</p>';
                                echo '<a href="index.php?deleteFriend=' . $names[count($names) - 2] .'" class="btn btn-primary">Delete</a>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';

                            

                    }

                    else {

                        // If the filter wasn't used, we can display the entire list

                        $nameFilter = '';

                        for( $i = 0; $i < count($names) - 2; $i++ ){
                                
                
                            echo '<div class="card card-custom mx-2 mb-3" style="width:200px">';
                            echo '<img class="card-img-top" src="img_avatar1.png" alt="Card image">';
                            echo '<div class="card-body">';
                            echo '<h6 class="card-title">' . $names[$i] . '</h6>';
                            
                            echo '<p class="card-text">Some example text.</p>';
                            echo '<a href="index.php?deleteFriend=' . $names[$i] .'" class="btn btn-primary">Delete</a>';
                            echo '</div>';
                            echo '</div>';
                                
                        }

                        echo '<div class="card card-custom mx-2 mb-3" style="width:200px">';
                        echo '<img class="card-img-top" src="img_avatar1.png" alt="Card image">';
                        echo '<div class="card-body">';


                        // If the last friend on the list was just added, we display an badge that
                        // says it's a new friend

                        if(isset($_POST['name']) && !empty($_POST['name']))
                            echo '<h6 class="card-title">' . $names[count($names) - 2] . '<span class="badge badge-secondary">New</span></h6>';
                        else
                            echo '<h6 class="card-title">' . $names[count($names) - 2] . '</h6>';
                        
                        echo '<p class="card-text">Some example text.</p>';
                        echo '<a href="index.php?deleteFriend=' . $names[count($names) - 2] .'" class="btn btn-primary">Delete</a>';
                        echo '</div>';
                        echo '</div>';

                        echo '</div>';
                        

                    }



                    
                }

                fclose($file);
                
            }
            
            
        
        ?>



        <br />
        <br />

        

        <!-- FRIEND LIST CONTROL FORM - FILTERING -->

        

        <br />
        <br />



        </div>
        <div style="text-align: center;">
        
        <div class="jumbotron jumbotron-fluid text-center" style="background-color: #d9d9d9;margin-bottom:0">
          <form class="form-horizontal text-center" action="index.php" method="post">
            <center>
            <div class="col-sm-3">
            <input type="text" class="form-control" name="nameFilter" value="<?=$nameFilter?>">
            <br/>
            <button type="submit" class="btn btn-primary">Filter list</button>

    
           </div>
           </center>
        </form>
        </div>
    </div>  
    </body>
</html>
