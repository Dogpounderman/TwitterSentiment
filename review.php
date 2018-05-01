<?php
    require_once("support.php");

    if (isset($_POST["addReview"])) {
            $host = "localhost";
        	$user = "dbuser";
        	$password = "goodbyeWorld";
        	$database = "groupproj";
        	$table = "reviews";
        	$db_connection = new mysqli($host, $user, $password, $database);

        	if ($db_connection->connect_error) {
                    		die($db_connection->connect_error);
                    	}

                    	 $displayName = $_POST["displayName"];
                         $rating = $_POST["rating"];
                         $review = $_POST["review"];

			 $file = $_POST["file"];
			 $fileData = addslashes(file_get_contents($file));
			 $docMimeType = "image/jpeg";


                $sqlQuery = "insert into $table (docName, docMimeType, image, name, rating, review) values ";
                	$sqlQuery .= "('{$file}', '{$docMimeType}', '{$fileData}', '{$displayName}', '{$rating}', '{$review}')";

                    /*    $sqlQuery = sprintf("insert into $table (docName, docMimeType, image, name, rating, review) values('{$file}','{$docMimeType}', '{$fileData}','{$displayName}', '{$rating}', '{$review}')"); */


                        $result = $db_connection->query($sqlQuery);
                        	if (!$result) {
                        		die("Insertion failed: " . $db_connection->error);
                        	}

                    	 $db_connection->close();
    }



    $host = "localhost";
            	$user = "dbuser";
            	$password = "goodbyeWorld";
            	$database = "groupproj";
            	$table = "reviews";
            	$toAdd = "";
            	 $db_connection = new mysqli($host, $user, $password, $database);
        	if ($db_connection->connect_error) {
        		die($db_connection->connect_error);
        	}
        	$query = "select * from $table";
        	$result = $db_connection->query($query);
        	if (!$result) {
           		die("Retrieval failed: ". $db_connection->error);
    	    } else {
            	$num_rows = $result->num_rows;
            	for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                      $result->data_seek($row_index);
                      $row = $result->fetch_array(MYSQLI_ASSOC);
                      $displayNameItem = $row['name'];
                      $ratingItem = $row['rating'];
                      $reviewItem = $row['review'];
		      $imageItem = $row['docName'];
		      $mimeType = $row['docMimeType'];
		      $data = $row['image'];


                      $toAdd .= "<tr><td class='name'>$displayNameItem</td>
                                 <td class='rating'>$ratingItem". "/5</td>
                                 <td class= 'reviewText'>$reviewItem</td>
				 <td><img src=\"retrievingDocument.php?fileToRetrieve=$imageItem\" alt=\"Image To Display\" height='100' width='100'/></td></tr>";
                }
           }

$db_connection->close();

    $topPart = <<<EOBODY
        <nav class="navbar-default navbar stuff" id="bar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="toxic.php">Toxicity Calculator<span class="glyphicon glyphicon-alert"></span></a>
                        </div>
                        <ul class="nav navbar-nav">
                        <li><a href="toxic.php">Toxicity Calculator</a></li>
                            <li><a href="main.html">About</a></li>
                            <li><a href="faq.php">FAQ</a></li>
                            <li class="active"><a href="review.php">Reviews</a></li>
                            <li><a href="contact.php">Contact Us</a></li>

                        </ul>
                    </div>
                </nav>
                <h2 class ="title">Consumer Reviews <span class="glyphicon glyphicon-user"></span></h2>

                <div class = "form-group control-label col-sm-10" id = "reviewTable">
                 				<table class="table table-bordered table-striped">
                 					<thead>
                 						<tr>

                 							<th class="head">
                 								Name
                 							</th>
                 							<th class="head">
                 							    Rating
                 							</th>
                 							<th class="head">
                 								Review
                 							</th>
                 							<th class="head">
                                                                                                     								Image
                                                                                                     							</th>
                 						</tr>
                 					</thead>
                 					<tbody>
                 						<tr>
                                          <td class="name">Zack Wang</td>
                                          <td class="rating" >5/5</td>
                                          <td class= "reviewText" >This thing is amazing! Employers should use this
                                          website to find out the toxicity of those they are hiring.
                                         </td>
                                         <td>
                                                                                                                          <img src= 'bulb.jpg' alt='Image To Display' height='100' width='100'/>
                                                                                                                          </td>
                 						</tr>
                 						<tr>
                                                                                  <td class="name">Wallace Loh</td>
                                                                                  <td class="rating" >5/5</td>
                                                                                  <td class= "reviewText" >Amazing website. I cannot beleive this was made
                                                                                  by UMD students. The creators of this website deserve an A for their grade.
                                                                                  I will fire their professor if they don't receive an A on this project.
                                                                                 </td>
                                                                                 <td>
                                                                                 <img src= 'bulb.jpg' alt='Image To Display' height='100' width='100'/>
                                                                                 </td>
                                                         						</tr>

                                                         						$toAdd<br><br>
                 					</tbody>
                 				</table>
                 			</div>

                <form action="{$_SERVER["PHP_SELF"]}" method="post">
                    <div id = "reviewTextArea" class = "form-group control-label col-sm-6">
                        <strong>Add Your Review: </strong> <br><br>
                        <strong>Your Name: </strong><input type="text" name="displayName" class="form-control" required>
                                  <br>
                        <strong>Your Rating: </strong>
                         <input type="radio" name="rating" value="1"> 1
                         <input type="radio" name="rating" value="2"> 2
                         <input type="radio" name="rating" value="3" checked> 3
                         <input type="radio" name="rating" value="4"> 4
                         <input type="radio" name="rating" value="5"> 5<br><br>
			 <strong>Add Your Image:</strong> <br><br>
			 <input type="file" name="file" id="file">
			 <br>


                         <strong>Your Review: </strong>
                          <textarea rows="6" cols="80" name="review"></textarea>
                          <br><br>



                          <input type="submit" name="addReview" class="btn btn-primary btn-lg btn-block" value = "Add Review">
                          <br>
                          <input type="reset" class="btn btn-primary btn-lg btn-block"  value = "Clear">

                                             <br>
                                             </div>

                </form>
                <br><br><br><br><br><br><br><br>
                <br><br><br><br><br><br><br><br>
                <br><br><br><br><br><br><br><br>
                <br><br><br><br><br><br><br><br>
                <br><br><br><br><br><br><br><br><br>

EOBODY;

     $page = generatePage($topPart);
        echo $page;
?>
